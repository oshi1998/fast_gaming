var defaultCode = "";

function read() {
    $.ajax({
        method: "post",
        url: "api/discount_code/read.php"
    }).done(function (res) {
        console.log(res);

        let data = res.data;

        let data_table;
        let no = 1;

        data.forEach(element => {
            data_table += `
                <tr>
                    <td>${no++}</td>
                    <td>${element['dc_created']}</td>
                    <td>${element['dc_code']}</td>
                    <td>${element['dc_type']}</td>
                    <td>${element['dc_value']}</td>
                    <td>
                        <button class="btn btn-primary" onclick="edit('${element['dc_id']}')">
                            <i class="fas fa-edit"></i>
                            <span>แก้ไข</span>
                        </button>
                        <button class="btn btn-danger" onclick="deleteData('${element['dc_id']}')">
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
        <label>โค้ดส่วนลด</label> <strog id="show_result"></strog>
        <input type="text" class="form-control" name="code" id="code" onchange="checkCode(event.target.value)">
    </div>

    <div class="form-group">
        <label>ประเภท</label>
        <select class="form-control" name="type">
            <option value="ส่วนลดเปอร์เซ็น">ส่วนลดเปอร์เซ็น</option>
            <option value="ส่วนลดเงินสด">ส่วนลดเงินสด</option>
        </select>
    </div>

    <div class="form-group">
        <label>มูลค่า</label>
        <input type="number" class="form-control" name="value">
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="create()">
            <i class="fas fa-edit"></i>
            <span>บันทึก</span>
        </button>
    </div>
</form>
    `;

    $('#myModalLabel').text('เพิ่มข้อมูลโค้ดส่วนลด');
    $('#myModalBody').html(form);
    $('#myModal').modal('show');
}

function setDefaultCode(code) {
    defaultCode = code;
    console.log(defaultCode);
}

function checkCode(code) {
    $.ajax({
        method: "get",
        url: "api/discount_code/check_code.php",
        data: {
            "code": code
        }
    }).done(function (res) {
        $('#show_result').text(res.message).css('color', 'green');
    }).fail(function (res) {
        $('#show_result').text(res.responseJSON['message']).css('color', 'red');
        $('#code').val("").focus();
    });
}

function checkEditCode(code) {


    if (code != defaultCode) {
        $.ajax({
            method: "get",
            url: "api/discount_code/check_code.php",
            data: {
                "code": code
            }
        }).done(function (res) {
            $('#show_result').text(res.message).css('color', 'green');
        }).fail(function (res) {
            $('#show_result').text(res.responseJSON['message']).css('color', 'red');
            $('#code').val("").focus();
        });
    } else {
        $('#show_result').text("");
        return;
    }
}

function create() {
    $.ajax({
        method: "post",
        url: "api/discount_code/create.php",
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
        url: "api/discount_code/readById.php",
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
            <input type="text" class="form-control" name="id" value="${id}" readonly>
        </div>

        <div class="form-group">
            <label>โค้ดส่วนลด</label> <strog id="show_result"></strog>
            <input type="text" class="form-control" name="code" id="code" value="${data['dc_code']}" onclick="setDefaultCode('${data['dc_code']}')" onchange="checkEditCode(event.target.value)">
        </div>

        <div class="form-group">
            <label>ประเภท</label>
            <select class="form-control" name="type" id="type">
                <option value="ส่วนลดเปอร์เซ็น">ส่วนลดเปอร์เซ็น</option>
                <option value="ส่วนลดเงินสด">ส่วนลดเงินสด</option>
            </select>
        </div>

        <div class="form-group">
            <label>มูลค่า</label>
            <input type="number" class="form-control" name="value" value="${data['dc_value']}">
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
        $('#type').val(data['dc_type']);
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
        url: "api/discount_code/update.php",
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
        title: "ยืนยันการลบโค้ดส่วนลดรหัส" + id + "?",
        text: "หากดำเนินการไปแล้ว จะไม่สามารถกู้คืนได้",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/discount_code/delete.php",
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