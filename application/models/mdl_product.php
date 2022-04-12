<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Mdl_product extends CI_Model
{

    //
    //  @param  array   @array = [
    //                              table   => @text table name,
    //                              where   => @array [key=>value]
    //                           ]
    function checkValue($array)
    {
        $results = array(
            'error'     => 1,
            'num'       => "",
            'txt'       => "การส่งข้อมูลไม่ถูกต้อง"
        );
        
        if (!$array['table']) {
            return $results;
        }

        $table = $array['table'];
        $sql = $this->db->from($table);
        if ($array['where']) {
            $sql->where($array['where']);
        }
        $num = $this->db->count_all_results(null, false);
        $q = $sql->get();

        $results = array(
            'error'     => 0,
            'num'       => $num,
            'txt'       => "",
        );

        return $results;
    }
    // ====================== EDIT STATUS ========================== //


    function deleteItem($arrayparam)
    {
        $id = $arrayparam['id'];
        $table = $arrayparam['table'];

        switch ($table) {
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

        $tablename = $table['table'];
        $tablefield = $table['field'];

        $rcheck = $this->mdl_product->checkValue(array('table' => 'retail_productlist', 'where' => array($tablefield => $id, 'status' => 1)));
        if ($rcheck['error']) {
            $result = array(
                'id'          => $id,
                'data'        => $rcheck['txt'],
                'error_code'        => 1
            );
            return $result;
        }

        if ($rcheck['num']) {
            $result = array(
                'id'          => $id,
                'data'        => 'มีรายการเชื่อมโยงอยู่ ' . $rcheck['num'] . ' รายการ',
                'error_code'        => 2
            );
            return $result;
        }

        $update = array(
            'status'      => 0,
        );
        $this->db->where('id', $id);
        $this->db->update($tablename, $update);

        // ============== Log_Detail ============== //
        $log_query = $this->db->last_query();
        $last_id = $this->session->userdata('log_id');
        $detail = "Update " . $tablename . " Code : " . $this->session->userdata('useradminid') . " Name : " . $this->session->userdata('useradminname');
        $type = "DELETE";
        $arraylog = array(
            'log_id'            => $last_id,
            'detail'           => $detail,
            'logquery'       => $log_query,
            'type'               => $type,
            'date_starts'    => date('Y-m-d H:i:s')
        );
        updateLog($arraylog);

        if ($this->db->affected_rows()) {
            $result = array(
                'id'          => $id,
                'data'        => $update,
                'error_code'        => 0
            );
        }

        return $result;
    }

    function updateItem($arrayparam)
    {
        $id = $arrayparam['id'];
        $table = $arrayparam['table'];

        switch ($table) {
            case 'main':
                $tablename = 'retail_productmain';
                break;
            case 'submain':
                $tablename = 'product_submain';
                break;
            case 'type':
                $tablename = 'product_type';
                break;
            case 'category':
                $tablename = 'product_category';
                break;
            default:
                $tablename = 'retail_productmain';
                break;
        }

        //  get data
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $arr_name = array_keys(array_column($data, 'name'), 'edit_name_th');

        $update = array(
            'name_th'      => get_valueNullToNull($data[$arr_name[0]]->value),
            'date_update'      => date('Y-m-d H:i:s'),
            'user_update'      => $this->session->userdata('useradminid'),
        );
        $this->db->where('id', $id);
        $this->db->update($tablename, $update);

        // ============== Log_Detail ============== //
        $log_query = $this->db->last_query();
        $last_id = $this->session->userdata('log_id');
        $detail = "Update ".$tablename." Code : " . $this->session->userdata('useradminid') . " Name : " . $this->session->userdata('useradminname');
        $type = "Update";
        $arraylog = array(
            'log_id'            => $last_id,
            'detail'           => $detail,
            'logquery'       => $log_query,
            'type'               => $type,
            'date_starts'    => date('Y-m-d H:i:s')
        );
        updateLog($arraylog);

        if ($this->db->affected_rows()) {
            $result = array(
                'id'          => $id,
                'data'        => $update,
            );
        }

        return $result;
    }

    function addItem($arrayparam)
    {
        $result = array();

        $table = $arrayparam['table'];
        $data = $arrayparam['data'];
        
        switch ($table) {
            case 'main':
                $tablenames = array('table' => 'retail_productmain', 'field' => '');
                break;
            case 'submain':
                $tablenames = array('table' => 'product_submain', 'field' => '');
                break;
            case 'type':
                $tablenames = array('table' => 'product_type', 'field' => '');
                break;
            case 'category':
                $tablenames = array('table' => 'product_category', 'field' => '');
                break;
            default:
                $tablenames = array('table' => 'retail_productmain', 'field' => '');
                break;
        }
        //  check value
        $tablename = $tablenames['table'];

        $rcheck = $this->mdl_product->checkValue(array('table' => $tablename, 'where' => array('name_th' => $data['name_th'], 'status' => 1)));
        if ($rcheck['error']) {
            $result = array(
                'data'        => $rcheck['txt'],
                'error_code'  => $rcheck['error']
            );
            return $result;
        }

        if ($rcheck['num']) {
            $result = array(
                'data'        => 'มีรายการซ้ำ',
                'error_code'  => 2
            );
            return $result;
        }

        $arraysql = array(
            'name_th'      => get_valueNullToNull($data['name_th']),
            'date_starts'      => date('Y-m-d H:i:s'),
            'user_starts'      => $this->session->userdata('useradminid'),
        );
        $this->db->insert($tablename, $arraysql);
        $id = $this->db->insert_id();
        if ($id) {
            // ============== Log_Detail ============== //
            $log_query = $this->db->last_query();
            $last_id = $this->session->userdata('log_id');
            $detail = "Insert ".$tablename." Code : " . $this->session->userdata('useradminid') . " Name : " . $this->session->userdata('useradminname');
            $type = "Insert";
            $arraylog = array(
                'log_id'            => $last_id,
                'detail'           => $detail,
                'logquery'       => $log_query,
                'type'               => $type,
                'date_starts'    => date('Y-m-d H:i:s')
            );
            updateLog($arraylog);

            $result = array(
                'id'          => $id,
                'data'        => $arraysql,
            );
        }

        return $result;
    }
}
