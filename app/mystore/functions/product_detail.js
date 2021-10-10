CKEDITOR.replace('detail', {
    extraPlugins: 'filebrowser',
    filebrowserUploadMethod: 'form',
    filebrowserUploadUrl: 'api/product/uploadImg.php',
});

function submit() {

    let fd = new FormData(document.getElementById("detailForm"));
    fd.append("detail",CKEDITOR.instances.detail.getData());

    $.ajax({
        method: "post",
        url: "api/product/update_detail.php",
        data: fd,
        cache: false,
        contentType: false,
        processData: false
    }).done(function (res) {
        console.log(res);
        swal({
            title: "สำเร็จ",
            text: res.message,
            icon: "success"
        }).then(() => {
            window.location = "product.php"
        });
    }).fail(function (res) {
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON["message"],
            icon: "error"
        });
    });
}