	<?php
	ini_set('max_execution_time', 0);
	ini_set('memory_limit', "100M");

	use Phppot\DataSource;
	use PhpOffice\PhpSpreadsheet\Reader\Xls;
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

	require_once 'DataSource.php';

	$db = new DataSource();
	$conn = $db->getConnection();
	require_once('./vendor/autoload.php');

	#
	#	setting
	#	**	table
	($importvalue ? $selected = 'selected' : $selected = "");

	$select = "<select id='seltable' name='seltable' class='form-control' >";
	$select .= "<option value='bu2' " . ($importvalue == 'bu2' ? 'selected' : "") . " >BU2</option>";
	$select .= "</select>";
	$tablemain = $select;
	#
	#
	$parse = parse_url(site_url());
	$documentroot =  $_SERVER['DOCUMENT_ROOT'] . "/" . $parse['path'];

	if (isset($_POST["import"])) {

		$allowedFileType = [
			'application/vnd.ms-excel',
			'text/xls',
			'text/xlsx',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		];

		if (in_array($_FILES["file"]["type"], $allowedFileType)) {

			$targetPath = $documentroot . '/asset/upload/' . $_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

			$Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

			//	for file *.xls
			if ($_FILES["file"]["type"] == 'application/vnd.ms-excel') {
				$Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			}

			$spreadSheet = $Reader->load($targetPath);
			$excelSheet = $spreadSheet->getActiveSheet();
			$spreadSheetAry = $excelSheet->toArray();
			$sheetCount = count($spreadSheetAry);
			// echo $sheetCount." : count<br>";

			//	if i = 0 is a column table
			//=	 call database	=//
			$ci = &get_instance();
			$ci->load->database();
			//===================//

			$x = 0;
			$array = array();
			$array_complete = array();
			$array_error = array();
			$endpoint = "";					//	จุดที่มาร์คให้ระบบรู้ว่าจบการเก็บข้อมูลที่บรรทัดไหน	

			//	setting
			$array['bill'] = array();		//	ชื่อ bill

			//	เพื่อตรวจสอบว่าข้อมูลนี้คือชุดแถวข้อมูลเริ่มต้นของบิล หรือไม่ เพื่อจะต่อข้อมูลบิลไปเรื่อยๆกับชุดข้อมูลถัดไป
			$identify = "";

			for ($i = 0; $i < $sheetCount; $i++) {

				$start_bill = "";
				$result_group[$i] = 1;	//	if result = 0 not find data

				if (is_numeric(array_search('รวมวันที่', $spreadSheetAry[$i]))) {
					$endpoint = $i;
				}
				/* echo $i." = ".is_numeric(array_search('รวมเครื่องที่', $spreadSheetAry[$i]))." - ".$endpoint."<br>";
if(!is_numeric(array_search('รวมเครื่องที่', $spreadSheetAry[$i]))){
echo "boot<br>";
}else{
	echo "not running<br>";
} */
				//	เช็คว่าเป็นบรรทัดสรูปยอดหรือไม่ หากใช่ ให้ข้ามไป
				if (!is_numeric(array_search('รวมเครื่องที่', $spreadSheetAry[$i])) && $endpoint == "") {

					foreach ($spreadSheetAry[$i] as $key => $value) {

						$datainsert[$spreadSheetAry[$i][$key]] = get_valueNullToNull($value);

						//	ชื่อ booth
						if ($i == 2 && $key == 4) {
							$booth_name = trim($datainsert[$spreadSheetAry[$i][$key]]);

							//	select id booth
							$sql = $this->db->select('ID')
								->from('retail_methodorder')
								->where('topic', $booth_name);
							$q = $sql->get();
							$num = $q->num_rows();
							if ($num) {
								$row = $q->row();
								$booth_id = $row->ID;
							} else {
								$err_i = $i+1;
								$err_key = $key+1;

								$result_group[$i] = 0;
								$array_error[$i][$key] = 'ไม่พบชื่อบูธ value = '.$booth_name.' [row=' . $err_i . '][col=' . $err_key . ']';
							}
						}

						//	เนื้อหาที่ต้องใช้ (ข้ามส่วนหัวเอกสาร)
						if ($i > 6) {

							//	หาวันที่
							if ($key == 0 && $value) {
								$array['bill']['date'] = $datainsert[$spreadSheetAry[$i][$key]];
								$start_bill = 1;

								//	สำหรับเรียงลำดับสินค้าภายในบิล
								$item_no = 0;
								$array_item = array();			//	reset รายการสินค้าในบิล
								$array['bill']['net'] = 0;		//	reset ราคารวม
							}

							if ($start_bill) {

								//	หาเลขเครื่อง POS
								if ($key == 1 && $value) {
									$array['bill']['pos_id'] = $datainsert[$spreadSheetAry[$i][$key]];
								}

								//	หาเลขที่ใบเสร็จ
								if ($key == 2 && $value) {
									$array['bill']['code'] = $datainsert[$spreadSheetAry[$i][$key]];

									//	คีย์ array สำหรับสร้างบิล
									$identify = $datainsert[$spreadSheetAry[$i][$key]];

									//	check error
									$sqlcheck = $this->db->select('ID')
										->from('retail_bill')
										->where('code', $identify);
									$qcheck = $sqlcheck->get();
									$numcheck = $qcheck->num_rows();
									if ($numcheck) {
										$err_i = $i+1;
										$err_key = $key+1;

										$result_group[$i] = 0;
										$array_error[$i][$key] = 'มีรายการบิลซ้ำในระบบ value = '.$identify.' [row=' . $err_i . '][col=' . $err_key . ']';
									}
								}

								//	หายอดก่อน vat
								if ($key == 7 && $value) {
									$array['bill']['price'] = sprintf('%0.2f', preg_replace("/([^0-9\\.])/i", "", $datainsert[$spreadSheetAry[$i][$key]]));
								}

								//	หายอด vat
								if ($key == 9 && $value) {
									$array['bill']['vat'] = sprintf('%0.2f', preg_replace("/([^0-9\\.])/i", "", $datainsert[$spreadSheetAry[$i][$key]]));
								}
							} else {		//	รายการสินค้าต่อมาของบิลนั้น ( $key[0] จะไม่มีค่า )

								//	หารหัสสินค้า
								if ($key == 1 && $value) {
									$array_item[$item_no]['code'] = $datainsert[$spreadSheetAry[$i][$key]];

									//	check error
									$sqlcheck = $this->db->select('ID')
										->from('retail_productlist')
										->where('code', $array_item[$item_no]['code']);
									$qcheck = $sqlcheck->get();
									$numcheck = $qcheck->num_rows();
									if (!$numcheck) {
										$err_i = $i+1;
										$err_key = $key+1;
										
										$result_group[$i] = 0;
										$array_error[$i][$key] = 'ไม่พบรหัสสินค้า value = '.$array_item[$item_no]['code'].' [row=' . $err_i . '][col=' . $err_key . ']';
									}
								}

								//	หาชื่อสินค้า
								if ($key == 5 && $value) {
									$array_item[$item_no]['name'] = $datainsert[$spreadSheetAry[$i][$key]];
								}

								//	หาหน่วยสินค้า
								if ($key == 8 && $value) {
									$array_item[$item_no]['unit'] = $datainsert[$spreadSheetAry[$i][$key]];
								}

								//	หาหน่วยสินค้า
								if ($key == 10 && $value) {
									$array_item[$item_no]['total'] = $datainsert[$spreadSheetAry[$i][$key]];
								}

								//	หาราคาสินค้า
								if ($key == 11 && $value) {
									$array_item[$item_no]['price'] = sprintf('%0.2f', preg_replace("/([^0-9\\.])/i", "", $datainsert[$spreadSheetAry[$i][$key]]));

									//	หายอด ราคารวมทั้งหมด
									$array['bill']['net'] += $array_item[$item_no]['price'];
								}
							}
						}
					}	//	end foreach วนลูปคอลัมด้านใน


					if ($identify && $result_group[$i] == 1) {

						$array['bill']['booth_id'] = $booth_id;
						$array['bill']['booth_name'] = $booth_name;
						$array_complete[$identify] = $array;
					}

					if ($array_item && $result_group[$i] == 1) {
						$item_no++;	//	เริ่มเรียงลำดับรายการสินค้าเมื่อระบบมีการกำหนดเลข bill แล้ว (identify)

						$array_complete[$identify]['bill']['net'] = sprintf('%0.2f', $array['bill']['net']);
						$array_complete[$identify]['bill_item'] = $array_item;
					}
				}	//	end for วนลูปชูดแถวข้อมูล

				$x++;
			}

			/* echo "<pre>";
			// print_r($group);
			print_r($array_complete); 
			echo "====<br>";
			print_r($spreadSheetAry);
			echo "===================";

			echo "</pre>";
			exit; */

			//	running program
			if (count($array_error) < 1) {
				// echo "running";
				// $create_bill = $ci->mdl_excel->create_bill($array_complete);
				$create_bill = $ci->mdl_excel->create_bill($array_complete);
				$total_table = $create_bill['total'];
			}
		} else {
			$type = "error";
			$message = "Invalid File Type. Upload Excel File.";
		}
	}

	?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<?php include("structer/backend/head.php"); ?>
		<style>
			.outer-container {
				background: #F0F0F0;
				border: #e0dfdf 1px solid;
				padding: 40px 20px;
				border-radius: 2px;
			}

			.btn-submit {
				background: #333;
				border: #1d1d1d 1px solid;
				border-radius: 2px;
				color: #f0f0f0;
				cursor: pointer;
				padding: 5px 20px;
				font-size: 0.9em;
			}

			.tutorial-table {
				margin-top: 40px;
				font-size: 0.8em;
				border-collapse: collapse;
				width: 100%;
			}

			.tutorial-table th {
				background: #f0f0f0;
				border-bottom: 1px solid #dddddd;
				padding: 8px;
				text-align: left;
			}

			.tutorial-table td {
				background: #FFF;
				border-bottom: 1px solid #dddddd;
				padding: 8px;
				text-align: left;
			}

			#response {
				padding: 10px;
				margin-top: 10px;
				border-radius: 2px;
				display: none;
			}

			.success {
				background: #c7efd9;
				border: #bbe2cd 1px solid;
			}

			.error {
				background: #fbcfcf;
				border: #f3c6c7 1px solid;
			}

			div#response.display-block {
				display: block;
			}
		</style>
	</head>

	<body class="hold-transition sidebar-mini layout-fixed">
		<input type="hidden" id="query" name="query" value="<?php echo $processquery; ?>">
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
								<h1>รายงาน</h1>
							</div>
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item"><a href="<?php echo site_url('mod_admin') ?>/ctl_login/backend_main">Home</a></li>
									<li class="breadcrumb-item active"><?php echo $submenu; ?></li>
								</ol>
							</div>
						</div>
					</div><!-- /.container-fluid -->
				</section>
				<form id="frmupdate" name="frmupdate" method="post" action="<?php echo site_url('mod_staff/ctl_staff/staff_update'); ?>">
					<input id="staffid" name="staffid" value="" type="hidden">
					<input id="staffname" name="staffname" value="" type="hidden">
				</form>
				<section class="content">
					<div class="container-fluid">
						<div class="row">

							<section class="col-lg-12 connectedSortable">
								<!-- Custom tabs (Charts with tabs)-->
								<div class="card">
									<div class="card-header">
										<h3 class="card-title"> <i class="fa fa-bars" aria-hidden="true"></i> รายงานจากเครื่อง POS (BU2) </h3>
									</div>
									<div class="card-body">

										<div class="row">
											<div class="col-sm-12">
												<div class="card-body">


													<div class="row">
														<div class="form-group col-sm-6 col-xs-12">
															<label for="bu">เลือก BU</label>
															<div class="">
																<?php
																echo $tablemain;
																?>
															</div>
														</div>
														<div class="form-group col-sm-6 col-xs-12">
															<label for="upload">อัพโหลดไฟล์ excel</label>
															<div class="">
																<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
																	<input id="import" name="import" type="hidden" value="<?php echo $importvalue; ?>">
																	<div>
																		<label>Choose Excel File</label> <input type="file" name="file" id="file" accept=".xls,.xlsx">

																		<button id="btnsubmit" name="btnsubmit" type="button" class="btn-submit">Import</button>
																	</div>

																</form>
															</div>
														</div>
													</div>
												</div>

												<div class=" mt-4">
													<ul class="nav nav-tabs">
														<li class="nav-item">
															<a href="#result" data-toggle="tab" aria-expanded="false" class="nav-link show">
																<span class="d-block d-sm-none"><i class="fa fa-file-text"></i></span>
																<span class="d-none d-sm-block">ผลลัพธ์</span>
															</a>
														</li>
														<li class="nav-item">
															<a href="#dataupdate" data-toggle="tab" aria-expanded="true" class="nav-link">
																<span class="d-block d-sm-none"><i class="fa fa-bar-chart"></i></span>
																<span class="d-none d-sm-block">ข้อมูลวันนี้</span>
															</a>
														</li>
													</ul>
												</div>
												<div class="tab-content">

													<div id="result" class="tab-pane fade in active show">
														<div id="response" class="display-block"></div>
														<?php
														$resultrow = "";
														if ($_POST['import']) {
															$resultrow = "จำนวนบิลทั้งหมด " . $countgroup . "<br>";
															$resultrow .= "<span class='text-info'> จำนวนบิลที่พร้อมเข้าระบบ " . count($array_complete) . " </span><br><hr>";
															if (count($array_error)) {
																$i=1;
																foreach ($array_error as $key => $row) {
																	foreach ($row as $keyin => $valin) {
																		$resultrow .= "<span class='text-danger'>error No. " . $i . "  = " . $valin . "</span><br>";
																		$i++;
																	}
																}
															} else {
																$resultrow .= "<span class='text-success'> จำนวนบิลที่เข้าระบบไปแล้ว " . $total_table . " </span>";
															}
														}

														?>
														<div class="col-sm-12">
															<div class="card-body">
																<?php echo $resultrow; ?>
																<div class="dataimport mt-2"></div>
															</div>
														</div>
													</div>

													<?php
													require_once('form_dump.php');
													?>

												</div>

											</div>
										</div>
										<hr>
									</div>

								</div>
							</section>

						</div>
					</div>
				</section>

			</div>
			<?php include("structer/backend/footer.php"); ?>
			<?php include("structer/backend/script.php"); ?>
			<!-- SweetAlert2 -->
			<script src="<?php echo $base_bn; ?>plugins/sweetalert2/sweetalert2.min.js"></script>
		</div>
		<script>
			$(function() {
				if (window.history.replaceState) {
					window.history.replaceState(null, null, window.location.href);
				}

				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000
				});

				/*
				#	submit upload 
				#	select program for set score
				*/
				$(document).on('click', '#btnsubmit', function(event) {
					if ($('input#import').val() == '') {
						alert('select table');
						return false;
					}
					var d = document;

					var chkdiv = $('div').find('#response');
					if (chkdiv.length > 0) {
						$('#response').removeClass();
						$('#response').fadeIn();
						var div = '<div class="spinner-border text-info"></div>';

						$('div#response').html(div);
					}

					//	for defend click button import excel again
					/* if(d.getElementById('query').value != 1){
						d.frmExcelImport.submit();
					}else{
						location.replace(location.href);
					} */


					d.frmExcelImport.submit();

				});

			});
			$(document).on('change', '#seltable', function(event) {
				event.stopPropagation();

				let select = $(this).val();
				// $('input#import').val(select);
				window.location.replace('<?php echo site_url("/mod_excel/ctl_excel/'+select+'"); ?>');
			});

			//	result import
			$(document).on('click', '#resultImport', function(event) {
				event.stopPropagation();

				let dataimport = ".dataimport";
				let textloading = '<div class="spinner-border text-info"></div>';

				$.ajax({
						method: "get",
						beforeSend: function() {
							$(dataimport).html(textloading);
						},
						data: {
							id: '<?php echo $json_group; ?>'
						},
						url: "get_dataImport",
						success: function(result) {
							// console.log(JSON.stringify(result));
							let obj = jQuery.parseJSON(result);
							let divhtml;

							createHtml(obj);
							async function createHtml(obj) {
								let result1 = await blockHTML(obj);
								blocksuccess(result1.respone);
							}
						},

						error: function(error) {
							alert(error);
						}
					})
					.fail(function(xhr, status, error) {
						// error handling
						window.location.reload();
					});
			});
		</script>
		<?php
		require_once('sc_dump.php');
		?>
	</body>

	</html>