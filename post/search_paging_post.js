jQuery(($)=>{
    $(document).on("submit","#search-post-form",function(){
        $('#response').html("");
        const keywords=$(this).find("input[name='keywords']").val();
        const topic=$(this).find("select[name='topic']").val();
        showPost(keywords,topic,"");
        return false
    });
    $(document).on("click",".paging_item",function(){
        $('#response').html("");
        const url = $(this).attr("data-url");
        const keywords=$(this).attr("data-keywords");
        const topic=$(this).attr("data-topic");
        showPost(keywords,topic,url);
        return false
    });
});
