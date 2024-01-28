jQuery(($)=>{
    $(document).on("click", ".update-one-post-button",(e)=>{
        $('#response').html("");
        const id = $(e.target).attr("data-id");
        $.getJSON("rest-api/post/read_one.php?id="+id, (data1)=>{
            $.getJSON("rest-api/topic/read.php", (data2)=>{
                let topic_option = `<select name="topic_id" class="form-control">`
                $.each(data2.records, (key , val)=>{
                    if(data1.topic_id==val.id){
                        topic_option += `<option value="`+val.id+`" selected>` + val.name + `</option>`;
                    }else{
                        topic_option += `<option value="`+val.id+`">` + val.name + `</option>`;
                    }  
                })
                topic_option += `</select>`;
                
                let create_post = `
                    <div id="read-posts" class="btn btn-primary read-post-button">
                    Посты
                    </div>
                    <form action="#" id="update-post-form" method="post" border="0">
                        <input type="hidden" name="id" value="`+data1.id+`">
                        <input type="hidden" name="user_id" value="`+data1.user_id+`">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <td>Название</td>
                                <td><input type="text" name="title" class="form-control" value="`+data1.title+`" required></td>
                            </tr>
                            <tr>
                                <td>Текст</td>
                                <td><textarea  name="text" class="form-control" required>`+data1.text+`</textarea></td>
                            </tr>
                            <tr>
                                <td>Тема</td>
                                <td>`+ topic_option +`</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Изменить пост</button>
                                </td>
                            </tr>
                        </table>
                    </form>`;
                $("#app").html(create_post);
            });
        });
    });
    $(document).on("submit", "#update-post-form", function(){
        $('#response').html("");
        let form_data = JSON.stringify($(this).serializeObject());
        console.log(form_data);
        $.ajax({
            url:"rest-api/post/update.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            success: (result)=>{
                $('#response').html("<div class='alert alert-primary'><h2>Данные обновлены</h2></div>");
                showPost('',null,'');
            },
            error:(xhr, resp, text)=>{
                console.log(xhr, resp, text);
                $('#response').html("<div class='alert alert-danger'><h2>Не удалось обновить данные</h2></div>");
            }
        })
        return false;
    })
});