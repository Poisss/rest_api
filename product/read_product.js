jQuery(($)=>{
    $(document).on("click","#read_products",()=>{
        $('#response').html("");
        showProducts('','','',null,'');
    });
    $(document).on("click",".read-product-button",()=>{
        $('#response').html("");
        showProducts('','','',null,'');
    });
});

function showProducts(keywords,price_min,price_max,category_id,url){
    let url_json="rest-api/product/search_paging.php";
    let attr='?page=1';
    if(url != ''){
        url_json=url;
        attr='';
    }else{
        if(keywords != ''){
            attr+="&keywords="+keywords;
        }
        if(price_min != '' && price_max != ''){
            attr+="&price="+price_min+"-"+price_max;
        }
        if(category_id != null){
            attr+="&category="+category_id;
        }
    }
    $.getJSON(url_json+attr,(data)=>{
        $.getJSON("rest-api/category/read.php", (data2)=>{
            let category_option = `<select name="category_id" class="form-control">
            <option value="" disabled selected>Выберите категорию</option>`
            $.each(data2.records, (key , val)=>{
                if(category_id==val.id){
                    category_option += `<option value="`+val.id+`" selected>` + val.name + `</option>`;
                }else{
                    category_option += `<option value="`+val.id+`">` + val.name + `</option>`;
                } 
            })
            category_option += `</select>`;
            let read_products_html=`
                            <h1 id="page-title">
                                Все товары
                            </h1>
                            <div class="search">
                                <div id="create-product" class="btn btn-primary create-product-button center">
                                    Создание товара
                                </div>
                                <div class="">
                                    <form action="#" id="search-product-form" method="post">
                                        <div class="input-group ">
                                            <input type="text" value="`+ keywords +`" name="keywords" class="form-control product-search-keywords margin_l_r" placeholder="Поиск товаров">
                                            <div>
                                                <p>Цена</p>
                                                <input type="number" value="`+ price_min +`" name="price_min" placeholder="от">
                                                <input type="number" value="`+ price_max +`" name="price_max" placeholder="до">
                                            </div>
                                            `+ category_option +`
                                            <button type="submit" class="btn btn-secondary">Найти</button>
                                        </div>
                                    </form> 
                                </div>
                            </div> 
                            <table class="table table-bordered table-hover margin_t_b">
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
            read_products_html+=`</table><div class="paging">`;
            let num=1;
            $.each(data.paging.pages, (key , val)=>{
                if(val.current_page=="yes"){
                    read_products_html+=`<div class="paging_item paging_item_active" 
                    data-url="`+val.url+`" data-keywords="`+keywords+`" data-price-min="`+price_min+`" 
                    data-price-max="`+price_max+`" data-category-id="`+category_id+`">`+num+`</div>`;
                }else{
                    read_products_html+=`<div class="paging_item paging_item_not-active" 
                    data-url="`+val.url+`" data-keywords="`+keywords+`" data-price-min="`+price_min+`" 
                    data-price-max="`+price_max+`" data-category-id="`+category_id+`">`+num+`</div>`;
                }
                
                num++;
            });
            read_products_html+=`<div>`;

            $('#app').html(read_products_html);
        });
    });
};