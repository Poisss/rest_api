jQuery(($)=>{
    $(document).on("click", ".delete-one-post-button",(e)=>{
        $('#response').html("");
        const id = $(e.target).attr("data-id");
        let obj={
            id:id
        };
        bootbox.confirm({
            message:'<h4>Вы точно желаете удалить?</h4>',
            buttons:{
                confirm:{
                    label:"Да",
                    className:"btn-danger"
                },
                cancel:{
                    label:"Нет",
                    className:"btn-primary"
                }
            },
            callback:result=>{
                if(result==true){
                    $.ajax({
                        url:"rest-api/post/delete.php",
                        type: "POST",
                        dataType: "json",
                        data: JSON.stringify(obj),
                        success: (result)=>{
                            $('#response').html("<div class='alert alert-primary'><h2>Пост удален</h2></div>");
                            showPost('',null,'');
                        },
                        error:(xhr, resp, text)=>{
                            console.log(xhr, resp, text);
                            $('#response').html("<div class='alert alert-danger'><h2>Не удалось удалить пост</h2></div>");
                        }
                    })
                }
            }
        });
        
        return false;
    });
});