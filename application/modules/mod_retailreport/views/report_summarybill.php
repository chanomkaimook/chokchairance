<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Writer;

$this->load->helper('excel_helper');

/* $write_array[] = array(
	"ลำดับ",
	"วันทำรายการ",
	"เลขที่",

	"ชื่อสินค้า",
	"จำนวน",
	"เขต",
	"สาขา",
	"ผู้สั่ง",
	"ผู้ตรวจ",

	"คืนสินค้า",
); */

$write_array[] = array(
	"วันที่",
	"store",
	"เลขที่เอกสาร",

	"ชื่อเครื่อง",
	"รหัสสินค้า",
	"รายละเอียด",
	"จำนวน",
	"หน่วย",
	"ยอดขายสุทธิ",

	"กลุ่มสินค้า",
	"หมวดหมู่",
	"รูปแบบ",
	"Price Category",
	"Month",
);

//
//	setting
//	* 0=A, 1=B, 2=C...
// $totalarray = count($write_array) - 1;
$totalarray = array_sum(array_map("count", $write_array)) - 1;
$columnfirst = get_columnExcelNameFromNumber(0);
$columnlast = get_columnExcelNameFromNumber($totalarray);
//
foreach ($query as $row => $val) {
	//	number
	$row++;

	$q_staff_start = get_WhereParaSelect('name_th,lastname_th,name,lastname', 'staff', 'code', $val->bill_user_starts);
	$q_staff_update = get_WhereParaSelect('name_th,lastname_th,name,lastname', 'staff', 'code', $val->bill_user_update);
	$approve1 = ($q_staff_start->name_th ? $q_staff_start->name_th . " " . $q_staff_start->lastname_th : $q_staff_start->name . " " . $q_staff_start->lastname);
	$approve2 = ($q_staff_update->name_th ? $q_staff_update->name_th . " " . $q_staff_update->lastname_th : $q_staff_update->name . " " . $q_staff_update->lastname);

	$creditnote = 0;

	// check ยอดใบลดหนี้ หากมีให้นำมาลบยอดรวม
	$sqlt = $this->db->select('retail_creditnote.net_total as rtd_net')
		->from('retail_creditnote')
		->join('retail_creditnotedetail', 'retail_creditnote.id=retail_creditnotedetail.creditnote_id', 'left')
		->where('retail_creditnote.rt_id', $val->bill_id)
		->where('retail_creditnote.complete', 2)
		->where('retail_creditnote.status', 1);
	$qt = $sqlt->get();
	$numt = $qt->num_rows();
	if ($numt) {
		$rowt = $qt->row();
		$creditnote = number_format($rowt->rtd_net, 2);
		$nettotal = number_format($nettotal - $rowt->rtd_net);
	}
	//


	$r_main = get_WherePara('retail_productmain', 'id', $val->bill_pmain_id);
	$r_submain = get_WherePara('product_submain', 'id', $val->bill_psubmain_id);
	$r_type = get_WherePara('product_type', 'id', $val->bill_ptype_id);
	$r_cate = get_WherePara('product_category', 'id', $val->bill_pcate_id);

	$write_array[] = array(

		date('d-m-Y', strtotime($val->bill_datetime)),
		$val->bill_gateway,
		$val->bill_code,
		$val->bill_pos,
		$val->bill_pid,
		$val->product_name,
		$val->bill_qty,
		$val->bill_unit,
		$val->bill_prototalprice,

		$r_main->NAME_TH,
		$r_submain->NAME_TH,
		$r_type->NAME_TH,
		$r_cate->NAME_TH,
		date('M-y', strtotime($val->bill_datetime))
		// '1/3/2022'

	);
}
// echo "<pre>";print_r($write_array);echo "</pre>";die();
$row++;
$last_row = $row;

// echo  count($write_array)."<br>"."<pre>";print_r($write_array);echo "</pre>";die();
//	
//	set style
$richText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();

$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0);


$spreadsheet->getActiveSheet()->fromArray($write_array, NULL, $columnfirst . '1');
/* $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
for($i = 1; $i <= $highestRow; $i++) {
	$cell = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($columnIndex, $i);
	$cell->setValueExplicit($cell->getValue(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
  } */
  /* $spreadsheet->getActiveSheet()
    ->getStyle("I")
    ->getNumberFormat()
    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING); */

  //	set format	
/* $spreadsheet->getActiveSheet()->getStyle($columnlast . '2:' . $columnlast . '' . $last_row)->getNumberFormat()
->setFormatCode('B1mmm-yy'); */

#	set default excel
$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
$spreadsheet->getDefaultStyle()->getFont()->setSize(8);

#	creat text
$row_ritchtext = $last_row + 2;
$richText->createText('This invoice is ');
$payable = $richText->createTextRun('document to secret for Senior officer farmchokchai');
$payable->getFont()->setBold(true);
$payable->getFont()->setItalic(true);
$payable->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN));
$richText->createText(', Do not share.');
$spreadsheet->getActiveSheet()->getCell('A' . $row_ritchtext)->setValue($richText);
$spreadsheet->getActiveSheet()->getStyle('A' . $row_ritchtext)
	->getAlignment()
	->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

#	array set
$styleHead = [
	'font' => [
		'bold' => true,
		'name' => 'Cordia New',
		'size' => 15,
		'color' => [
			'argb' => 'FFFFFF',
		]
	],
	'alignment' => [
		'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
		'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
	],
	'fill' => [
		'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
		'rotation' => 90,
		'color' => [
			'argb' => '8064A2',
		]
	],
];
$spreadsheet->getActiveSheet()->getStyle($columnfirst . '1:' . $columnlast . '1')->applyFromArray($styleHead);

$styleBody = [
	'font' => [
		'name' => 'Cordia New',
		'size' => 15
	],
	'alignment' => [
		'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
		'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
	],
	'fill' => [
		'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
		'rotation' => 90,
		'color' => [
			'argb' => 'E4DFEC',
		]
	],
];
$spreadsheet->getActiveSheet()->getStyle($columnfirst . '2:' . $columnlast . '' . $last_row)->applyFromArray($styleBody);

#	array set alignment
$styleAlign = [
	'alignment' => [
		'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
		'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
	]
];
$spreadsheet->getActiveSheet()->getStyle('B2:B' . $last_row)->applyFromArray($styleAlign);
$spreadsheet->getActiveSheet()->getStyle('F2:F' . $last_row)->applyFromArray($styleAlign);

#	array set alignment
$styleAlignRight = [
	'alignment' => [
		'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
		'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
	]
];
$spreadsheet->getActiveSheet()->getStyle('I2:I' . $last_row)->applyFromArray($styleAlignRight);

for ($rowi = 0; $rowi <= $last_row; $rowi++) {
	$div = $rowi % 2;

	if ($div == 0) {
		#	set background odd
		$spreadsheet->getActiveSheet()->getStyle($columnfirst . $rowi . ':' . $columnlast . $rowi)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('CCC0DA');
	}
}


#
#	number format
#	product list
$spreadsheet->getActiveSheet()->getStyle('i2:i' . $last_row)->getNumberFormat()
	->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);



#	array set
/* $stylePrice = [
	'font' => [
		'bold' => false,
		'name' => 'Arial',
		'size' => 8,
	],
	'alignment' => [
		'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
		'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
	]
];
$spreadsheet->getActiveSheet()->getStyle('E2:E' . $last_row)->applyFromArray($stylePrice); */


#	array set border
$styleBorder = [
	'borders' => [
		'allBorders' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			'color' => ['argb' => 'FFFFFFFF'],
		],
	],
];
$spreadsheet->getActiveSheet()->getStyle($columnfirst . '1:' . $columnlast . '' . $last_row)->applyFromArray($styleBorder);

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(60);
$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(10);

$spreadsheet->getActiveSheet()->getColumnDimension('j')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('k')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('l')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('m')->setWidth(18);


#	set height
$spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);

#	set sheet name
$spreadsheet->getActiveSheet()->setTitle(date('Y-m-d'));

#	protection
$spreadsheet->getActiveSheet()->getProtection()->setSheet(false);

//
//	setting
$filename = "rp_billSalesMix_" . date('Y-m-d') . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
// header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: cache, must-revalidate');
header('Pragma: public');
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//	for clear bug when export file error extension not valid
for ($i = 0; $i < ob_get_level(); $i++) {
	ob_end_flush();
}
ob_implicit_flush(1);
ob_clean();
//
$writer->save('php://output');
