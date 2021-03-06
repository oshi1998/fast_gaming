var defaultName = "";

function read() {
    $.ajax({
        method: "post",
        url: "api/brand/read.php"
    }).done(function (res) {
        console.log(res);

        let data = res.data;

        let data_table;
        let no = 1;

        data.forEach(element => {
            data_table += `
                <tr>
                    <td>${no++}</td>
                    <td>${element['brand_created']}</td>
                    <td>${element['brand_name']}</td>
                    <td>
                        <button class="btn btn-primary" onclick="edit('${element['brand_id']}')">
                            <i class="fas fa-edit"></i>
                            <span>แก้ไข</span>
                        </button>
                        <button class="btn btn-danger" onclick="deleteData('${element['brand_id']}')">
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
        <label>ชื่อยี่ห้อ</label> <strong id="show_result"></strong>
        <input type="text" class="form-control" name="name" id="name" onchange="checkName(event.target.value)">
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="create()">
            <i class="fas fa-edit"></i>
            <span>บันทึก</span>
        </button>
    </div>
</form>
    `;

    $('#myModalLabel').text('เพิ่มข้อมูลยี่ห้อ');
    $('#myModalBody').html(form);
    $('#myModal').modal('show');
}

function setDefaultName(name) {
    defaultName = name;
    console.log(defaultName);
}

function checkName(name) {
    $.ajax({
        method: "get",
        url: "api/brand/check_name.php",
        data: {
            "name": name
        }
    }).done(function (res) {
        $('#show_result').text(res.message).css('color', 'green');
    }).fail(function (res) {
        $('#show_result').text(res.responseJSON['message']).css('color', 'red');
        $('#name').val("").focus();
    });
}

function checkEditName(name) {

    console.log("Edit Name = " + name);
    console.log("Default Name = " + defaultName);

    if (name != defaultName) {
        $.ajax({
            method: "get",
            url: "api/brand/check_name.php",
            data: {
                "name": name
            }
        }).done(function (res) {
            $('#show_result').text(res.message).css('color', 'green');
        }).fail(function (res) {
            $('#show_result').text(res.responseJSON['message']).css('color', 'red');
            $('#name').val("").focus();
        });
    } else {
        $('#show_result').text("");
        return;
    }
}

function create() {
    $.ajax({
        method: "post",
        url: "api/brand/create.php",
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
        url: "api/brand/readById.php",
        data: {
            "id": id
        },
    }).done(function (res) {
        console.log(res);

        let data = res.data;
        form = `
        <form id="updateForm">

            <div class="form-group">
                <label>รหัสยี่ห้อ</label>
                <input type="text" class="form-control" name="id" id="id" value="${id}" readonly>
            </div>

            <div class="form-group">
                <label>ชื่อยี่ห้อ</label> <strog id="show_result"></strog>
                <input type="text" class="form-control" name="name" id="name" value="${data['brand_name']}" onclick="setDefaultName('${data['brand_name']}')"  onchange="checkEditName(event.target.value)">
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
        url: "api/brand/update.php",
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
        title: "ยืนยันการลบยี่ห้อรหัส " + id + "?",
        text: "หากดำเนินการไปแล้ว จะไม่สามารถกู้คืนได้",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/brand/delete.php",
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