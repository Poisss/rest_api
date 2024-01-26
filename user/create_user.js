jQuery(($)=>{
    $(document).on("click", "#sign_up", function(){
        $('#response').html("");
        let createUser = `
        <form action="#" id="form-registr" class="m-t-15px">
            <div class="first_name">
                <input class="form-control" name="firstname" type="text" placeholder="Имя">
            </div>
            <div class="last_name">
                <input class="form-control m-t-15px" name="lastname" type="text" placeholder="Фамилия">
            </div>
            <div class="patronymic_name">
                <input class="form-control m-t-15px" name="patronymic" type="text" placeholder="Отчество">
            </div>
            <div class="email">
                <input class="form-control m-t-15px" name="email" type="email" placeholder="Почта">
            </div>
            <div class="password">
                <input class="form-control m-t-15px" name="password" type="password" placeholder="Пароль">
            </div>
            <div class="btn">
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            </div>
        </form>`
        $("#app").html(createUser)
        console.log("вы зареганы");
    })
})
$(document).on("submit", "#form-registr", function(){
    $('#response').html("");
    let form_data = JSON.stringify($(this).serializeObject());
    $.ajax({
        url:"rest-api/user/create.php",
        type: "POST",
        dataType: "json",
        data: form_data,
        success: (result)=>{
            $('#response').html("<div class='alert alert-primary'><h2>Пользователь создан</h2></div>");
            showProducts();
        },
        error:(xhr, resp, text)=>{
            console.log(xhr, resp, text);
            $('#response').html("<div class='alert alert-danger'><h2>Не удалось создать пользователя</h2></div>");
        }
    })
    return false;
})