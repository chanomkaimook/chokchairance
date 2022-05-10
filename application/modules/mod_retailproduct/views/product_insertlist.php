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

                                    <form id="demo2" name="demo2" class="demo" enctype="multipart/form-data" accept-charset="utf-8" method="post">
                                        <input type="hidden" id="prolist_id" name="prolist_id" value="<?php echo $UPproductlist->ID; ?>">
                                        <div class="titel text-left"> <i class="fa fa-database" aria-hidden="true"></i> Data Management </div>
                                        <div class="form-row">

                                            <label class="form-group col-md-3 text-right" for="name_th"> เลือกกลุ่มสินค้า </label>
                                            <div class="form-group col-md-9 ">
                                                <select id="select-productmain" name="select-productmain" class="selectpicker" data-live-search="true">

                                                    <?php
                                                    $setlist = "";
                                                    $disabled = "";

                                                    if ($UPproductlist->ID) {
                                                        $disabled = "disabled";
                                                        //  check type promotion
                                                        if ($UPproductlist->PROMOTION == 1 || $UPproductlist->PRODUCTSET == 1) {
                                                            $setlist = "on";
                                                        }

                                                        foreach ($Query_productmain->result() as $row) { ?>
                                                            <option <?php if ($UPproductlist->PROMAIN_ID == $row->ID) {
                                                                        echo 'selected';
                                                                    } ?> value="<?php echo $row->ID ?>"><?php echo $row->NAME_TH; ?></option>
                                                        <?php   }
                                                    } else {
                                                        echo ' <option  value=""> -- เลือก -- </option>';
                                                        foreach ($Query_productmain->result() as $row) {

                                                        ?>
                                                            <option value="<?php echo $row->ID ?>"><?php echo $row->NAME_TH; ?></option>
                                                    <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                            <?php
                                            if ($setlist == "on") {
                                                $sql = $this->db->select('id,codemac,name_th')
                                                    ->from('retail_productlist')
                                                    ->where('retail_productlist.promotion is null')
													->where('retail_productlist.productset is null')
                                                    ->where('status', 1);
                                                $q = $sql->get();
                                                $num = $q->num_rows();

                                                //
                                                // product list
                                                $this->load->library('product');
                                                $id = $UPproductlist->ID;
                                                $list = $UPproductlist->LIST_ID;
                                                $array_list = $this->product->get_dataProductCut(array('id' => $id, 'list_id' => $list));
                                                // 
                                                // 
                                            ?>
                                                <label class="form-group col-md-3 text-right" for="code"> ผูกสินค้า </label>
                                                <div class="form-group col-md-9 contentpromotion">
                                                    <div class="list_promotion">

                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <select name="select-listid" class="selectpicker " data-live-search="true">
                                                                    <option value="">เลือกสินค้าผูกกับโปร</option>
                                                                    <?php
                                                                    if ($num) {
                                                                        foreach ($q->result() as $r) {
                                                                            //  name
                                                                            if ($r->codemac ? $codemac = "(" . $r->codemac . ")" : $codemac = "");
                                                                            $name = $r->name_th . "" . $codemac;
                                                                    ?>
                                                                            <option value="<?php echo $r->id; ?>"><?php echo $name; ?></option>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <label class="col-md-2 text-right" for="code"> จำนวน </label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="pro_qty" class="form-control form-control-sm " value="" OnKeyPress="return checkNumber(this)">
                                                            </div>
                                                            <hr>
                                                        </div>

                                                        <?php
                                                        if (array_key_exists('data', $array_list)) :
                                                            if (count($array_list['data'])) {
                                                                foreach ($array_list['data'] as $key => $val) :
                                                        ?>
                                                                    <div class="row">
                                                                        <div class="col-md-7">
                                                                            <select name="select-listid" class="selectpicker " data-live-search="true">
                                                                                <option value="">เลือกสินค้าผูกกับโปร</option>
                                                                                <?php
                                                                                if ($num) {
                                                                                    foreach ($q->result() as $r) {

                                                                                        $selected_listid = "";
                                                                                        if ($val['id'] == $r->id) {
                                                                                            $selected_listid = "selected=selected";
                                                                                        }

                                                                                        //  name
                                                                                        if ($r->codemac ? $codemac = "(" . $r->codemac . ")" : $codemac = "");
                                                                                        $name = $r->name_th . "" . $codemac;
                                                                                ?>
                                                                                        <option value="<?php echo $r->id; ?>" <?php echo $selected_listid; ?>><?php echo $name; ?></option>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <label class="col-md-2 text-right" for="code"> จำนวน </label>
                                                                        <div class="col-md-2">
                                                                            <input type="text" name="pro_qty" class="form-control form-control-sm " value="<?php echo $val['total'];?>" OnKeyPress="return checkNumber(this)">
                                                                        </div>
                                                                        <hr>
                                                                        <div class="col-md-1 btnManagePromotion">
                                                                        <button type="button" class="btn btn-danger w-100 btn-sm btnDelPromotion"><i class='fas fa-trash-alt'></i></button>
                                                                        </div>
                                                                    </div>
                                                        <?php
                                                                endforeach;
                                                            }
                                                        endif;
                                                        ?>

                                                    </div>

                                                    <div class="row">
                                                        <ul class="text-secondary mb-0">
                                                            <li><span><small>บิลที่เปิดด้วยรายการสินค้านี้จะเปลี่ยนแปลงรายการที่ผูกให้อัตโนมัติ</small></span></li>
                                                            <li><span><small>หากบิลที่มีรายการสินค้านี้ถูกเปิดใบลดหนี้ หรือใบส่งของไปแล้ว จะไม่มีการเปลี่ยนแปลงรายการที่ผูกภายในบิล</small></span></li>
                                                        </ul>
                                                    </div>

                                                </div>
                                            <?php

                                            }
                                            ?>

                                            <label class="form-group col-md-3 text-right" for="prosubmain"> เลือกหมวดหมู่ </label>
                                            <div class="form-group col-md-9 ">
                                                <select id="select-productsubmain" name="select-productsubmain" class="selectpicker" data-live-search="true">
                                                    <?php
                                                    if ($UPproductlist->ID) {
                                                        foreach ($Query_productsubmain->result() as $row) { ?>
                                                            <option <?php if ($UPproductlist->PROSUBMAIN_ID == $row->ID) {
                                                                        echo 'selected';
                                                                    } ?> value="<?php echo $row->ID ?>"><?php echo $row->NAME_TH; ?></option>
                                                        <?php   }
                                                    } else {
                                                        echo ' <option  value=""> -- เลือก -- </option>';
                                                        foreach ($Query_productsubmain->result() as $row) {
                                                        ?>
                                                            <option value="<?php echo $row->ID ?>"><?php echo $row->NAME_TH; ?></option>
                                                    <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                            <label class="form-group col-md-3 text-right" for="protype"> เลือกรูปแบบ </label>
                                            <div class="form-group col-md-9 ">
                                                <select id="select-producttype" name="select-producttype" class="selectpicker" data-live-search="true">
                                                    <?php
                                                    if ($UPproductlist->ID) {
                                                        foreach ($Query_producttype->result() as $row) { ?>
                                                            <option <?php if ($UPproductlist->PROTYPE_ID == $row->ID) {
                                                                        echo 'selected';
                                                                    } ?> value="<?php echo $row->ID ?>"><?php echo $row->NAME_TH; ?></option>
                                                        <?php   }
                                                    } else {
                                                        echo ' <option  value=""> -- เลือก -- </option>';
                                                        foreach ($Query_producttype->result() as $row) {
                                                        ?>
                                                            <option value="<?php echo $row->ID ?>"><?php echo $row->NAME_TH; ?></option>
                                                    <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                            <label class="form-group col-md-3 text-right" for="procatagory"> Catagory </label>
                                            <div class="form-group col-md-9 ">
                                                <select id="select-productcatagory" name="select-productcatagory" class="selectpicker" data-live-search="true" <?php echo $disabled; ?> >
                                                    <?php
                                                    if ($UPproductlist->ID) {
                                                        foreach ($Query_productcate->result() as $row) { ?>
                                                            <option <?php if ($UPproductlist->PROCATE_ID == $row->ID) {
                                                                        echo 'selected';
                                                                    } ?> value="<?php echo $row->ID ?>"><?php echo $row->NAME_TH; ?></option>
                                                        <?php   }
                                                    } else {
                                                        echo ' <option  value=""> -- เลือก -- </option>';
                                                        foreach ($Query_productcate->result() as $row) {
                                                        ?>
                                                            <option value="<?php echo $row->ID ?>"><?php echo $row->NAME_TH; ?></option>
                                                    <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>

                                            <label class="form-group col-md-3 text-right" for="code"> Code </label>
                                            <div class="form-group col-md-9 ">
                                                <input type="text" class="form-control " name="code" id="code" placeholder="กำหนดชื่อ code" value="<?php echo $UPproductlist->CODE; ?>">
                                            </div>

                                            <label class="form-group col-md-3 text-right" for="name_th"> ชื่อรายการเมนู | TH</label>
                                            <div class="form-group col-md-9 ">
                                                <input type="text" class="form-control " name="name_th" id="name_th" placeholder="ชื่อรายการเมนู" value="<?php echo $UPproductlist->NAME_TH; ?>">
                                            </div>

                                            <label class="form-group col-md-3 text-right" for="name_us"> ชื่อรายการเมนู | US </label>
                                            <div class="form-group col-md-9 ">
                                                <input type="text" class="form-control " name="name_us" id="name_us" placeholder="ชื่อรายการเมนู" value="<?php echo $UPproductlist->NAME_US; ?>">
                                            </div>

                                            <label class="form-group col-md-3 text-right" for="price"> กำหนดราคา </label>
                                            <div class="form-group col-md-9 ">
                                                <input type="text" class="form-control " name="price" id="price" placeholder="กำหนดราคา" value="<?php echo $UPproductlist->PRICE; ?>">
                                            </div>


                                            <?php
                                            $status1_checked = "";
                                            $status2_checked = "";

                                            if ($this->input->get('prolist_id') != '') {
                                                if ($UPproductlist->STATUS == 1) {
                                                    $status1_checked = 'checked';
                                                }
                                                if ($UPproductlist->STATUS == 0) {
                                                    $status2_checked = 'checked';
                                                }
                                            } else {
                                                $status1_checked = 'checked';
                                            }

                                            ?>

                                            <label class="form-group col-md-3 text-right" for="status"> สถานะการแสดงผล</label>
                                            <div class="form-group col-md-9">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="status1" name="status" <?php echo $status1_checked; ?>>
                                                    <label for="status1" class="custom-control-label">ทำงาน</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="status2" name="status" <?php echo $status2_checked; ?>>
                                                    <label for="status2" class="custom-control-label">ปิดการทำงาน</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="status3" name="status" <?php echo $status2_checked; ?>>
                                                    <label for="status3" class="custom-control-label">ลบจากระบบ</label>
                                                </div>
                                            </div>

                                        </div>

                                        <hr>
                                        <div class="row">
                                            <label class="form-group col-md-3"> </label>
                                            <div class="col-md-9 ">
                                                <?php if ($this->input->get('prolist_id') != '') {
                                                    echo '<button type="button" class="btn btn-default btn-sm" id="Save"><li class="fa fa-floppy-o"> </li> Update</button>';
                                                } else {
                                                    echo '<button type="button" class="btn btn-default btn-sm" id="Save"><li class="fa fa-floppy-o"> </li> Save </button>';
                                                } ?>
                                                <button type="button" class="btn btn-default btn-sm" id="cancel">
                                                    <li class="fa fa-angle-double-left"> </li> Back Main
                                                </button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </section>

                    </div>
                </div>
            </section>

        </div>
        <?php include("structer/backend/footer.php"); ?>
        <?php include("structer/backend/script.php"); ?>
        <script src="<?php echo $base_bn; ?>frontend/bootstrap-select/js/bootstrap-select.js"></script>
    </div>
    <script>
        let html = `<div class="col-md-1 btnManagePromotion">
                        <button type="button" class="btn btn-secondary w-100 btn-sm btnAddPromotion">+</button>
                    </div>`;
        let htmldel = `<button type="button" class="btn btn-danger w-100 btn-sm btnDelPromotion"><i class='fas fa-trash-alt'></i></button>`;
        $(document).ready(function() {
            $(".contentpromotion").ready(function(e) {
                htmlAddPromotion();
                // $('.contentpromotion .list_promotion .row:eq(0)').append(html);
            });

            async function htmlBlockPromotion() {
                let optionlist = await get_ProductList();

                let htmlPro = await new Promise((resolve, reject) => {

                    resolve(createBlock(optionlist));
                });
                let html_AddPromotion = await new Promise((resolve, reject) => {

                    resolve(
                        htmlAddPromotion()
                    );
                });

            }

            function createBlock(optionlist) {
                let hmtl = `
                                <div class="row">

                                    <div class="col-md-7">
                                        <select name="select-listid" class="selectpicker" data-live-search="true">
                                            <option value="">เลือกสินค้าผูกกับโปร</option>
                                            ${optionlist}
                                        </select>
                                    </div>

                                    <label class="col-md-2 text-right" for="code"> จำนวน </label>
                                    <div class="col-md-2">
                                        <input type="text" name="pro_qty" class="form-control form-control-sm " value="" OnKeyPress="return checkNumber(this)">
                                    </div>
                                    <hr>
                                </div>
                            `
                $('.contentpromotion .list_promotion').prepend(hmtl)
            }

            function htmlAddPromotion() {

                let element = $('.contentpromotion .list_promotion .row');

                let lengthTotal = element.length - 1;
                if (element.length) {
                    let element_btn = $('.btnManagePromotion');
                    if (element_btn.length) {
                        $('.btnManagePromotion').html(htmldel);
                    }
                    $('.contentpromotion .list_promotion .row:eq(0)').append(html);
                    $('select[name=select-listid]').selectpicker('refresh')
                }
            }

            function get_ProductList() {
                let result = "";
                let url = "./getProductList";
                return new Promise((resolve, reject) => {


                    fetch(url)
                        .then(res => res.json())
                        .then((resp) => {

                            if (resp.length) {
                                resp.forEach(function(key, item) {
                                    result += `<option value="${key.id}">${key.value}</option>`;
                                })
                            }
                            resolve(result)
                        })
                        .catch(function(error) {
                            alert(`Error : ${error}`)
                        })


                })

            }

            $(document).on('click', '.btnAddPromotion', function() {
                //  add html promotion
                htmlBlockPromotion();
            })
            $(document).on('click', '.btnDelPromotion', function(e) {
                //  del html promotion
                $(this).parents('.list_promotion .row').empty();
            })


            $("#cancel").on("click", function(e) {
                window.location.replace('product');
            });

            $("#Save").on("click", function(e) {
                var result = ["code", "name_th", "select-productmain", "select-productsubmain", "select-producttype", "select-productcatagory"];
                for (var x = 0; x < result.length; x++) {
                    if (document.forms["demo2"][result[x]].value == '') {
                        swal("เกิดข้อผิดผลาด", "กรอกข้อมูลให้ครบถ้วน / please insert data", "warning");
                        document.getElementById(result[x]).focus();
                        return false;
                    }
                }
                dataform();
            });

            function dataform() {

                if (document.getElementById("status1").checked == true) {
                    var status = "1";
                } else if (document.getElementById("status2").checked == true) {
                    var status = "0";
                } else {
                    var status = "3";
                }

                var data = new FormData();
                var d = document;
                var prolist_id = '';
                if ($('#prolist_id').val()) {
                    prolist_id = $('#prolist_id').val();
                }

                //  list promotion
                let qty = $('[name=pro_qty]');
                if (qty.length) {
                    let qtyn = 0;
                    qty.each(function(key) {
                        
                        if ($(this).val() && $('[name=select-listid]').eq(key).val() != "") {
                            data.append("product_cut[" + qtyn + "][id]", $('[name=select-listid]').eq(key).val());
                            data.append("product_cut[" + qtyn + "][value]", parseInt($(this).val()));
                            qtyn++;
                        }
                        
                    })
                }

                data.append("prolist_id", prolist_id);
                data.append("name_th", d.getElementById('name_th').value);
                data.append("name_us", d.getElementById('name_us').value);
                data.append("promain_id", d.getElementById('select-productmain').value);
                data.append("prosubmain_id", d.getElementById('select-productsubmain').value);
                data.append("protype_id", d.getElementById('select-producttype').value);
                data.append("procate_id", d.getElementById('select-productcatagory').value);
                data.append("price", d.getElementById('price').value);
                data.append("code", d.getElementById('code').value);

                let select_listid = $('.select-listid');
                if (select_listid.length) {
                    if (select_listid.val() == "") {
                        swal("ผิดผลาด", "กรุณาระบุช่องผูกสินค้า", "warning");

                        return false;
                    }
                    data.append("listid", select_listid.val());
                }


                data.append("status", status);

                var settings2 = {
                    "crossDomain": true,
                    "url": "ajaxdataProlistForm",
                    "method": "POST",
                    "type": "POST",
                    "processData": false,
                    "contentType": false,
                    "mimeType": "multipart/form-data",
                    "data": data
                }
                $.ajax(settings2).done(function(response) {
                        var obj = jQuery.parseJSON(response);
                        if (obj.error_code == 1) {
                            swal("ผิดผลาด", obj.txt, "warning");
                        } else {
                            swal("บันทึกข้อมูลเรียบร้อย", obj.txt, "success");
                            $(".swal-button").on("click", function(e) {
                                window.location.replace('product_insertlist?prolist_id=' + obj.getid);
                            });

                        }
                    })
                    .fail(function(response) {
                        console.log('Error : ' + response);
                    })
            }


        });
    </script>
    <script type="text/javascript">
        function checkNumber(ele) {
            var vchar = String.fromCharCode(event.keyCode);
            // console.log(vchar);
            if (vchar < '0' || vchar > '9') {
                return false
            }

        }

        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script>

</body>

</html>