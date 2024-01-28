jQuery(($)=>{
    $(document).on("click", ".create-post-button",()=>{
        $('#response').html("");
        $.getJSON("rest-api/topic/read.php", (data)=>{
            let topic_option = `<select name="topic_id" class="form-control">`
            $.each(data.records, (key , val)=>{
                topic_option += `<option value="`+val.id+`">` + val.name + `</option>`;
            })
            topic_option += `</select>`;
            const id = getCookie('id');
            let create_post = `
            <div id="read-posts" class="btn btn-primary read-post-button">
            Посты
            </div>
            <form action="#" id="create-post-form" method="post" border="0">
                <input type="hidden" name="user_id" value="`+id+`">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>Название</td>
                        <td><input type="text" name="title" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td>Текст</td>
                        <td><textarea  name="text" class="form-control" required> </textarea></td>
                    </tr>
                    <tr>
                        <td>Тема</td>
                        <td>`+ topic_option +`</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-primary">Создать пост</button>
                        </td>
                    </tr>
                </table>
            </form>`;
            $("#app").html(create_post);
        });
    });
    $(document).on("submit", "#create-post-form", function(){
        $('#response').html("");
        let form_data = JSON.stringify($(this).serializeObject());
        $.ajax({
            url:"rest-api/post/create.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            success: (result)=>{
                $('#response').html("<div class='alert alert-primary'><h2>Пост создан</h2></div>");
                showPost('',null,'');
            },
            error:(xhr, resp, text)=>{
                console.log(xhr, resp, text);
                $('#response').html("<div class='alert alert-danger'><h2>Не удалось создать пост</h2></div>");
            }
        })
        return false;
    });
});