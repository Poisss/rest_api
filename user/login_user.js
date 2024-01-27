$(document).on("click", "#login", () => {
    $('#response').html("");
    showLoginPage();
  });
  
  function showLoginPage() {
    
    let html = `
          <h1>Авторизация</h1>
          <form action="#" id="login-form" class="m-t-15px">
              <div class="email">
                  <input class="form-control m-t-15px" name="email" type="email" placeholder="Почта">
              </div>
              <div class="password">
                  <input class="form-control m-t-15px" name="password" type="password" placeholder="Пароль">
              </div>
              <div class="btn">
              <button type="submit" class="btn btn-primary">Войти</button>
              </div>
          </form>`;
    $("#app").html(html);
    showLogOutMenu();
  }
$(document).on("submit", "#login-form", function(){
    $('#response').html("");
    let form_data = JSON.stringify($(this).serializeObject());
    $.ajax({
        url:"rest-api/user/login.php",
        type: "POST",
        dataType: "json",
        data: form_data,
        success: (result)=>{
            setCookie("id", result.id, 1);
            setCookie("jwt", result.jwt, 1);
            showLogInMenu();
            $('#response').html("<div class='alert alert-primary'><h2>Вы успешно вошли</h2></div>");
            $('#app').html("");
            
        },
        error:(xhr, resp, text)=>{
            console.log(xhr, resp, text);
            $('#response').html("<div class='alert alert-danger'><h2>Не удалось войти</h2></div>");
            login-form.find("input").value('');
        }
    })
    return false;
});
$(document).on("click", "#logout", () => {
    deleteCookie('id');
    deleteCookie('jwt');
    showLoginPage();
    $('#response').html("<div class='alert alert-primary'><h2>Вы успешно вышли из системы</h2></div>");
})
  