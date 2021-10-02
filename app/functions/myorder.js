function chooseBank(bank_id) {
    $.ajax({
        method: "get",
        url: "app/mystore/api/bank/readById.php",
        data: {
            "id": bank_id
        }
    }).done(function (res) {
        let data = res.data;
        $('#re_bank').val(data['bank_name']);
        $('#re_acc_number').val(data['bank_acc_number']);
        $('#re_acc_name').val(data['bank_acc_name']);
    });
}

function submitTransaction(){

    let fd = new FormData(document.getElementById("transactionForm"));

    $.ajax({
        method: "post",
        url: "app/api/transaction/create.php",
        data: fd,
        cache: false,
        contentType: false,
        processData: false
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