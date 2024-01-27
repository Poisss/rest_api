jQuery(($)=>{
    $(document).on("submit","#search-product-form",function(){
        $('#response').html("");
        const keywords=$(this).find("input[name='keywords']").val();
        const price_min=$(this).find("input[name='price_min']").val();
        const price_max=$(this).find("input[name='price_max']").val();
        const category_id=$(this).find("select[name='category_id']").val();
        showProducts(keywords,price_min,price_max,category_id,'');
        return false
    });
    $(document).on("click",".paging_item",function(){
        $('#response').html("");
        const url = $(this).attr("data-url");
        const keywords=$(this).attr("data-keywords");
        const price_min=$(this).attr("data-price-min");
        const price_max=$(this).attr("data-price-max");
        const category_id=$(this).attr("data-category-id");
        showProducts(keywords,price_min,price_max,category_id,url);
        return false
    });
});
