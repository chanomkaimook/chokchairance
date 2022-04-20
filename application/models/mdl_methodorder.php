<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Mdl_methodorder extends CI_Model
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
        $tablename = $arrayparam['table'];


        /* $rcheck = $this->checkValue(array('table' => 'retail_bill', 'where' => array('methodorder_id' => $id, 'status' => 1)));
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
        } */

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

        $tablename = $arrayparam['table'];
        //  get data
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $arr_name = array_keys(array_column($data, 'name'), 'name');
        $arr_delivery_id = array_keys(array_column($data, 'name'), 'delivery_id');

        $rcheck = $this->checkValue(array('table' => $tablename, 'where' => array('topic' => get_valueNullToNull($data[$arr_name[0]]->value), 'status' => 1)));
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

        $update = array(
            'delivery_id'      => get_valueNullToNull($data[$arr_delivery_id[0]]->value),
            'topic'             => get_valueNullToNull($data[$arr_name[0]]->value),
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

        $data = $arrayparam['data'];
    
        //  check value
        $tablename = $arrayparam['table'];

        $rcheck = $this->checkValue(array('table' => $tablename, 'where' => array('topic' => $data['name'], 'status' => 1)));
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
            'delivery_id'      => get_valueNullToNull($data['delivery_id']),
            'topic'             => get_valueNullToNull($data['name']),
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
