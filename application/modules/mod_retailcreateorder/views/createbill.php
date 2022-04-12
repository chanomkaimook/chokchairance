
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
                #swal2-title{
                    font-weight: 300;
                    padding: 1.5rem 0.5rem;
                    font-size: 1.5rem;
                    color: #333;
                    text-align: center;
                }
                .swal2-header {
                    padding: 0;
                    border-bottom: 1px solid #ffffff;
                }
                .is-invalid {
                    border: 1px solid #ff5434;
                }
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
                                            <input type="hidden" id="bill_update" name="bill_update" value="N">
                                            <input type="hidden" id="bill_id" name="bill_id" value="-1">
                                            <input type="hidden" id="TBLtotalprice" name="TBLtotalprice" value="">
                                            <input type="hidden" id="StatusComplete" name="StatusComplete" value="0">
                                             
                                            <div class="titel text-left"> <i class="fa fa-file-o" aria-hidden="true"></i> สร้างรายการออเดอร์ </div>
                                            <div class="form-row"> 
											<!--
                                                <div class="form-group col-md-6">
                                                    <div class="">
                                                        <ul class="nav nav-pills pull-left mb-1">
                                                            <li class="nav-item" style="background-color: #33333317;border-radius: 5px;margin: 0.1rem;">
                                                                <button type="button" class="btn btn-defaultnl btn-sm nav-link active" data-toggle="tab" value="0" id="statustransfere"> โอนเงิน </button>
                                                            </li>
                                                            <li class="nav-item" style="background-color: #33333317;border-radius: 5px;margin: 0.1rem;">
                                                                <button type="button" class="btn btn-defaultnl btn-sm nav-link" data-toggle="tab" value="5" id="statustransfere"> เก็บเงินที่หลัง </button>
                                                            </li>
                                                            <li class="nav-item" style="background-color: #33333317;border-radius: 5px;margin: 0.1rem;">
                                                                <button type="button" class="btn btn-defaultnl btn-sm nav-link" data-toggle="tab" value="6" id="statustransfere"> อื่นๆ </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
											-->
												<div class="form-group col-md-4">
                                                    <label class="">วันที่สร้างบิล</label>
                                                    <span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                        <input type="date" class="form-control " name="order_date" id="order_date" value="<?php echo date('Y-m-d'); ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="">เลือกการส่ง</label>
                                                    <span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-cubes"></i></span>
                                                        </div>
                                                        <select class="custom-select " name="deliveryid" id="deliveryid">
                                                            <option value=""> เลือกรูปแบบการจัดส่ง </option>
															<?php
																$sql = $this->db->select('*')
																->from('delivery')
																->where('status',1)
																->get();
																foreach($sql->result() as $row){
																	echo '<option value="'.$row->ID.'"> '.$row->NAME_US.' </option>';
																}
															?>
                                                        </select>
                                                    </div>
                                                </div>
												<div class="form-group col-md-4">
                                                    <label class="">ช่องทางการรับออเดอร์</label>
                                                    <span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-paper-plane"></i></span>
                                                        </div>
                                                        <select class="custom-select " name="method_order" id="method_order">
                                                            <option value=""> เลือกช่องทางการรับออเดอร์ </option>
                                                            <?php foreach($Query_methodorder->result() AS $row){ ?>
                                                                <option value="<?php echo $row->ID; ?>"> <?php echo $row->TOPIC; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
												<div class="form-group col-md-3">
                                                    <label class="">ชื่อ-นามสกุล</label>
                                                    <span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-user-circle-o"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control " name="name" id="name" placeholder="ชื่อ-นามสกุล">
                                                    </div>
                                                </div>
												<div class="form-group col-md-3">
                                                    <label class="">เบอร์โทรศัพท์</label>
													<span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control " name="tel" id="tel" placeholder="เบอร์โทรศัพท์">
                                                    </div>
                                                </div>
												<div class="form-group col-md-3">
                                                    <label class="">รหัสไปรษณีย์</label>
                                                    <span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <input type="number" class="form-control " name="zipcode" id="zipcode" placeholder="รหัสไปรษณีย์" >
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="">Text Code : </label> 
                                                    <input type="text" class="form-control " name="TextCode" id="TextCode" placeholder="Text Code...." onblur="checkTextcode();">
                                                </div>
                                                
                                                
                                                <div class="form-group col-md-12">
                                                    <label class="">ที่อยู่</label>
                                                    <span class="is-required">(* กรุณาระบุข้อมูล)</span>
                                                    <textarea rows="2" class="form-control" name="address" id="address" placeholder="ที่อยู่"></textarea>
                                                </div>
                                                
                                                <div class="form-group col-md-12">
                                                    <label class="">เลขที่เสียภาษี/เลขที่บัตรประชาชน</label>
                                                    <input type="text" class="form-control " name="text_nameber" id="text_nameber" placeholder="เลขที่เสียภาษี/เลขที่บัตรประชาชน">
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
                                                                <option value="<?php echo $row->ID; ?>"> <?php echo $row->NAME_TH." | ".$row->NAME_US; ?> </option>
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
                                                        <input type="date" class="form-control " name="transferedDate" id="transferedDate">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>เวลาโอนเงิน </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                                        </div>
                                                        <input type="time" class="form-control " name="transferedTime" id="transferedTime">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="">จำนวนเงิน</label>
                                                    <input type="number" class="form-control " name="Amount" id="Amount" placeholder="จำนวนเงิน - Amount" style="height: 62px;">
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <label class="">หมายเหตุ/Remark</label>
                                                    <textarea rows="2" class="form-control" name="TransferedRemark" id="TransferedRemark" placeholder="กรณีโอนมากว่า 1 รายการกรุณาระบุเลข Invoice/Transfered More Then 1 Order"></textarea>
                                                </div>
                                                 
                                                <div class="form-group col-md-6">
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
                                                <div class="form-group col-md-6">
                                                    <div class="p-1 fileImage">  </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="">คำอธิบายเพิ่มเติม </label>
                                                    <textarea rows="3" class="form-control" name="remark_order" id="remark_order" placeholder="คำอธิบาย..."></textarea>
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
                                                                <tr id='tr-0'>
                                                                    <td colspan="5" class="text-center"> --- โปรดเพิ่มรายการออเดอร์ --- </td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody id="total">
                                                                 
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>รวมยอดขายสุทธิ</b> </td>
                                                                    <td class="text-right" style="padding: .2rem;" id='total-price'> - </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ค่ากล่องพัสดุ</b> </td>
                                                                    <td class="text-center" style="padding: .2rem;">  
                                                                        <input type="number" class="form-control " style="height: 1.5rem;" name="total-Parcelcost" id="total-Parcelcost" value="0"> 
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ค่าบริการจัดส่ง</b> </td>
                                                                    <td class="text-center" style="padding: .2rem;">
                                                                        <input type="number" class="form-control " style="height: 1.5rem;" name="total-Shippingcost" id="total-Shippingcost" value="0">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ค่าธรรมเนียม shopee</b> </td>
                                                                    <td class="text-center" style="padding: .2rem;">
                                                                        <input type="number" class="form-control " style="height: 1.5rem;" name="shor_money" id="shor_money" value="0">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ส่วนลด</b> </td>
                                                                    <td class="text-center" style="padding: .2rem;background-color: #FF9800;">
                                                                        <input type="number" class="form-control " style="background-color: #FF9800; height: 1.5rem; border: 0; color: #FFF;" name="discount" id="discount" value="0">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right"  style="padding: .2rem 1rem;" colspan="4"> <b>ค่าธรรมเนียมเก็บเงินปลายทาง</b> </td>
                                                                    <td class="text-center" style="padding: .2rem;background-color: #F44336;">
                                                                        <input type="number" class="form-control " style="background-color: #F44336; height: 1.5rem; border: 0; color: #FFF;" name="tax" id="tax" value="0">
                                                                    </td>
                                                                </tr>
                                                                <tr style="background-color: #d9d9d9;">
                                                                    <td class="text-center" style="padding: .2rem 1rem;" colspan="4"> <b>ยอดชำระรวมค่าจัดส่ง</b> </td>
                                                                    <td class="text-right" style="padding: .2rem;" id='total-cost'> - </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
												
												<div class="form-group col-md-12">
                                                    <div class="">
                                                        <ul class="nav nav-pills pull-left mb-1 ">
                                                            <li class="nav-item" style="background-color: #33333317;border-radius: 5px;margin: 0.1rem;">
                                                                <button type="button" class="btn btn-defaultnl btn-sm nav-link" data-toggle="tab" value="0" id="statustransfere"> โอนเงิน </button>
                                                            </li>
                                                            <li class="nav-item" style="background-color: #33333317;border-radius: 5px;margin: 0.1rem;">
                                                                <button type="button" class="btn btn-defaultnl btn-sm nav-link" data-toggle="tab" value="5" id="statustransfere"> เก็บเงินที่หลัง </button>
                                                            </li>
                                                            <li class="nav-item" style="background-color: #33333317;border-radius: 5px;margin: 0.1rem;">
                                                                <button type="button" class="btn btn-defaultnl btn-sm nav-link" data-toggle="tab" value="6" id="statustransfere"> อื่นๆ </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
											
											
                                            <hr>
                                            <div class="row">
                                                <label class="form-group col-md-3"> </label>
                                                <div class="col-md-9 ">
                                                    <button type="button" class="btn btn-default btn-sm" id="Save">
                                                        <span class="text-save"> <i class="fa fa-floppy-o"></i> ยืนยันการสร้างบิล  </span>
                                                        <span class="text-spinner"> <i class="spinner fa fa-refresh" aria-hidden="true"></i> กรุณารอสักครู่...  </span>
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-sm" id="cancel"><li class="fa fa-angle-double-left"> </li> กลับหน้ารายการ </button>
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
            // เช็ค TextCode ซ้ำ //
            function checkTextcode(){
                var textcode = $('#TextCode').val();
                $.ajax({
                    url: "ajaxchecktextcode",     
                    type:'POST',
                    data: {textcode: textcode},
                    success: function (results) {
                        var obj = jQuery.parseJSON(results); 
                        if(obj>0){
                            $("#TextCode").addClass('is-invalid');
                            $("#TextCode").focus();
                            alert('ผิดผลาด! กรุณาตรวจสอบใหม่ Text Code นี้เคยมีการสร้างออเดอร์ไปแล้ว'); 
                            $('#TextCode').val('');
                            $("#TextCode").removeClass('is-invalid');
                        } else {
                            $("#TextCode").removeClass('is-invalid');
                        }
                    }
                });
            }
			
			$(document).on('keypress blur', '#zipcode', function(event) {
				console.log($(this).val().length);
				let lengthZipcode  = $(this).val().length;
				if(lengthZipcode > 4 ){
					
					let str = $(this).val();
					let strCut = str.substring(0, 5);
					$(this).val(strCut);
					
					return false;
				}
			});
			
			$('.bd-example-modal-lg').on('shown.bs.modal', function () {
                // $("#select-productmain").eq(0).prop('checked');
                $("#select-productmain").val("");
                $('.selectpicker').selectpicker('refresh')
            });

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
                        html += '<img id="img-Trans'+i+'" src="'+window.URL.createObjectURL(image_file[0].files[i])+'" alt="image" class="img-fluid img-thumbnail" style="width: 83px; height: 125px;">'
                    }
                }
                $('.fileImage').html(html);
            });
            $(document).on('click', '#statustransfere', function(event) {
                var val = this.value;
                $('#StatusComplete').val(val);
            }); 
            $("#cancel").on("click", function (e) {
                window.location.replace('bill');
            });
           
            $("#cancelimgdetail").on("click", function (e) {
                $("#imagedledetail").text("Choose file");
                $("#image_file").val("");
                $('.fileImage').html('');
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
                var total = (rowTotal + totalParcelcost + totalShippingcost + shormoney+tax) - discount;
                total = new Intl.NumberFormat('ja-JP').format(parseFloat(total).toFixed(2));
                
				//
                //  for bill free price
                if($('#StatusComplete').val() == 6){ 
                    $('#total-cost').text(0);
                }else{
                    $('#total-cost').text(total);
                }
				
                sumtax(totalParcelcost, totalShippingcost, shormoney, discount);
            }

            function sumtax(totalParcelcost, totalShippingcost, shormoney, discount){
                if($('#StatusComplete').val() == 5){
                    var TBLtotalprice = $('#TBLtotalprice').val();
                    var total = (parseFloat(TBLtotalprice)+totalParcelcost+totalShippingcost+shormoney+discount)-discount;
                    var sum = parseFloat(total)*(3/100);                    
                    $('#tax').val(parseFloat(sum).toFixed(2)); 
                }
            }
             
            $(document).on("click", "#Save" , function() {
			// console.log($("#statustransfere.active").val()+"++");return false;
				
				var result = ["deliveryid", "name", "method_order", "address", "zipcode","tel"];
                for(var x=0;x<result.length;x++){
                    if(document.forms["demo2"][result[x]].value == ''){
                        Swal.fire(
                            'ผิดผลาด!',
                            'กรอกข้อมูลให้ครบถ้วน',
                            'warning'
                        )
                        $("#"+result[x]).addClass('is-invalid');
                        $("#"+result[x]).focus();
                        return false;
                    }else{
                        $("#"+result[x]).removeClass('is-invalid');
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
				
				if($("#statustransfere.active").val() == undefined){
                    Swal.fire(
                        'ผิดผลาด!',
                        'กรุณาเลือกการชำระเงิน',
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
                            var image_file = $('#image_file');
                            if(image_file[0].files.length>0){
                                var formdata = new FormData();
                                var d = document;
                                var length = (image_file[0].files.length - 1);
                                for(var i=0; i<=length;i++){                    
                                    formdata.append('ImgPayment[]', image_file[0].files[i]);
                                }
                                formdata.append('BillID', obj.getid); 
                                formdata.append('BillUpdate', 'N'); 
                                $.ajax({
                                    url: "ajaximg",
                                    type: "POST",
                                    data: formdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (results) {
                                        var obj = jQuery.parseJSON(results);
                                        if(obj.status == 200){
                                            Swal.fire('สำเร็จ!', 'ทำรายการสำเร็จวันที่ออกบิล <?php echo thai_date(date('Y-m-d')); ?>', 'success')
                                            $(".swal2-confirm").on("click", function (e) {
                                                window.location.replace('viwecreatebill?id='+obj.getid);
                                            });
                                        } 
                                    }
                                });  
                            } else {
                                if(obj.error_code == 0){
                                    Swal.fire('สำเร็จ!', 'ทำรายการสำเร็จวันที่ออกบิล <?php echo thai_date(date('Y-m-d')); ?>', 'success')
                                    $(".swal2-confirm").on("click", function (e) {
                                        window.location.replace('viwecreatebill?id='+obj.getid);
                                    });
                                }
                            }
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
				
				$('.selectpicker').selectpicker('refresh')
				
                var qty = $('#qty').val();
                var result = ["select-productmain", "select-productlist", "qty"];
                for(var x=0;x<result.length;x++){
                    if(document.forms["demo2"][result[x]].value == ''){
                        Swal.fire(
                            'ผิดผลาด!',
                            'กรอกข้อมูลให้ครบถ้วน',
                            'warning'
                        )
                        $("#"+result[x]).addClass('is-invalid');
                        $("#"+result[x]).focus();
                        return false;
                    }else{
                        $("#"+result[x]).removeClass('is-invalid');
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
                    html += '<tr id="tr-'+tbllength+'-'+obj.ProlistID+'" class="each-total">';
                    html += '    <td style="text-align: center;"> ';
                    html += '        <button type="button" class="btn btn-danger btn-sm" id="btndeleterow" value="tr-'+tbllength+'-'+obj.ProlistID+'"> <i class="fa fa-trash-o" aria-hidden="true"></i>   </button>';
                    html += '    </td>';
                    html += '    <input type="hidden" id="orderlist['+tbllength+'-'+obj.ProlistID+'][promain]" name="orderlist['+tbllength+'-'+obj.ProlistID+'][promain]" value="'+obj.PromainID+'">';
                    html += '    <input type="hidden" id="orderlist['+tbllength+'-'+obj.ProlistID+'][prolist]" name="orderlist['+tbllength+'-'+obj.ProlistID+'][prolist]" value="'+obj.ProlistID+'">';
                    html += '    <input type="hidden" id="orderlist['+tbllength+'-'+obj.ProlistID+'][proqty]" name="orderlist['+tbllength+'-'+obj.ProlistID+'][proqty]" value="'+obj.prolist_qty+'">';
                    html += '    <input type="hidden" id="orderlist['+tbllength+'-'+obj.ProlistID+'][totalprice]" name="orderlist['+tbllength+'-'+obj.ProlistID+'][totalprice]" value="'+obj.total_price+'">';
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
                    rowTotal = new Intl.NumberFormat('ja-JP').format(parseFloat(rowTotal).toFixed(2));
        
                    var totalParcelcost = parseFloat($('#total-Parcelcost').val());
                    var totalShippingcost = parseFloat($('#total-Shippingcost').val());
                    var shormoney = parseFloat($('#shor_money').val());
                    var tax = parseFloat($('#tax').val());
                    var discount = parseFloat($('#discount').val());
                    var rowTotal = $('#TBLtotalprice').val();
                    var Total_cost = (parseFloat(rowTotal) + totalParcelcost + totalShippingcost + shormoney + tax) - discount;
                    if($('#StatusComplete').val() == 5){
                        var Total = $('#TBLtotalprice').val();
                        var sum = Total*(3/100);
                        $('#tax').val(sum); 
                    }
                    
					//
                    //  for bill free price
                    if($('#StatusComplete').val() == 6){    
                        $('#total-price').text(0);
                        $('#total-cost').text(0);
                    }else{
                        $('#total-price').text(rowTotal);
                        $('#total-cost').text(Total_cost);
                    }
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
 