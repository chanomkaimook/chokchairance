<?php

use phpDocumentor\Reflection\Types\Integer;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product
{
	public function __construct()
	{
			// Assign the CodeIgniter super-object
			$this->TBMAIN = 'retail_productlist';
			$this->DIR = 'supplier';
	}

	//
	//	==================================================
	//		FUNCTION 
	//	==================================================
	//
	//	status complete
	//	@param status	@int = complete bill (receive)
	function get_dataComplete($status)
	{
		switch ($status) {
			case 0:
				$statustext = "รอคลังรับสินค้า";
				break;
			case 1:
				$statustext = "รอคลังรับสินค้า";
				break;
			case 2:
				$statustext = "สำเร็จ";
				break;
			case 3:
				$statustext = "ยกเลิก";
				break;
		}

		$result = array(
			'data' => $statustext
		);

		return $result;
	}

	// 
	//	decode value only id
	//	paramiter text
	//	@param item	@int = product id
	//	@param text	@text = text
	function decodeValue_focus($item,$text){
		//=	 call database	=//
		$ci = &get_instance();
		$ci->load->database();
		//===================//
		//	setting
		$result = array(); 
		$resultdecode = array(); 
		$res = array();

		if($text){
			$resultdecode = $this->decodeValue($text);
		}

		$dataproduct = "";
		if(count($resultdecode)){
			$dataproduct = array_keys(array_column($resultdecode,'id'),$item);
		}
		
		if($dataproduct){
			$result = $resultdecode[$dataproduct[0]];
		}

		return $result;
	}
	// 
	//	decode value
	//	paramiter text
	//	@param text	@text = text
	function decodeValue($text){
		//=	 call database	=//
		$ci = &get_instance();
		$ci->load->database();
		//===================//
		//	setting
		$result = array(); 

		// 
		// ตัวอย่าง [{"id":"4","value":"8"},{"id":"1","value":"5"}]
		// json type (php : json_encode)
		// 

		$array = json_decode($text);

		//	จำนวน
		$total = count($array);
		
		if($total){
			foreach($array as $key => $val){
				//	product cut total
				$product_total = preg_replace('/[^0-9]+/iu', '', $val->value);	//	preg เพื่อเอาเฉพาะเลข ดักพวกคำศัพท์ต่างๆ

				// product id
				$product_id = preg_replace('/[^0-9]+/iu', '', $val->id);
				$product_qry = $this->sqlWhere(array('field'=>'NAME_TH,ID','where' => array('id'=>$product_id)));
				if($product_qry['num']){
					$row_product = $product_qry['data']->row();
					
					//	return
					$result[$key]['id'] = $row_product->ID;
					$result[$key]['name'] = $row_product->NAME_TH;
					$result[$key]['total'] = $product_total;
				} 
				
			}
		}

		return $result;

	}

	// 
	//	sql
	//	paramiter Array
	//	@param field	@array = select field
	//	@param where	@array = condition sql such as array('field'=>value)
	function sqlWhere($array){
		//=	 call database	=//
		$ci = &get_instance();
		$ci->load->database();
		//===================//
		//	setting
		$tb_product = $this->TBMAIN;
		$data = "";

		$results = array(
            'error'     => 1,
            'num'       => "",
            'txt'       => "การส่งข้อมูลไม่ถูกต้อง"
        );
        
        if (!$array['where'] || !$array['field']) {
            return $results;
        }else{
			$sql = $ci->db->select($array['field'])
			->from($tb_product)
			->where('status',1);
			if ($array['where']) {
				$sql->where($array['where'],null,null);
			}
			$num = $ci->db->count_all_results(null, false);
			$data = $sql->get();
		}

        $results = array(
            'error'     => "",
            'num'       => $num,
            'data'       => $data,
            'txt'       => "",
        );

        return $results;
	}

	// 
	//	check data table product
	//	paramiter Array
	//	@param where	@array = condition sql such as array('field'=>value)
	function checkValue($array){
		//=	 call database	=//
		$ci = &get_instance();
		$ci->load->database();
		//===================//
		//	setting
		$tb_product = $this->TBMAIN;

		$results = array(
            'error'     => 1,
            'num'       => "",
            'txt'       => "การส่งข้อมูลไม่ถูกต้อง"
        );
        
        if (!$array['where']) {
            return $results;
        }else{
			$sql = $ci->db->from($tb_product);
			if ($array['where']) {
				$sql->where($array['where'],null,null);
			}
			$num = $ci->db->count_all_results(null, false);
			$q = $sql->get();
		}

        $results = array(
            'error'     => "",
            'num'       => $num,
            'txt'       => "",
        );

        return $results;
	}

	// 
	//	get data product cut on stock (promotion)
	//	paramiter Array
	//	@param id	@int = product id
	function get_dataProductCut($array = array('id'=>null,'list_id'=>null))
	{
		//=	 call database	=//
		$ci = &get_instance();
		$ci->load->database();
		//===================//
		// setting
		$pid =	$array['id'];
		$list =	$array['list_id'];
		$data = array();
		$error = 1;
		$txt = "เกิดข้อผิดพลาด";

		// return 
		$result = array(
			'error'     	=> $error,
            'txt'       	=> $txt,
            'data'       	=> $data
		);

		// check value list_id
		if($pid){
			$arrayset = array(
				'where'		=> array(
					'list_id is not null'	=> null,
					'id'		=> $pid
					)
			);
			$check = $this->checkValue($arrayset);

			//	error check
			if($check['error']){
				$result['error'] = $check['error'];
				$result['txt'] = $check['txt'];

				return $result;
			}

			// decode value
			if($list){
				$json_result = $this->decodeValue($list);
			}else{
				$json_result = $data;
			}

			$result['error'] = "";
			$result['txt'] = "";
			$result['data'] = $json_result;
		}

		return $result;
	}
}
