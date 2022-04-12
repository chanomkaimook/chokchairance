<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("structer/backend/head.php"); ?>
    <link rel="stylesheet" href="<?php echo $base_bn; ?>frontend/bootstrap-select/css/bootstrap-select.css">

    <style>
        .selectstyle {
            height: calc(1.25rem + 2px);
            font-size: 0.7rem;
            padding: 0rem .75rem;
            width: 25%;
        }

        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 100%;
        }

        .btn-light {
            color: #1f2d3d;
            background-color: #ffffff;
            border: 1px solid #ced4da;
            box-shadow: none;
            font-size: 0.7rem;
        }
    </style>
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
                            <h1><?php echo $submenu; ?></h1>
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
                <div class="container-fluid">
                    <div class="row">

                        <section class="col-lg-12 connectedSortable">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"> <i class="fa fa-bars" aria-hidden="true"></i> Manage <?php echo $submenu; ?> </h3>
                                </div>
                                <div class="card-body">

                                    <div class="row" style="background-color: rgba(140, 175, 255, 0.15); padding: 20px; margin: 1px;border: 1px solid #87aaff; ">
                                        <div class="col-sm-12 text-right">
                                            <?php
                                            $pm_insertmain = chkPermissPage('product_insertmain');
                                            if ($pm_insertmain == 1) :
                                            ?>
                                                <a href=# class="btn_menumain btn btn-info btn-sm" data-type="main" data-toggle="modal" data-target=".modal-product">
                                                    <li class="fa fa-plus-square-o "></li> ข้อมูลกลุ่ม
                                                </a>
                                                <a href=# class="btn_menumain btn btn-info btn-sm" data-type="submain" data-toggle="modal" data-target=".modal-product">
                                                    <li class="fa fa-plus-square-o "></li> ข้อมูลหมวดหมู่
                                                </a>
                                                <a href=# class="btn_menumain btn btn-info btn-sm" data-type="type" data-toggle="modal" data-target=".modal-product">
                                                    <li class="fa fa-plus-square-o "></li> ข้อมูลรูปแบบ
                                                </a>
                                                <a href=# class="btn_menumain btn btn-info btn-sm" data-type="category" data-toggle="modal" data-target=".modal-product">
                                                    <li class="fa fa-plus-square-o "></li> ข้อมูล catalog
                                                </a>
                                            <?php
                                            endif;
                                            $pm_insertlist = chkPermissPage('product_insertlist');
                                            if ($pm_insertlist == 1) :
                                            ?>
                                                <a href="<?php echo site_url('mod_retailproduct') ?>/ctl_retailproduct/product_insertlist" class="btn btn-info btn-sm">
                                                    <li class="fa fa-plus-square-o "></li> เพิ่มรายการเมนู
                                                </a>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                        <!--
                                        <div class="col-sm-12">

                                            <label class=""> ค้นหา </label>
                                            <div class="input-group ">
                                                 <input type="text" class="form-control form-control-sm" name="keyword" id="keyword">
                                            </div>
                                            
                                        </div>
										-->
                                        <div class="col-sm-6">

                                            <label class=""> เลือกเมนูหลัก </label>
                                            <div class="input-group input-group-sm">
                                                <select id="select-productmain" name="select-productmain" class="selectpicker" data-live-search="true">
                                                    <option value=""> -- โปรดเลือกเมนู -- </option>
                                                    <?php foreach ($Query_productmain->result() as $row) { ?>
                                                        <option value="<?php echo $row->ID ?>"><?php echo $row->NAME_TH; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <label class=""> เลือกการค้นหา (สถานะ) </label>
                                            <div class="input-group input-group-sm">
                                                <select class="custom-select " name="status" id="status">
                                                    <option value=""> เลือกสถานะ </option>
                                                    <option value="1"> Status Open </option>
                                                    <option value="0"> Status Off </option>
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-default btn-sm" id="bntvaldate"><i class="fas fa-search"></i> Search </button>
                                                    <button type="button" class="btn btn-default btn-sm" id="refresh_page"><i class="fas fa-refresh"></i> Refresh </button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <hr>

                                    <div class="table-responsive">
                                        <table id="ex1" class="table table-bordered  ">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th>รายการ</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <!-- modal Peview -->
                                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="titel text-left col-md-12"> <i class="fa fa-file-text-o" aria-hidden="true"></i> เนื้อหาเพิ่มเติม (Content)</div>
                                                <div id="resultcontent" style="padding: 10px;border: 1px solid #7c7c7c; border-radius: 5px; ">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- modal promotion reference -->
                                    <div class="modal fade md_proref bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="titel text-left col-md-12"> <i class="fa fa-file-text-o" aria-hidden="true"></i> โปรที่ผู้กับสินค้าชิ้นนี้</div>
                                                <div id="resultproref" style="padding: 10px;">

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                    </div>
            </section>

            <style>
                .modal-content {
                    padding: inherit;
                }
            </style>
            <!-- // ========== Modal ============ // -->
            <div class="modal fade modal-product bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-info">Extra Large Modal</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <!-- เพิ่ม -->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-8 ">
                                        <div class="card ">
                                            <div class="card-header bg-success">
                                                <h3 class="card-title">เพิ่มข้อมูล</h3>
                                            </div>
                                            <form id="frmmodal_add" name="frmmodal_add">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="name_th">ชื่อ</label>
                                                        <input type="text" class="form-control" id="name_th" name="name_th" placeholder="Enter name">
                                                    </div>
                                                </div>

                                                <div class="card-footer text-right">
                                                    <button type="button" id="btn_modal_addproduct" class="btn btn-primary">เพิ่มข้อมูล</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- เพิ่ม -->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-8 ">
                                        <div class="card ">
                                            <div class="card-header bg-warning">
                                                <h3 class="card-title">แก้ไขข้อมูล</h3>
                                            </div>
                                            <form id="frmmodal_edit" name="frmmodal_edit">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="selectproduct">เลือกรายชื่อ</label>
                                                        <select id="selectproduct" name="selectproduct" class="form-control select2" style="width:100%">
                                                            <option selected="">เลือก</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name_th">แก้ไขชื่อ</label>
                                                        <input type="text" class="form-control" id="edit_name_th" name="edit_name_th" placeholder="Enter name">
                                                    </div>
                                                </div>

                                                <div class="card-footer text-right">
                                                    <button type="button" id="btn_modal_editproduct" class="btn btn-primary mx-2 w-25">บันทึก</button>
                                                    <button type="button" id="btn_modal_delproduct" class="btn btn-danger">ลบ</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle-o" aria-hidden="true"></i> ปิด</button>
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
    <script src="<?php echo $base_bn; ?>frontend/bootstrap-select/js/bootstrap-select.js"></script>
    <script src="<?php echo $base_bn; ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo $base_bn; ?>plugins/select2/js/select2.full.min.js"></script>
    </div>
    <script>
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            //Initialize Select2 Elements
            $('.select2').select2()

            productlist();
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $('.btn[data-filter]').on('click', function() {
                $('.btn[data-filter]').removeClass('active');
                $(this).addClass('active');
            });

            // list promotion reference
            $(document).on('click', '.btn_promotionref', function() {
                var data = new FormData();
                // data.append('sku', $('.btn_promotionref').attr('id'));
                // console.log($(this).attr('data-id'));
                let url = 'get_listPromotionRef?sku=' + $(this).attr('data-id');
                fetch(url)
                    .then(res => res.json())
                    .then((resp) => {
                        let html = "";
                        $.each(resp, function(key, value) {
                            key++;
                            html += key + " " + value + "<br>";
                        })
                        $('#resultproref').html(html);
                    })
                    .catch((error) => {
                        console.log(`error :${error}`);
                    })
            });

            //----------------------------filter--------------------------//
            $(document).on('click', '#bntvaldate', function(event) {

                if ($('#status').val() != '') {
                    var status = $('#status').val();
                } else {
                    var status = null;
                }
                if ($('#keyword').val() != '') {
                    var keyword = $('#keyword').val();
                } else {
                    var keyword = null;
                }
                if ($('#select-productmain').val() != '') {
                    var selectproductmain = $('#select-productmain').val();
                } else {
                    var selectproductmain = null;
                }
                $('#ex1').DataTable().destroy();
                productlist(status, keyword, selectproductmain);

            });

            $(document).on('click', '#refresh_page', function(event) {
                $('#ex1').DataTable().destroy();
                productlist();
            });

            $(document).on('click', '#editstatus', function(event) {
                $.post("ajaxeditstatus", {
                    id: this.value
                }, function(result) {
                    var obj = jQuery.parseJSON(result);
                    Toast.fire({
                        type: 'success',
                        title: ' Confirm Status success ' + obj.txt + '.'
                    });
                    $('#ex1').DataTable().destroy();
                    productlist();
                });
            });

            function productlist(status, keyword, selectproductmain) {
                if (status == 0) {
                    status = 'off';
                }
                var dataTable = $('#ex1').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "ajax": {
                        url: "<?php echo base_url() . 'mod_retailproduct/ctl_retailproduct/fetch_product'; ?>",
                        type: "POST",
                        data: {
                            status: status,
                            keyword: keyword,
                            selectproductmain: selectproductmain
                        }
                    },
                    "columnDefs": [{
                        "targets": 0,
                        "orderable": false,
                    }, ],
                });
            }
            //
            // Button function
            //
            let type;
            var modalProduct = $('.modal-product');
            $(document).on('click', '.btn_menumain', function() {
                let element = $(this);
                let btn_name = element.text().trim();
                type = element.attr('data-type');

                //  style modal
                let title = btn_name;
                $('.modal-product').find('.modal-title').html(title);

                async_getData(type);

            })

            let htmlSelect = "";

            function onSelectProduct(e) {
                htmlSelect = itemId
            }
            $(document).on('change', '#selectproduct', function() {
                let element = $('#edit_name_th');
                element.val($('option:selected', this).attr('data-name'));
                htmlSelect = $('option:selected', this).val();
            })

            // 
            //  click add
            $(document).on('click', '#btn_modal_addproduct', function() {
                var itemid = $('#name_th').val();
                if (itemid == "") {
                    Swal.fire({
                        type: 'warning',
                        title: 'โปรดระบุชื่อ',
                        text: '',
                        timer: 2000
                    })

                    return false;
                }

                let form = $('form#frmmodal_add').serializeArray();

                let url = '../../api/product/'+type+'/add/';

                Swal.fire({
                    title: 'Wait ...',
                    allowOutsideClick: false,
                    async onOpen(result) {
                        fetch(
                                url, {

                                    headers: {
                                        'API-KEY': 'XOGgx6vzY2yIj7li4tS1PMrqckh8dmE5FVQRZGeL',
                                    },
                                    method: 'POST',
                                    body: JSON.stringify(form)
                                })
                            .then(async (response) => {
                                let result = await response.json();

                                swal.close();

                                if (!response.ok) {
                                    throw new Error("HTTP status " + response.status);
                                } else {

                                    if (result.error_code) {
                                        Swal.fire({
                                            type: 'warning',
                                            title: 'ข้อมูลไม่ถูกต้อง',
                                            text: result.data,
                                        }).then((response) => {
                                            if (response) {
                                                $('#name_th').addClass('is-invalid').focus();
                                            }
                                        })

                                        return false;
                                    }
                                    //
                                    //  success
                                    Swal.fire({
                                        type: 'success',
                                        title: 'รายการสำเร็จ',
                                        text: 'เพิ่มรายการสำเร็จ',
                                        timer: 2000,
                                    }).then(async (resolve) => {
                                        let doing1 = await new Promise((resolve, reject) => {
                                            resolve(
                                                    getData(type)
                                                )
                                        });

                                        //  clear value
                                        $('#name_th').val('');
                                        $('#name_th').removeClass('is-valid');

                                    })
                                }
                            })
                            .catch(function(error) {
                                alert(`${error}`);
                            })
                    },
                    onBeforeOpen() {
                        Swal.showLoading()
                    }
                })

            })

            $(document).on('keypress', '#name_th', function() {
                $(this).removeClass('is-invalid');
                $(this).addClass('is-valid');
            })

            // 
            //  click edit
            $(document).on('click', '#btn_modal_editproduct', function() {
                var itemid = $('option:selected', '#selectproduct').val();
                if (itemid == "") {
                    Swal.fire({
                        type: 'warning',
                        title: 'โปรดเลือกรายชื่อ',
                        text: '',
                        timer: 2000
                    })

                    return false;
                }

                let form = $('form#frmmodal_edit').serializeArray();

                let url = '../../api/product/'+type+'/edit/' + itemid;

                Swal.fire({
                    title: 'Wait ...',
                    allowOutsideClick: false,
                    async onOpen(result) {
                        fetch(
                                url, {

                                    headers: {
                                        'API-KEY': 'XOGgx6vzY2yIj7li4tS1PMrqckh8dmE5FVQRZGeL',
                                    },
                                    method: 'POST',
                                    body: JSON.stringify(form)
                                })
                            .then(async (response) => {
                                let result = await response.json();

                                swal.close();

                                if (!response.ok) {
                                    throw new Error("HTTP status " + response.status);
                                } else {

                                    if (result.error_code) {
                                        Swal.fire({
                                            type: 'warning',
                                            title: 'ข้อมูลไม่ถูกต้อง',
                                            text: result.data,
                                        }).then((response) => {
                                            if (response) {
                                                $('#edit_name_th').addClass('is-invalid').focus();
                                            }
                                        })

                                        return false;
                                    }
                                    //
                                    //  success
                                    Swal.fire({
                                        type: 'success',
                                        title: 'รายการสำเร็จ',
                                        text: 'แก้ไขรายการสำเร็จ',
                                        timer: 2000,
                                    }).then(async (resolve) => {
                                        let doing1 = await new Promise((resolve, reject) => {
                                            resolve(
                                                    getData(type)
                                                )
                                        });

                                    })
                                }
                            })
                            .catch(function(error) {
                                alert(`${error}`);
                            })
                    },
                    onBeforeOpen() {
                        Swal.showLoading()
                    }
                })

            })

            $(document).on('keypress', '#edit_name_th', function() {
                $(this).removeClass('is-invalid');
                $(this).addClass('is-valid');
            })

            // 
            //  click delete 
            $(document).on('click', '#btn_modal_delproduct', function() {
                var itemid = $('option:selected', '#selectproduct').val();
                if (itemid == "") {
                    Swal.fire({
                        type: 'warning',
                        title: 'โปรดเลือกรายชื่อ',
                        text: '',
                        timer: 2000
                    })

                    return false;
                }

                Swal.fire({
                    type: 'warning',
                    title: 'ลบข้อมูล',
                    // timer: 2000,
                    showConfirmButton: true,
                    confirmButtonText: "ยืนยัน",
                    showCancelButton: true,
                    cancelButtonText: "ยกเลิก",
                    text: 'ต้องการลบข้อมูลนี้',
                }).then((response) => {
                    //
                    //  confirm
                    if (response.value) {
                        Swal.fire({
                            title: 'Wait ...',
                            allowOutsideClick: false,
                            async onOpen(result) {
                                fetch(
                                        '../../api/product/'+type+'/delete/' + itemid, {

                                            headers: {
                                                'API-KEY': 'XOGgx6vzY2yIj7li4tS1PMrqckh8dmE5FVQRZGeL',
                                            },
                                            method: 'POST'
                                        })
                                    .then(async (response) => {
                                        let result = await response.json();

                                        swal.close();

                                        if (!response.ok) {
                                            throw new Error("HTTP status " + response.status);
                                        } else {

                                            if (result.error_code) {
                                                Swal.fire({
                                                    type: 'warning',
                                                    title: 'ข้อมูลไม่ถูกต้อง',
                                                    text: result.data,
                                                })

                                                return false;
                                            }
                                            //
                                            //  success
                                            Swal.fire({
                                                type: 'success',
                                                title: 'รายการสำเร็จ',
                                                text: 'ลบรายการสำเร็จ',
                                                timer: 2000,
                                            }).then(
                                                modalProduct.modal('hide')
                                            )
                                        }
                                    })
                                    .catch(function(error) {
                                        alert(`${error}`);
                                    })
                            },
                            onBeforeOpen() {
                                Swal.showLoading()
                            }
                        })
                    }

                })
            })

            modalProduct.on('hide.bs.modal', function() {
                document.frmmodal_add.reset();
                document.frmmodal_edit.reset();

                $('#edit_name_th').removeClass('is-valid')
                $('#edit_name_th').removeClass('is-invalid')

                $('#name_th').removeClass('is-valid')
                $('#name_th').removeClass('is-invalid')

                htmlSelect = "";
            })

            async function async_getData(type) {
                let result1 = await new Promise((resolve, reject) => {
                    return resolve(
                        getData(type)
                    )
                })
            }

            function getData(type) {

                let url = '../ctl_retailproduct/getdata';
                fetch(url + '?' + new URLSearchParams({
                        ptype: type
                    }))
                    .then(res => res.json())
                    .then((resp) => {
                        return htmlSelectOption(resp);
                    })
                    .catch(function(error) {
                        alert(error);
                    })

            }

            //
            //  @param  resp    @array = [id=list ID,name=name_th]
            //
            function htmlSelectOption(resp) {
                let option = '<option value="">เลือก</option>';
                $.each(resp, function(key, item) {

                    option += '<option value="' + item.id + '" data-name="' + item.name + '" ' + (htmlSelect == item.id ? 'selected' : '') + '>' + item.name + '(' + item.count + ')</option>';
                })

                $('#selectproduct').html(option);
            }
        })
    </script>
</body>

</html>