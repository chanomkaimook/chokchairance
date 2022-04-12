
<!DOCTYPE html>
<html lang="en">
   	<head> 
      <?php include("structer/backend/head.php"); ?>
        <style>
            .boder-title {border-bottom: 1px dotted #333; }
            .D-flex  {display: flex;}
            .M-001   {width: 80%; padding: 0 0 0 1rem;}
            .width5  {width: 5%;}
            .width20 {width: 20%;}
            .width80 {width: 80%;}
            .width95 {width: 95%;}
            .div-bottom {border: 1px solid #333; padding: 1rem;}
            .cancel-img{
                width: 30%;
                margin: 1rem 0;
                position: absolute;
                /* transform: rotate(30deg); */
                /* z-index: 9999; */
                left: 29rem;
                top: -4rem;
            }
            .swal2-header {
                padding: 1rem;
                border-bottom: 1px solid #dee2e600;
            }
            .img-pay001 { width: 30%; }
            @media screen and (max-width: 768px){
                .D-flex  {display: block;}
                .width5  {width:100%;}
                .width20 {width: 100%;}
                .width80 {width: 100%;}
                .width95 {width: 100%;}
                .table-bordered thead th {
                    border-bottom-width: 2px;
                    font-size: 0.3rem;
                }
                .btn-app {min-width: 100%; }
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
					<div class="col-xl-6">
						<h1><?php echo $mainmenu; ?></h1>
					</div>
					<div class="col-xl-6">
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
                                            <input type="hidden" id="bill_ID" name="bill_ID" value="<?php echo $this->input->get('id'); ?>">
                                            <div class="titel text-left"> 
                                                <i class="fa fa-print" aria-hidden="true"></i> ใบออเดอร์ 
                                                    <a href="<?php echo site_url('mod_retailcreateorder/ctl_createorder/excel?id='.$Query_billdetil['ID'].'&print=1&mdl=mdl_claim'); ?>" class="btn btn-default btn-sm" style="padding: 0rem .5rem; position: absolute; right: 2rem;">
                                                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>  Excel 
                                                    </a>
                                            </div>
                                            <div class="form-row">

                                                <div class="form-group col-md-3 col-xl-6 text-left">
                                                    <b>ขออนุมัติออเดอร์เจอร์กี้จัดส่งไปรษณีย์</b> 
                                                </div>
                                                <div class="form-group col-md-9 col-xl-6 text-right">
                                                    <b>วันที่ : </b><span> <?php echo $Query_billdetil['DATE_STARTS']; ?></span>
                                                </div>
                                                <div class="form-group col-md-3 col-xl-6 text-left">
                                                    <b>ออเดอร์ที่ : </b><span> <?php echo $Query_billdetil['CODE']; ?> </span> 
                                                    <?php if($Query_billdetil['STATUSCOMPLETE'] == 4){ echo '<span style="background-color: #17a2b8; color: #FFF; padding: 0.1rem 1rem; border-radius: 5px;"> <li class="fa fa-archive"> </li> CLAIM </span>'; } ?>
                                                </div>
                                                <div class="form-group col-md-9 col-xl-4 text-right">
                                                    <b>ช่องทางการรับออเดอร์ : </b><span> <?php echo $Query_billdetil['METHODORDER_TOPIC']; ?> </span>
                                                </div>
                                                <div class="form-group col-md-9 col-xl-2 text-right">
                                                    <b>รูปแบบการจัดส่ง : </b><span> <?php echo $Query_billdetil['DELIVERYFORMID']; ?> </span>
                                                </div>
                                                 
                                                <div class="form-group col-md-3">
                                                    <div class="D-flex">
                                                        <div class="width20"><b>ชื่อ-นามสกุล : </b></div>
                                                        <div class="boder-title M-001 width80"> <?php echo $Query_billdetil['NAME']; ?> </div> 
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="D-flex">
                                                        <div class="width20"><b>Text Code : </b></div>
                                                        <div class="boder-title M-001 width80"> <?php echo $Query_billdetil['TextCode']; ?> </div> 
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="D-flex">
                                                        <div class="width20"><b>เบอร์โทรศัพท์ : </b></div>
                                                        <div class="boder-title M-001 width80"><?php echo $Query_billdetil['PHONENUMBER']; ?></div> 
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-7">
                                                    <div class="D-flex">
                                                        <div class="width5"><b>ที่อยู่ : </b></div>
                                                        <div class="boder-title M-001 width95"> <?php echo $Query_billdetil['ADDRESS']; ?> </div> 
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <div class="D-flex">
                                                        <div class="width20"><b>รหัสไปรษณีย์ : </b></div>
                                                        <div class="boder-title M-001 width95"> <?php echo $Query_billdetil['ZIPCODE']; ?> </div> 
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="D-flex">
                                                        <div class="width20"><b>เลขที่เสียภาษี/เลขที่บัตรประชาชน : </b></div>
                                                        <div class="boder-title M-001 width80"> <?php echo $Query_billdetil['TEXTNUMBER']; ?> </div> 
                                                    </div>
                                                </div>
                                                 
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <div class="D-flex">
                                                        <div class="width20"><b>ธนาคารที่โอน : </b></div>
                                                        <div class="boder-title M-001 width95"> <?php echo $Query_billdetil['BANIKNAME']; ?> </div> 
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <div class="D-flex">
                                                        <div class="width20"><b>วันที่โอนเงิน/เวลาโอนเงิน : </b></div>
                                                        <div class="boder-title M-001 width95"> <?php if($Query_billdetil['TRANSFEREDDAYTIME'] != ''){ echo $Query_billdetil['TRANSFEREDDAYTIMETHAI']; } ?> </div> 
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group col-md-4">
                                                    <div class="D-flex">
                                                        <div class="width20"><b>จำนวนเงิน : </b></div>
                                                        <div class="boder-title M-001 width95"> <?php echo $Query_billdetil['TRANSFEREDAMOUNTNumber']; ?> </div> 
                                                    </div>  
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <div class="D-flex">
                                                        <div class="width20"><b>หมายเหตุ/Remark : </b></div>
                                                        <div class="boder-title M-001 width95"> <?php echo $Query_billdetil['TRANSFEREDREMARK']; ?> </div> 
                                                    </div>                                                  
                                                </div>
                                            </div>
                                            <br>
                                            <div class="titel text-left"> 
                                                <i class="fa fa-file-text" aria-hidden="true"></i> รายการออเดอร์
                                            </div>
                                            <?php if($Query_billdetil['REMARKORDER'] != ''){ ?>
                                                <div style="padding-bottom: 0.5rem;"> <b> คำอธิบายเพิ่มเติม : </b> <?php echo $Query_billdetil['REMARKORDER']; ?> </div>
                                            <?php } ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php if($Query_billdetil['BILLSTATUS'] == 0 && $Query_billdetil['STATUSCOMPLETE'] == 3){ ?>
                                                        <div class="text-center">
                                                            <img src="<?php echo $basepic.'front/retail/icon/main-img1x.png'; ?>" class="cancel-img">
                                                        </div>
                                                    <?php } else if($Query_billdetil['BILLSTATUS'] == 1 && $Query_billdetil['STATUSCOMPLETE'] == 2){ ?>
                                                        <div class="text-center">
                                                            <img src="<?php echo $basepic.'front/retail/icon/main-img2x.png'; ?>" class="cancel-img">
                                                        </div>
                                                    <?php } ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id='table-bill'>
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 5%;text-align: center;">ลำดับ</th>
                                                                    <th style="text-align: center;">รายการออเดอร์</th>
                                                                    <th style="width: 10%;text-align: center;">ราคา/บาท</th>
                                                                    <th style="width: 10%;text-align: center;">จำนวน/หน่วย</th>
                                                                    <th style="width: 10%;text-align: center;">รวมเป็นเงิน/บาท</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="ORlist">
                                                                <?php foreach($Query_billdetil['billist'] AS $row1){ ?>
                                                                    <tr style="background-color: #d9d9d9;"> 
                                                                        <td colspan="5"> <b> <?php echo $row1['PRONAME_MAIN']; ?> </b> </td>
                                                                    </tr>
                                                                    <?php $index = 1; 
                                                                            foreach($row1['PRONAME_LIST'] AS $row2){ ?>
                                                                    <tr class="each-total">
                                                                        <td style="text-align: center;"> <?php echo $index++; ?> </td>
                                                                        <td style="text-align: left;">  <?php  echo $row2['PRONAME_LIST']; ?> </td>
                                                                        <td style="text-align: right;"> <?php  echo $row2['PRICE']; ?></td>
                                                                        <td style="text-align: right;"> <?php  echo $row2['QUANTITY']; ?></td>
                                                                        <td style="text-align: right;"> <?php  echo $row2['RBD_TOTALPRICE']; ?> </td>
                                                                    </tr>
                                                                <?php
                                                                        }
                                                                    } 
                                                                ?>
                                                            </tbody>
                                                            <tbody id="total">
                                                                 
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>รวมยอดขายสุทธิ</b> </td>
                                                                    <td class="text-right" style="padding: .2rem;" id='total-price'><?php echo $Query_billdetil['TOTALPRICE']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ค่ากล่องพัสดุ</b> </td>
                                                                    <td class="text-right" style="padding: .2rem;"><?php echo $Query_billdetil['PARCELCOST']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ค่าบริการจัดส่ง</b> </td>
                                                                    <td class="text-right" style="padding: .2rem;"><?php echo $Query_billdetil['DELIVERYFEE']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ค่าธรรมเนียม shopee</b> </td>
                                                                    <td class="text-right" style="padding: .2rem;"><?php echo $Query_billdetil['SHORMONEY']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ส่วนลด</b> </td>
                                                                    <td class="text-right" style="padding: .2rem;"><?php echo $Query_billdetil['DISCOUNTPRICE']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right" style="padding: .2rem 1rem;" colspan="4"> <b>ค่าธรรมเนียมเก็บเงินปลายทาง</b> </td>
                                                                    <td class="text-right" style="padding: .2rem;"><?php echo $Query_billdetil['TAX']; ?></td>
                                                                </tr>
                                                                <tr style="background-color: #d9d9d9;">
                                                                    <td class="text-center" style="padding: .2rem 1rem;" colspan="4"> <b>ยอดชำระรวมค่าจัดส่ง</b> </td>
                                                                    <td class="text-right" style="padding: .2rem;" id='total-cost'><?php echo $Query_billdetil['NETTOTAL']; ?></td>
                                                                </tr>
                                                                 
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($Query_billdetil['STATUSCOMPLETE'] == 4){ ?>
                                                <div class="titel text-left" style="margin-bottom: 0px;"> 
                                                    <i class="fa fa-archive" aria-hidden="true"></i> หมายเหตุการเคลม
                                                </div>
                                                <div class="row">
                                                   
                                                    <div class="col-md-12">
                                                        <div class="div-bottom">
                                                            <div class="row">
                                                                <div class="col-md-12 col-xl-12 text-center">
                                                                    <h4> <?php echo 'หมายเหตุ : '.$Query_billdetil['REMARK']; ?> </h4>
                                                                    <div class="text-left">
                                                                        <?php 
                                                                            if($Query_billdetil['REMARKCLAIM'] != ''){
                                                                                echo '<hr><b> อธิบายข้อผิดผลาด </b><br>'.$Query_billdetil['REMARKCLAIM'];
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            <?php } ?>
                                                 
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
													<?php
														$billclaim = chkPermissPage('btn_approveclaim');
														if($billclaim == 1):
													?>
                                                    <button type="button" id="btn_approve" value="1" class="btn btn-app bg-warning"> <i class="fa fa-archive"></i> ยืนยันตรวจสอบการเคลม </button>
													<?php
														endif;
													?>
												    <a href="<?php echo site_url('mod_retailcreateorder/ctl_claim/claim'); ?>" class="btn btn-app"> <i class="fa fa-home"></i> กลับหน้าหลัก </a>
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
            <script src="<?php echo $base_bn;?>plugins/sweetalert2/sweetalert2.min.js"></script>
        </div>
        <script>
            $(function () {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                // การอนุมัติ //
                $(document).on('click', '#btn_approve', function(event) {
                    var bill_ID = $('#bill_ID').val();
                    var bnt_val = this.value
                    $.post("statusapprove", { id: bill_ID, val: bnt_val }, function(result){
                        var obj = jQuery.parseJSON(result);
                        if(obj.error_code == 0){
                            Swal.fire('Success!', obj.txt, 'success')
                            $(".swal2-confirm").on("click", function (e) {
                                window.location.replace('claim');
                            });
                        }
                    });
                }); 
  
            });
        </script>
	</body>
</html>
 