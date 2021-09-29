function addCart(product_id){
    $.ajax({
        method: "post",
        url: "app/api/cart/add.php",
        data: {
            "id" : product_id
        }
    }).done(function(){
        window.location = 'mycart.php'
    }).fail(function(res){
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}