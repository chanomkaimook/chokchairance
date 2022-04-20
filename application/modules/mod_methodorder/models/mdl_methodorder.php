<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_methodorder extends CI_Model
{

    //---------------------------- creditnote ----------------------------//

    function make_query()
    {
        $request = $_REQUEST;

        $table = 'retail_methodorder';
        $table_sub1 = 'delivery';

        $order_column = array(
            $table . ".ID"
        );

        $this->db->select(
            $table . '.ID as data_id,' .
            $table . '.DELIVERY_ID as data_delivery,' .
            $table . '.TOPIC as data_name,' .
            $table . '.DATE_STARTS as data_date_starts,' .
            $table . '.DATE_UPDATE as data_date_update,' .
            $table . '.USER_STARTS as data_user_starts,' .
            $table . '.USER_UPDATE as data_user_update,' .

            $table_sub1 . '.NAME_TH as data_delivery_name'
        );
        $this->db->from($table);
        $this->db->join($table_sub1,$table.'.delivery_id='.$table_sub1.'.id','left');
        $this->db->where($table.'.status',1);


        if (!empty($request["search"]["value"])) {
            $this->db->like($table . ".TOPIC", $request["search"]["value"]);
        }


        if (!empty($request["valdate"]) && !empty($request["valdateTo"])) {
            $this->db->where('date(' . $table . '.DATE_STARTS) BETWEEN "' . $request["valdate"] . '" and "' . $request["valdateTo"] . '"');
        } else if (!empty($request["valdate"]) || !empty($request["valdateTo"])) {

            if (!empty($request["valdate"])) {
                $this->db->where('date(' . $table . '.DATE_STARTS)', $request["valdate"]);
            }

            if (!empty($request["valdateTo"])) {
                $this->db->where('date(' . $table . '.DATE_STARTS) <="', $request["valdateTo"]);
            }
        }

        if (!empty($request["order"])) {
            $this->db->order_by($order_column[$request['order']['0']['column']], $request['order']['0']['dir']);
        }else{
            $this->db->order_by($table.'.id', 'desc');

        }
    }

    function alldata()
    {
        $request = $_REQUEST;

        $this->make_query();
        $query = $this->db->get();
        $total = $query->num_rows();

        return $total;
    }

    function makedata()
    {
        $request = $_REQUEST;

        $this->make_query();
        if ($request['length'] != -1) {
            $this->db->limit($request['length'], $request['start']);
            // $this->db->limit(50,0);
        }

        $query = $this->db->get();
        return $query;
    }

    //	find user name
    //	@param	code	@text = useradmin code
    function findUsernameByCode($code)
    {
        //=	 call database	=//
        $ci = &get_instance();
        $ci->load->database();
        //===================//
        $username = "";

        $sqluser = $ci->db->select('name_th,name,lastname_th,lastname')
            ->from('staff')
            ->where('staff.code', trim($code));
        $quser = $sqluser->get();
        $numuser = $quser->num_rows();
        if ($numuser) {
            $ruser = $quser->row();

            $username = ($ruser->name_th ? $ruser->name_th." ".$ruser->lastname_th : $ruser->name." ".$ruser->lastname);
        }

        return $username;
    }
}
