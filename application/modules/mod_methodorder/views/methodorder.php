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
							<h1><?php echo $namemethod; ?></h1>
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
			<?php if (chkPermissPage('adddatalist')) { ?>
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
												<!-- <select class="custom-select " name="sel_complete" id="sel_complete">
													<option disabled selected hidden> เลือกรูปแบบ </option>
													<option value=""> ทั้งหมด </option>
													<option value="1"> รอคลังรับสินค้า </option>
													<option value="2"> สำเร็จ </option>
													<option value="3"> ยกเลิก </option>

												</select> -->

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
													<th>ชื่อ</th>
													<th width="100px">วันที่</th>
													<th width="100px">โดย</th>
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
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header bg-info">
							<h6 class="modal-title mt-0">สร้าง <?php echo $namemethod ?></h6>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<div class="modal-body">
							<div class="loading col-12 text-center d-none">
								<div class="spinner-border text-info"></div>
							</div>

							<!-- form create bill -->
							<div id="form" class="">
								<form action="" id="frm" name="frm" class="">
									<div class="">
										<div id="block_add_data" class="row">
											<div class="form col-md-12 justify-content-center formcontent">
												<div class="form-group">
													<label for="">เลือก BU</label>
													<select id="modal_data_delivery" name="modal_data_delivery" class="form-control select2" style="width:100%">
														<option selected="">เลือก</option>
													</select>
												</div>

												<div class="form-group">
													<label for="">จุดขาย</label>
													<input id="modal_data_name" name="modal_data_name" type="text" class="form-control" placeholder="กรอกเพิ่มข้อมูล">
												</div>

												<div class="ele_btn text-right mt-4">
													<button id="btn_add_data" name="btn_add_data" type="button" class="btn btn-secondary mx-1 ">เพิ่มข้อมูล</button>
												</div>
											</div>
										</div>
									</div>
								</form>

							</div>

						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

		</div>
		<?php include("structer/backend/footer.php"); ?>
		<?php include("structer/backend/script.php"); ?>

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
							"data": "name"
						},
						{
							"data": "date"
						},
						{
							"data": "user"
						}
					],

				});

			}

			$(document).on('click', '#btn_add_data', function(e) {
				e.stopPropagation;
				e.stopImmediatePropagation();

				add_data();
			})

			//	add supplier
			function add_data() {
				displayLoadingAdd();

				let url = '../../api/methodorder/add/';

				data = [{
					name: "name",
					value: $('#modal_data_name').val()
				}, {
					name: "delivery_id",
					value: $('#modal_data_delivery').val()
				}];

				fetch(url, {
						headers: {
							'API-KEY': 'XOGgx6vzY2yIj7li4tS1PMrqckh8dmE5FVQRZGeL',
						},
						method: 'POST',
						body: JSON.stringify(data)
					})
					.then(res => res.json())
					.then((resp) => {
						if (resp.error_code) {
							swal.fire({
								type: 'warning',
								title: 'ข้อมูลไม่ถูกต้อง',
								text: resp.data
							}).then((result) => {
								hideLoadingAdd();
							})

							return false;
						}

						hideLoadingAdd();
						//
						//  success
						Swal.fire({
							type: 'success',
							title: 'รายการสำเร็จ',
							text: 'เพิ่มรายการสำเร็จ',
							timer: 2000,
						}).then(async (resolve) => {
							//	table refresh
							$('#btnDataRefresh').trigger('click');
							$('.modal').modal('hide');

						})

					})
					.catch(function(err) {
						console.log(`error : ${err}`)
					})
			}

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
			})

			//----------------------------function--------------------------//
			function displayLoadingAdd() {
				let loading = '<div class="spinner-border text-info"></div>';

				$('#block_add_data .ele_btn button').addClass('d-none');
				$('#block_add_data .ele_btn').append(loading);
			}

			function hideLoadingAdd() {
				$('#block_add_data .spinner-border').remove();
				$('#block_add_data .ele_btn button').removeClass('d-none');

				$('#modal_data_name').val('');
			}

			function displayLoading(elename) {
				let loading = '<div class="spinner-border text-info"></div>';

				$(elename).removeClass('d-none');

				document.frm.reset();
				$('.thumbnail-image').empty();

				$(elename).html(loading);
			}

			function hideLoading(elename) {
				$(elename).addClass('d-none');
			}

			//	cancel modal
			$('.modal-addbill').on('hide.bs.modal', function() {
				displayLoading();
				$('#selecttype ').removeClass('d-none');

				hideLoading();
			});

			// on load modal
			$('.modal-addbill').on('show.bs.modal', function() {
				async_getData();
			});

			async function async_getData(type) {
				let result1 = await new Promise((resolve, reject) => {
					return resolve(
						getData(type)
					)
				})
			}

			function getData(type) {

				let url = '../ctl_methodorder/getdata';
				fetch(url)
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

					option += '<option value="' + item.id + '" data-name="' + item.name + '" selected>' + item.name + '</option>';
				})

				$('#modal_data_delivery').html(option);
			}

		})
	</script>

</body>

</html>