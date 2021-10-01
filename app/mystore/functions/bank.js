function read() {
    $.ajax({
        method: "post",
        url: "api/bank/read.php"
    }).done(function (res) {
        console.log(res);

        let data = res.data;

        let data_table;
        let no = 1;

        data.forEach(element => {
            data_table += `
                <tr>
                    <td>${no++}</td>
                    <td>${element['bank_created']}</td>
                    <td>${element['bank_name']}</td>
                    <td>${element['bank_acc_number']}</td>
                    <td>${element['bank_acc_name']}</td>
                    <td>
                        <button class="btn btn-primary" onclick="edit('${element['bank_id']}')">
                            <i class="fas fa-edit"></i>
                            <span>แก้ไข</span>
                        </button>
                        <button class="btn btn-danger" onclick="deleteData('${element['bank_id']}')">
                            <i class="fas fa-trash"></i>
                            <span>ลบ</span>
                        </button>
                    </td>
                </tr>
            `;
        });

        $('#databody').html(data_table);
        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "order": [[0, "asc"]],
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    }).fail(function (res) {
        swal({
            title: "เกิดข้อผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}

function add() {
    let form = `
    <form id="createForm">

    <div class="form-group">
        <label>ชื่อธนาคาร</label>
        <input type="text" class="form-control" name="bank_name">
    </div>

    <div class="form-group">
        <label>เลขบัญชี</label>
        <input type="text" class="form-control" name="acc_number">
    </div>

    <div class="form-group">
        <label>ชื่อบัญชี</label>
        <input type="text" class="form-control" name="acc_name">
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="create()">
            <i class="fas fa-edit"></i>
            <span>บันทึก</span>
        </button>
    </div>
</form>
    `;

    $('#myModalLabel').text('เพิ่มข้อมูลบัญชีธนาคาร');
    $('#myModalBody').html(form);
    $('#myModal').modal('show');
}

function create() {
    $.ajax({
        method: "post",
        url: "api/bank/create.php",
        data: $('#createForm').serialize()
    }).done(function (res) {
        console.log(res);
        swal({
            title: "สำเร็จ",
            text: res.message,
            icon: "success"
        }).then(() => {
            window.location.reload();
        })
    }).fail(function (res) {
        swal({
            title: "เกิดข้อผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}

function edit(id) {

    let form;

    $.ajax({
        method: "get",
        url: "api/bank/readById.php",
        data: {
            "id": id
        },
    }).done(function (res) {
        console.log(res);

        let data = res.data;
        form = `
        <form id="updateForm">

            <div class="form-group">
                <label>รหัส</label>
                <input type="text" class="form-control" name="id" id="id" value="${id}" readonly>
            </div>

            <div class="form-group">
                <label>ชื่อธนาคาร</label>
                <input type="text" class="form-control" name="bank_name" value="${data['bank_name']}">
            </div>

            <div class="form-group">
                <label>เลขบัญชี</label>
                <input type="text" class="form-control" name="acc_number" value="${data['bank_acc_number']}">
            </div>

            <div class="form-group">
                <label>ชื่อบัญชี</label>
                <input type="text" class="form-control" name="acc_name" value="${data['bank_acc_name']}">
            </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="update()">
                <i class="fas fa-edit"></i>
                <span>บันทึก</span>
            </button>
        </div>
    </form> 
        `;

        $('#myModalLabel').text('แก้ไขข้อมูล ' + id);
        $('#myModalBody').html(form);
        $('#myModal').modal('show');
    }).fail(function (res) {
        swal({
            title: "เกิดข้อผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}

function update() {
    $.ajax({
        method: "post",
        url: "api/bank/update.php",
        data: $('#updateForm').serialize()
    }).done(function (res) {
        console.log(res);
        swal({
            title: "สำเร็จ",
            text: res.message,
            icon: "success"
        }).then(() => {
            window.location.reload();
        })
    }).fail(function (res) {
        swal({
            title: "เกิดข้อผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}

function deleteData(id) {
    swal({
        title: "ยืนยันการลบรหัส " + id + "?",
        text: "หากดำเนินการไปแล้ว จะไม่สามารถกู้คืนได้",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/bank/delete.php",
                data: {
                    "id": id
                }
            }).done(function (res) {
                console.log(res);
                swal({
                    title: "สำเร็จ",
                    text: res.message,
                    icon: "success"
                }).then(() => {
                    window.location.reload();
                })
            }).fail(function (res) {
                swal({
                    title: "เกิดข้อผิดพลาด",
                    text: res.responseJSON['message'],
                    icon: "error"
                });
            });
        } else {
            return;
        }
    });
}