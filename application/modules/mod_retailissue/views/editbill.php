<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("structer/backend/head.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <?php
        include('structer/backend/navbar.php');
        include('structer/backend/menu.php');
        ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?php echo "ใบเบิก - แก้ไข"; ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo site_url('mod_admin') ?>/ctl_admin/backend_main">Home</a></li>
                                <li class="breadcrumb-item active"><?php echo $submenu; ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">

                <div class="container">
                    <div class="row">

                        <section class="col-lg-12 connectedSortable">
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"> <i class="fa fa-bars" aria-hidden="true"></i> <?php echo "Manage " . $mainmenu; ?> </h3>
                                </div>
                                <div class="card-body">

                                    <?php require_once('form_bill.php'); ?>

                                </div>
                            </div>
                        </section>
                        <!--	Modal	-->
                        <div class="modal modal-image fade bs-example-modal-center" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        ...
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </section>

        </div>
        <?php include("structer/backend/footer.php"); ?>
        <?php include("structer/backend/script.php"); ?>

        <script src="<?php echo $base_bn; ?>plugins/sweetalert2/sweetalert2.min.js"></script>

    </div>

    <script>
        const queryString = decodeURIComponent(window.location.search);
        const params = new URLSearchParams(queryString);
        let billID = params.get("id");

        $(function() {

            //	setting
            let frm = $('form#frm');

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            //  get order bill data
            get_orderBill(billID);

            //	search order
            function get_orderBill(billID) {
                displayLoading('.content .card-body');

                var data = new FormData();
                data.append("bill_id", billID);

                //	วิธี fetch แบบ error handling
                fetch('get_dataBill', {
                        method: 'POST',
                        body: data
                    })
                    .then(res => res.json())
                    .then((resp) => {
                        hideLoading();

                        if (!resp) {
                            $('.connectedSortable .card-body').append('<p class="aaa">ไม่มีข้อมูล</p>');
                            return false;
                        }

                        let bill = resp.data;
                        let billdetail = resp.datadetail;
                        let billreceivedetail = resp.datareceivedetail;

                        $('#bill_id').val(bill.tb_id);
                        $('#bill_code').val(bill.tb_code);

                        formDataInsert(bill);

                        if (billdetail[0]) {
                            formDataDetailInsert(billdetail);
                        }

                        formDataReceiveDetailInsert(billreceivedetail);

                        //  load image
                        fetchImage(bill.tb_id);
                    })
                    .catch(function(err) {
                        console.log(`error : ${err}`)
                    })
            }

            //  load bill image
            function fetchImage(billid) {
                let html = "";
                let img = "";
                let url = 'get_billImg?id=' + billid;
                let option = {
                    method: 'GET',
                };

                fetch(url, option)
                    .then(res => res.json())
                    .then((resp) => {

                        let dataresult = resp.data;
                        for (var i in dataresult) {
                            img = `<div >
                            <span class="btn btn-outline-danger del-img" style="position:absolute;">delete</span>
                            <img src="${dataresult[i]['path']}" data-id="${dataresult[i]['id']}" data-del="">
                            </div>`;
                            $('.bill-image').append(img);
                        }
                    })
                    .catch(error => {
                        console.log(`error : ${error}`)
                    })
            }

            $(document).on('click', '#submitform', function(e) {
                e.stopPropagation;
                e.stopImmediatePropagation();

                add_bill();
            })

            $(document).on('click', '#btn-back', function(e) {
                e.stopPropagation;
                e.stopImmediatePropagation();

                window.location.replace('viewbill?id=' + billID);
            })

            $(document).on('click', '.btn-del', function() {
                let tr_id = $(this).parents('tr').attr('data-row');
                $('tr[data-row=' + tr_id + ']').remove();
            })

            $(document).on('click', '.bill-image img', function(e) {
                e.stopPropagation;
                e.stopImmediatePropagation();

                $('.modal-image .modal-body').html(this.outerHTML);
                $('.modal-image').modal({
                    show: true
                });
            })

            $(document).on('click', '.del-img', function(e) {
                e.stopPropagation;
                e.stopImmediatePropagation();

                this.parentElement.setAttribute('class', 'd-none');
                this.parentElement.getElementsByTagName("img")[0].setAttribute('data-del', '1');
            })

            //  image 
            $(document).on('change', '#image_file', function(event) {
                let image_file = $(this);
                var length = (image_file[0].files.length - 1);
                var html = "";
                for (var i = 0; i <= length; i++) {

                    if (image_file[0].files[i]) {

                        //  check extension
                        let fileName = image_file[0].files[i].name,
                            idxDot = fileName.lastIndexOf(".") + 1,
                            extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                        if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {
                            //TO DO
                            html += '<img id="img-' + i + '" src="' + window.URL.createObjectURL(image_file[0].files[i]) + '" class="img" >';
                            $('.thumbnail-image').html(html);
                        } else {
                            //  error
                            swal.fire('ข้อมูลไม่ถูกต้อง', 'บันทึกเฉพาะไฟล์รูปภาพ', 'warning');
                            clearImage(); // Reset the input so no files are uploaded

                            return false;
                        }
                    }
                }
            });

            $(document).on('click', '#cancelimgdetail', function() {
                clearImage();
            })

            function clearImage() {
                $("#imagedledetail").text("Choose file");
                $("#image_file").val(null);

                $('.thumbnail-image').html('');
            }

            function formDataInsert(bill) {
                let usercreate =  bill.tb_user_starts;
                let datecreate =  toThaiDateTimeString(new Date(bill.tb_date_starts), 'datetime');

                let userupdate;
                let dateupdate;
                if(bill.tb_date_update){
                    dateupdate = toThaiDateTimeString(new Date(bill.tb_date_update), 'datetime'); 
                }

                //  set style div
                frm.find('.bill_code').text(bill.tb_code);
                frm.find('.bill_type').text(bill.tb_type);
                frm.find('.billto').text(bill.tb_billto);
                frm.find('.bill_status').html(bill.tb_complete);
                frm.find('#remark').text(bill.tb_remark);
                frm.find('.bill_staffcreate').text(bill.tb_user_starts);
                frm.find('.bill_datecreate').text(datecreate);
                frm.find('.bill_staffedit').text(bill.tb_user_update);
                frm.find('.bill_dateedit').text(dateupdate);

                if(bill.check_rc){
                    $('#btn-cancel').remove();
                }

                frm.removeClass('d-none');
            }

            function formDataDetailInsert(billdetail) {
                let hmtl = "";

                // console.log(billdetail.length);
                
                if (billdetail.length) {

                    billdetail.forEach(function(key, val) {
                        let index = val + 1;
                        let product_name = key.product_name;
                        let product_price = formatMoney(key.product_price);
                        let product_qty = key.product_qty;
                        let product_totalprice = key.product_totalprice;
                        let promain = key.promain;
                        let prolist = key.prolist;
                        let list = key.list;

                        let receivetotal = key.product_receive;
                        let receivewaite = key.product_receivewaite;

                        let iddetail = key.product_rowid;

                        let button_del = '<button type="button" class="btn btn-sm btn-danger btn-del"><i class="fa fa-close"></i></button>';
                        let input_qty = '<input type="text" value="' + product_qty + '" class="w-100 input-qty" data-id="' + iddetail + '" data-promain="' + promain + '" data-prolist="' + prolist + '" data-list="' + list + '" data-price="' + product_price + '" OnKeyPress="return checkNumber(this)">';

                        if(receivetotal > 0){
                            button_del = "";
                        }

                        if(billdetail.length == 1){
                            //  หากรายการสินค้าเหลือ 1 ไม่ให้ลบ
                            button_del = "";
                        }

                        hmtl += '<tr data-row="' + index + '">';
                        hmtl += '<td class="">'+ button_del +'</td>';
                        hmtl += '<td class="index">' + index + '</td>';
                        hmtl += '<td class="name">' + product_name + '</td>';
                        hmtl += '<td class="qty">' + input_qty + '</td>';
                        hmtl += '<td class="text-right">' + receivetotal + '</td>';
                        hmtl += '<td class="text-right text-danger">' + receivewaite + '</td>';
                        hmtl += '</tr>';
                    })

                    frm.find('.tabledetail tbody').html(hmtl);
                }
            }

            function formDataReceiveDetailInsert(billdetail) {
                let hmtl = "";

                billdetail.forEach(function(key, val) {
                    let index = val + 1;
                    let codename = key.codename;
                    let date_starts = key.date_starts;
                    let product_name = key.product_name;
                    let product_qty = key.product_qty;
                    let receivetotal = key.product_receive;
                    let by = key.by;

                    hmtl += '<tr data-row="' + index + '">';
                    hmtl += '<td ></td>';
                    hmtl += '<td>' + codename + '</td>';
                    hmtl += '<td>' + date_starts + '</td>';
                    hmtl += '<td>';
                    hmtl += '<span class="text-right" >' + product_name + '</span>';
                    hmtl += '</td>';
                    hmtl += '<td>' + product_qty + '</td>';
                    hmtl += '<td>' + by + '</td>';
                    hmtl += '</tr>';
                })

                frm.find('.tablereceivedetail tbody').html(hmtl);
            }

            //----------------------------function--------------------------//
            function displayLoading(elename) {
                let loading = '<div class="spinner-border text-info loading"></div>';

                $(elename).append(loading);
            }

            function hideLoading() {
                $('.loading').addClass('d-none');
            }

            function add_bill() {
                //  loader
                let loading = '<div class="col-sm-12 text-center loading"><div class="spinner-border text-info"></div></div>';
                let rowtoolbtn = $('.row-form-tool-btn');
                let toolbtn = $('.form-tool-btn');

                rowtoolbtn.append(loading);
                toolbtn.addClass('d-none');

                let loop = document.querySelectorAll('[data-loop]');
                let product = document.querySelectorAll('.tabledetail tbody tr');

                let array = [];
                var data = new FormData();

                let pd_promain = 0;
                let pd_prolist = 0;
                let pd_list = 0;
                let pd_name = 0;
                let pd_qty = 0;
                let pd_price = 0;
                let pd_totalprice = 0;

                let error = 0;
                //	product
                product.forEach(function(key, index) {
                    pd_iddetail = key.getElementsByTagName('input')[0].getAttribute('data-id');
                    pd_promain = key.getElementsByTagName('input')[0].getAttribute('data-promain');
                    pd_prolist = key.getElementsByTagName('input')[0].getAttribute('data-prolist');
                    pd_list = key.getElementsByTagName('input')[0].getAttribute('data-list');
                    pd_name = key.getElementsByClassName('name')[0].innerHTML;
                    pd_qty = key.getElementsByClassName('qty')[0].getElementsByTagName('input')[0].value;
                    pd_price = 0;
                    pd_totalprice = 0;

                    if (pd_qty < 0 || pd_qty == "") {
                        swal.fire('ข้อมูลผิดพลาด', 'กรุณากรอกจำนวนสินค้า', 'warning');
                        error = 1;
                    }

                    data.append('item[' + index + '][iddetail]', pd_iddetail);
                    data.append('item[' + index + '][promain]', pd_promain);
                    data.append('item[' + index + '][prolist]', pd_prolist);
                    data.append('item[' + index + '][list]', pd_list);
                    data.append('item[' + index + '][name]', pd_name);
                    data.append('item[' + index + '][qty]', pd_qty);
                    data.append('item[' + index + '][price]', pd_price);
                    data.append('item[' + index + '][totalprice]', pd_totalprice);
                })

                //	amount total
                loop.forEach(function(key, index) {
                    data.append(key.getAttribute('data-name'), key.value);
                    // array.push(key.value);
                })

                data.append('remark', document.getElementById('remark').value);
                data.append('bill_id', document.getElementById('bill_id').value);
                data.append('bill_code', document.getElementById('bill_code').value);

                // image
                var image_file = $('#image_file');
                if (image_file[0].files.length > 0) {
                    var length = (image_file[0].files.length - 1);
                    for (var i = 0; i <= length; i++) {
                        data.append('file[]', image_file[0].files[i]);
                    }

                }

                let imageDelete = document.querySelectorAll('img[data-del]');
                let dataid = "";
                let datadel = "";
                imageDelete.forEach(function(key, index) {
                    dataid = key.getAttribute('data-id');
                    datadel = key.getAttribute('data-del');
                    if (datadel == 1) {
                        data.append('imagedel[]', dataid);
                    }
                })

                if (error == 0) {
                    let url = 'update_bill';
                    let options = {
                        method: 'POST',
                        body: data
                    };

                    fetch(url, options)
                        .then(res => res.json())
                        .then(resp => {
                            // console.log(resp);
                            if (resp.error_code != 0) {
                                swal.fire('ข้อมูลผิดพลาด', resp.txt, 'warning');
                                $('.loading').remove();
                                toolbtn.removeClass('d-none');
                            } else {
                                //  success
                                swal.fire({
                                    type: 'success',
                                    title: 'บันทึกรายการทำเสร็จ',
                                    text: resp.txt
                                }).then((result) => {

                                    let rowtoolbtn = $('.row-form-tool-btn');
                                    let toolbtn = $('.form-tool-btn');

                                    $('.loading').remove();
                                    toolbtn.removeClass('d-none');

                                    window.location.replace('viewbill?id=' + billID);
                                })
                            }
                        })
                        .catch((error) => {
                            console.log(`error : ${error}`);
                        })
                }


            }

        })

        //----------------------------function--------------------------//
    </script>
    <script>
        function checkNumber(ele) {
            var vchar = String.fromCharCode(event.keyCode);
            // console.log(vchar);
            if (vchar < '0' || vchar > '9') {
                return false
            }

        }

        function checkPrice(ele) {
            var vchar = event.keyCode;

            let arraydetail = [45, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58];

            let search = arraydetail.find(res => res == vchar);
            if (!search) {
                return false;
            }
        }

        function formatMoney(number, decPlaces, decSep, thouSep) {
            decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
                decSep = typeof decSep === "undefined" ? "." : decSep;
            thouSep = typeof thouSep === "undefined" ? "," : thouSep;
            var sign = number < 0 ? "-" : "";
            var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
            var j = (j = i.length) > 3 ? j % 3 : 0;

            return sign +
                (j ? i.substr(0, j) + thouSep : "") +
                i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
                (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
        }
        //	date
        //	@param	date	@date = date yyyy-mm-dd (2021-07-08)
        //	@param	typereturn	@text = [date , datetime]
        //	return datetime TH
        //
        function toThaiDateTimeString(date, typereturn) {
            let monthNames = [
                "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน",
                "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม.",
                "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
            ];

            let year = date.getFullYear() + 543;
            let month = monthNames[date.getMonth()];
            let numOfDay = date.getDate();
            // console.log(date + "--" + typereturn);
            let hour = date.getHours().toString().padStart(2, "0");
            let minutes = date.getMinutes().toString().padStart(2, "0");
            let second = date.getSeconds().toString().padStart(2, "0");

            switch (typereturn) {
                case 'datetime':
                    return `${numOfDay} ${month} ${year} ` +
                        `${hour}:${minutes}:${second} น.`;
                    break;
                case 'date':
                    return `${numOfDay} ${month} ${year} `;
                    break;
                default:
                    return `${numOfDay} ${month} ${year} ` +
                        `${hour}:${minutes}:${second} น.`;
                    break;
            }

        }
    </script>
</body>

</html>