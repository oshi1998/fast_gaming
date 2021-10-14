function read() {
    $.ajax({
        method: "post",
        url: "api/product/read.php"
    }).done(function (res) {
        console.log(res);

        let data = res.data;
        let data_table;
        let status;

        data.forEach(element => {

            if (element['pro_status'] == 0) {
                status = `
                    <div class="custom-control custom-switch text-center">
                        <input type="checkbox" class="custom-control-input" id="customSwitch${element['pro_id']}" onchange="disable('${element['pro_id']}')" checked>
                        <label class="custom-control-label" for="customSwitch${element['pro_id']}"></label>
                    </div>
                `
            } else {
                status = `
                    <div class="custom-control custom-switch text-center">
                        <input type="checkbox" class="custom-control-input" id="customSwitch${element['pro_id']}" onchange="enable('${element['pro_id']}')">
                        <label class="custom-control-label" for="customSwitch${element['pro_id']}"></label>
                    </div>
                `
            }

            data_table += `
                <tr>
                    <td>${element['pro_created']}</td>
                    <td>
                        <img class="img-lg" src="../images/products/${element['pro_img']}">
                    </td>
                    <td>${element['pro_id']}</td>
                    <td>${element['pt_name']}</td>
                    <td>${element['brand_name']}</td>
                    <td>${element['pro_name']}</td>
                    <td>${element['pro_price']}</td>
                    <td>${element['pro_qty']}</td>
                    <td>
                        ${status}
                    </td>
                    <td>
                        <a class="btn btn-info" href="product_detail.php?id=${element['pro_id']}">
                            <i class="fas fa-edit"></i>
                            <span>จัดการรายละเอียดสินค้า</span>
                        </a>
                        <button class="btn btn-primary" onclick="edit('${element['pro_id']}')">
                            <i class="fas fa-edit"></i>
                            <span>แก้ไข</span>
                        </button>
                        <button class="btn btn-danger" onclick="deleteData('${element['pro_id']}')">
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

function add(pt_id, pt_name, brand_id, brand_name) {
    let form = `
    <form id="createForm">
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="form-group row">

                <div class="col-12 text-center mb-3">
                    <img id="preview_img" style="width:300px;height:300px" class="mb-3">
                    <input type="file" class="form-control" name="img" accept="image/*" onchange="readFile(event)">
                </div>

            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="form-group">
                <label>รหัสสินค้า</label> <strong id="show_result"></strong>
                <button type="button" class="btn btn-default float-right" onclick="generateProId()">สร้างรหัสสินค้าอัตโนมัติ</button> <br><br>
                <input type="text" class="form-control" name="id" id="id" onchange="checkId(event.target.value)">
            </div>

            <div class="form-group">
                <label>ชื่อสินค้า</label>
                <input type="text" class="form-control" name="name">
            </div>
        
            <div class="form-group">
                <label>จำนวน</label>
                <input type="number" class="form-control" name="qty">
            </div>
            <div class="form-group">
                <label>ราคา/ชิ้น</label>
                <input type="number" class="form-control" name="price">
            </div>
            <div class="form-group">
                <label>ประเภทสินค้า</label>
                <select class="form-control" name="type" readonly>
                    <option value="${pt_id}">${pt_name}</option>
                </select>
            </div>
            <div class="form-group">
                <label>ยี่ห้อสินค้า</label>
                <select class="form-control" name="brand" readonly>
                    <option value="${brand_id}">${brand_name}</option>
                </select>
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

    $('#myModalLabel').text('เพิ่มข้อมูลสินค้า');
    $('#myModalBody').html(form);
    $('#myModal').modal('show');
}

function readFile(event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('preview_img');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function generateProId() {

    let today = new Date();
    let date = today.getFullYear() + '' + (today.getMonth() + 1) + '' + today.getDate();
    let time = today.getHours() + '' + today.getMinutes() + '' + today.getSeconds();

    let id = "PRO" + date + time;
    $('#id').val(id);
    checkId(id);
}

function checkId(id) {
    $.ajax({
        method: "get",
        url: "api/product/check_id.php",
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
        url: "api/product/create.php",
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
        url: "api/product/readById.php",
        data: {
            "id": id
        },
    }).done(function (res) {
        console.log(res);

        let data = res.data;
        let types = res.types;
        let brands = res.brands;

        form = `
        <form id="updateForm">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group row">

                    <div class="col-12 text-center mb-3">
                        <img id="preview_img" src="../images/products/${data['pro_img']}" style="width:300px;height:300px" class="mb-3">
                        <input type="file" class="form-control" name="img" accept="image/*" onchange="readFile(event)">
                        <input type="text" name="old_img" value="${data['pro_img']}" hidden readonly>
                    </div>

                </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="form-group">
                <label>รหัสสินค้า</label>
                <input type="text" class="form-control" name="id" value="${id}" readonly>
            </div>

            <div class="form-group">
                <label>ชื่อสินค้า</label>
                <input type="text" class="form-control" name="name" value="${data['pro_name']}">
            </div>
        
            <div class="form-group">
                <label>จำนวน</label>
                <input type="number" class="form-control" name="qty" value="${data['pro_qty']}">
            </div>
            <div class="form-group">
                <label>ราคา/ชิ้น</label>
                <input type="number" class="form-control" name="price" value="${data['pro_price']}">
            </div>
            <div class="form-group">
                <label>ประเภทสินค้า</label>
                <select class="form-control" name="type" id="type">`;

        types.forEach(element => {
            form += `<option value="${element['pt_id']}">${element['pt_name']}</option>`
        });

        form += `
                </select>
            </div>
            <div class="form-group">
                <label>ยี่ห้อสินค้า</label>
                <select class="form-control" name="brand" id="brand">`;

        brands.forEach(element => {
            form += `
                    <option value="${element['brand_id']}">${element['brand_name']}</option>
                    `;
        });

        form += `
                </select>
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
        $('#type').val(data['pro_type']);
        $('#brand').val(data['pro_brand']);
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
        url: "api/product/update.php",
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

function deleteData(id) {
    swal({
        title: "ยืนยันการลบสินค้ารหัส " + id + "?",
        text: "หากดำเนินการไปแล้ว จะไม่สามารถกู้คืนได้",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/product/delete.php",
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

function enable(id) {
    $.ajax({
        method: "get",
        url: "api/product/enable.php",
        data: {
            "id": id
        }
    }).done(function (res) {
        console.log(res);
    }).fail(function (res) {
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON["message"],
            icon: "error"
        });
    });
}

function disable(id) {
    $.ajax({
        method: "get",
        url: "api/product/disable.php",
        data: {
            "id": id
        }
    }).done(function (res) {
        console.log(res);
    }).fail(function (res) {
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON["message"],
            icon: "error"
        });
    });
}