
<!DOCTYPE html>
<html lang="en">
   	<head> 
      <?php include("structer/backend/head.php"); ?>
      <link rel="stylesheet" href="<?php echo $base_bn;?>frontend/bootstrap-select/css/bootstrap-select.css">
      <link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/wickedcss.min.css"> 
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
                .btn-app4 {
                    border-radius: 3px;
                    background-color: #f8f9fa;
                    border: 1px solid #ddd;
                    color: #6c757d;
                    font-size: 12px;
                    height: 100%;
                    min-width: 80px;
                    padding: 15px 5px;
                    position: relative;
                    text-align: center;
                }
                .modal-footer {
                    display: -ms-flexbox;
                    display: flex;
                    -ms-flex-align: center;
                    align-items: center;
                    -ms-flex-pack: end;
                    justify-content: flex-end;
                    padding: 1rem 0 0;
                    border-top: 1px solid #e9ecef;
                    border-bottom-right-radius: .3rem;
                    border-bottom-left-radius: .3rem;
                }
                .swal2-header {
                    padding: 0;
                    border-bottom: 1px solid #FFF;
                }
                .is-warning {
                    border: 1px solid #ff5434;
                }
                .div-bottom {border: 1px solid #333; padding: 1rem;}
                .is-required{
                    margin-left: 10px;
                    font-size: 0.7rem;
                    color: #f00;
                }
                .text-ImgMultiple {
                    font-size: 0.7rem;
                    font-weight: 100;
                    color: #F44336;
                }
                .img-pay001 { width: 30%; }
                @media screen and (max-width: 991px){
                    .img-pay001 { width: 100%; }
                }
        </style>
    </head>
   	<body class="hold-transition sidebar-mini">

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
						<h1><?php echo $mainmenu; ?></h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('mod_admin') ?>/ctl_admin/backend_main">Home</a></li>
                            <li class="breadcrumb-item active"><?php echo $submenu; ?></li>
						</ol>
					</div>
					</div>
				</div><!-- /.container-fluid -->
			</section>
		  
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						  
						<section class="col-lg-12 connectedSortable">
							<!-- Custom tabs (Charts with tabs)-->
							<div class="card">
								<div class="card-header">
									<h3 class="card-title"> <i class="fa fa-bars" aria-hidden="true"></i>   </h3>
 								</div> 
								<div class="card-body">
                                    <form id="demo2" name="demo2" class="demo"  enctype="multipart/form-data" accept-charset="utf-8"  method="post">
                                            <input type="hidden" id="bill_update" name="bill_update" value="Y">
                                            <input type="hidden" id="claim_remark" name="claim_remark" value="<?php echo $this->input->post('claim_remark'); ?>">
                                            <input type="hidden" id="bill_id" name="bill_id" value="<?php echo $this->input->post('hdfclaimorder'); ?>">
                                            <input type="hidden" id="TBLtotalprice" name="TBLtotalprice" value="<?php echo $Query_billdetil['TOTALPRICE_LANG']; ?>">
                                            <input type="hidden" id="StatusComplete" name="StatusComplete" value="<?php echo $Query_billdetil['STATUSCOMPLETE']; ?>">
                                            <input type="hidden" id="BillStatus" name="BillStatus" value="<?php echo $Query_billdetil['BillStatus_Collect']; ?>">

                                            <div class="titel text-left" style="margin-bottom: 0px;"> <i class="fa fa-archive" aria-hidden="true"></i> หมายเหตุการเคลม </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="div-bottom">
                                                        <div class="row">
                                                            <div class="col-md-12 col-xl-12 text-center">
                                                                <h4> <?php echo 'หมายเหตุ : '.$this->input->post('claim_remark'); ?> </h4>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label class="">อธิบายข้อผิดผลาด : </label>
                                                                <textarea class="form-control" rows="3" name="claim_remark2" id="claim_remark2" placeholder="คำอธิบาย..."></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="titel text-left"> <i class="fa fa-file-o" aria-hidden="true"></i> แก้ไขรายการออเดอร์ </div>
                                             
                                            <div class="form-row">
                                                <label class="form-group col-md-6 text-right" for="order_date"> </label>
                                                <div class="form-group col-md-3">
                                                    <label class="">เลือกการส่ง</label>
                                                    <span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <select class="custom-select " name="deliveryid" id="deliveryid">
                                                        <option <?php if($Query_billdetil['DELIVERY_FORM'] == ''){ echo 'selected';} ?> value=""> เลือกรูปแบบการจัดส่ง </option>
                                                        <option <?php if($Query_billdetil['DELIVERY_FORM'] == 1){ echo 'selected';} ?> value="1"> KERRY </option>
                                                        <option <?php if($Query_billdetil['DELIVERY_FORM'] == 2){ echo 'selected';} ?> value="2"> EMS </option>
                                                        <option <?php if($Query_billdetil['DELIVERY_FORM'] == 3){ echo 'selected';} ?> value="3"> FLASH </option>
                                                        <option <?php if($Query_billdetil['DELIVERY_FORM'] == 4){ echo 'selected';} ?> value="4"> DHL </option>
                                                        <option <?php if($Query_billdetil['DELIVERY_FORM'] == 5){ echo 'selected';} ?> value="5"> SCG </option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="">วันที่</label>
                                                    <span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <input type="date" class="form-control " name="order_date" id="order_date" value="<?php echo date('Y-m-d',strtotime($Query_billdetil['DATE_STARTS_strtotime'])); ?>">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label class="">ชื่อ-นามสกุล</label>
                                                    <span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <input type="text" class="form-control " name="name" id="name" placeholder="ชื่อ-นามสกุล" value="<?php echo $Query_billdetil['NAME']; ?>">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="">Text Code : </label> 
                                                    <input type="text" class="form-control " name="TextCode" id="TextCode" placeholder="Text Code...." value="<?php echo $Query_billdetil['TextCode']; ?>" <?php echo $disabled; ?>>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="">เบอร์โทรศัพท์</label>
                                                    <input type="text" class="form-control " name="tel" id="tel" placeholder="เบอร์โทรศัพท์" value="<?php echo $Query_billdetil['PHONENUMBER']; ?>">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="">ช่องทางการรับออเดอร์</label><span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <select class="custom-select " name="method_order" id="method_order">
                                                        <option value=""> เลือกช่องทางการรับออเดอร์ </option>
                                                        <?php foreach($Query_methodorder->result() AS $row){ ?>
                                                            <option <?php if($Query_billdetil['METHODORDER_ID'] == $row->ID){ echo 'selected';} ?> value="<?php echo $row->ID; ?>"> <?php echo $row->TOPIC; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-10">
                                                    <label class="">ที่อยู่</label>
                                                    <span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <textarea rows="2" class="form-control" name="address" id="address" placeholder="ที่อยู่"><?php echo $Query_billdetil['ADDRESS']; ?></textarea>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="">รหัสไปรษณีย์</label>
                                                    <span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <input type="number" class="form-control " name="zipcode" id="zipcode" placeholder="รหัสไปรษณีย์" style="height: 62px;" value="<?php echo $Query_billdetil['ZIPCODE']; ?>">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="">เลขที่เสียภาษี/เลขที่บัตรประชาชน</label>
                                                    <input type="text" class="form-control " name="text_nameber" id="text_nameber" placeholder="เลขที่เสียภาษี/เลขที่บัตรประชาชน" value="<?php echo $Query_billdetil['TEXTNUMBER']; ?>">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row" style="background-color: #ddd;padding: 0.5rem;border-radius: 1rem;border: 1px solid #9E9E9E;">
                                                <div class="form-group col-md-6">
                                                    <label>ธนาคารที่โอน</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-university"></i></span>
                                                        </div>
                                                        <select class="custom-select " name="bankID" id="bankID">
                                                            <option value=""> เลือกธนาคารที่โอน </option>
                                                            <?php foreach($Query_bank->result() AS $row){ ?>
                                                                <option <?php if($Query_billdetil['BANIKID'] == $row->ID){ echo 'selected';} ?> value="<?php echo $row->ID; ?>"> <?php echo $row->NAME_TH." | ".$row->NAME_US; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>วันที่โอนเงิน</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                        <input type="date" class="form-control " name="transferedDate" id="transferedDate" value="<?php if($Query_billdetil['TRANSFEREDDAYTIME'] != ''){ echo date('Y-m-d',strtotime($Query_billdetil['TRANSFEREDDAYTIME'])); } ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>เวลาโอนเงิน </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                                        </div>
                                                        <input type="time" class="form-control " name="transferedTime" id="transferedTime" value="<?php if($Query_billdetil['TRANSFEREDDAYTIME'] != ''){ echo date('H:i',strtotime($Query_billdetil['TRANSFEREDDAYTIME'])); } ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="">จำนวนเงิน</label>
                                                    <input type="number" class="form-control " name="Amount" id="Amount" placeholder="จำนวนเงิน - Amount" style="height: 62px;" value="<?php echo $Query_billdetil['TRANSFEREDAMOUNT']; ?>">
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <label class="">หมายเหตุ/Remark</label>
                                                    <textarea rows="2" class="form-control" name="TransferedRemark" id="TransferedRemark" placeholder="กรณีโอนมากว่า 1 รายการกรุณาระบุเลข Invoice/Transfered More Then 1 Order"><?php echo $Query_billdetil['TRANSFEREDREMARK']; ?></textarea>
                                                </div>
                                                  
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="">คำอธิบายเพิ่มเติม </label>
                                                    <textarea rows="3" class="form-control" name="remark_order" id="remark_order" placeholder="คำอธิบาย..."><?php echo $Query_billdetil['REMARK_ORDER']; ?></textarea>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="titel text-left"> 
                                                <i class="fa fa-file-text" aria-hidden="true"></i> รายการออเดอร์
                                                <button style="padding: 0rem .5rem; position: absolute; right: 2rem;" type="button" class="btn btn-default btn-sm modal-bill" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus-circle" aria-hidden="true"></i>  เพิ่ม </button> 
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id='table-bill'>
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 5%;text-align: center;">#</th>
                                                                    <th style="text-align: center;">รายการออเดอร์</th>
                                                                    <th style="width: 10%;text-align: center;">ราคา/บาท</th>
                                                                    <th style="width: 10%;text-align: center;">จำนวน/หน่วย</th>
                                                                    <th style="width: 10%;text-align: center;">รวมเป็นเงิน/บาท</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="ORlist">
                                                                <?php $index=1; foreach($Query_billdetil['billist'] AS $row1){  
                                                                        foreach($row1['PRONAME_LIST'] AS $row2){ ?>
                                                                        <tr id="tr-<?php echo $index; ?>" class="each-total">
                                                                            <td style="text-align: center;"> 
                                                                                <button type="button" class="btn btn-danger btn-sm" id="btndeleterow" value="tr-<?php echo $index; ?>"> <i class="fa fa-trash-o" aria-hidden="true"></i>   </button>
                                                                            </td>
                                                                            <input type="hidden" id="orderlist[<?php echo $index; ?>][promain]" name="orderlist[<?php echo $index; ?>][promain]" value="<?php echo $row1['PRONAME_MAINID']; ?>">
                                                                            <input type="hidden" id="orderlist[<?php echo $index; ?>][prolist]" name="orderlist[<?php echo $index; ?>][prolist]" value="<?php echo $row2['PRONAME_LISTID']; ?>">
                                                                            <input type="hidden" id="orderlist[<?php echo $index; ?>][proqty]" name="orderlist[<?php echo $index; ?>][proqty]" value="<?php echo $row2['QUANTITY']; ?>">
                                                                            <input type="hidden" id="orderlist[<?php echo $index; ?>][totalprice]" name="orderlist[<?php echo $index; ?>][totalprice]" value="<?php echo $row2['RBD_TOTALPRICE_LANG']; ?>">
                                                                            <td style="text-align: left;">  <?php  echo $row2['PRONAME_LIST']; ?> </td>
                                                                            <td style="text-align: right;"> <?php  echo $row2['PRICE']; ?></td>
                                                                            <td style="text-align: right;"> <?php  echo $row2['QUANTITY']; ?></td>
                                                                            <td id="TOTALP" style="text-align: right;" lang="<?php  echo $row2['RBD_TOTALPRICE_LANG']; ?>"> <?php  echo $row2['RBD_TOTALPRICE']; ?> </td>
                                                                        </tr>
                                                                <?php $index++;
                                                                        }
                                                                    } 
                                                                ?>
                                                            </tbody>
                                                            <tbody id="total">
                                                                 
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>รวมยอดขายสุทธิ</b> </td>
                                                                    <td class="text-right" style="padding: .2rem;" id='total-price'> <?php echo $Query_billdetil['TOTALPRICE']; ?> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ค่ากล่องพัสดุ</b> </td>
                                                                    <td class="text-center" style="padding: .2rem;"> 
                                                                        <input type="number" class="form-control " style="height: 1.5rem;" name="total-Parcelcost" id="total-Parcelcost" value="<?php echo $Query_billdetil['PARCELCOST_LANG']; ?>"> 
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ค่าบริการจัดส่ง</b> </td>
                                                                    <td class="text-center" style="padding: .2rem;">
                                                                        <input type="number" class="form-control " style="height: 1.5rem;" name="total-Shippingcost" id="total-Shippingcost" value="<?php echo $Query_billdetil['DELIVERYFEE_LANG']; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ค่าธรรมเนียม shopee</b> </td>
                                                                    <td class="text-center" style="padding: .2rem;">
                                                                        <input type="number" class="form-control " style="height: 1.5rem;" name="shor_money" id="shor_money" value="<?php echo $Query_billdetil['SHORMONEY']; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ส่วนลด</b> </td>
                                                                    <td class="text-center" style="padding: .2rem;background-color: #FF9800;">
                                                                        <input type="number" class="form-control " style="background-color: #FF9800; height: 1.5rem; border: 0; color: #FFF;" name="discount" id="discount" value="<?php echo $Query_billdetil['DISCOUNTPRICE_LANG']; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ค่าธรรมเนียมเก็บเงินปลายทาง</b> </td>
                                                                    <td class="text-center" style="padding: .2rem;background-color: #F44336;">
                                                                        <input type="number" class="form-control " style="background-color: #F44336; height: 1.5rem; border: 0; color: #FFF;" name="tax" id="tax" value="<?php echo $Query_billdetil['TAX']; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr style="background-color: #d9d9d9;">
                                                                    <td class="text-center" style="padding: .2rem 1rem;" colspan="4"> <b>ยอดชำระรวมค่าจัดส่ง</b> </td>
                                                                    <td class="text-right" style="padding: .2rem;" id='total-cost'> <?php echo $Query_billdetil['NETTOTAL']; ?> </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="titel text-left" style="margin-bottom: 0px;"> 
                                                <i class="fa fa-file-image-o" aria-hidden="true"></i> หลักฐานการโอนเงิน
                                                <button style="padding: 0rem .5rem; position: absolute; right: 2rem;" type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
                                                    <i class="fa fa-search-plus" aria-hidden="true"></i>  Zoom 
                                                </button> 
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="div-bottom text-center">
                                                        <div class="fileImage">
                                                            <?php 
                                                                if($Query_billdetil['PICPAYMENT'] == '' && $Query_billdetil['PICPAYMENT2'] == ''){ 
                                                                    foreach($Query_billdetil['IMGNAME'] AS $row){ 
                                                                        if($row['IMGNAME_NAME']){
                                                                            echo '<img src="'.$basepic.'front/retail/BillPaymentMultiple/'.$row['IMGNAME_NAME'].'" class="img-pay001">';
                                                                        } else {
                                                                            echo '<img src="https://heuft.com/upload/image/400x267/no_image_placeholder.png" class="img-pay001">';
                                                                        }
                                                                    }
                                                                } else { 
                                                                    echo '<img src="'.$basepic.'front/retail/Bill_Pyment/'.$Query_billdetil['PICPAYMENT'].'" class="img-pay001">';
                                                                    if($Query_billdetil['PICPAYMENT2'] != ''){  
                                                                        echo '<img src="'.$basepic.'front/retail/Bill_Pyment/'.$Query_billdetil['PICPAYMENT2'].'" class="img-pay001">';
                                                                    }  
                                                                } 
                                                            ?>
                                                        </div>
                                                        <div style="text-align: left;">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label class="">หลักฐานการโอนเงิน <span class="text-ImgMultiple"> (สามารถใส่ได้มากกว่า 1 รายการ) </span> </label>
                                                                    <div class="input-group">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="image_file[]" id="image_file" multiple>
                                                                            <label class="custom-file-label" for="image_file"><span id="imagedledetail">Choose file</span></label>
                                                                        </div>
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text" id="cancelimgdetail"><i class="fa fa-window-close"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    <p style="color: #9a9a9a;">Image 1 MB | Size : 275 x 440</p>
                                                                </div>
                                                                 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <label class="form-group col-md-3"> </label>
                                                <div class="col-md-9 ">
                                                    <button type="button" class="btn btn-default btn-sm" id="Save">
                                                        <span class="text-save"> <i class="fa fa-floppy-o"></i> ยืนยันการแก้ไขบิล  </span>
                                                        <span class="text-spinner"> <i class="spinner fa fa-refresh" aria-hidden="true"></i> กรุณารอสักครู่...  </span>
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-sm" id="cancel"><li class="fa fa-window-close-o "> </li> ยกเลิกการแก้ไขบิล </button>
                                                </div>
                                            </div>
                                            <!-- Modal ZOOM -->
                                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog " role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-file-image-o" aria-hidden="true"></i> หลักฐานการโอนเงิน</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php 
                                                                if($Query_billdetil['PICPAYMENT'] == '' && $Query_billdetil['PICPAYMENT2'] == ''){ 
                                                                    foreach($Query_billdetil['IMGNAME'] AS $row){ 
                                                                        if($row['IMGNAME_NAME']){
                                                                            echo '<img src="'.$basepic.'front/retail/BillPaymentMultiple/'.$row['IMGNAME_NAME'].'" style="width: 100%;">';
                                                                        } else {
                                                                            echo '<img src="https://heuft.com/upload/image/400x267/no_image_placeholder.png" style="width: 100%;">';
                                                                        }
                                                                    }
                                                                } else { 
                                                                    echo '<img src="'.$basepic.'front/retail/Bill_Pyment/'.$Query_billdetil['PICPAYMENT'].'" style="width: 100%;">';
                                                                    if($Query_billdetil['PICPAYMENT2'] != ''){  
                                                                        echo '<img src="'.$basepic.'front/retail/Bill_Pyment/'.$Query_billdetil['PICPAYMENT2'].'" style="width: 100%;">';
                                                                    }  
                                                                } 
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- // ========== Modal ============ // -->
                                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="titel text-left"> <i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ </div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="">เลือกเมนูหลัก</label>
                                                                <select id="select-productmain" name="select-productmain" class="selectpicker" data-live-search="true">
                                                                    <option  value=""> -- โปรดเลือกเมนูหลัก -- </option>
                                                                    <?php foreach($Query_productmain->result() AS $row){ ?>
                                                                            <option value="<?php echo $row->ID ?>"><?php echo $row->NAME_TH; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6" id="SLproductlist">
                                                                <label class="">เลือกรายการเมนู</label>
                                                                <select id="select-productlist" name="select-productlist" class="selectpicker selectpicker_1" data-live-search="true" disabled>
                                                                    
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="">จำนวน</label>
                                                                <input type="number" class="form-control " name="qty" id="qty" placeholder="จำนวน">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <button type="button" class="btn btn-app4 btn-block" id="add-order"> <i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ </button>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle-o" aria-hidden="true"></i> ปิด</button>
                                                        </div>
                                                    </div>
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
            <script src="<?php echo $base_bn;?>frontend/bootstrap-select/js/bootstrap-select.js"></script>
            <script src="<?php echo $base_bn;?>plugins/sweetalert2/sweetalert2.min.js"></script>
        </div>
        <script>
            $('.text-spinner').hide();
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            $(document).on('change', '#image_file', function(event) {
                var image_file = $('#image_file');
                var length = (image_file[0].files.length - 1);
                var html = '';
                for(var i=0; i<=length;i++){                    
                    if ( image_file[0].files[i] ){
                        html += '<img id="img-Trans'+i+'" src="'+window.URL.createObjectURL(image_file[0].files[i])+'" class="img-pay001">'
                    }
                }
                $('.fileImage').html(html);
            });
            $("#cancel").on("click", function (e) {
                window.location.replace('bill');
            });
            $("#cancelimgxx").on("click", function (e) {
                $("#imagedle").text("Choose file");
                $("#imageInput").val("");
            });
            $("#cancelimgdetail").on("click", function (e) {
                $("#imagedledetail").text("Choose file");
                $("#image_file").val("");
            });
            
            // ============================ //
            $( "#total-Parcelcost" ).keyup(function() {
                var totalParcelcost = parseFloat($('#total-Parcelcost').val());
                var totalShippingcost = parseFloat($('#total-Shippingcost').val());
                var shormoney = parseFloat($('#shor_money').val());
                var tax = parseFloat($('#tax').val());
                var discount = parseFloat($('#discount').val());
                var rowTotal = 0;
                if($('#TBLtotalprice').val() != ''){ rowTotal = parseFloat($('#TBLtotalprice').val()); }
                totalcost(totalParcelcost, totalShippingcost, shormoney, rowTotal, tax, discount);
            });
            $( "#total-Shippingcost" ).keyup(function() {
                var totalParcelcost = parseFloat($('#total-Parcelcost').val());
                var totalShippingcost = parseFloat($('#total-Shippingcost').val());
                var shormoney = parseFloat($('#shor_money').val());
                var tax = parseFloat($('#tax').val());
                var discount = parseFloat($('#discount').val());
                var rowTotal = 0;
                if($('#TBLtotalprice').val() != ''){ rowTotal = parseFloat($('#TBLtotalprice').val()); }
                totalcost(totalParcelcost, totalShippingcost, shormoney, rowTotal, tax, discount);
            });
            $( "#shor_money" ).keyup(function() {
                var totalParcelcost = parseFloat($('#total-Parcelcost').val());
                var totalShippingcost = parseFloat($('#total-Shippingcost').val());
                var shormoney = parseFloat($('#shor_money').val());
                var tax = parseFloat($('#tax').val());
                var discount = parseFloat($('#discount').val());
                var rowTotal = 0;
                if($('#TBLtotalprice').val() != ''){ rowTotal = parseFloat($('#TBLtotalprice').val()); }
                totalcost(totalParcelcost, totalShippingcost, shormoney, rowTotal, tax, discount);
            });
            $( "#tax" ).keyup(function() {
                var totalParcelcost = parseFloat($('#total-Parcelcost').val());
                var totalShippingcost = parseFloat($('#total-Shippingcost').val());
                var shormoney = parseFloat($('#shor_money').val());
                var tax = parseFloat($('#tax').val());
                var discount = parseFloat($('#discount').val());
                var rowTotal = 0;
                if($('#TBLtotalprice').val() != ''){ rowTotal = parseFloat($('#TBLtotalprice').val()); }
                totalcost(totalParcelcost, totalShippingcost, shormoney, rowTotal, tax, discount);
            });
            $( "#discount" ).keyup(function() {
                var totalParcelcost = parseFloat($('#total-Parcelcost').val());
                var totalShippingcost = parseFloat($('#total-Shippingcost').val());
                var shormoney = parseFloat($('#shor_money').val());
                var tax = parseFloat($('#tax').val());
                var discount = parseFloat($('#discount').val());
                var rowTotal = 0;
                if($('#TBLtotalprice').val() != ''){ rowTotal = parseFloat($('#TBLtotalprice').val()); }
                totalcost(totalParcelcost, totalShippingcost, shormoney, rowTotal, tax, discount);
            });
 
            function totalcost(totalParcelcost, totalShippingcost, shormoney, rowTotal, tax, discount){
                var total = (rowTotal + totalParcelcost + totalShippingcost + shormoney + tax) - discount;
                total = new Intl.NumberFormat('ja-JP').format(parseFloat(total).toFixed(2));
                $('#total-cost').text(total);
            }
             
            $(document).on("click", "#Save" , function() {
                var result = ["deliveryid", "name", "address", "claim_remark2"];
                for(var x=0;x<result.length;x++){
                    if(document.forms["demo2"][result[x]].value == ''){
                        Swal.fire(
                            'ผิดผลาด!',
                            'กรอกข้อมูลให้ครบถ้วน',
                            'warning'
                        )
                        $("#"+result[x]).addClass('is-warning');
                        $("#"+result[x]).focus();
                        return false;
                    }else{
                        $("#"+result[x]).removeClass('is-warning');
                    }
                }
                 
                if($("#TBLtotalprice").val() == ''){
                    Swal.fire(
                        'ผิดผลาด!',
                        'กรุณาเลือกรายการออเดอร์',
                        'warning'
                    )
                    return false;
                }
                $('#Save').attr('disabled','disabled');
                $('.text-save').hide();
                $('.text-spinner').show();
                dataform();
            });

            function dataform(){
                $.ajax({
                    url: "ajaxdataform",     
                    type:'POST',
                    data: $("form").serialize(),
                    success: function (results) {
                        var obj = jQuery.parseJSON(results);
                        if(obj.error_code == 1){
                            Swal.fire( 'ผิดผลาด!', 'Error', 'warning');
                        } else {
                            $.post("claimorder", { 
                                id: obj.getid, 
                                remark: obj.claim_remark1, 
                                valradio: obj.valradio,
                                remarkclaim: obj.claim_remark2
                            }, function(result){
                                var obj = jQuery.parseJSON(result);
                                if(obj.error_code == 0){
                                    var image_file = $('#image_file');
                                    if(image_file[0].files.length>0){
                                        var formdata = new FormData();
                                        var d = document;
                                        var length = (image_file[0].files.length - 1);
                                        for(var i=0; i<=length;i++){                    
                                            formdata.append('ImgPayment[]', image_file[0].files[i]);
                                        }
                                        formdata.append('BillID', obj.getid); 
                                        formdata.append('BillUpdate', 'Y');
                                        $.ajax({
                                            url: "ajaximg",
                                            type: "POST",
                                            data: formdata,
                                            processData: false,
                                            contentType: false,
                                            success: function (results) {
                                                var obj = jQuery.parseJSON(results);
                                                if(obj.status == 200){
                                                    Swal.fire('สำเร็จ!', "เคลมรายการออเดอร์สำเร็จ ณ วันที่ <?php echo thai_date(date('Y-m-d')); ?>", 'success')
                                                    $(".swal2-confirm").on("click", function (e) {
                                                        window.location.replace('bill');
                                                    });
                                                } 
                                            }
                                        });  
                                    } else {
                                        if(obj.error_code == 0){
                                            Swal.fire('สำเร็จ!', 'แก้ไขรายการสำเร็จ ณ วันที่ <?php echo thai_date(date('Y-m-d')); ?>', 'success')
                                            $(".swal2-confirm").on("click", function (e) {
                                                window.location.replace('bill');
                                            });
                                        }
                                    }
                                }
                            });
                        }
                    }
                });
            }
 
            $(document).on("click", "#btndeleterow" , function() {
                var val = $(this).val();
                var html = "";
                $("#"+val).remove();
                if($("#table-bill #ORlist tr").length == 0){
                    html += '<tr id="tr-'+$("#table-bill #ORlist tr").length+'">';
                    html += '    <td colspan="5" class="text-center"> --- โปรดเพิ่มรายการออเดอร์ --- </td>';
                    html += '</tr>';
                    $("#table-bill #ORlist").append(html); 
                    $('#total-price').text('-');
                    $('#TBLtotalprice').val('');
                }
                TBtotalprice();
                var totalParcelcost = parseFloat($('#total-Parcelcost').val());
                var totalShippingcost = parseFloat($('#total-Shippingcost').val());
                var shormoney = parseFloat($('#shor_money').val());
                var tax = parseFloat($('#tax').val());
                var discount = parseFloat($('#discount').val());
                var rowTotal = 0;
                if($('#TBLtotalprice').val() != ''){ rowTotal = parseFloat($('#TBLtotalprice').val()); }
                totalcost(totalParcelcost, totalShippingcost, shormoney, rowTotal, tax, discount);
            });
            $(document).on("click", ".modal-bill" , function() {
                $('#qty').val(''); var html2 = '';
                $("#select-productmain").selectpicker('refresh');
                $("#select-productlist").html(html2).selectpicker('refresh');
            });
            $(document).on("click", "#add-order" , function() {
                
                var productmainID = $('#select-productmain').val();
                var productlistID = $('#select-productlist').val();
                var qty = $('#qty').val();
                var result = ["select-productmain", "select-productlist", "qty"];
                for(var x=0;x<result.length;x++){
                    if(document.forms["demo2"][result[x]].value == ''){
                        Swal.fire(
                            'ผิดผลาด!',
                            'กรอกข้อมูลให้ครบถ้วน',
                            'warning'
                        )
                        $("#"+result[x]).addClass('is-warning');
                        $("#"+result[x]).focus();
                        return false;
                    }else{
                        $("#"+result[x]).removeClass('is-warning');
                    }
                }
                addrowtable(productmainID, productlistID, qty);
            });

            function addrowtable(productmainID, productlistID, qty){
                var html = '';
                $.post("ajaxaddrowtable", { 
                    PromainID: productmainID,
                    ProlistID: productlistID,
                    qty: qty,
                }, function(result){
                    var obj = jQuery.parseJSON(result);
                    $("#tr-0").remove();
                    var tbllength = ($("#table-bill #ORlist tr").length + 1);
                    html += '<tr id="tr-'+tbllength+'" class="each-total">';
                    html += '    <td style="text-align: center;"> ';
                    html += '        <button type="button" class="btn btn-danger btn-sm" id="btndeleterow" value="tr-'+tbllength+'"> <i class="fa fa-trash-o" aria-hidden="true"></i>   </button>';
                    html += '    </td>';
                    html += '    <input type="hidden" id="orderlist['+tbllength+'][promain]" name="orderlist['+tbllength+'][promain]" value="'+obj.PromainID+'">';
                    html += '    <input type="hidden" id="orderlist['+tbllength+'][prolist]" name="orderlist['+tbllength+'][prolist]" value="'+obj.ProlistID+'">';
                    html += '    <input type="hidden" id="orderlist['+tbllength+'][proqty]" name="orderlist['+tbllength+'][proqty]" value="'+obj.prolist_qty+'">';
                    html += '    <input type="hidden" id="orderlist['+tbllength+'][totalprice]" name="orderlist['+tbllength+'][totalprice]" value="'+obj.total_price+'">';
                    html += '    <td style="text-align: left;">'+obj.prolist_name+'</td>';
                    html += '    <td style="text-align: right;">'+obj.prolist_price+'</td>';
                    html += '    <td style="text-align: right;">'+obj.prolist_qty+'</td>';
                    html += '    <td id="TOTALP" style="text-align: right;" lang="'+obj.total_price+'">'+obj.NF_total_price+'</td>';
                    html += '</tr>';
                    $("#table-bill #ORlist").append(html);
                    TBtotalprice();
                    Toast.fire({
                        type: 'success',
                        title: ' เพิ่มรายการเมนู '+obj.prolist_name+' เรียบร้อย '
                    });    
                });
            }
                
            $('#select-productlist').change(function(){
                $('#qty').val('');
            });
            $('#select-productmain').change(function(){
                var option = $(this).find('option:selected'),
                id = option.val();
                name = option.data('name');
                $("#select-productlist").empty();
                $("#select-productlist").removeAttr('disabled')
                ajaxprolist(id);
            });

            function ajaxprolist(id){
                $.ajax({
                    url: "ajaxselectproductmain",     
                    type:'POST',
                    data: {
                        action: 'my_special_ajax_call',
                        val: id 
                    },
                    success: function (results) {
                        var obj = jQuery.parseJSON(results);
                        var html = '';
                        html +=' <option value="">โปรดเลือกรายการเมนู</option>';
                        $.each(obj, function( index, value ) {
                            html +=' <option value="'+value.ID+'">'+value.NAME_TH+'</option>';
                        });
                        $("#select-productlist").html(html).selectpicker('refresh');
                    }
                });
            }

            function TBtotalprice(){
                // Total Price //
                var arr_totalprice = [];
                $('#table-bill #ORlist .each-total').each(function () {
                    var row = $(this);
                    var rowTotal = 0;
                    $(this).find('td#TOTALP').each(function () {
                        var td = $(this);
                        arr_totalprice.push(parseFloat(td.context.lang).toFixed(2));
                    });
                    arr_totalprice = arr_totalprice.map(Number);
                    rowTotal = arr_totalprice.reduce(function(a,b){  return a+b },0);
                    $('#TBLtotalprice').val(rowTotal);
                    var up_rowTotal = rowTotal;
                    rowTotal = new Intl.NumberFormat('ja-JP').format(parseFloat(rowTotal).toFixed(2));
                    $('#total-price').text(rowTotal);
                    if($('#BillStatus').val() == "C"){
                        var Total = $('#TBLtotalprice').val();
                        var sum = Total*(3/100);
                        $('#tax').val(sum); 
                    }
                    var totalParcelcost = parseFloat($('#total-Parcelcost').val());
                    var totalShippingcost = parseFloat($('#total-Shippingcost').val());
                    var shormoney = parseFloat($('#shor_money').val());
                    var tax = parseFloat($('#tax').val());
                    var discount = parseFloat($('#discount').val());
                    var rowTotal = $('#TBLtotalprice').val();
                    var Total_cost = (parseFloat(rowTotal) + totalParcelcost + totalShippingcost + shormoney + tax) - discount;
                    $('#total-cost').text(Total_cost);
                });
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                bsCustomFileInput.init();
            });
        </script>
	</body>
</html>
 