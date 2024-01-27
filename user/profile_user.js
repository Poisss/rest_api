jQuery(($)=>{
    $(document).on("click","#profile",(e)=>{
        $('#response').html("");
        showProfile();
    });   
});
function showProfile(){
    const id = getCookie('id');
        $.getJSON("rest-api/user/read_one.php?id="+id,(data)=>{
            let user_one =`
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td>Имя</td>
                                    <td>`+data.firstname +`</td>
                                </tr>
                                <tr>
                                    <td>Фамилия</td>
                                    <td>`+data.lastname +`</td>
                                </tr>
                                <tr>
                                    <td>Отчество</td>
                                    <td>`+data.patronymic+`</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>`+data.email+`</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button class="btn btn-primary m-t-10px update-one-user-button" >
                                            Редактировать
                                        </button>
                                    </td>
                                </tr>
                            </table>`;
            $("#app").html(user_one);                
        });
}