<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billretail_PDF extends CI_Controller {
 
	public function __construct()
    {
		parent::__construct();
		$this->load->model('mdl_sql');
		$this->load->model('mdl_createorder');
		$this->load->model('mdl_claim');
		$this->load->model('mdl_uplode');
		$this->load->library('session');
		$this->load->library('Permiss');
        $this->load->helper(array('form', 'url','myfunction_helper','sql_helper','permiss_helper','array_helper'));
        
        $this->set	= array (
            'ctl_name'				=> 'ctl_sentformems',
            'username_session'		=> $this->session->userdata('useradminname'),
            'userid_session'		=> $this->session->userdata('useradminid')
        );
        if($this->session->userdata('useradminid') == ''){
        	redirect('mod_admin/ctl_login');
        }
    }
     
	public function BillPDF() {
		$html = '';
		$id = $this->input->get('id');
		$mdl = $this->input->get('mdl');
		if($mdl){
			$mdl = $mdl;
		} else {
			$mdl = 'mdl_createorder';
		}
		$QueryBillDetail = $this->$mdl->datebilldetail($id);
		
		// STYLE //
		$html .= '
		<style>
			table {
				border: 1px solid #333;
				border-collapse: collapse;
				width: 100%;
			}

			td {
				border: 1px solid #333;
 				padding: 0.3%;
			}
			th {
				border: 1px solid #333;
				text-align: left;
				padding: 0.4%;
			}
			.border-002 {
				border: 1px solid #fff;
			}
			.text-right {text-align: right;}
			.text-center {text-align: center;}
			.text-left {text-align: left;}
			.font-color { color: #FFF;padding: 0.2rem 0.5rem; }
			.title {color: #FFF;padding: 0.2rem 0.5rem;background-color: #333;}
			.P-1rem {padding-top: 0.5rem;}
		</style> 
		';
		// HTML //

		$html .='<table class="table table-bordered border-002">';
		$html .='	<tbody>';
		$html .='		<tr>';
		$html .='			<td class="border-002" style="width: 15%;"> <img src="asset/images/front/icon/favicon.png" style="width: 80px;">  </td>';
		$html .='			<td class="border-002" style="width: 85%;vertical-align: bottom;"> 
								<div style=" font-size: 1.5rem; font-weight: bold; "> รายละเอียดออเดอร์ </div> 
								<div style=" font-size: 1rem; font-weight: bold; "> Chokchai Steakhouse Retail </div> 
							</td>';
		$html .='		</tr>';
		$html .='	</tbody>';
		$html .='</table>';
		
		$html .='<table class="table table-bordered border-002 P-1rem">';
		$html .='	<tbody>';
    
		$html .='		<tr>';
		$html .='			<td class="border-002" colspan="5">  <hr> </td>';
		$html .='		</tr>';

		$html .='		<tr>';
		$html .='			<td class="border-002" colspan="2"> <b>ขออนุมัติออเดอร์เจอร์กี้จัดส่งไปรษณีย์</b> </td>';
		$html .='			<td class="border-002 text-right" colspan="3"> <b>วันที่ : </b><span> '. $QueryBillDetail["DATE_STARTS"].'</span></td>';
		$html .='		</tr>';
		$html .='		<tr>';
		$html .='			<td class="border-002" colspan="1">  <b>ออเดอร์ที่ : </b><span> '. $QueryBillDetail["CODE"].' </span> </td>';
 		$html .='			<td class="border-002 text-right" colspan="4"> <b> ช่องทางการรับออเดอร์ : </b> '. $QueryBillDetail["METHODORDER_TOPIC"].' <b>รูปแบบการจัดส่ง : </b><span> '. $QueryBillDetail["DELIVERYFORMID"].' </span> </td>';
		$html .='		</tr>';
		 
		$html .='		<tr>';
		$html .='			<td class="border-002" colspan="2"> <b>ชื่อ-นามสกุล : </b> '. $QueryBillDetail["NAME"].' </td>';
		$html .='			<td class="border-002" colspan="3"> <b>เบอร์โทรศัพท์ : </b> '. $QueryBillDetail["PHONENUMBER"].'</td>';
		$html .='		</tr>';
		 
		$html .='		<tr>';
		$html .='			<td class="border-002" colspan="3"> <b>ที่อยู่ : </b> '. $QueryBillDetail["ADDRESS"].'</td>';
		$html .='			<td class="border-002 " colspan="2"> <b>รหัสไปรษณีย์ : </b> '. $QueryBillDetail["ZIPCODE"].'</td>';
		$html .='		</tr>';
		$html .='		<tr>';
		$html .='			<td class="border-002" colspan="5"> <b>เลขที่เสียภาษี/เลขที่บัตรประชาชน : </b> '. $QueryBillDetail["TEXTNUMBER"].'</td>';
		$html .='		</tr>';
				
		$html .='	</tbody>';
		$html .='</table>';

		$html .='<table class="table table-bordered border-002 P-1rem">';
		$html .='	<tbody>';
		$html .='		<tr>';
		$html .='			<td class="border-002" colspan="3">  <b>ธนาคารที่โอน : </b><span> '. $QueryBillDetail["BANIKNAME"].' </span>  </td>';
		$html .='			<td class="border-002" colspan="2"> <b> วันที่โอนเงิน/เวลาโอนเงิน : </b> '. $QueryBillDetail["TRANSFEREDDAYTIMETHAI"].'</td>';
		$html .='		</tr>';
		$html .='		<tr>';
		$html .='			<td class="border-002" colspan="3">  <b>จำนวนเงิน : </b><span> '. $QueryBillDetail["TRANSFEREDAMOUNTNumber"].' บาท </span>  </td>';
		$html .='			<td class="border-002" colspan="2"> <b> หมายเหตุ/Remark : </b> '. $QueryBillDetail["TRANSFEREDREMARK"].'</td>';
		$html .='		</tr>';
		$html .='	</tbody>';
		$html .='</table>';

		$html .='<table class="table table-bordered border-002">';
		$html .='	<tbody>';
		$html .='		<tr>';
		$html .='			<td class="border-002 title"> รายการออเดอร์ </td>';
		$html .='		</tr>';
		if($QueryBillDetail['REMARKORDER'] != ''){ 
			$html .='		<tr>';
			$html .='			<td class="border-002"> 
								<div style="padding-bottom: 0.5rem;"> <b> คำอธิบายเพิ่มเติม : </b> '.$QueryBillDetail["REMARKORDER"].' </div>
								</td>';
			$html .='		</tr>';
		}
		$html .='	</tbody>';
		$html .='</table>';

		$html .='<div class="P-1rem">';
		$html .='	<table class="table table-bordered" id="table-bill">';
		$html .='		<thead>';
		$html .='			<tr>';
		$html .='				<th style="width: 5px;text-align: center;">ลำดับ</th>';
		$html .='				<th style="width: 65px;text-align: center;">รายการออเดอร์</th>';
		$html .='				<th style="width: 10px;text-align: center;">ราคา<br><small>(บาท)</small></th>';
		$html .='				<th style="width: 10px;text-align: center;">จำนวน<br><small>(หน่วย)</small></th>';
		$html .='				<th style="width: 10px;text-align: center;">รวมเป็นเงิน<br><small>(บาท)</small></th>';
		$html .='			</tr>';
		$html .='		</thead>';
		$html .='		<tbody id="ORlist">';
							foreach($QueryBillDetail['billist'] AS $row1){ 
		$html .='			<tr style="background-color: #d9d9d9;"> ';
		$html .='				<td colspan="5"> <b> '.$row1['PRONAME_MAIN'].' </b> </td>';
		$html .='			</tr>';
								$index = 1; 
								foreach($row1['PRONAME_LIST'] AS $row2){ 
				$html .='			<tr class="each-total">';
				$html .='				<td style="text-align: center;"> '.$index++.' </td>';
				$html .='				<td style="text-align: left;">  '.$row2['PRONAME_LIST'].' </td>';
				$html .='				<td style="text-align: right;"> '.$row2['PRICE'].'</td>';
				$html .='				<td style="text-align: center;"> '.$row2['QUANTITY'].'</td>';
				$html .='				<td style="text-align: right;"> '.$row2['RBD_TOTALPRICE'].' </td>';
				$html .='			</tr>';
	 							} 
							}
		 
		$html .='		</tbody>';
		$html .='		<tbody id="total">';
						
		$html .='			<tr>';
		$html .='				<td class="text-right" style="padding: .1rem;" colspan="4"> <b>รวมยอดขายสุทธิ</b> </td>';
		$html .='				<td class="text-right" style="padding: .1rem;" id="total-price">'.$QueryBillDetail['TOTALPRICE'].'</td>';
		$html .='			</tr>';
		$html .='			<tr>';
		$html .='				<td class="text-right" style="padding: .1rem;" colspan="4"> <b>ค่ากล่องพัสดุ</b> </td>';
		$html .='				<td class="text-right" style="padding: .1rem;">'.$QueryBillDetail['PARCELCOST'].'</td>';
		$html .='			</tr>';
		$html .='			<tr>';
		$html .='				<td class="text-right" style="padding: .1rem;" colspan="4"> <b>ค่าบริการจัดส่ง</b> </td>';
		$html .='				<td class="text-right" style="padding: .1rem;">'.$QueryBillDetail['DELIVERYFEE'].'</td>';
		$html .='			</tr>';
		$html .='			<tr>';
		$html .='				<td class="text-right" style="padding: .1rem;" colspan="4"> <b>ค่าธรรมเนียม shopee</b> </td>';
		$html .='				<td class="text-right" style="padding: .1rem;">'.$QueryBillDetail['SHORMONEY'].'</td>';
		$html .='			</tr>';
		$html .='			<tr>';
		$html .='				<td class="text-right" style="padding: .1rem;" colspan="4"> <b>ส่วนลด</b> </td>';
		$html .='				<td class="text-right" style="padding: .1rem;">'.$QueryBillDetail['DISCOUNTPRICE'].'</td>';
		$html .='			</tr>';
		$html .='			<tr>';
		$html .='				<td class="text-right" style="padding: .1rem;" colspan="4"> <b>ค่าธรรมเนียมเก็บเงินปลายทาง</b> </td>';
		$html .='				<td class="text-right" style="padding: .1rem;">'.$QueryBillDetail['TAX'].'</td>';
		$html .='			</tr>';
		$html .='			<tr style="background-color: #d9d9d9;">';
		$html .='				<td class="text-center" style="padding: .1rem;" colspan="4"> <b>ยอดชำระรวมค่าจัดส่ง</b> </td>';
		$html .='				<td class="text-right" style="padding: .1rem;" id="total-cost">'.$QueryBillDetail['NETTOTAL'].'</td>';
		$html .='			</tr>';
		 
		$html .='		</tbody>';
		$html .='	</table>';
		$html .='</div>';

		$html .='<br><table class="table table-bordered border-002 P-1rem">';
		$html .='	<tbody>';
		$html .='		<tr>';
		$html .='			<td class="border-002 title"> หลักฐานการโอน </td>';
		$html .='		</tr>';

		$html .='		<tr>';
		$html .='			<td class="border-002"> ';
							 
						foreach($QueryBillDetail['IMGNAME'] AS $row){ 
							if($row['IMGNAME_NAME']){
								$html .= '<img src="asset/images/front/retail/BillPaymentMultiple/'.$row['IMGNAME_NAME'].'" style="width: 100px; padding: .1rem;">';
							} else {
								$html .= '<img src="https://heuft.com/upload/image/400x267/no_image_placeholder.png" style="width: 100px; padding: .1rem;">';
							}
						}
						 
		$html .='			</td>';
		$html .='		</tr>';
		$html .='	</tbody>';
		$html .='</table>';

		// echo $html; exit;
		$data['htmlPDF'] = $html;
		$data['base_bn'] = base_url().BASE_BN;
		$data['basepic'] = base_url().BASE_PIC;
		$this->load->view('BillPDF', $data);
	}
 
}
