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
                "pro_id": pro_id,
                "amount": amount
            }
        }).done(function (res) {
            swal({
                title: "สำเร็จ",
                text: res.message,
                icon: "success"
            }).then(() => {
                window.location.reload();
            });
        }).fail(function (res) {
            swal({
                title: "ผิดพลาด",
                text: res.responseJSON['message'],
                icon: "error"
            });
        });
    }


}

function updateShipping(shipping_id) {
    $.ajax({
        method: "post",
        url: "app/api/cart/update_shipping.php",
        data: {
            "id": shipping_id
        }
    }).done(function (res) {
        swal({
            title: "สำเร็จ",
            text: res.message,
            icon: "success"
        }).then(() => {
            window.location.reload();
        });
    }).fail(function (res) {
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}

function checkShipping() {
    $.ajax({
        method: "get",
        url: "app/api/cart/check_shipping.php"
    }).done(function (res) {
        let shipping = res.shipping;
        $('#shipping').val(shipping);
    }).fail(function () {
        return false;
    });
}

function usingDC() {

    let code = $.trim($('#code').val());

    if (code != "" && code != null) {
        $.ajax({
            method: "post",
            url: "app/api/cart/update_dc.php",
            data: {
                "code": code
            }
        }).done(function (res) {
            swal({
                title: "สำเร็จ",
                text: res.message,
                icon: "success"
            }).then(() => {
                window.location.reload();
            });
        }).fail(function (res) {
            swal({
                title: "ผิดพลาด",
                text: res.responseJSON['message'],
                icon: "error"
            });
        });
    } else {
        swal({
            title: "ผิดพลาด",
            text: "คุณยังไม่ได้ใส่โค้ดส่วนลด!",
            icon: "error"
        });
    }
}

function checkDC() {
    $.ajax({
        method: "get",
        url: "app/api/cart/check_discount.php"
    }).done(function (res) {
        let discount = res.discount;
        $('#code').val(discount);
        $('#code').prop('disabled', true);
    }).fail(function () {
        return false;
    });
}

function cancelDC() {
    swal({
        title: "ยืนยันการยกเลิกใช้โค้ดส่วนลด?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                method: "get",
                url: "app/api/cart/cancel_dc.php",
            }).done(function (res) {
                swal({
                    title: "สำเร็จ",
                    text: res.message,
                    icon: "success"
                }).then(() => {
                    window.location.reload();
                });
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

function checkbill() {
    let shipping = $('#shipping').val();

    if (shipping != "" && shipping != null) {
        window.location = 'checkbill.php'
    } else {
        swal({
            title: "ผิดพลาด",
            text: "ท่านยังไม่ได้เลือกการจัดส่ง",
            icon: "error",
        });
        $('#shipping').focus();
        return false;
    }
}

function updatePaymentMethod(payment_method) {
    $.ajax({
        method: "post",
        url: "app/api/cart/update_payment_method.php",
        data: {
            "payment_method": payment_method
        }
    }).done(function (res) {
        swal({
            title: "สำเร็จ",
            text: res.message,
            icon: "success"
        }).then(() => {
            window.location.reload();
        });
    }).fail(function (res) {
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}

function checkPaymentMethod() {
    $.ajax({
        method: "get",
        url: "app/api/cart/check_payment_method.php"
    }).done(function (res) {
        let payment_method = res.payment_method;
        $('#payment_method').val(payment_method);
    }).fail(function () {
        return false;
    });
}