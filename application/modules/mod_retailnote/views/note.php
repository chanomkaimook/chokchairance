<!DOCTYPE html>
<html lang="en">

<head>
	<?php include("structer/backend/head.php"); ?>
	<link rel="stylesheet" href="<?php echo $base_bn; ?>frontend/bootstrap-select/css/bootstrap-select.css">
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
							<h1><?php echo "Note"; ?></h1>
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

			<style>
				#addbill {
					position: fixed;
					bottom: 30px;
					right: 0px;
					z-index: 999;
				}

				#addbill {
					cursor: pointer;
					transition: transform 0.2s;
					transform: scale(0.8, 0.8);
				}

				#addbill .btnplus {
					transition: transform 0.2s;
				}

				#addbill:hover {
					transform: scale(1, 1);
				}

				.btnplus:hover {
					background-color: #3bc8df !important;
					color: blue;
					transform: rotate(360deg);
				}

				#addbill h1 {
					padding: 0px;
					margin: 0px;
				}
			</style>
			<?php if (chkPermissPage('addnote')) { ?>
				<div id="addbill" class="m-4">
					<div class="btnplus img-circle bg-info p-4" data-toggle="modal" data-target=".modal-addbill">
						<!-- <h1><i class="fas fa-plus"></i></h1> -->
						<span class="lead">เพิ่ม</span>
					</div>
				</div>
			<?php } ?>
			<section class="content">

				<div class="container-fluid">
					<div class="row">

						<section class="col-lg-12 connectedSortable">
							<!-- Custom tabs (Charts with tabs)-->
							<div class="card">
								<div class="card-header">
									<h3 class="card-title"> <i class="fa fa-bars" aria-hidden="true"></i> <?php echo "Manage " . $mainmenu; ?> </h3>
								</div>
								<div class="card-body">
									<div class="row justify-content-center" style="background-color: rgba(140, 175, 255, 0.15); padding: 20px; margin: 1px;border: 1px solid #87aaff; ">
										<div class="col-6">

											<label class=""> เลือกวันที่ - วันที่ </label>
											<div class="input-group ">
												<input type="date" class=" form-control form-control-sm" id="valdate">
												<input type="date" class=" form-control form-control-sm" id="valdateTo">
											</div>

										</div>

										<div class="col-6">
											<label class=""> เลือกรูปแบบ </label>
											<div class="input-group input-group-sm">
												<select class="custom-select " name="sel_complete" id="sel_complete">
													<option disabled selected hidden> เลือกรูปแบบ </option>
													<option value=""> ทั้งหมด </option>
													<option value="0"> รอ </option>
													<option value="2"> สำเร็จ </option>
													<option value="3"> ยกเลิก </option>

												</select>

												<div class="input-group-append">
													<button type="button" class="btn btn-default btn-sm" id="btnSearch"><i class="fas fa-search text-muted"></i> ค้นหา </button>
													<button type="button" class="btn btn-default btn-sm" id="btnDataRefresh"><i class="fas fa-refresh text-muted"></i> อัพเดต </button>
												</div>
											</div>
										</div>


									</div>

									<div class="table-responsive mt-2">
										<table id="ex1" class="table table-bordered table-hover ">
											<thead class="thead-dark">
												<tr>
													<th width="35px">#</th>
													<th>เลขที่รายการ</th>
													<th>รายการ</th>
													<th>หมายเหตุ</th>
													<th width="100px">วันที่</th>
													<th width="100px">โดย</th>
													<th width="20px">สถานะ</th>
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

			<style>
				span[role="button"] {
					cursor: pointer;
				}

				span[role="button"] p:hover {
					color: #007bff;
					/*	color primary */
				}

				form label {
					color: #888;
				}
			</style>
			<!--	Modal	-->
			<div class="modal modal-addbill fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static">
				<div class="modal-dialog modal-dialog-centered modal-xl">
					<div class="modal-content">
						<div class="modal-header bg-info">
							<h6 class="modal-title mt-0">สร้าง Note</h6>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<div class="modal-body">
							<div class="loading col-12 text-center d-none">
								<div class="spinner-border text-info"></div>
							</div>

							<!-- form create bill -->
							<div id="form" class="">
								<form action="" id="frm" name="frm" class="">
									<div class="col-md-12">
										<span class="text-info">เป็นเอกสารสร้างเพื่อแจ้งเตือน</span>
									</div>

									<div class="col-md-12 col-lg-12">
										<div class="p-2 bg-dark mt-2">
											
											<label for="" class="text-white">รายการสินค้า</span></label>
											<button type="button" class="btn btn-default btn-sm modal-bill float-right" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่ม </button>
										</div>
										<div class="table-responsive">
											<table class="bill_sup_product w-100">
												<thead>
													<tr>
														<th width="40px"> </th>
														<th width="40px">ลำดับ</th>
														<th class="text-center">สินค้า</th>
														<th width="60px">จำนวน</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
									</div>

									<div class="my-4  row">
										<div class="form-group col-sm-12">
											<label for="remark">หมายเหตุ</label>
											<textarea id="remark" name="remark" class="form-control" rows="2"></textarea>
										</div>
									</div>

									<?php if (chkPermissPage('addnote')) { ?>
										<div class="row row-form-tool-btn">
											<div class="col-sm-12 text-center form-tool-btn">
												<button type="button" id="submitform" class="btn btn-md w-25 btn-outline-primary">บันทึก</button>
												<button type="button" class="btn btn-md btn-danger" data-dismiss="modal" aria-hidden="true">ยกเลิก</button>
											</div>
										</div>
									<?php } ?>
								</form>

							</div>

						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<!-- modal Product -->
            <div class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index:10000">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="titel text-left"> <i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="">เลือกเมนูหลัก</label>
                                <select id="select-productmain" name="select-productmain" class="selectpicker" data-live-search="true">
                                    <option value=""> -- โปรดเลือกเมนูหลัก -- </option>
                                    <?php
                                    $sql = $this->db->select('*')
                                        ->from('retail_productmain')
                                        ->where('status', 1)
                                        ->get();
                                    foreach ($sql->result() as $row) {
                                        echo '<option value="' . $row->ID . '"> ' . $row->NAME_TH . ' </option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="SLproductlist">
                                <label class="">เลือกรายการเมนู</label>
                                <select id="select-productlist" name="select-productlist" class="selectpicker selectpicker_1" data-live-search="true" disabled>

                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="">จำนวน</label>
                                <input type="number" class="form-control " name="productqty" id="productqty" placeholder="จำนวน">
                            </div>
                            <div class="form-group col-md-6 text-center p-auto m-auto">
                                <button type="button" class="btn btn-lg btn-info w-100" id="add-order"> <i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="htmlvalidate"></div>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle-o" aria-hidden="true"></i> ปิด</button>
                        </div>
                    </div>
                </div>
            </div>

		</div>
		<?php include("structer/backend/footer.php"); ?>
		<?php include("structer/backend/script.php"); ?>
		<script src="<?php echo $base_bn; ?>frontend/bootstrap-select/js/bootstrap-select.js"></script>	
		<script src="<?php echo $base_bn; ?>plugins/sweetalert2/sweetalert2.min.js"></script>

	</div>

	<?php require_once('script_formbill.php'); ?>

	<script>
		const queryString = decodeURIComponent(window.location.search);
		const params = new URLSearchParams(queryString);
		let getDate = params.get("date");

		// $("#selectsupplier").selectpicker('refresh');

		$(function() {

			//	setting
			let frm = $('form#frm');

			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000
			});

			//	run data table
			createDataTable();

			function createDataTable() {
				let url = 'getDataBill';

				var datatable = $('#ex1').DataTable({
					"processing": true,
					"serverSide": true,
					'order': [
						// [4 , 'asc'],
						// [1 , 'desc']
					],

					'ajax': {
						url: url,
						type: 'get',
						data: function(d) {
							d.valdate = $('#valdate').val();
							d.valdateTo = $('#valdateTo').val();
							d.sel_complete = $('#sel_complete').val() !== null ? $('#sel_complete').val() : null;
						},
						error: function(xhr, error, code) {
							//  xhr return array status async
							if (xhr.status != 200) {
								alert('พบข้อผิดพลาด กรุณาแจ้งเจ้าหน้าที่');
							}
						}
					},
					"columns": [{
							"data": "id"
						},
						{
							"data": "code"
						},
						{
							"data": "name"
						},
						{
							"data": "remark"
						},
						{
							"data": "date"
						},
						{
							"data": "user"
						},
						{
							"data": "status"
						}
					],

				});

			}

			//  ========= Begin add product   ========
            $(document).on("click", ".modal-bill", function() {
                $('#productqty').val('');
                var html2 = '';
                $("#select-productmain").selectpicker('refresh');
                $("#select-productlist").html(html2).selectpicker('refresh');
            });

            $('.bd-example-modal-lg').on('shown.bs.modal', function() {
                // $("#select-productmain").eq(0).prop('checked');
                $("#select-productmain").val("");
                $(".modal-footer .htmlvalidate").html('');
                $('.selectpicker').selectpicker('refresh')
            });

            $('#select-productlist').change(function() {
                $('#productqty').val('');
            });
            $('#select-productmain').change(function() {
                var option = $(this).find('option:selected'),
                id = option.val();
                name = option.data('name');
                $("#select-productlist").empty();
                $("#select-productlist").removeAttr('disabled')
                ajaxprolist(id);
            });

            function ajaxprolist(id) {
                $.ajax({
                    url: "ajaxselectproductmain",
                    type: 'POST',
                    data: {
                        action: 'my_special_ajax_call',
                        val: id
                    },
                    success: function(results) {
                        var obj = jQuery.parseJSON(results);
                        var html = '';
                        html += ' <option value="">โปรดเลือกรายการเมนู</option>';
                        $.each(obj, function(index, value) {
                            html += ' <option value="' + value.ID + '">' + value.NAME_TH + '</option>';
                        });
                        $("#select-productlist").html(html).selectpicker('refresh');
                    }
                });
            }

            $(document).on("click", "#add-order", function() {
                if ($('.modal_add_bill').is(':visible')) {
                    var frmmodal = $('#frmnew');
                } else {
                    var frmmodal = $('#frmstore');
                }

                var productmainID = $('#select-productmain').val();
                var productlistID = $('#select-productlist').val();

                $('.selectpicker').selectpicker('refresh')

                var qty = $('#productqty').val();
                var result = [{
                    "html": "#select-productmain",
                    "th": "เมนูหลัก"
                }, {
                    "html": "#select-productlist",
                    "th": "รายการเมนู"
                }, {
                    "html": "#productqty",
                    "th": "จำนวน"
                }];


                async function runcheck() {
					let trow = $('table.bill_sup_product tbody tr').length;
					
					let result1 = await checkValidateProductList(result);

					if (result1.error_code == 0) {
						let datasetting = {
							plist_id: $('#select-productlist').val(),
							pqty: $('#productqty').val(),
							form: frmmodal
						}

						createListProduct(datasetting);
					} else {
						$('.modal-footer .htmlvalidate').html('<span class="text-validate text-danger float-left"> โปรดระบุ ' + result1.txt + '</span>');
					}
					
                }
                runcheck();
            });

            function checkValidateProductList(result) {
                // let param;
                let error = 0;
                let cal = "unknow";

                $.each(result, function(key, value) {
                    param = $(value.html).val();

                    if (!param) {
                        error = 1;
                        cal = value.th;
                        return false;
                    }
                });

                return new Promise((resolve, reject) => {
                    resolve({
                        error_code: error,
                        txt: cal
                    })
                })
            }

            function createListProduct(dataarray) {
                // console.log(dataarray);
                var data = new FormData();

                data.append("billid", "");
                data.append("pid", dataarray.plist_id);
                data.append("pqty", dataarray.pqty);

                fetch('get_product', {
                        method: 'POST',
                        body: data
                    })
                    .then(res => res.json())
                    .then((resp) => {
                        if(!resp){
                            $('.modal-footer .htmlvalidate').html('<span class="text-validate text-danger float-left"> มีข้อมูลอยู่แล้ว </span>');
                        }else{
                            let totalprice = resp.qty * resp.price;

                            let billdetail = [{
                                list: resp.list,
                                product_name: resp.name_th,
                                product_price: resp.price,
                                product_qty: resp.qty,
                                product_totalprice: formatMoney(totalprice),
                                prolist: resp.id,
                                promain: resp.main,
                                product_rowid: resp.id
                            }]
                            formDataDetailAppend(billdetail);

                            //  close modal
                            $('.bd-example-modal-lg').modal('hide');
                        }
                        
                    })
                    .catch(function(err) {
                        console.log(`error : ${err}`);
                    })

            }
            function formDataDetailAppend(billdetail) {
                let hmtl = "";

                // console.log(billdetail);
                let number = $('.bill_sup_product tbody tr').length;
                if (billdetail.length) {

                    billdetail.forEach(function(key, val) {
                        let index = number + 1;
                        let product_name = key.product_name;
                        let product_price = formatMoney(key.product_price);
                        let product_qty = key.product_qty;
                        let product_totalprice = key.product_totalprice;
                        let promain = key.promain;
                        let prolist = key.prolist;
                        let list = key.list;

                        let iddetail = key.product_rowid;

                        let button_del = '<button type="button" class="btn btn-sm btn-danger btn-del"><i class="fa fa-close"></i></button>';
                        let input_qty = '<input type="text" value="' + product_qty + '" class="w-100 input-qty" data-id="' + iddetail + '" data-promain="' + promain + '" data-prolist="' + prolist + '" data-list="' + list + '" data-price="' + product_price + '" OnKeyPress="return checkNumber(this)">';

                        hmtl += '<tr data-row="' + index + '">';
                        hmtl += '<td class="">'+ button_del +'</td>';
                        hmtl += '<td class="index">' + index + '</td>';
                        hmtl += '<td class="name">' + product_name + '</td>';
                        hmtl += '<td class="qty">' + input_qty + '</td>';
                        hmtl += '</tr>';
                    })

                    frm.find('.bill_sup_product tbody').append(hmtl);
                }
            }
            //  ========= End add product   ========

			$(document).on('click', '#btnSearch', function(e) {
				e.stopPropagation;
				e.stopImmediatePropagation();

				$('#ex1').DataTable().search('').draw();
				$('#ex1').DataTable().ajax.reload();
			})

			$(document).on('click', '#btnDataRefresh', function(e) {
				e.stopPropagation;
				e.stopImmediatePropagation();

				$('#ex1').DataTable().ajax.reload(null, false);

				get_countMenu();
			})

			//----------------------------function--------------------------//
			function displayLoading(elename) {
				let loading = '<div class="spinner-border text-info"></div>';

				$(elename).removeClass('d-none');

				document.frm.reset();
				$('.thumbnail-image').empty();

				$('#billto').attr('disabled','disabled');

				$(elename).html(loading);
			}

			function hideLoading(elename) {
				$('table.bill_sup_product tbody').empty();
			}

			//	cancel modal
			$('.modal-addbill').on('hide.bs.modal', function() {
				displayLoading();

				hideLoading();
			});

		})
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
	</script>
</body>

</html>