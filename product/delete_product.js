jQuery(($)=>{
    $(document).on("click", ".delete-one-product-button",(e)=>{
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
                        url:"rest-api/product/delete.php",
                        type: "POST",
                        dataType: "json",
                        data: JSON.stringify(obj),
                        success: (result)=>{
                            showProducts();
                        },
                        error:(xhr, resp, text)=>{
                            console.log(xhr, resp, text);
                        }
                    })
                }
            }
        });
        
        return false;
    });
});