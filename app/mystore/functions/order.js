function viewOrder(order_id) {
    $.ajax({
        method: "get",
        url: "api/order/readById.php",
        data: {
            "id": order_id
        }
    }).done(function (res) {
        console.log(res);
        let order = res.order;
        let detail = res.detail;
        let dc = res.dc;

        let dc_code;

        if(dc==false){
            dc_code = "ไม่ได้ใช้โค้ดส่วนลด"
        }else{
            dc_code = dc['use_dc_code'];
        }

        let form_html = `

        <table class="table table-striped">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>สินค้า</th>
                <th>ราคา/ชิ้น</th>
                <th>จำนวน</th>
                <th>ราคารวม</th>
            </tr>
        </thead>
        <tbody>`;

        let no = 1;

        detail.forEach(element => {
            total = element['pro_price'] * element['odd_amount'];
            form_html += `
                <tr>
                    <td>${no++}</td>
                    <td>${element['pro_name']}</td>
                    <td>${element['pro_price']}</td>
                    <td>${element['odd_amount']}</td>
                    <td>${total.toFixed(2)}</td>
                </tr>
            `
        });


        form_html += `
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <th>รวมค่าสินค้า</th>
                <th>${order['od_pro_total']}</th>
            </tr>
            <tr>
                <td>การจัดส่ง</td>
                <td>${order['od_delivery_type']}</td>
                <td></td>
                <th>ค่าส่ง</th>
                <th>${order['od_shipping_cost']}</th>
            </tr>
            <tr>
                <td>โค้ดส่วนลด</td>
                <td>${dc_code}</td>
                <td></td>
                <th>ส่วนลด</th>
                <th>${order['od_discount_cost']}</th>
            </tr>
            <tr>
                <td>การชำระเงิน</td>
                <td>${order['od_payment_method']}</td>
                <td></td>
                <th>รวมทั้งสิ้น</th>
                <th>${order['od_total']}</th>
            </tr>
        </tfoot>
    </table>
</div>
        
        `;

        $('#myModalLabel').text("รายละเอียดคำสั่งซื้อ " + order_id);
        $('#myModalBody').html(form_html);
        $('#myModal').modal('show');
    }).fail(function (res) {
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}

function viewProof(order_id) {
    $.ajax({
        method: "get",
        url: "api/order/readTst.php",
        data: {
            "id": order_id
        }
    }).done(function (res) {
        console.log(res);
        let tst = res.data;

        let form_html = `
            <div class="row">
                <div class="col-lg-3 col-12">
                    <img style="width:100%;height:450px" src="../images/slips/${tst['tst_slip']}">
                </div>
                <div class="col-lg-9 col-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>เลขธุรกรรม</th>
                                    <td>${tst['tst_id']}</td>
                                </tr>
                                <tr>
                                    <th>รหัสรายการสั่งซื้อ</th>
                                    <td>${tst['tst_od_id']}</td>
                                </tr>
                                <tr>
                                    <th>โอนเข้าบัญชี</th>
                                    <td>${tst['tst_re_bank'] + " " + tst['tst_re_acc_number'] + " (" + tst['tst_re_acc_name'] + ")"}</td>
                                </tr>
                                <tr>
                                    <th>โอนจากบัญชี</th>
                                    <td>${tst['tst_transfer_bank'] + " " + tst['tst_transfer_acc_number'] + " (" + tst['tst_transfer_acc_name'] + ")"}</td>
                                </tr>
                                <tr>
                                    <th>โอนเมื่อ</th>
                                    <td>${tst['tst_transfer_datetime']}</td>
                                </tr>
                                <tr>
                                    <th>จำนวนเงินที่ต้องชำระ</th>
                                    <td>${tst['tst_amount']}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        `;

        $('#myModalLabel').text("หลักฐานการชำระเงินรหัสสั่งซื้อ " + order_id);
        $('#myModalBody').html(form_html);
        $('#myModal').modal('show');
    }).fail(function (res) {
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });
}

function acceptOrder(order_id) {
    swal({
        title: "ยืนยันการอนุมัติการชำระเงิน " + order_id + "?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willConfirm) => {
        if (willConfirm) {
            $.ajax({
                type: "get",
                url: "api/order/accept.php",
                data: {
                    "id": order_id
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

function cancelOrder(order_id) {
    let form = `
    
        <form id="cancelForm">
            <div class="form-group">
                <label>รหัสสั่งซื้อ</label>
                <input type="text" class="form-control" name="id" id="order_id" value="${order_id}" readonly>
            </div>
            <div class="form-group">
                <label>สาเหตุที่ยกเลิก</label>
                <textarea class="form-control" name="note"></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="submitCancel()">ดำเนินการยกเลิก</button>
            </div>
        </form>
    `;

    $('#myModalLabel').text("ยกเลิกรหัสสั่งซื้อ " + order_id);
    $('#myModalBody').html(form);
    $('#myModal').modal('show');
}

function submitCancel() {
    swal({
        title: "ยืนยันการยกเลิกรหัสสั่งซื้อ " + $('#order_id').val() + "?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willConfirm) => {
        if (willConfirm) {
            $.ajax({
                type: "post",
                url: "api/order/cancel.php",
                data: $("#cancelForm").serialize()
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

function delivery(order_id) {

    let now = new Date();
    let today = now.getFullYear() + '-' + ("0" + (now.getMonth() + 1)).slice(-2) + '-' + ("0" + now.getDate()).slice(-2);

    let form = `
    
    <form id="deliveryForm">
        <div class="form-group">
            <label>รหัสสั่งซื้อ</label>
            <input type="text" class="form-control" name="id" id="order_id" value="${order_id}" readonly>
        </div>
        <div class="form-group">
            <label>วันที่ดำเนินการจัดส่ง</label>
            <input type="date" class="form-control" name="date" value="${today}">
        </div>
        <div class="form-group">
            <label>เลข EMS</label>
            <input type="text" class="form-control" name="ems">
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="submitDelivery()">บันทึก</button>
        </div>
    </form>
`;

    $('#myModalLabel').text("จัดส่งสินค้ารหัสสั่งซื้อ" + order_id);
    $('#myModalBody').html(form);
    $('#myModal').modal('show');
}

function submitDelivery() {
    swal({
        title: "ยืนยันการจัดส่งสินค้ารหัสสั่งซื้อ " + $('#order_id').val() + "?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willConfirm) => {
        if (willConfirm) {
            $.ajax({
                type: "post",
                url: "api/order/delivery.php",
                data: $("#deliveryForm").serialize()
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

function editDelivery(order_id) {
    $.ajax({
        method: "get",
        url: "api/order/readById.php",
        data: {
            "id": order_id
        }
    }).done(function (res) {
        console.log(res);
        let order = res.order;

        let form = `
    
    <form id="deliveryForm">
        <div class="form-group">
            <label>รหัสสั่งซื้อ</label>
            <input type="text" class="form-control" name="id" id="order_id" value="${order_id}" readonly>
        </div>
        <div class="form-group">
            <label>วันที่ดำเนินการจัดส่ง</label>
            <input type="date" class="form-control" name="date" value="${order['od_delivery_date']}">
        </div>
        <div class="form-group">
            <label>เลข EMS</label>
            <input type="text" class="form-control" name="ems" value="${order['od_ems']}">
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="updateDelivery()">บันทึก</button>
        </div>
    </form>
    `;
        $('#myModalLabel').text("แก้ไขข้อมูลการจัดส่งสินค้า " + order_id);
        $('#myModalBody').html(form);
        $('#myModal').modal('show');
    }).fail(function (res) {
        swal({
            title: "ผิดพลาด",
            text: res.responseJSON['message'],
            icon: "error"
        });
    });



}

function updateDelivery() {
    $.ajax({
        method:"post",
        url: "api/order/delivery.php",
        data: $('#deliveryForm').serialize()
    }).done(function(res){
        console.log(res);
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

function successOrder(order_id) {
    swal({
        title: "โปรดยืนยันว่ารหัสสั่งซื้อ " + order_id + " สำเร็จแล้ว?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willConfirm) => {
        if (willConfirm) {
            $.ajax({
                type: "get",
                url: "api/order/success.php",
                data: {
                    "id": order_id
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

