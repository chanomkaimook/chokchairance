<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', "100M");

defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_excel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setting = array(
			'retail_bill'		=> "retail_bill",
			'retail_billdetail'		=> "retail_billdetail"
		);
	}
	//
	//	เฉพาะอัพโหลดสินค้าเข้า
	//	@param	array		@array = array[ id=>array[codemacitem1,codemacitem2] ]
	//	
	function create_row($array)
	{
		$result = array();
		//
		//	array
		if ($array) {
			$i = 0;
			foreach ($array as $key => $row) {

				$code = trim($array[$key][0]['code']);

				$arraytocheck = array(
					'product_main'		=> trim($array[$key][0]['main'])
				);
				$promain_id = $this->mdl_excel->getID_fromName($arraytocheck);


				$arraytocheck = array(
					'product_submain'		=> trim($array[$key][0]['submain'])
				);
				$prosubmain_id = $this->mdl_excel->getID_fromName($arraytocheck);


				$arraytocheck = array(
					'product_type'		=> trim($array[$key][0]['type'])
				);
				$protype_id = $this->mdl_excel->getID_fromName($arraytocheck);


				$arraytocheck = array(
					'product_category'		=> trim($array[$key][0]['cat'])
				);
				$procate_id = $this->mdl_excel->getID_fromName($arraytocheck);

				$name_th = trim($array[$key][0]['name']);

				$datainsert = array(
					'code'	=> $code,
					'promain_id'	=> $promain_id,
					'prosubmain_id'	=> $prosubmain_id,
					'protype_id'	=> $protype_id,
					'procate_id'	=> $procate_id,
					'name_th'	=> $name_th,

					'user_starts'	=> '00001'	//	page365
				);

				$this->db->insert('retail_productlist', $datainsert);
				$id = $this->db->insert_id();
				if ($id) {
					$i++;
				}
			}
			$result = array(
				'total'	=> $i
			);
		}

		return $result;
	}

	//
	// @param	array = [key => value] key=table, value=name  
	// 
	function getID_fromName($array = array())
	{
		$result = "";
		if (count($array)) {
			foreach ($array as $key => $val) {
				if ($val) {
					$sql = $this->db->select('ID')
						->from($key)
						->where('name_th', trim($val));
					$q = $sql->get();
					$num = $q->num_rows();
					if ($num) {
						$row = $q->row();
						$result = $row->ID;
					}
				}
			}
		}

		return $result;
	}
	//
	//	@param	array		@array = [1005704064] => Array
	/*   (
            [bill] => Array
                (
                    [date] => 27/3/2022
                    [net] => 7.00
                    [pos_id] => 005
                    [code] => 1005704064
                    [price] => 6.54
                    [vat] => 0.46
                    [booth_name] => BOOTH 1
                )

            [bill_item] => Array
                (
                    [0] => Array
                        (
                            [code] => 2001
                            [name] => น้ำดื่มโชคชัย
                            [unit] => ขวด
                            [total] => 1
                            [price] => 7.00
                        )

                )

        )
	*/
	//
	function create_file($file = null,$newname = null)
	{
		$id = "";
		$error_code = 1;
		$txt = 'ไม่มีการทำงาน';
		$table = 'fileupload';

		if ($file) {
			$explode = explode('.',$file); 
			// $code = time().'.'.$explode[1];
			$code = $newname;

			$data = array(
				'code'			=> $code,
				'name'			=> $file,
				'user_starts'	=> $this->session->userdata('useradminid')
			);
			$this->db->insert($table, $data);
			$id = $this->db->insert_id();
			if ($id) {
				$error_code = 0;
				$txt = 'success';

			}
		}

		$result = array(
			'error_code'	=> $error_code,
			'txt'			=> $txt,
			'data'			=> array(
				'id'	=> $id
			)
		);

		return $result;
	}
	function create_bill($array,$fileid)
	{
		//	setting
		// $retail_billdetail = 'retail_billdetail';
		// $retail_bill = 'retail_bill';

		$retail_bill = $this->setting['retail_bill'];
		$retail_billdetail = $this->setting['retail_billdetail'];

		$result = array();
		//
		//	array
		if ($array) {
			$i = 0;
			foreach ($array as $key => $row) {
				//	generate code
				$code = trim($key);

				//	delivery form
				$delivery_formid = 2;		//	BU 2

				//	methodorder
				$methodorder_id = trim($array[$key]['bill']['booth_id']);		// booth id

				//	customer
				$name = "N/A";

				//	price total
				$total_price = sprintf('%0.2f', preg_replace("/([^0-9\\.])/i", "", $array[$key]['bill']['price']));
				$tax = sprintf('%0.2f', preg_replace("/([^0-9\\.])/i", "", $array[$key]['bill']['vat']));
				$net_total = sprintf('%0.2f', preg_replace("/([^0-9\\.])/i", "", $array[$key]['bill']['net']));

				$booth_name = trim($array[$key]['bill']['booth_name']);
				$fileuploadref_id = trim($fileid);

				$status_complete = 2;
				$status_approve1 = 1;
				$status_approve2 = 1;


				//bill status
				$billstatus = "T";

				$pos = trim($array[$key]['bill']['pos_id']);

				//date starts
				$date_starts = trim($array[$key]['bill']['date']);

				$datainsert = array(
					'code'	=> $code,

					'delivery_formid'	=> $delivery_formid,
					'methodorder_id'	=> $methodorder_id,

					'name'				=> $name,

					'total_price'		=> $total_price,
					'tax'				=> $tax,
					'net_total'			=> $net_total,

					'status_approve1'	=> $status_approve1,
					'status_approve2'	=> $status_approve2,
					'status_complete'	=> $status_complete,
					'billstatus'	=> $billstatus,
					'pos'			=> $pos,
					'fileuploadref_id'			=> $fileuploadref_id,
					'station_name'			=> $booth_name,
					'date_upload'	=> date('Y-m-d H:i:s'),
					'date_starts'	=> $date_starts,
					'user_starts'	=> '00002',	//	dumpfile
				);
				$this->db->insert($retail_bill, $datainsert);
				$id = $this->db->insert_id();
				// if($id){
				$i++;	// count 
				foreach ($array[$key]['bill_item'] as $keydetail => $subdetail) {
					$item_code = ($array[$key]['bill_item'][$keydetail]['code'] ? $array[$key]['bill_item'][$keydetail]['code'] : "");
					$item_name = ($array[$key]['bill_item'][$keydetail]['name'] ? $array[$key]['bill_item'][$keydetail]['name'] : "");
					$item_total = ($array[$key]['bill_item'][$keydetail]['total'] ? $array[$key]['bill_item'][$keydetail]['total'] : "");
					$item_unit = ($array[$key]['bill_item'][$keydetail]['unit'] ? $array[$key]['bill_item'][$keydetail]['unit'] : "");
					$item_price = ($array[$key]['bill_item'][$keydetail]['price'] ? sprintf('%0.2f', preg_replace("/([^0-9\\.])/i", "", $array[$key]['bill_item'][$keydetail]['price'])) : "");

					//	แบบเทียบจาก codemac
					$sqlgroup = $this->db->select('*')
						->from('retail_productlist')
						->where('code', $item_code);
					// ->where('codemac',$array_product);
					$qgroup = $sqlgroup->get();
					$numgroup = $qgroup->num_rows();
					if ($numgroup) {
						$rowgroup = $qgroup->row();

						if ($rowgroup->LIST_ID) {
							$list_id = $rowgroup->LIST_ID;
						} else {
							$list_id = null;
						}

						$promotion = null;
						$productset = null;
						if($rowgroup->PROCATE_ID == 3){
							$promotion = 1;
						}
						if($rowgroup->PROCATE_ID == 4){
							$productset = 1;
						}

						$datainsertdetail = array(
							'code'		=> $code,
							'bill_id'	=> $id,

							'promain_id'	=> $rowgroup->PROMAIN_ID,
							'prosubmain_id'	=> $rowgroup->PROSUBMAIN_ID,
							'protype_id'	=> $rowgroup->PROTYPE_ID,
							'procate_id'	=> $rowgroup->PROCATE_ID,
							'prolist_id'	=> $rowgroup->ID,
							'list_id'		=> $list_id,
							'promotion'		=> $promotion,
							'productset'	=> $productset,
							'quantity'		=> $item_total,
							'total_price'	=> $item_price,
							'prounit'		=> $item_unit,

							'date_starts'	=> $date_starts,
							'user_starts'	=> '00002',	//	dumpfile
						);
						$this->db->insert($retail_billdetail, $datainsertdetail);
					}
				}

				// }


			}	/* END INSERT RETAIL_BILL */

			// ============== Log_Detail ============== //
			$log_query = $this->db->last_query();
			$last_id = $this->session->userdata('log_id');
			$detail = "Insert dump bill Code : " . $this->session->userdata('useradminid') . " Name : " . $this->session->userdata('useradminname');
			$type = "Insert";
			$arraylog = array(
				'log_id'  		 => $last_id,
				'detail'  		 => $detail,
				'logquery'       => $log_query,
				'type'     	 	 => $type,
				'date_starts'    => date('Y-m-d H:i:s')
			);
			updateLog($arraylog);

			$result = array(
				'total'	=> $i
			);
		}

		return $result;
	}

	function gencode()
	{
		$retail_bill = $this->setting['retail_bill'];
		$retail_billdetail = $this->setting['retail_billdetail'];

		$this->db->select($retail_bill . '.CODE AS codemax');
		$this->db->from($retail_bill);
		$this->db->order_by($retail_bill . '.ID', 'DESC');
		$Query_Max = $this->db->get();
		$num = $Query_Max->num_rows($Query_Max);
		$RowMax = $Query_Max->row();
		if ($num > 0) {
			$str = explode(" ", $RowMax->codemax);
			$Code = explode("_", $str[1]);
			$codeDB = '';
			$dateY = (date('Y') + 543);
			if ($Code[1] == $dateY) {
				$count = $Code[0] + 1;
				$codeDB = $str[0] . ' ' . $count . '_' . $Code[1];
			} else {
				$Code[0] = 0;
				$count = $Code[0] + 1;
				$codeDB = $str[0] . ' ' . $count . '_' . $dateY;
			}
		} else {
			$dateY = (date('Y') + 543);
			$codeDB = 'Jerky 1_' . $dateY;
		}

		return $codeDB;
	}

	//	find file upload
	function openFile_upload($array = array('date_starts' => ""))
	{
		$table = 'fileupload';
		($array['date_starts'] ? $date = $array['date_starts'] : $date = date('Y-m-d'));

		$sql =	$this->db->select('*')
			->from($table)
			->where('status', 1);
		if ($date) {
			$sql->where('date(date_starts)', $date);
		}
		$q = $sql->get();
		$num = $q->num_rows();
		if ($num) {
			$r = $q;
		} else {
			$r = "";
		}

		return $r;
	}
}
