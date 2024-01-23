jQuery(($)=>{
    $(document).on("click", ".delete-one-product-button",(e)=>{
        const id = $(e.target).attr("data-id");
        let obj={
            id:id
        };
        $.ajax({
            url:"rest-api/product/delete.php",
            type: "POST",
            dataType: "json",
            data: JSON.stringify(obj),
            success: (result)=>{
                showProducts();
            },
            error:(xhr, resp, text)=>{
                console.log(xhr, resp, text);
            }
        })
        return false;
    });
});