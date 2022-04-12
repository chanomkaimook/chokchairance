<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctl_claim extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
		parent::__construct();
 		$this->load->model('mdl_claim');
		$this->load->model('mdl_sql');
		$this->load->model('mdl_uplode');
		$this->load->library('session');
		$this->load->library('Permiss');
        $this->load->helper(array('form', 'url','myfunction_helper','sql_helper','permiss_helper'));
        
        $this->set	= array (
            'max_upload_image'		=> 1000000,		// 1 k = 1000
            'max_size_image'		=> 1920,
            'ctl_name'				=> 'ctl_createorder',
            'username_session'		=> $this->session->userdata('useradminname'),
            'userid_session'		=> $this->session->userdata('useradminid')
        );
        if($this->session->userdata('useradminid') == ''){
        	redirect('mod_admin/ctl_login');
        }
    }
     
	public function claim() {
 	
		$data = array (
			'mainmenu' 		=> 'retail',
			'submenu' 		=> 'claim'
		);
		 
 		$data['base_bn'] = base_url().BASE_BN;
		$data['basepic'] = base_url().BASE_PIC;
		$this->load->view('claim', $data);
	}

	public function viweclaimbill() {
		$data = array (
			'mainmenu' 		=> 'retail',
			'submenu' 		=> 'claim'
		);
		
		$id = $this->input->get('id');
		$data['Query_billdetil'] = $this->mdl_claim->datebilldetail($id);
  		$data['base_bn'] = base_url().BASE_BN;
		$data['basepic'] = base_url().BASE_PIC;
		// echo '<pre>'; print_r($data['Query_billdetil']); exit;
		$this->load->view('viweclaimbill', $data);
	}
 
	function fetch_claimorderlist(){  
	  
		$fetch_data = $this->mdl_claim->make_datatables_claimorderlist();  
		$basepic = base_url().BASE_PIC;
		$data = array(); $index = 1;  $status_bnt = ''; $remark = '';
		foreach($fetch_data as $row){  
			 
			if($row->STATUS_COMPLETE == 0){
				$STATUS_COMPLETE = '<span style="color: #ffc107 ;"> รอการอนุมัติ </span>';
			} else if($row->STATUS_COMPLETE == 1){
				$STATUS_COMPLETE = '<span style="color: #ffc107 ;"> รอการอนุมัติ </span>';
			} else if($row->STATUS_COMPLETE == 2){
				$STATUS_COMPLETE = '<span style="color: #28a745 ;"> อนุมัติสำเร็จ </span>';
			} else if($row->STATUS_COMPLETE == 3){
				$STATUS_COMPLETE = '<span style="color: #f44336 ;"> ยกเลิกรายการ </span>';
				if($row->REMARK != ''){
					$remark = '<b>หมายเหตุ : </b>'.$row->REMARK;
				}
			} else if($row->STATUS_COMPLETE == 4){
				$STATUS_COMPLETE = '<span style="color: #17a2b8 ;"> เคลม </span>';
				if($row->REMARK != ''){
					$remark = '<b>หมายเหตุ : </b>'.$row->REMARK;
				}
			}		
			if($row->STATUS_APPROVE1 == 1){
				$APPROVE1 = '<span style="color: #28a745 ;"> <i class="fa fa-check-circle" aria-hidden="true"></i> </span>';
			} else {
				$APPROVE1 = '<span style="color: #ffc107 ;"> <i class="fa fa-clock-o" aria-hidden="true"></i> </span>';
			}
			if($row->STATUS_APPROVE2 == 1){
				$APPROVE2 = '<span style="color: #28a745 ;"> <i class="fa fa-check-circle" aria-hidden="true"></i> </span>';
			} else {
				$APPROVE2 = '<span style="color: #ffc107 ;"> <i class="fa fa-clock-o" aria-hidden="true"></i> </span>';
			}
			$disabled = '';
			$claim = 'style="display: none;" ';
			if($row->STATUS_COMPLETE == 3){
				$disabled = 'style="display: none;" ';
			}else if($row->STATUS_COMPLETE == 4){
				$disabled = 'style="display: none;" ';
			} else if($row->STATUS_COMPLETE == 2){
				$disabled = 'style="display: none;" ';
				$claim = 'style="display: block;" ';
			}
			if($row->DELIVERY_FORMID == 1){
                $DELIVERYFORMID = 'KERRY';
            } else if($row->DELIVERY_FORMID == 2){
                $DELIVERYFORMID = 'EMS';
            } else if($row->DELIVERY_FORMID == 3){
				$DELIVERYFORMID = 'FLASH';
			} else if($row->DELIVERY_FORMID == 4){
				$DELIVERYFORMID = 'DHL';
			} else if($row->DELIVERY_FORMID == 5){
                $DELIVERYFORMID = 'SCG';
			} 
			
			$style_claim = '';
			$STATUSCLAIM = '';
			if($row->STATUS_COMPLETE == 4){
				if($row->STATUS_CLAIM == 2){
					$style_claim = 'st-claim-4';
					$STATUSCLAIMCOMPLETE = ($row->STATUS_CLAIMCOMPLETE == 1)? '<span> อนุมัติสำเร็จ </span>' : '<span> <i class="fa fa-clock-o" aria-hidden="true"></i> รอการอนุมัติ </span>' ;
					$STATUSCLAIM = '<div class="divstatus-claim"> '.$STATUSCLAIMCOMPLETE.' </div>';
				}
			}
			$sub_array = array();  
			$sub_array[] = "<div class='text-center'>".$index++."</div>";
			$sub_array[] =  '	
							<div class="row '.$style_claim.'">
								<div class="col-sm-5">
									<div class="list-CA001">
										<b>รหัสออเดอร์ : '.$row->CODE.' ('.$row->TextCode.')</b> <br>
										ชื่อ-นามสกุล : '.$row->NAME.' <br> 
										วันที่ : '.thai_date($row->DATE_STARTS).' เวลา : '.date('H:i:s',strtotime($row->DATE_STARTS)).' 
									</div>
								</div>
								<div class="col-sm-5">
									<div class="status-CA001">
										<b>รูปแบบการส่ง : </b>'.$DELIVERYFORMID.'<br>
										'.$remark.' 
										'.$STATUSCLAIM.'
									</div>
								</div>
								<div class="col-sm-2">
									<div class="bnt-CA001" >
										<a href="'.site_url('mod_retailcreateorder/ctl_claim/viweclaimbill?id='.$row->ID).'" class="btn btn-app3 btn-block"> <i class="fa fa-eye" aria-hidden="true"></i> ตรวจสอบ </a>
 									</div>
								</div>
							</div>
							 
							';  
 			$data[] = $sub_array;  
		}  
		$output = array(  
			"draw"             	=>     intval($_POST["draw"]),  
			"recordsTotal"      =>     $this->mdl_claim->get_all_data_claimorderlist(),  
			"recordsFiltered"   =>     $this->mdl_claim->get_filtered_data_claimorderlist(),  
			"data"              =>     $data  
		);  
		 
		echo json_encode($output);  
	}  
	
	public function statusapprove() {
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$returns = $this->mdl_claim->statusapprove();
			$return = json_decode($returns);
			echo $returns;
		}
	}
	    
}
