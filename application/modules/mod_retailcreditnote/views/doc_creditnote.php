<?php
require 'vendor/autoload.php';

	use PhpOffice\PhpSpreadsheet\Helper\Sample;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Writer;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	
	#
	#	Setting
	#
	
	$fontsize = 10;
	$fontfamily = 'Arial';
	$set_cl_width = 11;
	$set_rw_height = 15;
	$startrow = 1;
	$cl_s = "A";
	$cl_e = "H";
	$cl_1_s = "A";
	$cl_1_e = "E";
	$cl_2_s = "F";
	$cl_2_e = "H";
	$cl_f = $cl_s.$startrow;
	$cl_l = $cl_e."20";
	//	address column
	$adcl_1_s = "A";
	$adcl_1_e = "B";
	$adcl_2_s = "C";
	$adcl_2_e = "H";
	//	vat column
	$vtcl_1_s = "A";
	$vtcl_1_e = "C";
	$vtcl_2_s = "D";
	$vtcl_2_e = "E";
	$vtcl_3_s = "F";
	$vtcl_3_e = "H";
	//	text
	$textheader = "บริษัท โชคชัยอินเตอร์เนชั่นแนล จำกัด";
	$texttopic2 = "ใบลดหนี้";
	$textvoice = "เลขที่ ";
	$ad_head = "294 หมู่ 8 ถนนวิภาวดีรังสิต ตำบลคูคต อำเภอลำลูกกา จังหวัดปทุมธานี 12130";
	$tel_head = "โทร. 02-5322846-8 แฟ็กซ์. 02-5312436";
	$id_head = "เลขประจำตัวผู้เสียภาษี 0105509000146 (สำนักงานใหญ่)";
	//customer
	$invoice_date = "วันที่ (Date) ";
	$textcusnameth = "นามลูกค้า";
	$textcusnameen = "(Customer Name)";
	$textcusaddressth = "ที่อยู่";
	$textcusaddressen = "(Address)";
	$textcusvatth = "เลขประจำตัวผู้เสียภาษีอากร";
	$textlist_cl_1 = "รายการ";
	$textlist_cl_2 = "จำนวนเงิน";
	$texttotalprice = "จำนวนเงิน (Sub Total)";
	$textvat = "ภาษีมูลค่าเพิ่ม 7% (Vat)";
	$textnetprice = "รวมเงินทั้งสิ้น (Net Total)";
	$textparcel = "ค่าพัสดุ";
	$textshor = "ค่าธรรมเนียม shopee";
	$textdelivery = "ค่าส่ง (delivery)";
	$textdiscount = "ส่วนลด (discount)";
	$texttax = "ค่าธรรมเนียมเก็บเงินปลายทาง";
	//	sign
	$sgcl_s = "G";
	$sign_ordernumber = "เลขที่อ้างอิง ";
	$sign_recive = "ผู้รับเงิน...........................................";
	$sign_customer = "ผู้รับสินค้า : ";
	$sign_tranfer = "ผู้ส่งสินค้า...........................................";
	$imagesign = "panchatkew fin.jpg";


    /* 'retail_creditnote.id as cn_id',
    'retail_creditnote.code as cn_code',
    'retail_creditnote.rt_bill_code as cn_rt_bill_code',
    'retail_creditnote.total_price as cn_total_price',
    'retail_creditnote.parcel_cost as cn_parcel_cost',
    'retail_creditnote.delivery_fee as cn_delivery_fee',
    'retail_creditnote.discount_price as cn_discount_price',
    'retail_creditnote.shor_money as cn_shor_money',
    'retail_creditnote.tax as cn_tax',
    'retail_creditnote.net_total as cn_net_total',
    'retail_creditnote.approve as cn_approve',
    'retail_creditnote.approve_store as cn_approve_store',
    'retail_creditnote.complete as cn_complete',
    'retail_creditnote.remark as cn_remark',
    'retail_creditnote.loss as cn_loss',
    'retail_creditnote.date_starts as cn_date_starts',
    'retail_creditnote.user_starts as cn_user_starts',

    'retail_creditnotedetail.id as cnd_id',
    'retail_creditnotedetail.promain_id as cnd_productmain',
    'retail_creditnotedetail.prolist_id as cnd_productid',
    'retail_creditnotedetail.list_id as cnd_productlist',
    'retail_creditnotedetail.quantity as cnd_qty',
    'retail_creditnotedetail.total_price as cnd_price',

    'retail_bill.code as rt_code',
    'retail_bill.name as rt_name',
    'retail_bill.phone_number as rt_tel',
    'retail_bill.text_number as rt_citizen',
    'retail_bill.address as rt_address',
    'retail_bill.zipcode as rt_zipcode',

    'retail_productlist.name_th as rtp_name',
    'retail_productlist.price as rtp_price',

    'staff.name as sf_name',
    'staff.name_th as sf_nameth',
    'staff.lastname as sf_lastname',
    'staff.lastname_th as sf_lastnameth', */

    $row = 0;
	foreach($query->result() as $val){
		//	number
		$row++;
		
		/* $write_array[] = array(
							$row,
							date('d-m-Y',strtotime($val->bill_datetime)),
							$val->cn_code,
							$val->rt_name,
							$val->cnd_productmain,
							$val->cnd_productid,
							$val->cnd_qty,
							$val->cnd_price,
							$val->rt_tel,
							$val->rt_address,
							$val->rt_citizen,
							$val->cn_total_price,
							$val->cn_parcel_cost,
							$val->cn_delivery_fee,
							$val->cn_net_total,
							$val->cn_remark
						); */

		//
		//	check null
		$renew_address = "";
		if($val->rt_address){
			//	cut special char [<br />,\n,\t]
			$adexplode = explode("\n",$val->rt_address);
			if(count($adexplode) > 0){
				foreach($adexplode as $rows){
					$renew_address .= $rows." ";
				}
				
			}
		} 
		// echo htmlspecialchars($renew_address)."---<br>";
		// 
		
		//
		//	discout will value lessthan 0
		$decreasediscount = $val->bill_discount - ($val->bill_discount * 2);

		$write_array[] = array(
							"id"		=> $row,
							"code"		=> $val->cn_code,
							"name"		=> $val->rt_name,
							"address"		=> $renew_address,
							// "address"		=> iconv( 'TIS-620', 'UTF-8', $val->bill_address),
							"citizen"		=> $val->rt_citizen,
							"product"		=> $val->rtp_name,
							"qty"			=> $val->cnd_qty,
							"price"			=> $val->rtp_price,
							"totalprice"	=> $val->cnd_price,
							"tax"			=> $val->cn_tax,
							"shor"			=> $val->cn_shor_money,
							"parcel"		=> $val->cn_parcel_cost,
							"delivery"		=> $val->cn_delivery_fee,
							"discount"		=> $val->cn_discount_price,
							"netprice"		=> $val->cn_net_total,
							"date"			=> date('Y-m-d',strtotime($val->cn_date_starts)),
							"dateslip"		=> $val->cn_date_starts
						);

		$codereport = trim($val->cn_codereport);
	}

    /* echo "<pre>";
    print_r($write_array);
    echo "</pre>";
	die(); */
	#	group date order
	$ardate = unique_multidim_array($write_array,'date');
	
	#	group order
	$order = unique_multidim_array($write_array,'code');
	
	#	find product in order
	foreach($order as $row => $val){
		$arr_groupcode[] = array_keys(array_column($write_array, 'code'),$val['code']);
	}
	#
	#	new index
	#	code
	$code = array();
	foreach($order as $row => $val){
		array_push($code,$val);
	}
	
	#	date
	$arr_date = array();
	foreach($ardate as $row => $val){
		array_push($arr_date,$val);
		$arr_groupdate[] = array_keys(array_column($code, 'date'),$val['date']);
	}
	
	
	$arr_group = array1Para($code,$arr_date);
	
	/* $code[] = array(
				"id" 	=> 1,
            "code" 		=> 'Jerky 623_2563',
            "name" 		=> 'คุณวินัย กุมาร',
            "delivery" 	=> 75.00,
            "main" 		=> 4,
            "list" 		=> 18,
            "qty" 		=> 1,
            "price" 	=> 245.00,
            "date" 		=> '2020-01-30 15:22:10'
			);
	$code[] = array(
				"id" 	=> 2,
            "code" 		=> 'Jerky 622_2563',
            "name" 		=> 'สวริน​ทร์​ พรม​ศร',
            "delivery" 	=> 75.00,
            "main" 		=> 4,
            "list" 		=> 18,
            "qty" 		=> 1,
            "price" 	=> 245.00,
            "date" 		=> '2020-02-14 15:22:10'
			);
			
	$arr_group[] = array(
					4,5,6,7,8
			);
			$arr_group[] = array(
					2,3
			); */
	/* foreach($arr_group as $row => $val){
		echo "<br>";
		echo $row."---";
		foreach($val as $key){
			echo "[".$key."],";
		}
	}
	die(); */
	/* echo "<pre>";
    print_r($write_array);
    echo "array date================";
	print_r($ardate);
	echo "array group================";
	print_r($arr_groupdate);
	echo "array code================";
	print_r($code);
	echo "array group code================";
	print_r($arr_groupcode);
	echo "</pre>";die(); */
	
	$spreadsheet = new Spreadsheet();
	$spreadsheet->setActiveSheetIndex(0);
	// $spreadsheet->getActiveSheet()->fromArray($write_array,NULL,'A1');
	
	#	set dimention
	$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth($set_cl_width);
	$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth($set_cl_width);
	$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth($set_cl_width);
	$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth($set_cl_width);
	$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth($set_cl_width);
	$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth($set_cl_width);
	$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth($set_cl_width);
	$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth($set_cl_width);
	
	#	set default excel
	$spreadsheet->getDefaultStyle()->getFont()->setName($fontfamily);
	$spreadsheet->getDefaultStyle()->getFont()->setSize(10);
	
	#	array set font
	$styleHead = [
		'font' => [
			'bold' => true,
			'name' => 'Arial',
			'size' => 16,
		],
		'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
		]
	];
	
	#	array set vat
	$styleVat = [
		'font' => [
			'bold' => true,
			'name' => 'Arial',
		],
		'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
		]
	];
	
	#	array set product list
	$styleListname = [
		'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
		]
	];
	
	#	array set product list
	$styleListmoney = [
		'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
		]
	];
	
	#	array set font
	$styleTop = [
		'alignment' => [
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
		]
	];
	
	#	array set border
	$styleBorder = [
		'borders' => [
			'allBorders' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				'color' => ['argb' => '00000000'],
			],
		],
	];
	#	array set border
	$styleBorderOut = [
		'borders' => [
			'outline' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				'color' => ['argb' => '00000000'],
			],
		],
	];
	$nextrow = 0;
	foreach($arr_date as $rows => $val){
	#
	
	foreach($arr_groupdate[$rows] as $row => $val){
		
	#
	#	date bill start
	$datetime = date('Y-m-d',strtotime($code[$val]['date']));
	
	#
	#	date vat
	if($write_array[$key]['dateslip']){
		$textdatesllip = thai_date(date('Y-m-d',strtotime($write_array[$key]['dateslip'])));
	}else{
		$textdatesllip = "";
	}
	
	#
	#	invoice
	$invoice = $codereport;
	#--------------------------------------------------------------------------#
	
	#	======================================================
	#	==================		END VAT		==================
	
	
	#	==============================================================
	#	==================		BEGIN INVOICE		==================
	#
	#	date bill start
	$datetimeslip = date('Y-m-d',strtotime($code[$val]['dateslip']));
	
	#--------------------------------------------------------------------------#
	#	---	---	BEGIN HEADER	---	---
	#	address 1
	#	next row
	$nextrow = $nextrow+1;
	#	creat text title
	$richText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$ritch_style = $richText->createTextRun($textheader);
	$ritch_style->getFont()->setBold(true);
	$ritch_style->getFont()->setSize(16);
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($cl_1_s.$nextrow.':'.$cl_1_e.$nextrow);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight(30);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($cl_1_s.$nextrow)->setValue($richText);
	#
	#	change style
	$spreadsheet->getActiveSheet()->getStyle($cl_1_s.$nextrow)->applyFromArray($styleHead);
	#	
	#	creat text invoice
	$voiceText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$voice_style = $voiceText->createTextRun($textvoice.$invoice);
	$voice_style->getFont()->setSize($fontsize);
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($cl_2_s.$nextrow)->setValue($voiceText);
	#
	#	set alignment
	$spreadsheet->getActiveSheet()->getStyle($cl_2_s.$nextrow)
		->getAlignment()
		->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
	#
	#	set boder
	$spreadsheet->getActiveSheet()->getStyle($cl_s.$nextrow.':'.$cl_e.$nextrow)->applyFromArray($styleBorder);
	
	#	address 1
	#	next row
	$begin_address = $nextrow+1;
	$nextrow = $nextrow+1;
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($cl_s.$nextrow.':'.$cl_e.$nextrow);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#	
	#	creat text address
	$addressText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textaddress = $addressText->createTextRun($ad_head);
	$textaddress->getFont()->setName($fontfamily);
	$textaddress->getFont()->setSize($fontsize);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($cl_s.$nextrow)->setValue($addressText);
	
	#	address 2
	#	next row
	$nextrow = $nextrow+1;
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($cl_s.$nextrow.':'.$cl_e.$nextrow);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#	
	#	creat text address
	$addressText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textaddress = $addressText->createTextRun($tel_head);
	$textaddress->getFont()->setName($fontfamily);
	$textaddress->getFont()->setSize($fontsize);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($cl_s.$nextrow)->setValue($addressText);
	
	#	address 3
	#	next row
	$nextrow = $nextrow+1;
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($cl_s.$nextrow.':'.$cl_e.$nextrow);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#	
	#	creat text address
	$addressText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textaddress = $addressText->createTextRun($id_head);
	$textaddress->getFont()->setName($fontfamily);
	$textaddress->getFont()->setSize($fontsize);
	$textaddress->getFont()->setBold(true);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($cl_s.$nextrow)->setValue($addressText);
	
	#	title 2
	#	next row
	$nextrow = $nextrow+1;
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($cl_s.$nextrow.':'.$cl_e.$nextrow);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#	
	#	creat text topic
	$topicText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$texttopict = $topicText->createTextRun($texttopic2);
	$texttopict->getFont()->setBold(true);
	$texttopict->getFont()->setSize(16);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($cl_s.$nextrow)->setValue($topicText);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight(30);
	#
	#	change style
	$spreadsheet->getActiveSheet()->getStyle($cl_s.$nextrow)->applyFromArray($styleHead);
	
	#	invoice date 
	#	next row
	$nextrow = $nextrow+1;
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($cl_1_s.$nextrow.':'.$cl_1_e.$nextrow);
	$spreadsheet->getActiveSheet()->mergeCells($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#	
	#	creat text address
	$invoiceText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textInvoice = $invoiceText->createTextRun($invoice_date);
	$textInvoice->getFont()->setName($fontfamily);
	$textInvoice->getFont()->setSize($fontsize);
	$textInvoice->getFont()->setBold(true);
	$textInvoice2 = $invoiceText->createTextRun(thai_date($datetimeslip));
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($cl_2_s.$nextrow)->setValue($invoiceText);
	#--------------------------------------------------------------------------#
	#	---	---	BEGIN CUST	---	---
	#	customers profile 1
	#	next row
	$nextrow = $nextrow+1;
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($adcl_1_s.$nextrow.':'.$adcl_1_e.$nextrow);
	$spreadsheet->getActiveSheet()->mergeCells($adcl_2_s.$nextrow.':'.$adcl_2_e.$nextrow);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#	
	#	creat text customer 1
	$cusText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textcus = $cusText->createTextRun($textcusnameth);
	$textcus->getFont()->setName($fontfamily);
	$textcus->getFont()->setSize($fontsize);
	$textcus->getFont()->setBold(true);
	$textcus = $cusText->createTextRun(" ".$textcusnameen);
	$textcus->getFont()->setBold(true);
	$textcus->getFont()->setSize(8);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($adcl_1_s.$nextrow)->setValue($cusText);
	#	
	#	creat text customer 2
	$cusText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textcus = $cusText->createTextRun($code[$val]['name']);
	$textcus->getFont()->setName($fontfamily);
	$textcus->getFont()->setSize($fontsize);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($adcl_2_s.$nextrow)->setValue($cusText);
	#
	#	set style
	$spreadsheet->getActiveSheet()->getStyle($cl_s.$nextrow.':'.$cl_e.$nextrow)->applyFromArray($styleTop);
	
	#	customers profile 2
	#	next row
	$nextrow = $nextrow+1;
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($adcl_1_s.$nextrow.':'.$adcl_1_e.$nextrow);
	$spreadsheet->getActiveSheet()->mergeCells($adcl_2_s.$nextrow.':'.$adcl_2_e.$nextrow);
	#
	#	set height
	$newheigth = $set_rw_height*2;
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($newheigth);
	#	
	#	creat text customer 1
	$cusText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textcus = $cusText->createTextRun($textcusaddressth);
	$textcus->getFont()->setName($fontfamily);
	$textcus->getFont()->setSize($fontsize);
	$textcus->getFont()->setBold(true);
	$textcus = $cusText->createTextRun(" ".$textcusaddressen);
	$textcus->getFont()->setBold(true);
	$textcus->getFont()->setSize(8);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($adcl_1_s.$nextrow)->setValue($cusText);
	#	
	#	creat text customer 2
	$cusText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textcus = $cusText->createTextRun($code[$val]['address']);
	$textcus->getFont()->setName($fontfamily);
	$textcus->getFont()->setSize($fontsize);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($adcl_2_s.$nextrow)->setValue($cusText);
	#
	#	wraptext (show text non-over column width)
	$spreadsheet->getActiveSheet()->getStyle($adcl_2_s.$nextrow)->getAlignment()->setWrapText(true);
	#
	#	set style
	$spreadsheet->getActiveSheet()->getStyle($cl_s.$nextrow.':'.$cl_e.$nextrow)->applyFromArray($styleTop);
	
	#	customers profile 3
	#	next row
	$nextrow = $nextrow+1;
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($adcl_1_s.$nextrow.':'.$adcl_1_e.$nextrow);
	$spreadsheet->getActiveSheet()->mergeCells($adcl_2_s.$nextrow.':'.$adcl_2_e.$nextrow);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#	
	#	creat text customer 1
	$cusText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textcus = $cusText->createTextRun($textcusvatth);
	$textcus->getFont()->setName($fontfamily);
	$textcus->getFont()->setSize(9);
	$textcus->getFont()->setBold(true);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($adcl_1_s.$nextrow)->setValue($cusText);
	#	
	#	creat text customer 2
	$cusText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textcus = $cusText->createTextRun($code[$val]['citizen']);
	$textcus->getFont()->setName($fontfamily);
	$textcus->getFont()->setSize($fontsize);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($adcl_2_s.$nextrow)->setValue($cusText);
	#
	#	set style
	$spreadsheet->getActiveSheet()->getStyle($cl_s.$nextrow.':'.$cl_e.$nextrow)->applyFromArray($styleTop);
	#
	#	set boder
	$spreadsheet->getActiveSheet()->getStyle($cl_s.$begin_address.':'.$cl_e.$nextrow)->applyFromArray($styleBorder);
	#
	#--------------------------------------------------------------------------#
	#	---	---	END CUST	---	---
	#	---	---	BEGIN LIST	---	---
	#	list title product 
	#	next row
	$nextrow = $nextrow+1;
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($cl_1_s.$nextrow.':'.$cl_1_e.$nextrow);
	$spreadsheet->getActiveSheet()->mergeCells($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#	
	#	creat text list
	$listText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textList = $listText->createTextRun($textlist_cl_1);
	$textList->getFont()->setName($fontfamily);
	$textList->getFont()->setSize($fontsize);
	$textList->getFont()->setBold(true);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($cl_1_s.$nextrow)->setValue($listText);
	#	
	#	creat text list
	$listText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textList = $listText->createTextRun($textlist_cl_2);
	$textList->getFont()->setName($fontfamily);
	$textList->getFont()->setSize($fontsize);
	$textList->getFont()->setBold(true);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($cl_2_s.$nextrow)->setValue($listText);
	#
	#	set style
	$spreadsheet->getActiveSheet()->getStyle($cl_s.$nextrow.':'.$cl_e.$nextrow)->applyFromArray($styleListname);
	#
	#	set boder
	$spreadsheet->getActiveSheet()->getStyle($cl_s.$nextrow.':'.$cl_e.$nextrow)->applyFromArray($styleBorder);
	
	#	set start for border outline
	$block_row_listproduct_s = $nextrow+1;
	#
	#	array loop product list
	$nextrow++;			//	space 1 row
		foreach($arr_groupcode[$val] as $root => $key){
	
		#	list product
		#	next row
		$nextrow = $nextrow+1;
		#
		#	mergeCells
		$spreadsheet->getActiveSheet()->mergeCells($adcl_1_e.$nextrow.':'.$cl_1_e.$nextrow);
		$spreadsheet->getActiveSheet()->mergeCells($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow);

		#
		#	set height
		$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
		#	
		#	creat text list
		$listText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
		$textList = $listText->createTextRun($write_array[$key]['product']);			//	list product insert here
		$textList->getFont()->setName($fontfamily);
		$textList->getFont()->setSize($fontsize);
		#
		#	insert text
		$spreadsheet->getActiveSheet()->getCell($adcl_1_e.$nextrow)->setValue($listText);
		#
		#	set alignment
		$spreadsheet->getActiveSheet()->getStyle($adcl_1_e.$nextrow)
			->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		#	
		#	insert price
		$spreadsheet->getActiveSheet()
		->setCellValue(
			''.$vtcl_3_s.''.$nextrow,
			$write_array[$key]['totalprice']
		);
		/* $spreadsheet->getActiveSheet()->getStyle($cl_2_s.$nextrow)->getNumberFormat()
		->setFormatCode('#,##0.00'); */
		#
		#	set style
		// $spreadsheet->getActiveSheet()->getStyle($cl_1_s.$nextrow.':'.$cl_1_e.$nextrow)->applyFromArray($styleListname);
		$spreadsheet->getActiveSheet()->getStyle($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow)->applyFromArray($styleListmoney);
		}
		
		#	parcel
		#	next row
		$nextrow = $nextrow+1;
		#
		#	mergeCells
		$spreadsheet->getActiveSheet()->mergeCells($adcl_1_e.$nextrow.':'.$cl_1_e.$nextrow);
		$spreadsheet->getActiveSheet()->mergeCells($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow);
		#
		#	set height
		$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
		#
		#	insert text
		$spreadsheet->getActiveSheet()->getCell($adcl_1_e.$nextrow)->setValue($textparcel);
		$spreadsheet->getActiveSheet()->getCell($cl_2_s.$nextrow)->setValue($code[$val]['parcel']);
		#
		#	set style
		$spreadsheet->getActiveSheet()->getStyle($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow)->applyFromArray($styleListmoney);
		
		#	shor
		#	next row
		$nextrow = $nextrow+1;
		#
		#	mergeCells
		$spreadsheet->getActiveSheet()->mergeCells($adcl_1_e.$nextrow.':'.$cl_1_e.$nextrow);
		$spreadsheet->getActiveSheet()->mergeCells($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow);
		#
		#	set height
		$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
		#
		#	insert text
		$spreadsheet->getActiveSheet()->getCell($adcl_1_e.$nextrow)->setValue($textshor);
		$spreadsheet->getActiveSheet()->getCell($cl_2_s.$nextrow)->setValue($code[$val]['shor']);
		#
		#	set style
		$spreadsheet->getActiveSheet()->getStyle($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow)->applyFromArray($styleListmoney);
		
		#	list delivery
		#	next row
		$nextrow = $nextrow+1;
		#
		#	mergeCells
		$spreadsheet->getActiveSheet()->mergeCells($adcl_1_e.$nextrow.':'.$cl_1_e.$nextrow);
		$spreadsheet->getActiveSheet()->mergeCells($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow);
		#
		#	set height
		$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
		#
		#	insert text
		$spreadsheet->getActiveSheet()->getCell($adcl_1_e.$nextrow)->setValue($textdelivery);
		$spreadsheet->getActiveSheet()->getCell($cl_2_s.$nextrow)->setValue($code[$val]['delivery']);
		#
		#	set style
		$spreadsheet->getActiveSheet()->getStyle($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow)->applyFromArray($styleListmoney);
		
		#	list discount
		#	next row
		$nextrow = $nextrow+1;
		#
		#	mergeCells
		$spreadsheet->getActiveSheet()->mergeCells($adcl_1_e.$nextrow.':'.$cl_1_e.$nextrow);
		$spreadsheet->getActiveSheet()->mergeCells($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow);
		#
		#	set height
		$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
		#
		#	insert text
		$spreadsheet->getActiveSheet()->getCell($adcl_1_e.$nextrow)->setValue($textdiscount);
		$spreadsheet->getActiveSheet()->getCell($cl_2_s.$nextrow)->setValue($code[$val]['discount']);
		#
		#	set style
		$spreadsheet->getActiveSheet()->getStyle($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow)->applyFromArray($styleListmoney);
		
		#	list tax
		#	next row
		$nextrow = $nextrow+1;
		#
		#	mergeCells
		$spreadsheet->getActiveSheet()->mergeCells($adcl_1_e.$nextrow.':'.$cl_1_e.$nextrow);
		$spreadsheet->getActiveSheet()->mergeCells($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow);
		#
		#	set height
		$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
		#
		#	insert text
		$spreadsheet->getActiveSheet()->getCell($adcl_1_e.$nextrow)->setValue($texttax);
		$spreadsheet->getActiveSheet()->getCell($cl_2_s.$nextrow)->setValue($code[$val]['tax']);
		#
		#	set style
		$spreadsheet->getActiveSheet()->getStyle($cl_2_s.$nextrow.':'.$cl_2_e.$nextrow)->applyFromArray($styleListmoney);
		
	#	set end for border outline
	$block_row_listproduct_e = $block_row_listproduct_s+24;
	$nextrow = $block_row_listproduct_e;
	#	draw border
	$spreadsheet->getActiveSheet()->getStyle($cl_1_s.$block_row_listproduct_s.':'.$cl_1_e.$block_row_listproduct_e)->applyFromArray($styleBorderOut);
	$spreadsheet->getActiveSheet()->getStyle($cl_2_s.$block_row_listproduct_s.':'.$cl_2_e.$block_row_listproduct_e)->applyFromArray($styleBorderOut);
	
	#	vat data
	#	next row
	$begin_vat = $nextrow+1;
	$nextrow = $nextrow+1;
	$mergerow = $nextrow+2;
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($vtcl_1_s.$nextrow.':'.$vtcl_1_e.$mergerow);
	$spreadsheet->getActiveSheet()->mergeCells($vtcl_2_s.$nextrow.':'.$vtcl_2_e.$nextrow);
	$spreadsheet->getActiveSheet()->mergeCells($vtcl_3_s.$nextrow.':'.$vtcl_3_e.$nextrow);
	#
	#	set alignment
	$spreadsheet->getActiveSheet()->getStyle($vtcl_1_s.$nextrow.':'.$vtcl_3_e.$nextrow)->applyFromArray($styleVat);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#	set sum total	formular SUM(F12:H35) - SUM(F12:H35)*0.07
	$startcal = $block_row_listproduct_s+1;
	$endcal = $block_row_listproduct_e;
	#	
	#	creat text totalprice thai
	$add_delivery = $code[$val]['netprice'];
	$netpricethai = convertNumberToText($add_delivery);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($vtcl_1_s.$nextrow)->setValue($netpricethai);
	#	
	#	creat text totalprice
	$listText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textGroupVat = $listText->createTextRun($texttotalprice);
	$textGroupVat->getFont()->setName($fontfamily);
	$textGroupVat->getFont()->setSize(9);
	$textGroupVat->getFont()->setBold(true);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($vtcl_2_s.$nextrow)->setValue($listText);
	#
	#	set alignment
	$spreadsheet->getActiveSheet()->getStyle($vtcl_2_s.$nextrow)
		->getAlignment()
		->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	#	
	#	creat totalprice
	$spreadsheet->getActiveSheet()
	->setCellValue(
		$vtcl_3_s.$nextrow,
		'=SUM('.$vtcl_3_s.$startcal.':'.$vtcl_3_e.$endcal.') - SUM('.$vtcl_3_s.$startcal.':'.$vtcl_3_e.$endcal.')*7/107'
	);
	#	number format
	$spreadsheet->getActiveSheet()->getStyle($vtcl_3_s.$nextrow.':'.$vtcl_3_e.$nextrow)->getNumberFormat()
	->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	
	#	vat data
	#	next row
	$nextrow = $nextrow+1;
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($vtcl_2_s.$nextrow.':'.$vtcl_2_e.$nextrow);
	$spreadsheet->getActiveSheet()->mergeCells($vtcl_3_s.$nextrow.':'.$vtcl_3_e.$nextrow);
	#
	#	set alignment
	$spreadsheet->getActiveSheet()->getStyle($vtcl_2_s.$nextrow.':'.$vtcl_3_e.$nextrow)->applyFromArray($styleVat);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#	
	#	creat text vat
	$listText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textGroupVat = $listText->createTextRun($textvat);
	$textGroupVat->getFont()->setName($fontfamily);
	$textGroupVat->getFont()->setSize(9);
	$textGroupVat->getFont()->setBold(true);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($vtcl_2_s.$nextrow)->setValue($listText);
	#
	#	set alignment
	$spreadsheet->getActiveSheet()->getStyle($vtcl_2_s.$nextrow)
		->getAlignment()
		->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	#	
	#	creat vat
	$spreadsheet->getActiveSheet()
	->setCellValue(
		$vtcl_3_s.$nextrow,
		'=SUM('.$vtcl_3_s.$startcal.':'.$vtcl_3_e.$endcal.')*7/107'
	);
	#	number format
	$spreadsheet->getActiveSheet()->getStyle($vtcl_3_s.$nextrow.':'.$vtcl_3_e.$nextrow)->getNumberFormat()
	->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	
	#	vat data
	#	next row
	$nextrow = $nextrow+1;
	#
	#	mergeCells
	$spreadsheet->getActiveSheet()->mergeCells($vtcl_2_s.$nextrow.':'.$vtcl_2_e.$nextrow);
	$spreadsheet->getActiveSheet()->mergeCells($vtcl_3_s.$nextrow.':'.$vtcl_3_e.$nextrow);
	#
	#	set alignment
	$spreadsheet->getActiveSheet()->getStyle($vtcl_2_s.$nextrow.':'.$vtcl_3_e.$nextrow)->applyFromArray($styleVat);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#	
	#	creat text netprice
	$listText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textGroupVat = $listText->createTextRun($textnetprice);
	$textGroupVat->getFont()->setName($fontfamily);
	$textGroupVat->getFont()->setSize(9);
	$textGroupVat->getFont()->setBold(true);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($vtcl_2_s.$nextrow)->setValue($listText);
	#
	#	set alignment
	$spreadsheet->getActiveSheet()->getStyle($vtcl_2_s.$nextrow)
		->getAlignment()
		->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	#	
	#	creat netprice
	$spreadsheet->getActiveSheet()
	->setCellValue(
		$vtcl_3_s.$nextrow,
		'=SUM('.$vtcl_3_s.$startcal.':'.$vtcl_3_e.$endcal.')'
	);
	#
	#	set boder
	$spreadsheet->getActiveSheet()->getStyle($cl_s.$begin_vat.':'.$cl_e.$nextrow)->applyFromArray($styleBorder);
	#	number format
	$spreadsheet->getActiveSheet()->getStyle($vtcl_3_s.$nextrow.':'.$vtcl_3_e.$nextrow)->getNumberFormat()
	->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	
	#
	#	number format
	#	product list
	$spreadsheet->getActiveSheet()->getStyle($vtcl_3_s.$startcal.':'.$vtcl_3_e.$endcal)->getNumberFormat()
	->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	
	#	sign
	#	next row
	$start_cl_sign = $nextrow+1;
	$end_cl_sign = $nextrow+10;
	$nextrow_sign = $nextrow+8;
	$nextrow = $nextrow+2;
	#
	#	mergeCells
	// $spreadsheet->getActiveSheet()->mergeCells($cl_1_s.$start_cl_sign.':'.$cl_1_e.$end_cl_sign);
	// $spreadsheet->getActiveSheet()->mergeCells($cl_2_s.$start_cl_sign.':'.$cl_2_e.$end_cl_sign);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#	
	#	creat text sign
	$listText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textSign = $listText->createTextRun($sign_ordernumber.$write_array[$key]['code']);
	$textSign->getFont()->setName($fontfamily);
	$textSign->getFont()->setSize($fontsize);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($cl_1_s.$nextrow)->setValue($listText);
	#
	#	set alignment
	$spreadsheet->getActiveSheet()->getStyle($cl_1_s.$nextrow)
	->getAlignment()
	->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	#	
	#	creat text sign
	$listText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
	$textSign = $listText->createTextRun($sign_recive);
	$textSign->getFont()->setName($fontfamily);
	$textSign->getFont()->setSize($fontsize);
	#
	#	insert text
	$spreadsheet->getActiveSheet()->getCell($cl_2_s.$nextrow_sign)->setValue($listText);
	
	$rowcreatesign = $nextrow_sign - 4;
	$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
	$drawing->setName('Logo');
	$drawing->setDescription('Logo');
	$drawing->setPath("asset/images/back/sign/".$imagesign);
	$drawing->setCoordinates($sgcl_s.$rowcreatesign);
	$drawing->setHeight(50);
	$drawing->setWorksheet($spreadsheet->getActiveSheet());
	#
	#	set style
	$spreadsheet->getActiveSheet()->getStyle($cl_1_s.$start_cl_sign.':'.$cl_1_e.$end_cl_sign)->applyFromArray($styleBorderOut);
	$spreadsheet->getActiveSheet()->getStyle($cl_2_s.$start_cl_sign.':'.$cl_2_e.$end_cl_sign)->applyFromArray($styleBorderOut);
	
	#	space
	#	next row
	$nextrow = $end_cl_sign+1;
	#
	#	mergeCells
	// $spreadsheet->getActiveSheet()->mergeCells($cl_1_s.$start_cl_sign.':'.$cl_1_e.$end_cl_sign);
	// $spreadsheet->getActiveSheet()->mergeCells($cl_2_s.$start_cl_sign.':'.$cl_2_e.$end_cl_sign);
	#
	#	set height
	$spreadsheet->getActiveSheet()->getRowDimension($nextrow)->setRowHeight($set_rw_height);
	#
	#	set style
	$spreadsheet->getActiveSheet()->getStyle($cl_s.$nextrow.':'.$cl_e.$nextrow)->applyFromArray($styleBorderOut);
	#	set break page
	$spreadsheet->getActiveSheet()->setBreak($cl_s.$nextrow, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
	}
	#	==============================================================
	#	==================		END INVOICE		==================
	}
	
	
	#
	#--------------------------------------------------------------------------#
	#	---	---	END LIST	---	---
	
	#	set default row dimension
	// $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
	
	#	set sheet name
	$spreadsheet->getActiveSheet()->setTitle(date('Y-m-d'));
	
	#	protection
	$spreadsheet->getActiveSheet()->getProtection()->setSheet(false);
	
	//
	//	setting
	$filename = "cn_".$write_array[$key]['code']."-".date('Y-m-d').".xlsx";
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0');
	// header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: cache, must-revalidate');
	header('Pragma: public');
	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	// for clear bug when export file error extension not valid
	for ($i = 0; $i < ob_get_level(); $i++) {
	   ob_end_flush();
	}
	ob_implicit_flush(1);
	ob_clean();
	
	$writer->save('php://output');	
	
	/* $writer = new Xlsx($spreadsheet);
	$writer->setPreCalculateFormulas(false);
	$writer->save('reportfile/test.xlsx'); */
