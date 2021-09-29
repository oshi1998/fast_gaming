function myprofile() {
    $.ajax({
        method: "post",
        url: "app/api/myaccount/myprofile.php"
    }).done(function (res) {
        let data = res.data;

        $('#username').val(data['cus_username']);
        $('#firstname').val(data['cus_firstname']);
        $('#lastname').val(data['cus_lastname']);
        $('#email').val(data['cus_email']);
        $('#gender').val(data['cus_gender']);
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

function updateProfile() {
    $.ajax({
        method: "post",
        url: "app/api/myaccount/update_profile.php",
        data: $('#profileForm').serialize()
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

function updateAddress(){
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

function updatePassword(){
    $.ajax({
        method: "post",
        url: "app/api/myaccount/update_password.php",
        data: $('#passwordForm').serialize()
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