function login() {
    $.ajax({
        method: "post",
        url: "api/auth/login.php",
        data: $('#loginForm').serialize()
    }).done(function (res) {
        console.log(res);
        window.location = 'dashboard.php';
    }).fail(function (res) {
        console.log(res);
        swal({
            title: res.responseJSON['message'],
            icon: "error"
        });
    });
}