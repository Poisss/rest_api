jQuery(($)=>{
    $(document).on("click",".read-one-product-button",(e)=>{
        $('#response').html("");
        const id = $(e.target).attr("data-id");
        $.getJSON("rest-api/product/read_one.php?id="+id,(data)=>{
            let product_one =`
                            <div id="read-products" class="btn btn-primary read-product-button">
                                Товары
                            </div>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td>Название</td>
                                    <td>`+data.name+`</td>
                                </tr>
                                <tr>
                                    <td>Цена</td>
                                    <td>`+data.price+`</td>
                                </tr>
                                <tr>
                                    <td>Описание</td>
                                    <td>`+data.description+`</td>
                                </tr>
                                <tr>
                                    <td>Категория</td>
                                    <td>`+data.category_name+`</td>
                                </tr>
                            </table>`;
            $("#app").html(product_one);                
        });
    });
});