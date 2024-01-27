jQuery(($)=>{
    $(document).on("click", ".update-one-user-button",(e)=>{
        $('#response').html("");
        const id = getCookie('id');
        const jwt=getCookie('jwt');
        $.getJSON("rest-api/user/read_one.php?id="+id, (data)=>{
                let create_product = `
                    <form action="#" id="update-user-form" method="post" border="0">
                        <input type="hidden" name="id" value="`+data.id+`">
                        <input type="hidden" name="jwt" value="`+jwt+`">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <td>Имя</td>
                                <td><input type="text" name="firstname" class="form-control" value="`+data.firstname+`" required></td>
                            </tr>
                            <tr>
                                <td>Фамилия</td>
                                <td><input type="text" name="lastname" class="form-control" value="`+data.lastname+`" required></td>
                            </tr>
                            <tr>
                                <td>Отчество</td>
                                <td><input type="text" name="patronymic" class="form-control" value="`+data.patronymic+`" required></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><input type="text" name="email" class="form-control" value="`+data.email +`" required></td>
                            </tr>
                            <tr>
                                <td>Пароль</td>
                                <td><input type="text" name="password" class="form-control" value="" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                </td>
                            </tr>
                        </table>
                    </form>`;
                $("#app").html(create_product);
        });
    });
    $(document).on("submit", "#update-user-form", function(){
        $('#response').html("");
        let form_data = JSON.stringify($(this).serializeObject());
        console.log(form_data);
        $.ajax({
            url:"rest-api/user/update.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            success: (result)=>{
                $('#response').html("<div class='alert alert-primary'><h2>Данные обновлены</h2></div>");
                showProfile();
            },
            error:(xhr, resp, text)=>{
                console.log(xhr, resp, text);
                $('#response').html("<div class='alert alert-danger'><h2>Не удалось обновить данные</h2></div>");
            }
        })
        return false;
    })
});