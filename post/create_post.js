jQuery(($)=>{
    $(document).on("click", ".create-product-button",()=>{
        $('#response').html("");
        $.getJSON("rest-api/category/read.php", (data)=>{
            let category_option = `<select name="category_id" class="form-control">`
            $.each(data.records, (key , val)=>{
                category_option += `<option value="`+val.id+`">` + val.name + `</option>`;
            })
            category_option += `</select>`;
            let create_product = `
            <div id="read-products" class="btn btn-primary read-product-button">
            Товары
            </div>
            <form action="#" id="create-product-form" method="post" border="0">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>Название</td>
                        <td><input type="text" name="name" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td>Цена</td>
                        <td><input type="number" name="price" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td>Описание</td>
                        <td><textarea  name="description" class="form-control" required> </textarea></td>
                    </tr>
                    <tr>
                        <td>Категория</td>
                        <td>`+ category_option +`</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-primary">Создать товар</button>
                        </td>
                    </tr>
                </table>
            </form>`;
            $("#app").html(create_product);
        });
    });
    $(document).on("submit", "#create-product-form", function(){
        $('#response').html("");
        let form_data = JSON.stringify($(this).serializeObject());
        $.ajax({
            url:"rest-api/product/create.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            success: (result)=>{
                $('#response').html("<div class='alert alert-primary'><h2>Продукт создан</h2></div>");
                showProducts('','','',null,'');
            },
            error:(xhr, resp, text)=>{
                console.log(xhr, resp, text);
                $('#response').html("<div class='alert alert-danger'><h2>Не удалось создать продукт</h2></div>");
            }
        })
        return false;
    });
});