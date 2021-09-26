function read() {
    $.ajax({
        method: "post",
        url: "api/owner/read.php"
    }).done(function (res) {
        console.log(res);

        let data = res.data;
        let data_table;

        data.forEach(element => {
            data_table += `
                <tr>
                    <td>${element['usr_created']}</td>
                    <td>${element['usr_username']}</td>
                    <td>${element['usr_firstname'] + " " + element['usr_lastname']}</td>
                    <td>${element['usr_contact']}</td>
                    <td>
                        <button class="btn btn-primary" onclick="edit('${element['usr_username']}')">
                            <i class="fas fa-edit"></i>
                            <span>แก้ไข</span>
                        </button>
                        <button class="btn btn-danger" onclick="deleteData('${element['usr_username']}')">
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
            "order": [[0, "desc"]],
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
                <label>ชื่อผู้ใช้งาน</label> <strong id="show_result"></strong>
                <input type="text" class="form-control" name="username" id="username" onchange="checkUsername(event.target.value)">
            </div>
            <div class="form-group">
                <label>ชื่อจริง</label>
                <input type="text" class="form-control" name="firstname">
            </div>
            <div class="form-group">
                <label>นามสกุล</label>
                <input type="text" class="form-control" name="lastname">
            </div>
            <div class="form-group">
                <label>ข้อมูลติดต่อ เช่น ที่อยู่, เบอร์โทร เป็นต้น</label>
                <textarea class="form-control" name="contact"></textarea>
            </div>
            <div class="form-group">
                <label>รหัสผ่าน</label>
                <input type="text" class="form-control" name="password">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="create()">
                    <i class="fas fa-edit"></i>
                    <span>บันทึก</span>
                </button>
            </div>
        </form>
    `;

    $('#myModalLabel').text('เพิ่มข้อมูลเจ้าของร้าน');
    $('#myModalBody').html(form);
    $('#myModal').modal('show');
}

function checkUsername(username) {
    $.ajax({
        method: "get",
        url: "api/owner/check_username.php",
        data: {
            "username": username
        }
    }).done(function (res) {
        $('#show_result').text(res.message).css('color', 'green');
    }).fail(function (res) {
        $('#show_result').text(res.responseJSON['message']).css('color', 'red');
        $('#username').val("").focus();
    });
}

function create() {
    $.ajax({
        method: "post",
        url: "api/owner/create.php",
        data: $('#createForm').serialize(),
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

function edit(username) {

    let form;

    $.ajax({
        method: "get",
        url: "api/owner/readByUsername.php",
        data: {
            "username": username
        },
    }).done(function (res) {
        console.log(res);
        let data = res.data;
        form = `
            <form id="updateForm">
                <div class="form-group">
                    <label>ชื่อผู้ใช้งาน</label>
                    <input type="text" class="form-control" name="username" value="${username}" readonly>
                </div>
                <div class="form-group">
                    <label>ชื่อจริง</label>
                    <input type="text" class="form-control" name="firstname" value="${data['usr_firstname']}">
                </div>
                <div class="form-group">
                    <label>นามสกุล</label>
                    <input type="text" class="form-control" name="lastname" value="${data['usr_lastname']}">
                </div>
                <div class="form-group">
                    <label>ข้อมูลติดต่อ เช่น ที่อยู่, เบอร์โทร เป็นต้น</label>
                    <textarea class="form-control" name="contact">${data['usr_contact']}</textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="update()">
                        <i class="fas fa-edit"></i>
                        <span>บันทึก</span>
                    </button>
                </div>
            </form> 
        `;

        $('#myModalLabel').text('แก้ไขข้อมูล ' + username);
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
        url: "api/owner/update.php",
        data: $('#updateForm').serialize(),
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

function deleteData(username) {
    swal({
        title: "คุณต้องการลบข้อมูล " + username + "?",
        text: "หากทำการลบไปแล้ว จะไม่สามารถกู้ข้อมูลคืนได้!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/owner/delete.php",
                data: {
                    "username": username
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