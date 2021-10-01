var address, phone;

function myprofile() {
    $.ajax({
        method: "post",
        url: "app/api/myaccount/myprofile.php"
    }).done(function (res) {
        let data = res.data;

        address = data['cus_address'];
        phone = data['cus_phone'];

        $('#address').val(data['cus_address']);
        $('#phone').val(data['cus_phone']);
    }).fail(function (res) {
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        }).then(() => {
            window.location = 'index.php';
        });
    });
}

function updateAddress() {
    $.ajax({
        method: "post",
        url: "app/api/myaccount/update_address.php",
        data: $('#addressForm').serialize()
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

function order() {

    if (address == "" || address == null) {
        swal({
            title: "ผิดพลาด",
            text: "ข้อมูลที่อยู่สำหรับจัดส่งของท่าน ยังไม่ถูกต้องและครบถ้วน กรุณากรอกข้อมูลที่อยู่",
            icon: "error"
        }).then(() => {
            $('#address').focus();
            return false;
        })
    } else if (phone == "" || phone == null) {
        swal({
            title: "ผิดพลาด",
            text: "ข้อมูลที่อยู่สำหรับจัดส่งของท่าน ยังไม่ถูกต้องและครบถ้วน กรุณากรอกเบอร์โทร",
            icon: "error"
        }).then(() => {
            $('#phone').focus();
            return false;
        });
    } else {
        swal({
            title: "ยืนยันการสั่งซื้อสินค้า?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willConfirm) => {
            if (willConfirm) {
                $.ajax({
                    method: "post",
                    url: "app/api/cart/order.php",
                }).done(function (res) {
                    swal({
                        title: "สำเร็จ",
                        text: res.message,
                        icon: "success"
                    }).then(() => {
                        window.location = 'myaccount.php';
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
}
