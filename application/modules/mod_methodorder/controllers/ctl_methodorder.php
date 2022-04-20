<?php

use phpDocumentor\Reflection\Types\Integer;

defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_methodorder extends CI_Controller
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
		$this->load->model('mdl_methodorder');
		$this->load->library('session');
		$this->load->library('Permiss');
		$this->load->helper(array('form', 'url', 'myfunction_helper', 'sql_helper', 'permiss_helper'));

		$this->set	= array(
			'namemethod'				=> 'จุดขาย',
			'ctl_name'				=> 'ctl_methodorder',
			'username_session'		=> $this->session->userdata('useradminname'),
			'userid_session'		=> $this->session->userdata('useradminid')
		);
		if ($this->session->userdata('useradminid') == '') {
			redirect('mod_admin/ctl_login');
		}
	}

	public function methodorder()
	{

		$data = array(
			'mainmenu' 		=> 'retail',
			'submenu' 		=> 'retailmethodorder'
		);

		$data['namemethod'] = $this->set['namemethod'];
		$data['base_bn'] = base_url() . BASE_BN;
		$data['basepic'] = base_url() . BASE_PIC;
		$this->load->view('methodorder', $data);
	}

	public function getDataBill()
	{
		if ($this->input->server('REQUEST_METHOD')) {
			$request = $_REQUEST;

			$total = $this->mdl_methodorder->alldata();
			$sql = $this->mdl_methodorder->makedata();

			$data = array();
			$subdata = array();

			//	sql creditnote
			if ($sql->result()) {
				$index = $request['start'] + 1;
				foreach ($sql->result() as $row) {

					// $textdisplay = "<font class='text-bold'>".$row->cn_code." <i class='fas fa-search text-muted'></i></font>";
					$textdisplay = "<a href='" . site_url('mod_methodorder/ctl_methodorder/viewdata?id=' . $row->data_id) . "' target=_blank class='text-bold text-secondary text-md' >" . $row->data_name . " </a>";

					if ($row->data_user_update) {
						$date = thai_date(date('Y-m-d', strtotime($row->data_date_update)));
						$staff = $this->mdl_methodorder->findUsernameByCode($row->data_user_update);
					} else {
						$date = thai_date(date('Y-m-d', strtotime($row->data_date_starts)));
						$staff = $this->mdl_methodorder->findUsernameByCode($row->data_user_starts);
					}

					$rowarray = array();
					$rowarray['DT_RowId'] = $row->sp_id;	//	set row id
					$rowarray['id'] = $index;
					$rowarray['name'] = $textdisplay;
					$rowarray['date'] = $date;
					$rowarray['user'] = $staff;

					$subdata[] = $rowarray;
					$index++;
				}
			}

			$data['draw'] = intval($request['draw']);
			$data['recordsTotal'] = $total;
			$data['recordsFiltered'] = $total;
			$data['data'] = $subdata;

			$result = json_encode($data);
			echo $result;
		}
	}

	public function viewdata()
	{

		$data = array(
			'mainmenu' 		=> 'retail',
			'submenu' 		=> 'retailmethodorder'
		);

		$id = $this->input->get('id');
		$data['method'] = $this->uri->segment(3);

		$data['base_bn'] = base_url() . BASE_BN;
		$data['basepic'] = base_url() . BASE_PIC;
		$this->load->view('viewdata', $data);
	}

	public function editdata()
	{

		$data = array(
			'mainmenu' 		=> 'retail',
			'submenu' 		=> 'retailmethodorder'
		);

		$data['id'] = $this->input->get('id');
		$data['method'] = $this->uri->segment(3);

		$data['base_bn'] = base_url() . BASE_BN;
		$data['basepic'] = base_url() . BASE_PIC;
		$this->load->view('editdata', $data);
	}

	public function add_data()
	{
		$dataresult = array();

		$error_code = 1;
		$txt = "ไม่สามารถทำรายการได้";

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$request = $_REQUEST;
			if (trim($request['name'])) {

				$datainsert = array(
					'name_th'	=> trim($request['name']),
					'date_starts'	=> date('Y-m-d H:i:s'),
					'user_starts'	=> $this->session->userdata('useradminid')
				);

				$this->db->insert('supplier', $datainsert);
				$id = $this->db->insert_id();
				if ($id) {
					$error_code = 0;
					$txt = "ทำรายการสำเร็จ";
				}
			}
		}

		$dataresult = array(
			'error_code' 	=> $error_code,
			'txt'			=> $txt
		);

		$result = json_encode($dataresult);

		echo $result;
	}

	public function update_supplier()
	{
		$dataresult = array();

		$error_code = 1;
		$txt = "ไม่สามารถทำรายการได้";

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$request = $_REQUEST;
			if (trim($request['suppliername']) && $request['bill_id']) {

				$dataupdate = array(
					'name_th'	=> trim($request['suppliername']),
					'date_update'	=> date('Y-m-d H:i:s'),
					'user_update'	=> $this->session->userdata('useradminid')
				);

				$this->db->where('supplier.id', $request['bill_id']);
				$this->db->update('supplier', $dataupdate);

				$error_code = 0;
				$txt = "อัพเดตรายการสำเร็จ";
			}
		}

		$dataresult = array(
			'error_code' 	=> $error_code,
			'txt'			=> $txt
		);

		$result = json_encode($dataresult);

		echo $result;
	}

	//	get data bill to add
	public function get_data()
	{
		if ($this->input->server('REQUEST_METHOD')) {
			$request = $_REQUEST;
			$text = trim($request['bill_id']);

			$result = "";
			$data = array();
			$datadetail = array();
			$datareceivedetail = array();

			if ($text) {
				$table = 'retail_methodorder';
				$table_sub1 = 'delivery';

				$sql = $this->db->select(
					$table . '.ID as data_id,' .
					$table . '.DELIVERY_ID as data_delivery,' .
					$table . '.TOPIC as data_name,' .
					$table . '.DATE_STARTS as data_date_starts,' .
					$table . '.DATE_UPDATE as data_date_update,' .
					$table . '.USER_STARTS as data_user_starts,' .
					$table . '.USER_UPDATE as data_user_update,' .
					$table_sub1 . '.NAME_TH as data_delivery_name'
				)
					->from($table)
					->join($table_sub1,$table.'.delivery_id='.$table_sub1.'.id','left')
					->where($table.'.id', $text)
					->where($table.'.status', 1);
				$q = $sql->get();
				$num = $q->num_rows();

				if ($num) {
					foreach ($q->result() as $r) {
						$data	= array(
							'data_id'	=> trim($r->data_id),

							'data_delivery_name'		=> trim($r->data_delivery_name),
							'data_name'		=> trim($r->data_name),
							'data_date_starts'	=> trim($r->data_date_starts),
							'data_user_starts'		=> (trim($r->data_user_starts) ? $this->mdl_methodorder->findUsernameByCode($r->data_user_starts) : ""),
							'data_date_update'		=> trim($r->data_date_update),
							'data_user_update'		=> (trim($r->data_user_update) ? $this->mdl_methodorder->findUsernameByCode($r->data_user_update) : "")
						);
					}

					$dataresult = array('data' => $data);
					$result = json_encode($dataresult);
				} else {
					$result = json_encode($result);
				}
			}

			echo $result;
		}
	}

	//	cancel bill
	public function cancelBill()
	{
		$dataresult = array();

		$error_code = 1;
		$txt = "ไม่สามารถยกเลิกรายการได้";

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$request = $_REQUEST;
			if ($request['bill_id']) {

				$dataupdate = array(
					'status'	=> 0,
					'date_update'	=> date('Y-m-d H:i:s'),
					'user_update'	=> $this->session->userdata('useradminid')
				);

				$this->db->where('supplier.id', $request['bill_id']);
				$this->db->update('supplier', $dataupdate);

				$error_code = 0;
				$txt = "ยกเลิกรายการสำเร็จ";
			}
		}

		$dataresult = array(
			'error_code' 	=> $error_code,
			'txt'			=> $txt
		);

		$result = json_encode($dataresult);

		echo $result;
	}
	/**
	 * =====================================================================================================
	 * =====================================================================================================
	 * =====================================================================================================
	 */
	public function getData()
	{

		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$return = "";
			$dataresult = array();

			$table = array('table'=>'delivery');

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

		$sql = $this->db->select('ID,NAME_TH')
			->from($table)
			->where($table . '.status', 1);
		$num = $sql->count_all_results(null, false);
		$q = $sql->get();
		if ($num) {
			foreach ($q->result() as $row) {
				$result[] = array(
					'id'	=> $row->ID,
					'name'	=> $row->NAME_TH,
					'count'	=> "",
				);
			}
		}

		return $result;
	}
}
