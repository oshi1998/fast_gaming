var defaultAmount;

function addCart(product_id) {
    $.ajax({
        method: "post",
        url: "app/api/cart/add.php",
        data: {
            "id": product_id
        }
    }).done(function () {
        window.location = 'mycart.php'
    }).fail(function (res) {
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}

function removeCart(product_id) {
    swal({
        title: "ยืนยันการลบสินค้า " + product_id + "?",
        text: "หากดำเนินการไปแล้ว จะไม่สามารถกู้คืนได้",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                method: "get",
                url: "app/api/cart/remove.php",
                data: {
                    "id": product_id
                }
            }).done(function () {
                window.location.reload();
            }).fail(function (res) {
                swal({
                    title: "ผิดพลาด",
                    text: res.responseJSON['message'],
                    icon: "error"
                });
            });
        } else {
            return;
        }
    });
}

function updateView(product_id) {
    $.ajax({
        method: "get",
        url: "app/api/product/update_view.php",
        data: {
            "pro_id": product_id
        }
    });
}

function setDefaultAmount(amount) {
    defaultAmount = amount;
}

function updateAmount(amount, pro_id, qty) {
    if (amount == 0) {
        swal({
            title: "ผิดพลาด",
            text: "จำนวนสินค้าต้องมากกว่า 0",
            icon: "error"
        });
        $("#" + pro_id).val(defaultAmount);
        return false;
    } else if (amount > qty) {
        swal({
            title: "ผิดพลาด",
            text: "เรามีสินค้าเพียงแค่ " + qty,
            icon: "error"
        });
        $("#" + pro_id).val(defaultAmount);
        return false;
    } else {
        $.ajax({
            method: "post",
            url: "app/api/cart/update.php",
            data: {
                "pro_id":pro_id,
                "amount":amount
            }
        }).done(function(res){
            swal({
                title: "สำเร็จ",
                text: res.message,
                icon: "success"
            }).then(()=>{
                window.location.reload();
            });
        }).fail(function(res){
            swal({
                title: "ผิดพลาด",
                text: res.responseJSON['message'],
                icon: "error"
            });
        });
    }


}