jQuery(($)=>{
    $(document).on("click","#read_posts",()=>{
        $('#response').html("");
        showPost('',null,'');
    });
    $(document).on("click",".read-post-button",()=>{
        $('#response').html("");
        showPost('',null,'');
    });
});

function showPost(keywords,topic,url){
    let url_json="rest-api/post/search_paging.php";
    let attr='?page=1';
    if(url != ''){
        url_json=url;
        attr='';
    }else{
        if(keywords != ''){
            attr+="&keywords="+keywords;
        }
        if(topic != null){
            attr+="&topic="+topic;
        }
    }
    $.getJSON(url_json+attr,(data)=>{
        $.getJSON("rest-api/topic/read.php", (data2)=>{
            let topic_option = `<select name="topic" class="form-control">
            <option value="" disabled selected>Выберите тему</option>`
            $.each(data2.records, (key , val)=>{
                if(topic==val.id){
                    topic_option += `<option value="`+val.id+`" selected>` + val.name + `</option>`;
                }else{
                    topic_option += `<option value="`+val.id+`">` + val.name + `</option>`;
                } 
            })
            topic_option += `</select>`;
            let create_post=`<div>`;
            let size_table=`<th class="w-25-pt">
                                Название
                            </th>
                            <th class="w-15-pt">
                                Текст
                            </th>
                            <th class="w-15-pt">
                                Тема
                            </th>
                            <th class="w-10-pt text-align-center">
                                Действие
                            </th>`;
            if(authCheck()){
                create_post=`
                            <div class="search">
                                <div id="create-post" class="btn btn-primary create-post-button center">
                                    Создание поста
                                </div>
                `;
                size_table=`<th class="w-15-pt">
                                Название
                            </th>
                            <th class="w-10-pt">
                                Текст
                            </th>
                            <th class="w-15-pt">
                                Тема
                            </th>
                            <th class="w-25-pt text-align-center">
                                Действие
                            </th>`;
            }
            let read_posts_html=`
                            <h1 id="page-title">
                                Все посты
                            </h1>
                                `+create_post+`
                                <div class="">
                                    <form action="#" id="search-post-form" method="post">
                                        <div class="input-group ">
                                            <input type="text" value="`+ keywords +`" name="keywords" class="form-control post-search-keywords margin_l_r" placeholder="Поиск постов">                                            
                                            `+ topic_option +`
                                            <button type="submit" class="btn btn-secondary">Найти</button>
                                        </div>
                                    </form> 
                                </div>
                            </div> 
                            <table class="table table-bordered table-hover margin_t_b">
                                <tr>
                                   `+size_table+`
                                </tr>
            `;
            $.each(data.records,(key,val)=>{
                let btn=``;
                if(authCheck()){
                    btn=`<button class="btn btn-info m-t-10px update-one-post-button" data-id="`+val.id+`">Редактировать</button>
                        <button class="btn btn-danger m-t-10px delete-one-post-button" data-id="`+val.id+`">Удалить</button> `;
                }
                read_posts_html+=`
                            <tr>
                                <td>`+val.title+`</td>
                                <td>`+val.text+`</td>
                                <td>`+val.topic_name+`</td>
                                <td>
                                    <button class="btn btn-primary m-t-10px read-one-post-button" data-id="`+val.id+`">Просмотр</button>`+btn+`                          
                                </td>
                            </tr>
                `;
            });
            read_posts_html+=`</table><div class="paging">`;
            let num=1;
            $.each(data.paging.pages, (key , val)=>{
                if(val.current_page=="yes"){
                    read_posts_html+=`<div class="paging_item paging_item_active" 
                    data-url="`+val.url+`" data-keywords="`+keywords+`" data-topic="`+topic+`">`+num+`</div>`;
                }else{
                    read_posts_html+=`<div class="paging_item paging_item_not-active" 
                    data-url="`+val.url+`" data-keywords="`+keywords+`" data-price-min="`+topic+`">`+num+`</div>`;
                }
                
                num++;
            });
            read_posts_html+=`<div>`;

            $('#app').html(read_posts_html);
        });
    });
};