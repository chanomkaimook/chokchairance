<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_retailproduct extends CI_Controller
{

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
		$this->load->model('mdl_retailproduct');
		$this->load->model('mdl_sql');
		$this->load->library('session');
		$this->load->library('Permiss');
		$this->load->helper(array('form', 'url', 'myfunction_helper', 'sql_helper', 'permiss_helper'));

		$this->set	= array(
			'max_upload_image'		=> 1000000,		// 1 k = 1000
			'max_size_image'		=> 1920,
			'ctl_name'				=> 'ctl_retailproduct',
			'mainmenu'		        => 'retail',
			'submenu'		        => 'product',
			'username_session'		=> $this->session->userdata('useradminname'),
			'userid_session'		=> $this->session->userdata('useradminid')
		);
		if ($this->session->userdata('useradminid') == '') {
			redirect('mod_admin/ctl_login');
		}
	}

	public function product()
	{
		if (chkPermiss() == 1) {
			redirect('mod_admin/ctl_login');
		}

		$data = array(
			'mainmenu' 		=> $this->set['mainmenu'],
			'submenu' 		=> $this->set['submenu']
		);

		$data['Query_productmain'] = $this->mdl_sql->get_WhereParaqry('retail_productmain', 'status', 1);
		$data['base_bn'] = base_url() . BASE_BN;
		$data['basepic'] = base_url() . BASE_PIC;
		$this->load->view('product', $data);
	}

	public function product_insertmain()
	{
		if (chkPermiss() == 1) {
			redirect('mod_admin/ctl_login');
		}

		$data = array(
			'mainmenu' 		=> $this->set['mainmenu'],
			'submenu' 		=> $this->set['submenu']
		);

		$id = $this->input->get('promain_id');
		$data['Query_productmain'] = $this->mdl_sql->get_WhereTable('retail_productmain');
		$data['UPproductmain'] =  get_WherePara('retail_productmain', 'id', $id);
		$data['base_bn'] = base_url() . BASE_BN;
		$data['base_bn'] = base_url() . BASE_BN;
		$data['basepic'] = base_url() . BASE_PIC;
		$this->load->view('product_insertmain', $data);
	}

	public function product_insertlist()
	{
		if (chkPermiss() == 1) {
			redirect('mod_admin/ctl_login');
		}

		$data = array(
			'mainmenu' 		=> $this->set['mainmenu'],
			'submenu' 		=> $this->set['submenu']
		);

		$id = $this->input->get('prolist_id');
		$data['Query_productmain'] = $this->mdl_sql->get_WhereParaqry('retail_productmain', 'status', 1);
		$data['Query_productsubmain'] = $this->mdl_sql->get_WhereParaqry('product_submain', 'status', 1);
		$data['Query_producttype'] = $this->mdl_sql->get_WhereParaqry('product_type', 'status', 1);
		$data['Query_productcate'] = $this->mdl_sql->get_WhereParaqry('product_category', 'status', 1);
		$data['UPproductlist'] =  get_WherePara('retail_productlist', 'id', $id);
		$data['base_bn'] = base_url() . BASE_BN;
		$data['base_bn'] = base_url() . BASE_BN;
		$data['basepic'] = base_url() . BASE_PIC;
		$this->load->view('product_insertlist', $data);
	}


	function fetch_product()
	{

		//	load library product
		$this->load->library('product');
		/* $arrayset = array(
			'id'		=> 742,
			'list_id'	=> '[(p741):(t2)],[(p739):(t4)]'
		);
		print_r($this->product->get_dataProductCut($arrayset)); */

		$fetch_data = $this->mdl_retailproduct->make_datatables();
		$basepic = base_url() . BASE_PIC;
		$data = array();
		$index = 1;
		$status_bnt = '';
		foreach ($fetch_data as $row) {
			if ($row->RPL_STATUS == 1) {
				$status_bnt = '<li class="fa fa-toggle-on"> </li> Open';
				$bgcolor = 'bg-success';
			} else {
				$status_bnt = '<li class="fa fa-toggle-off"> </li> Off';
				$bgcolor = 'bg-danger';
			}

			$btngroup_manage =	'<div class="text-right form">
									<div class="form-group">
									<a href="' . site_url("mod_retailproduct") . '/ctl_retailproduct/product_insertlist?prolist_id=' . $row->RPL_ID . '" class="btn btn-default btn-sm w-100"> <li class="fa fa-pencil-square-o"> </li>  Edit </a>
									</div>
									<div class="form-group">
									<button type="button" id="editstatus" class="btn btn-sm w-100 ' . $bgcolor . '" value="' . $row->RPL_ID . '"> ' . $status_bnt . ' </button>
									</div>
								</div>';
			//	button
			$manage_check = chkPermissPage('btn_productmanage');
			if ($manage_check == 1) {
				$btngroup_manage = $btngroup_manage;
			} else {
				$btngroup_manage = "";
			}

			// ($row->RPM_ID == 6 ? $colormenu = 'text-success' : $colormenu="");
			$btn_proref = "<button class='btn btn-secondary btn-xs mx-2 btn_promotionref' data-target='.md_proref' data-toggle='modal' data-id='" . $row->RPL_ID . "' >โปรที่ผูก</button>";
			$promotionhook = "";

			if ($row->RPL_PRO) {
				$type_product = "โปรโมชั่น";
				$colormenu = 'text-success';
				$btn_proref = "";
				if (!$row->RPL_LISTID) {
					$promotionhook = "<span class='text-danger'>(ยังไม่ผูกสินค้า)</span>";
				}
			}else if ($row->RPL_SET) {
				$type_product = "สินค้าเซ็ต";
				$colormenu = 'text-primary';
				$btn_proref = "";
				if (!$row->RPL_LISTID) {
					$promotionhook = "<span class='text-danger'>(ยังไม่ผูกสินค้า)</span>";
				}
			} else {
				$type_product = "สินค้า";
				$colormenu = "";
			}

			//
			// get product cut
			if($row->RPL_LISTID){

				$get_prolist = $this->product->get_dataProductCut(array('id'=>$row->RPL_ID,'list_id'=>$row->RPL_LISTID));
			}else{
				$get_prolist = array();
			}

			$prolist = "";
			if(array_key_exists('data',$get_prolist)){
				$setarray = array();
				// print_r($get_prolist);
				foreach($get_prolist['data'] as $key => $val){
					$setarray[] = $val['name']." จำนวน ".$val['total'];
				}

				($setarray ? $prolist = implode(',<br>',$setarray) : $prolist);
			}
			//
			//

			$textmenu = "";
			$textmenu .= "ชื่อ : " . $row->RPL_NAME_TH . $btn_proref . "<br>";
			$textmenu .= "รูปแบบ : <span class='" . $colormenu . "'";
			$textmenu .= "style='font-weight: bold;'>" . $type_product . "</span> <br>";
			$textmenu .= "รหัส(SKU) : <span class='text-success'>" . $row->RPL_ID . "</span> | Code : <span class='text-info'>" . $row->RPL_CODE . "</span> " . $promotionhook . "<br>";
			$textmenu .= "วันที่เพิ่ม : " . thai_date($row->RPL_DATE_STARTS);

			$sub_array = array();
			$sub_array['detail'] = $textmenu;
			$sub_array['price'] = "<div class='text-right'>" . $row->RPL_PRICE . "</div>";
			$sub_array['cut'] = "<div class='text-center'>" . $prolist . "</div>";
			$sub_array['main'] = "<div class='text-center'>" . $row->RPM_NAME_TH . "</div>";
			$sub_array['submain'] = "<div class='text-center'>" . $row->RPS_NAME_TH . "</div>";
			$sub_array['type'] = "<div class='text-center'>" . $row->RPT_NAME_TH . "</div>";
			$sub_array['catalog'] = "<div class='text-center'>" . $row->RPC_NAME_TH . "</div>";
			$sub_array['action'] = "<div class='text-center'>" . $btngroup_manage . "</div>";

			$data[] = $sub_array;
		}
		$output = array(
			"draw"             	=>     intval($_POST["draw"]),
			"recordsTotal"      =>     $this->mdl_retailproduct->get_all_data(),
			"recordsFiltered"   =>     $this->mdl_retailproduct->get_filtered_data(),
			"data"              =>     $data
		);

		echo json_encode($output);
	}

	public function ajaxeditstatus()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$returns = $this->mdl_retailproduct->ajaxeditstatus();
			$return = json_decode($returns);
			echo $returns;
		}
	}

	public function ajaxdataForm()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$returns = $this->mdl_retailproduct->ajaxdataForm();
			$return = json_decode($returns);
			echo $returns;
		}
	}

	public function ajaxdataProlistForm()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('mdl_retailstock');

			$returns = $this->mdl_retailproduct->ajaxdataProlistForm();
			$return = json_decode($returns);
			echo $returns;
		}
	}

	public function get_listPromotionRef()
	{

		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$dataresult = array();

			$sql = $this->db->select('*')
				->from('retail_productlist')
				->where('retail_productlist.list_id', $this->input->get('sku'))
				->where('retail_productlist.status_view', 1)
				->where('retail_productlist.status', 1);
			$num = $sql->count_all_results(null, false);
			$q = $sql->get();
			if ($num) {
				foreach ($q->result() as $row) {
					$dataresult[] = $row->NAME_TH;
				}
			}

			$return = json_encode($dataresult);
			echo $return;
			exit;
		}
	}

	public function getData()
	{

		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$return = "";
			$dataresult = array();

			switch ($this->input->get('ptype')) {
				case 'main':
					$table = array('table' => 'retail_productmain', 'field' => 'promain_id');
					break;
				case 'submain':
					$table = array('table' => 'product_submain', 'field' => 'prosubmain_id');
					break;
				case 'type':
					$table = array('table' => 'product_type', 'field' => 'protype_id');
					break;
				case 'category':
					$table = array('table' => 'product_category', 'field' => 'procate_id');
					break;
				default:
					$table = array('table' => 'retail_productmain', 'field' => 'promain_id');
					break;
			}

			$dataresult = $this->getData_main($table);

			if (count($dataresult)) {
				$return = json_encode($dataresult);
			}

			echo $return;
			exit;
		}
	}

	public function getData_main($arraytable)
	{
		$table = $arraytable['table'];
		$field = $arraytable['field'];
		$sql = $this->db->select('ID,NAME_TH')
			->from($table)
			->where($table . '.status', 1);
		$num = $sql->count_all_results(null, false);
		$q = $sql->get();
		if ($num) {
			foreach ($q->result() as $row) {
				$sqlin = $this->db->from('retail_productlist')
					->where('retail_productlist.' . $field, $row->ID)
					->where('retail_productlist.status', 1);
				$total = $sqlin->count_all_results(null, false);
				$qin = $sqlin->get();

				$result[] = array(
					'id'	=> $row->ID,
					'name'	=> $row->NAME_TH,
					'count'	=> $total,
				);
			}
		}

		return $result;
	}

	public function getProductList()
	{
		$result = array();
		$sql = $this->db->from('retail_productlist')
			->where('retail_productlist.promotion is null')
			->where('retail_productlist.status', 1);
		$total = $sql->count_all_results(null, false);
		$q = $sql->get();
		$num = $q->num_rows();
		if($num){
			foreach($q->result() as $r){
				$result[] = array('id'=>$r->ID,'value'=>$r->NAME_TH);
			}
			
		}

		$results = json_encode($result);

		echo $results;
	}
}
