jQuery(($)=>{
    $(document).on("click", ".update-one-product-button",(e)=>{
        $('#response').html("");
        const id = $(e.target).attr("data-id");
        $.getJSON("rest-api/product/read_one.php?id="+id, (data1)=>{
            $.getJSON("rest-api/category/read.php", (data2)=>{
                let category_option = `<select name="category_id" class="form-control">`
                $.each(data2.records, (key , val)=>{
                    if(data1.category_id==val.id){
                        category_option += `<option value="`+val.id+`" selected>` + val.name + `</option>`;
                    }else{
                        category_option += `<option value="`+val.id+`">` + val.name + `</option>`;
                    }  
                })
                category_option += `</select>`;
                
                let create_product = `
                    <div id="read-products" class="btn btn-primary read-product-button">
                    Товары
                    </div>
                    <form action="#" id="update-product-form" method="post" border="0">
                        <input type="hidden" name="id" value="`+data1.id+`">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <td>Название</td>
                                <td><input type="text" name="name" class="form-control" value="`+data1.name+`" required></td>
                            </tr>
                            <tr>
                                <td>Цена</td>
                                <td><input type="number" name="price" class="form-control" value="`+data1.price+`" required></td>
                            </tr>
                            <tr>
                                <td>Описание</td>
                                <td><textarea  name="description" class="form-control" required>`+data1.description+`</textarea></td>
                            </tr>
                            <tr>
                                <td>Категория</td>
                                <td>`+ category_option +`</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Изменить товар</button>
                                </td>
                            </tr>
                        </table>
                    </form>`;
                $("#app").html(create_product);
            });
        });
    });
    $(document).on("submit", "#update-product-form", function(){
        $('#response').html("");
        let form_data = JSON.stringify($(this).serializeObject());
        console.log(form_data);
        $.ajax({
            url:"rest-api/product/update.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            success: (result)=>{
                $('#response').html("<div class='alert alert-primary'><h2>Данные обновлены</h2></div>");
                showProducts('','','',null,'');
            },
            error:(xhr, resp, text)=>{
                console.log(xhr, resp, text);
                $('#response').html("<div class='alert alert-danger'><h2>Не удалось обновить данные</h2></div>");
            }
        })
        return false;
    })
});