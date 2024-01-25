jQuery(($)=>{
    $('#response').html("");
    $(document).on("submit","#read_prod",()=>{
        showProducts('','','','');
    });
});
