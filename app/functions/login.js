function submitLogin() {
    $.ajax({
        method: "post",
        url: "app/api/auth/login.php",
        data: $('#loginForm').serialize()
    }).done(function () {
        window.location = 'index.php'
    }).fail(function (res) {
        $('#showAlert').html(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ผิดพลาด!</strong> ${res.responseJSON['message']}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
    });
}