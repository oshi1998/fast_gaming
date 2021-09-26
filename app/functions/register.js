function checkUsername(username) {
    $.ajax({
        method: "get",
        url: "app/api/register/checkUsername.php",
        data: {
            "username": username
        }
    }).done(function (res) {
        $('#showAlert').html(
            `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>สำเร็จ!</strong> ${res.message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
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
        $('#inputUsername').val("").focus();
    });
}

function submitRegister() {
    $.ajax({
        method: "post",
        url: "app/api/register/create.php",
        data: $('#registerForm').serialize()
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