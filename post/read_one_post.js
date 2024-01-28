jQuery(($)=>{
    $(document).on("click",".read-one-post-button",(e)=>{
        $('#response').html("");
        const id = $(e.target).attr("data-id");
        $.getJSON("rest-api/post/read_one.php?id="+id,(data)=>{
            let post_one =`
                            <div id="read-posts" class="btn btn-primary read-post-button">
                                Посты
                            </div>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td>Название</td>
                                    <td>`+data.title+`</td>
                                </tr>
                                <tr>
                                    <td>Описание</td>
                                    <td>`+data.text+`</td>
                                </tr>
                                <tr>
                                    <td>Категория</td>
                                    <td>`+data.topic_name+`</td>
                                </tr>
                            </table>`;
            $("#app").html(post_one);                
        });
    });
});