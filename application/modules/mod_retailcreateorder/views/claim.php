<!DOCTYPE html>
<html lang="en">
   	<head> 
        <?php include("structer/backend/head.php"); ?>
        <style>
            .modal-lg, .modal-xl {
                max-width: 1080px;
            }
            .bnt-CA001 {
                text-align: right;
                 border-radius: 5px;
             }
            .list-CA001, .status-CA001{
                padding: 0.5rem;
            }
            
            .btn-app3 {
                border-radius: 3px;
                background-color: #f8f9fa;
                border: 1px solid #ddd;
                color: #6c757d;
                font-size: 12px;
                 min-width: 80px;
                position: relative;
                text-align: center;
            }
            .mb-1, .my-1 {
                margin-bottom: 1rem!important;
            }
            .btn-defaultnl {
                /* background-color: #f8f9fa; */
                border-color: #ddd0;
                /* color: #444; */
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
            .divstatus-claim {
                padding: 0.2rem;
                background-color: #FF9800;
                border-radius: 5px;
                color: #FFF;
                width: 50%;
                text-align: center;
                margin: 0.5rem 0 0;
                font-weight: 100;
            }
            .st-claim-4{
                background-color: #FFE0B2;
                padding: 0.5rem;
                border-radius: 5px;
            }
            @media screen and (max-width: 991px){
                .divstatus-claim {  width: 100%; }
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
						<h1><?php echo $mainmenu; ?></h1>
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
							<!-- Custom tabs (Charts with tabs)-->
							<div class="card">
								<div class="card-header">
									<h3 class="card-title"> <i class="fa fa-bars" aria-hidden="true"></i> <?php echo "Manage ".$mainmenu; ?> </h3>
 								</div> 
								<div class="card-body">
                                    <div class="row" style="background-color: rgba(140, 175, 255, 0.15); padding: 20px; margin: 1px;border: 1px solid #87aaff; ">
                                        
                                        <div class="col-sm-6">

                                            <label class=""> เลือกวันที่ออกบิล (ระหว่างวันที่) </label>
                                            <div class="input-group ">
                                                <input type="date" class=" form-control form-control-sm" id="valdate">
                                                <input type="date" class=" form-control form-control-sm" id="valdateTo">
                                            </div>
                                            
                                        </div>

                                        <div class="col-sm-6">

                                            <label class=""> เลือกรูปแบบการจัดส่ง </label>
                                            <div class="input-group input-group-sm">
                                                <select class="custom-select " name="deliveryid" id="deliveryid">
                                                    <option value=""> เลือกรูปแบบการจัดส่ง </option>
                                                    <option value="1"> KERRY </option>
                                                    <option value="2"> EMS </option>
                                                    <option value="3"> FLASH </option>
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

                // ======================= //
                $('#cremark2').hide();
                $(document).on('click', '#customRadio1', function(event) {
                    $('#cremark2').hide();
                });
                $(document).on('click', '#customRadio2', function(event) {
                    $('#cremark2').show();
                });
                // ======================= //

                claimorderlist();
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
                
                //----------------------------filter--------------------------//
                $(document).on('click', '#bntvaldate', function(event) {
                    var valdate = $('#valdate').val();
                    var valdateTo = $('#valdateTo').val();
                    var deliveryid = $('#deliveryid').val();
                    $('#ex1').DataTable().destroy();
                    claimorderlist(valdate, valdateTo, deliveryid);
                }); 
                 
                $(document).on('click', '#refresh_page', function(event) {
                    $('#ex1').DataTable().destroy();
                    claimorderlist();  
                }); 
   
                function claimorderlist(valdate, valdateTo, deliveryid) {
                    var dataTable = $('#ex1').DataTable({  
                        "processing":true,  
                        "serverSide":true,  
                        "order":[],  
                        "ajax":{  
                                url:"<?php echo base_url() . 'mod_retailcreateorder/ctl_claim/fetch_claimorderlist'; ?>",  
                                type:"POST",
                                data:{
                                    valdate:valdate, valdateTo:valdateTo, deliveryid: deliveryid
                                } 
                        },  
                        "columnDefs":[  
                                {  
                                    "targets":0,  
                                    "orderable":false,  
                                },  
                        ],  
                    });  
                }
            })
        </script>
	</body>
</html>
 