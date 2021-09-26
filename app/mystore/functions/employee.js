function read() {
    $.ajax({
        method: "post",
        url: "api/emp/read.php"
    }).done(function (res) {
        console.log(res);

        let data = res.data;
        let data_table;

        data.forEach(element => {
            data_table += `
                <tr>
                    <td>${element['emp_created']}</td>
                 `;

            if (element['emp_avatar'] == "user.png") {
                data_table += `
                    <td>
                        <img class="img-lg" src="dist/img/${element['emp_avatar']}">
                    </td>
                    `;
            } else {
                data_table += `
                    <td>
                        <img class="img-lg" src="dist/img/emp/${element['emp_id']}/${element['emp_avatar']}">
                    </td>
                    `;
            }
            data_table += `
                    <td>${element['emp_id']}</td>
                    <td>${element['emp_firstname'] + " " + element['emp_lastname']}</td>
                    <td>${element['emp_contact']}</td>
                    <td>${element['emp_status']}</td>
                    <td>
                        <button class="btn btn-primary" onclick="edit('${element['emp_id']}')">
                            <i class="fas fa-edit"></i>
                            <span>แก้ไข</span>
                        </button>
                        <button class="btn btn-info" onclick="infoEmp('${element['emp_id']}')">
                            <i class="fas fa-address-card"></i>
                            <span>ข้อมูลพนักงาน</span>
                        </button>
                        <button class="btn btn-danger" onclick="out('${element['emp_id']}')">
                            <i class="fas fa-user-slash"></i>
                            <span>พ้นสภาพพนักงาน</span>
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
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="form-group row">
                <div class="col-lg-6 col-12 text-center mb-3">
                    <img id="preview_avatar" style="width:200px;height:250px" class="mb-3">
                    <input type="file" class="form-control" name="avatar" accept="image/*" onchange="readFile(event)">
                </div>
                <div class="col-lg-6 col-12">
                    <button type="button" class="btn btn-default" onclick="generateEmpId()">สร้างรหัสพนักงานอัตโนมัติ</button> <br>
                    <label>รหัสพนักงาน</label> <strong id="show_result"></strong>
                    <input type="text" class="form-control" name="id" id="id" onchange="checkId(event.target.value)">

                    <label>ชื่อจริง</label>
                    <input type="text" class="form-control" name="firstname">

                    <label>นามสกุล</label>
                    <input type="text" class="form-control" name="lastname">
                </div>
            </div>

            <div class="form-group">
                <label>ข้อมูลติดด่อ เช่น ที่อยู่,เบอร์โทร เป็นต้น</label>
                <textarea class="form-control" name="contact"></textarea>
            </div>
            <div class="form-group">
                <label>ตำแหน่ง</label>
                <select class="form-control" name="level">
                    <option value="" selected disabled>--- เลือกตำแหน่ง ---</option>
                    <option value="พนักงาน">พนักงาน</option>
                    <option value="ผู้จัดการ">ผู้จัดการ</option>
                </select>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="form-group">
                <label>รหัสผ่าน</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="form-group">
                <label>รหัสบัตรประชาชน</label>
                <input type="text" class="form-control" minlength="13" maxlength="13" name="id_card_code">
            </div>
            <div class="form-group">
                <label>ไฟล์ภาพบัตรประชาชน (เฉพาะ .png .jpg .jpeg)</label>
                <input type="file" class="form-control" name="id_card_img" accept="image/*">
            </div>
            <div class="form-group">
                <label>วันที่เข้าทำงาน</label>
                <input type="date" class="form-control" name="join_date">
            </div>
            <div class="form-group">
                <label>สถานภาพ</label>
                <select class="form-control" name="status">
                    <option value="" selected disabled>--- เลือกสถานภาพ ---</option>
                    <option value="พนักงานประจำ">พนักงานประจำ</option>
                    <option value="พนักงานตามสัญญาจ้าง">พนักงานตามสัญญาจ้าง</option>
                    <option value="พนักงานพาร์ทไทม์">พนักงานพาร์ทไทม์</option>
                </select>
            </div>
            <div class="form-group">
                <label>ไฟล์สัญญาจ้าง (.PDF เท่านั้น)</label>
                <input type="file" class="form-control" name="contract" accept=".pdf">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="create()">
            <i class="fas fa-edit"></i>
            <span>บันทึก</span>
        </button>
    </div>
</form>
    `;

    $('#myModalLabel').text('เพิ่มข้อมูลพนักงาน');
    $('#myModalBody').html(form);
    $('#myModal').modal('show');
}

function readFile(event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('preview_avatar');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function generateEmpId() {

    let today = new Date();
    let date = today.getFullYear() + '' + (today.getMonth() + 1) + '' + today.getDate();
    let time = today.getHours() + '' + today.getMinutes() + '' + today.getSeconds();

    let id = "EMP" + date + time;
    $('#id').val(id);
    checkId(id);
}

function checkId(id) {
    $.ajax({
        method: "get",
        url: "api/emp/check_id.php",
        data: {
            "id": id
        }
    }).done(function (res) {
        $('#show_result').text(res.message).css('color', 'green');
    }).fail(function (res) {
        $('#show_result').text(res.responseJSON['message']).css('color', 'red');
        $('#id').val("").focus();
    });
}

function create() {

    let fd = new FormData(document.getElementById("createForm"));

    $.ajax({
        method: "post",
        url: "api/emp/create.php",
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
        url: "api/emp/readById.php",
        data: {
            "id": id
        },
    }).done(function (res) {
        console.log(res);

        let data = res.data;

        let avatar_src;

        if (data['emp_avatar'] == "user.png") {
            avatar_src = `dist/img/${data['emp_avatar']}`;
        } else {
            avatar_src = `dist/img/emp/${id}/${data['emp_avatar']}`;
        }

        form = `
        <form id="updateForm">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group row">
                    <div class="col-lg-6 col-12 text-center mb-3">
                        <img id="preview_avatar" src="${avatar_src}" style="width:200px;height:250px" class="mb-3">
                        <input type="text" name="old_avatar" value="${data['emp_avatar']}" hidden readonly>
                        <input type="file" class="form-control" name="avatar" accept="image/*" onchange="readFile(event)">
                    </div>
                    <div class="col-lg-6 col-12">
                        <label>รหัสพนักงาน</label>
                        <input type="text" class="form-control" name="id" value="${id}" readonly>
    
                        <label>ชื่อจริง</label>
                        <input type="text" class="form-control" name="firstname" value="${data['emp_firstname']}">
    
                        <label>นามสกุล</label>
                        <input type="text" class="form-control" name="lastname" value="${data['emp_lastname']}">
                    </div>
                </div>
    
                <div class="form-group">
                    <label>ข้อมูลติดด่อ เช่น ที่อยู่,เบอร์โทร เป็นต้น</label>
                    <textarea class="form-control" name="contact">${data['emp_contact']}</textarea>
                </div>
                <div class="form-group">
                    <label>ตำแหน่ง</label>
                    <select class="form-control" name="level" id="level">
                        <option value="พนักงาน">พนักงาน</option>
                        <option value="ผู้จัดการ">ผู้จัดการ</option>
                    </select>
                </div>
            </div>
    
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label>รหัสบัตรประชาชน</label>
                    <input type="text" class="form-control" minlength="13" maxlength="13" name="id_card_code" value="${data['emp_id_card_code']}">
                </div>
                <div class="form-group">
                    <label>ไฟล์ภาพบัตรประชาชน (เฉพาะ .png .jpg .jpeg)</label>
                    <input type="text" name="old_id_card_img" value="${data['emp_id_card_img']}" hidden readonly>
                    <input type="file" class="form-control" name="id_card_img" accept="image/*">
                </div>
                <div class="form-group">
                    <label>วันที่เข้าทำงาน</label>
                    <input type="date" class="form-control" name="join_date" value="${data['emp_join_date']}">
                </div>
                <div class="form-group">
                    <label>สถานภาพ</label>
                    <select class="form-control" name="status" id="status">
                        <option value="พนักงานประจำ">พนักงานประจำ</option>
                        <option value="พนักงานตามสัญญาจ้าง">พนักงานตามสัญญาจ้าง</option>
                        <option value="พนักงานพาร์ทไทม์">พนักงานพาร์ทไทม์</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>ไฟล์สัญญาจ้าง (.PDF เท่านั้น)</label>
                    <input type="text" name="old_contract" value="${data['emp_contract']}" hidden readonly>
                    <input type="file" class="form-control" name="contract" accept=".pdf">
                </div>
            </div>
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
        $('#level').val(data['emp_level']);
        $('#status').val(data['emp_status']);
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
    let fd = new FormData(document.getElementById("updateForm"));

    $.ajax({
        method: "post",
        url: "api/emp/update.php",
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

function infoEmp(id) {
    let form;

    $.ajax({
        method: "get",
        url: "api/emp/readById.php",
        data: {
            "id": id
        },
    }).done(function (res) {
        console.log(res);

        let data = res.data;

        let avatar_src, contact, id_card_code, id_card_img, join, contract;

        if (data['emp_avatar'] == "user.png") {
            avatar_src = `dist/img/${data['emp_avatar']}`;
        } else {
            avatar_src = `dist/img/emp/${id}/${data['emp_avatar']}`;
        }

        if (data['emp_contact'] == "" || data['emp_contact'] == null) {
            contact = "ไม่มีข้อมูลติดต่อ"
        } else {
            contact = data['emp_contact'];
        }

        if (data['emp_id_card_code'] == "" || data['emp_id_card_code'] == null) {
            id_card_code = "ไม่มีข้อมูลรหัสบัตรประชาชน"
        } else {
            id_card_code = data['emp_id_card_code'];
        }

        if (data['emp_id_card_img'] == "" || data['emp_id_card_img'] == null) {
            id_card_img = "ไม่มีข้อมูลไฟล์ภาพบัตรประชาชน"
        } else {
            id_card_img = `<a target="_blank" href="dist/img/emp/${id}/${data['emp_id_card_img']}">ดูบัตรประชาชน</a>`;
        }

        if (data['emp_join_date'] == "" || data['emp_join_date'] == null || data['emp_join_date']=="0000-00-00") {
            join = "ไม่มีข้อมูลวันที่เข้าทำงาน"
        } else {
            join = data['emp_join_date'];
        }

        if (data['emp_contract'] == "" || data['emp_contract'] == null) {
            contract = "ไม่มีข้อมูลไฟล์สัญญาจ้าง"
        } else {
            contract = `<a target="_blank" href="dist/img/emp/${id}/${data['emp_contract']}">ดูสัญญาจ้าง</a>`;
        }

        form = `

        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group row">
                    <div class="col-lg-6 col-12 text-center mb-3">
                        <img id="preview_avatar" src="${avatar_src}" style="width:200px;height:250px" class="mb-3">
                    </div>
                    <div class="col-lg-6 col-12">
                        <label>รหัสพนักงาน</label>
                        <p>${id}</p>
    
                        <label>ชื่อจริง</label>
                        <p>${data['emp_firstname']}</p>
    
                        <label>นามสกุล</label>
                        <p>${data['emp_lastname']}</p>
                    </div>
                </div>
    
                <div class="form-group">
                    <label>ข้อมูลติดด่อ</label>
                    <p>${contact}</p>
                </div>
                <div class="form-group">
                    <label>ตำแหน่ง</label>
                    <p>${data['emp_level']}</p>
                </div>
            </div>
    
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label>รหัสบัตรประชาชน</label>
                    <p>${id_card_code}</p>
                </div>
                <div class="form-group">
                    <label>ไฟล์ภาพบัตรประชาชน</label>
                    <p>${id_card_img}</p>
                </div>
                <div class="form-group">
                    <label>วันที่เข้าทำงาน</label>
                    <p>${join}</p>
                </div>
                <div class="form-group">
                    <label>สถานภาพ</label>
                    <p>${data['emp_status']}</p>
                </div>
                <div class="form-group">
                    <label>ไฟล์สัญญาจ้าง</label>
                    <p>${contract}</p>
                </div>
            </div>
        </div>
        `;

        $('#myModalLabel').text('ข้อมูลพนักงาน ' + id);
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

function out(id) {

    let form = `
    <form id="outForm">

    <div class="form-group">
        <label>รหัสพนักงาน</label>
        <input type="text" class="form-control" name="id" id="outId" value="${id}" readonly>
    </div>

    <div class="form-group">
        <label>สาเหตุการพ้นสภาพ</label>
        <textarea class="form-control" name="note"></textarea>
    </div>

    <div class="form-group">
        <label>วันที่พ้นสภาพ</label>
        <input type="date" class="form-control" name="out_date">
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="submitOut()">
            <i class="fas fa-edit"></i>
            <span>ดำเนินการ</span>
        </button>
    </div>
</form>
    `;

    $('#myModalLabel').text('พ้นสภาพพนักงาน ' + id);
    $('#myModalBody').html(form);
    $('#myModal').modal('show');
}

function submitOut() {
    swal({
        title: "ยืนยันการพ้นสภาพพนักงาน " + $('#outId').val() + "?",
        text: "หากดำเนินการไปแล้ว สามารถคืนสถานภาพได้ในภายหลัง",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willOut) => {
        if (willOut) {
            $.ajax({
                type: "post",
                url: "api/emp/out.php",
                data: $('#outForm').serialize()
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