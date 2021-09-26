function read() {
    $.ajax({
        method: "post",
        url: "api/customer/read.php"
    }).done(function (res) {
        console.log(res);

        let data = res.data;
        let data_table;

        data.forEach(element => {
            data_table += `
                <tr>
                    <td>${element['cus_created']}</td>
                    <td>${element['cus_username']}</td>
                    <td>${element['cus_firstname'] + " " + element['cus_lastname']}</td>
                    <td>
                        ที่อยู่: ${element['cus_address']} <br>
                        เบอร์โทร: ${element['cus_phone']} <br>
                        อีเมล: ${element['cus_email']}
                    </td>
                    <td>
                        <button class="btn btn-primary" onclick="edit('${element['cus_username']}')">
                            <i class="fas fa-edit"></i>
                            <span>แก้ไข</span>
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
                <label>ที่อยู่</label>
                <textarea class="form-control" name="address"></textarea>
            </div>
            <div class="form-group">
                <label>เบอร์โทร</label>
                <input type="text" class="form-control" name="phone">
            </div>
            <div class="form-group">
                <label>อีเมล</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label>เพศ</label>
                <select class="form-control" name="gender">
                    <option value="" selected disabled>--- เลือกเพศ ---</option>
                    <option value="ชาย">ชาย</option>
                    <option value="หญิง">หญิง</option>
                </select>
            </div>
            <div class="form-group">
                <label>รหัสผ่าน</label>
                <input type="password" class="form-control" name="password">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="create()">
                    <i class="fas fa-edit"></i>
                    <span>บันทึก</span>
                </button>
            </div>
        </form>
    `;

    $('#myModalLabel').text('เพิ่มข้อมูลลูกค้า');
    $('#myModalBody').html(form);
    $('#myModal').modal('show');
}

function checkUsername(username) {
    $.ajax({
        method: "get",
        url: "api/customer/check_username.php",
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
        url: "api/customer/create.php",
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
        url: "api/customer/readByUsername.php",
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
            <input type="text" class="form-control" name="firstname" value="${data['cus_firstname']}">
        </div>
        <div class="form-group">
            <label>นามสกุล</label>
            <input type="text" class="form-control" name="lastname" value="${data['cus_lastname']}">
        </div>
        <div class="form-group">
            <label>ที่อยู่</label>
            <textarea class="form-control" name="address">${data['cus_address']}</textarea>
        </div>
        <div class="form-group">
            <label>เบอร์โทร</label>
            <input type="text" class="form-control" name="phone" value="${data['cus_phone']}">
        </div>
        <div class="form-group">
            <label>อีเมล</label>
            <input type="email" class="form-control" name="email" value="${data['cus_email']}">
        </div>
        <div class="form-group">
            <label>เพศ</label>
            <select class="form-control" name="gender" id="gender">
                <option value="ชาย">ชาย</option>
                <option value="หญิง">หญิง</option>
            </select>
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
        $('#gender').val(data['cus_gender']);
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
        url: "api/customer/update.php",
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