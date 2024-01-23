jQuery(($)=>{
    $('#response').html("");
    $(document).on("click","#read_products",()=>{
        showProducts();
    });
    $(document).on("click",".read-product-button",()=>{
        showProducts();
    });
});

function showProducts(){
    $.getJSON("rest-api/product/read.php",(data)=>{
        
        let read_products_html=`
                        <h1 id="page-title">
                            Все товары
                        </h1>
                        <div id="create-product" class="btn btn-primary create-product-button">
                            Создание товара
                        </div>
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th class="w-15-pt">
                                    Название
                                </th>
                                <th class="w-10-pt">
                                    Цена
                                </th>
                                <th class="w-15-pt">
                                    Категория
                                </th>
                                <th class="w-25-pt text-align-center">
                                    Действие
                                </th>
                            </tr>
        `;
        $.each(data.records,(key,val)=>{
            read_products_html+=`
                        <tr>
                            <td>`+val.name+`</td>
                            <td>`+val.price+`</td>
                            <td>`+val.category_name+`</td>
                            <td>
                                <button class="btn btn-primary m-t-10px read-one-product-button" data-id="`+val.id+`">Просмотр</button>
                                <button class="btn btn-info m-t-10px update-one-product-button" data-id="`+val.id+`">Редактировать</button>
                                <button class="btn btn-danger m-t-10px delete-one-product-button" data-id="`+val.id+`">Удалить</button>                            
                            </td>
                        </tr>
            `;
        });
        read_products_html+=`</table>`;

        $('#app').html(read_products_html);
    });
};