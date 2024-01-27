$.fn.serializeObject = function(){
    var o={};
    var a=this.serializeArray();
    $.each(a,function(){
        if(o[this.name] != undefined){
            if(!o[this.name].push){
                o[this.name]=[o[this.name]]
            }
            o[this.name].push(this.value || "");
        }else{
            o[this.name]=this.value || "";
        }
    });
    return o;
};
function showLogOutMenu(){
    $("#login, #sign_up").show();
    $("#logout, #profile").hide();
}
function showLogInMenu(){
    $("#login, #sign_up").hide();
    $("#logout, #profile").show();
}
function setCookie(cname,cvalue,exdays){
    var d=new Date();
    d.setTime(d.setTime()+(exdays*60*60*24));
    var expires="expires="+d.toUTCString();
    document.cookie=cname+"="+cvalue+";"+expires+";path=/";
}
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
function deleteCookie(name) {
    document.cookie=name+"=; max-age=-1";
}
function authCheck(){
    let id=getCookie('id');
    let jwt=getCookie('jwt');
    if(id!=undefined && jwt!=undefined){
        return true;
    }else{
        return false;
    }
}
if(authCheck()){
    showLogInMenu()
}else{
    showLogOutMenu()
}