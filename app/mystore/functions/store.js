function read(){
    $.ajax({
        method: "post",
        url: "api/store/read.php"
    }).done(function(res){
        console.log(res);

        let data = res.data;

        $('#name').val(data['st_name']);
        $('#address').val(data['st_address']);
        $('#phone').val(data['st_phone']);
        $('#email').val(data['st_email']);
        $('#preview_logo').prop('src','../images/'+data['st_logo']);
        $('#facebook').val(data['st_facebook']);
        $('#twitter').val(data['st_twitter']);
        $('#ig').val(data['st_ig']);
        $('#youtube').val(data['st_youtube']);
        $('#line').val(data['st_line']);
        $('#description').val(data['st_description']);
        $('#keywords').val(data['st_keywords']);
        $('#author').val(data['st_author']);
    }).fail(function(res){
        swal({
            title: "เกิดข้อผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}

function readFile(event){
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('preview_logo');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function submitForm1(){

    let fd = new FormData(document.getElementById("form1"));

    $.ajax({
        method: "post",
        url: "api/store/update_form1.php",
        data: fd,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(res){
        console.log(res);
        swal({
            title: "สำเร็จ",
            text: res.message,
            icon: "success"
        }).then(()=>{
            window.location.reload();
        })
    }).fail(function(res){
        swal({
            title: "เกิดข้อผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });

}

function submitForm2(){
    $.ajax({
        method: "post",
        url: "api/store/update_form2.php",
        data: $('#form2').serialize(),
    }).done(function(res){
        console.log(res);
        swal({
            title: "สำเร็จ",
            text: res.message,
            icon: "success"
        }).then(()=>{
            window.location.reload();
        })
    }).fail(function(res){
        swal({
            title: "เกิดข้อผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}

function submitForm3(){
    $.ajax({
        method: "post",
        url: "api/store/update_form3.php",
        data: $('#form3').serialize(),
    }).done(function(res){
        console.log(res);
        swal({
            title: "สำเร็จ",
            text: res.message,
            icon: "success"
        }).then(()=>{
            window.location.reload();
        })
    }).fail(function(res){
        swal({
            title: "เกิดข้อผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}