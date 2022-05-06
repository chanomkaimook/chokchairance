<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_retailproduct extends CI_Model
{

    //---------------------------- DATATABLE ----------------------------//
    var $order_column = array(null,"RPL_PRICE", null , "RPM_NAME_TH", "RPS_NAME_TH", "RPT_NAME_TH", "RPC_NAME_TH",null);
    function make_query()
    {

        $this->db->select('
            retail_productlist.NAME_TH AS RPL_NAME_TH, retail_productlist.NAME_US AS RPL_NAME_US, retail_productlist.STATUS AS RPL_STATUS,
            retail_productlist.DATE_STARTS AS RPL_DATE_STARTS, retail_productlist.ID AS RPL_ID, retail_productlist.CODE AS RPL_CODE,
            retail_productlist.list_id AS RPL_LISTID, retail_productlist.CODEMAC AS RPL_CM,

            retail_productmain.ID AS RPM_ID, 
            retail_productmain.NAME_TH AS RPM_NAME_TH, 

            product_submain.ID AS RPS_ID, 
            product_submain.NAME_TH AS RPS_NAME_TH, 

            product_type.ID AS RPT_ID, 
            product_type.NAME_TH AS RPT_NAME_TH, 

            product_category.ID AS RPC_ID, 
            product_category.NAME_TH AS RPC_NAME_TH, 

            retail_productlist.price AS RPL_PRICE,
            retail_productlist.promotion AS RPL_PRO,
            retail_productlist.productset AS RPL_SET,
            retail_productlist.promain_id AS RPL_MAIN,
            retail_productlist.prosubmain_id AS RPL_SUBMAIN,
            retail_productlist.protype_id AS RPL_TYPE,
            retail_productlist.procate_id AS RPL_CATE
        ');
        $this->db->from('retail_productlist');
        $this->db->join('retail_productmain', "retail_productlist.PROMAIN_ID = retail_productmain.ID", 'left');
        $this->db->join('product_submain', "retail_productlist.PROSUBMAIN_ID = product_submain.ID", 'left');
        $this->db->join('product_type', "retail_productlist.PROSUBMAIN_ID = product_type.ID", 'left');
        $this->db->join('product_category', "retail_productlist.PROCATE_ID = product_category.ID", 'left');
        $this->db->where('retail_productlist.STATUS_VIEW', 1);    //  for show 

        if (!empty($_POST["search"]["value"])) {
            $this->db->where(
                "(retail_productmain.NAME_TH like '%" . $_POST["search"]["value"] . "%'
                or retail_productmain.NAME_US like '%" . $_POST["search"]["value"] . "%'
                or retail_productlist.NAME_TH like '%" . $_POST["search"]["value"] . "%'
                or retail_productlist.NAME_US like '%" . $_POST["search"]["value"] . "%'
                or retail_productlist.CODE like '" . $_POST["search"]["value"] . "'
                or retail_productlist.ID like '" . $_POST["search"]["value"] . "'
                )",
                null,
                null
            );
            /* $this->db->like("retail_productmain.NAME_TH", $_POST["search"]["value"]);  
           $this->db->or_like("retail_productmain.NAME_US", $_POST["search"]["value"]);  
           $this->db->or_like("retail_productlist.NAME_TH", $_POST["search"]["value"]);  
           $this->db->or_like("retail_productlist.NAME_US", $_POST["search"]["value"]);  */
        }

        if (!empty($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('retail_productlist.ID', 'DESC');
        }

        if (!empty($_POST["keyword"])) {
            $this->db->like("retail_productmain.NAME_TH", $_POST["selectproductmain"]);
            $this->db->or_like("retail_productmain.NAME_US", $_POST["selectproductmain"]);
            $this->db->or_like("retail_productlist.NAME_TH", $_POST["selectproductmain"]);
            $this->db->or_like("retail_productlist.NAME_US", $_POST["selectproductmain"]);
        }

        if (!empty($_POST["selectproductmain"])) {
            $this->db->where('retail_productmain.ID', $_POST["selectproductmain"]);
        }
        if (!empty($_POST["selectproductsubmain"])) {
            $this->db->where('product_submain.ID', $_POST["selectproductsubmain"]);
        }
        if (!empty($_POST["selectproducttype"])) {
            $this->db->where('product_type.ID', $_POST["selectproducttype"]);
        }
        if (!empty($_POST["selectproductcate"])) {
            $this->db->where('product_category.ID', $_POST["selectproductcate"]);
        }

        if (!empty($_POST["status"])) {
            $status = $_POST["status"];
            if ($_POST["status"] == 'off') {
                $status = '0';
            }
            $this->db->where('retail_productlist.STATUS', $status);
        }
    }
    function make_datatables()
    {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        // echo $this->db->get_compiled_select();
        $query = $this->db->get();
        return $query->result();
    }
    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_all_data()
    {
        $this->db->select("*");
        $this->db->from('retail_productmain');
        return $this->db->count_all_results();
    }
    // ====================== EDIT STATUS ========================== //

    function ajaxeditstatus()
    {
        $id = $this->input->post('id');
        $status_chk = '';
        $this->db->select('retail_productlist.STATUS AS STATUS');
        $this->db->from('retail_productlist');
        $this->db->where('retail_productlist.ID', $id);
        // echo $this->db->get_compiled_select();
        $Query  = $this->db->get();
        $row = $Query->row();

        if ($row->STATUS == 1) {
            $data = array('status' => 0);
        } else {
            $data = array('status' => 1);
        }
        $status_product = $data['status'];
        $status_producttxt = '';
        if ($status_product == 1) {
            $status_producttxt = 'Open';
        } else {
            $status_producttxt = 'Off';
        }

        $this->db->where('id', $id);
        $this->db->update('retail_productlist', $data);

        // ============== Log_Detail ============== //
        $log_query = $this->db->last_query();
        $last_id = $this->session->userdata('log_id');
        $detail = "Update Status product To " . $status_producttxt . " Code : " . $this->session->userdata('useradminid') . " Name : " . $this->session->userdata('useradminname');
        $type = "Update";
        $arraylog = array(
            'log_id'            => $last_id,
            'detail'           => $detail,
            'logquery'       => $log_query,
            'type'               => $type,
            'date_starts'    => date('Y-m-d H:i:s')
        );
        updateLog($arraylog);
        $code = 0;
        $txt = "";

        $data = array(
            "error_code"         => "",
            "txt"                 => $status_producttxt
        );
        $data = json_encode($data);
        return $data;
    }

    function ajaxdataForm()
    {

        if ($this->input->post('name_th') != "") {
            if ($this->input->post('promain_id') != '') {
                $data = array(
                    'NAME_TH'             => get_valueNullToNull(trim($this->input->post('name_th'))),
                    'NAME_US'             => get_valueNullToNull(trim($this->input->post('name_us'))),

                    'date_update'     => date('Y-m-d H:i:s'),
                    'user_update'     => $this->session->userdata('useradminid'),
                    'status'         => $this->input->post('status')
                );
                $this->db->where('id', $this->input->post('promain_id'));
                $this->db->update('retail_productmain', $data);

                // ============== Log_Detail ============== //
                $log_query = $this->db->last_query();
                $last_id = $this->session->userdata('log_id');
                $detail = "Update Productmain Code : " . $this->session->userdata('useradminid') . " Name : " . $this->session->userdata('useradminname');
                $type = "Update";
                $arraylog = array(
                    'log_id'            => $last_id,
                    'detail'           => $detail,
                    'logquery'       => $log_query,
                    'type'               => $type,
                    'date_starts'    => date('Y-m-d H:i:s')
                );
                updateLog($arraylog);
                $code = 0;
                $txt = "Update Success";
            } else {
                $data = array(
                    'NAME_TH'             => get_valueNullToNull(trim($this->input->post('name_th'))),
                    'NAME_US'             => get_valueNullToNull(trim($this->input->post('name_us'))),

                    'date_starts'     => date('Y-m-d H:i:s'),
                    'user_starts'     => $this->session->userdata('useradminid'),
                    'status'         => $this->input->post('status')
                );
                $this->db->insert('retail_productmain', $data);
                $last_promoteid = $this->db->insert_id();
                // ============== Log_Detail ============== //
                $log_query = $this->db->last_query();
                $last_id = $this->session->userdata('log_id');
                $detail = "Insert Productmain Code : " . $this->session->userdata('useradminid') . " Name : " . $this->session->userdata('useradminname');
                $type = "Insert";
                $arraylog = array(
                    'log_id'            => $last_id,
                    'detail'           => $detail,
                    'logquery'       => $log_query,
                    'type'               => $type,
                    'date_starts'    => date('Y-m-d H:i:s')
                );
                updateLog($arraylog);
                $code = 0;
                $txt = "Insert Success";
            }
        } else {
            $code = 1;
            $txt = "ERROR";
        }

        $data = array(
            "error_code"         => "",
            "txt"                 => $txt,
        );

        $data = json_encode($data);
        return $data;
    }

    function ajaxdataProlistForm()
    {
        if ($this->input->post('name_th') != "") {
            if ($this->input->post('prolist_id') != '') {
                
                $codechk = get_valueNullToNull(trim($this->input->post('code')));
                if ($codechk) {
                    $sqlcheck = $this->db->select('ID')
                        ->from('retail_productlist')
                        ->where('id !=', $this->input->post('prolist_id'))
                        ->where('status_view', 1)
                        ->where('code', $codechk);
                    $qcheck = $sqlcheck->get();
                    $numcheck = $qcheck->num_rows();
                    if ($numcheck) {
                        $data = array(
                            "error_code"        => 1,
                            "txt"               => 'code '.$codechk.' ซ้ำในระบบ',
                            "getid"             => $this->input->post('prolist_id')
                        );

                        $data = json_encode($data);
                        return $data;
                    }
                }

                //  ตรวจสอบสินค้าที่ผูกกับโปร
                $is_promotion = null;
                $is_productset = null;
                $sqlhook = $this->db->select('list_id,promotion,productset')
                    ->from('retail_productlist')
                    ->where('id', $this->input->post('prolist_id'));
                $qhook = $sqlhook->get();
                $numhook = $qhook->num_rows();
                if ($numhook) {
                    $rhook = $qhook->row();

                    $list_old = $rhook->list_id ? $rhook->list_id : null;
                    $is_promotion = $rhook->promotion ? $rhook->promotion : null;
                    $is_productset = $rhook->productset ? $rhook->productset : null;
                }

                $status = $this->input->post('status');
                $status_view = 1;

                if ($status == 3) {
                    $status = 0;
                    $status_view = 0;
                }

                if (trim($this->input->post('listid'))) {
                    $listid = trim($this->input->post('listid'));
                } else {
                    $listid = null;
                }

                // ระบุ promotion
                $promotion = "";
                $productset = "";
                if(trim($this->input->post('procate_id')) == 3){
                   $promotion = 1;
                }

                if(trim($this->input->post('procate_id')) == 4){
                    $productset = 1;
                 }

                if($this->input->post('product_cut')){
                    $product_cut = json_encode($_REQUEST['product_cut']);
                }else{
                    $product_cut = null;
                }

                $data = array(
                    'NAME_TH'             => get_valueNullToNull(trim($this->input->post('name_th'))),
                    'NAME_US'             => get_valueNullToNull(trim($this->input->post('name_us'))),

                    'PROMAIN_ID'             => get_valueNullToNull(trim($this->input->post('promain_id'))),
                    'PROSUBMAIN_ID'             => get_valueNullToNull(trim($this->input->post('prosubmain_id'))),
                    'PROTYPE_ID'             => get_valueNullToNull(trim($this->input->post('protype_id'))),
                    'PROCATE_ID'             => get_valueNullToNull(trim($this->input->post('procate_id'))),

                    'PROMOTION'             => get_valueNullToNull($promotion),
                    'PRODUCTSET'             => get_valueNullToNull($productset),

                    'LIST_ID'             => get_valueNullToNull($product_cut),
                    'PRICE'             => (trim($this->input->post('price')) ? number_format(trim($this->input->post('price')),2) : '0.00') ,
                    'CODE'             => get_valueNullToNull(trim($this->input->post('code'))),

                    'date_update'     => date('Y-m-d H:i:s'),
                    'user_update'     => $this->session->userdata('useradminid'),
                    'status_view'     => $status_view,
                    'status'         => $status
                );

                $this->db->where('id', $this->input->post('prolist_id'));
                $this->db->update('retail_productlist', $data);

                //
                //  update bill
                $dataupdate = array();
                if ($list_old != $product_cut) {
                    $dataupdate['list_id'] = $product_cut;
                }
                $dataupdate['promotion'] = $is_promotion;
                $dataupdate['productset'] = $is_productset;

                if($dataupdate){
                    $this->db->where('prolist_id', $this->input->post('prolist_id'));
                    $this->db->where('status', 1);
                    $this->db->update('retail_billdetail', $dataupdate);
                }
                //
                //

                // ============== Log_Detail ============== //
                $log_query = $this->db->last_query();
                $last_id = $this->session->userdata('log_id');
                $detail = "Update Product List Code : " . $this->session->userdata('useradminid') . " Name : " . $this->session->userdata('useradminname');
                $type = "Update";
                $arraylog = array(
                    'log_id'            => $last_id,
                    'detail'           => $detail,
                    'logquery'       => $log_query,
                    'type'               => $type,
                    'date_starts'    => date('Y-m-d H:i:s')
                );
                updateLog($arraylog);
                $code = 0;
                $txt = "Update Success";
                $getid = $this->input->post('prolist_id');
            } else {
                $codechk = get_valueNullToNull(trim($this->input->post('code')));
                if ($codechk) {
                    $sqlcheck = $this->db->select('ID')
                        ->from('retail_productlist')
                        ->where('status_view', 1)
                        ->where('code', $codechk);
                    $qcheck = $sqlcheck->get();
                    $numcheck = $qcheck->num_rows();
                    if ($numcheck) {
                        $data = array(
                            "error_code"        => 1,
                            "txt"               => 'code '.$codechk.' ซ้ำในระบบ',
                            "getid"             => $this->input->post('prolist_id')
                        );

                        $data = json_encode($data);
                        return $data;
                    }
                }

                // ระบุ promotion
                if(trim($this->input->post('procate_id')) == 3){
                    $promotion = 1;
                 }else{
                    $promotion = "";
                 }

                $data = array(
                    'NAME_TH'             => get_valueNullToNull(trim($this->input->post('name_th'))),
                    'NAME_US'             => get_valueNullToNull(trim($this->input->post('name_us'))),

                    'PROMAIN_ID'             => get_valueNullToNull(trim($this->input->post('promain_id'))),
                    'PROSUBMAIN_ID'             => get_valueNullToNull(trim($this->input->post('prosubmain_id'))),
                    'PROTYPE_ID'             => get_valueNullToNull(trim($this->input->post('protype_id'))),
                    'PROCATE_ID'             => get_valueNullToNull(trim($this->input->post('procate_id'))),

                    'PROMOTION'             => $promotion,

                    'PRICE'             => (trim($this->input->post('price')) ? number_format(trim($this->input->post('price')),2) : '0.00'),
                    'CODE'             => get_valueNullToNull(trim($this->input->post('code'))),

                    'date_starts'     => date('Y-m-d H:i:s'),
                    'user_starts'     => $this->session->userdata('useradminid'),
                    'status'         => $this->input->post('status')
                );
                $this->db->insert('retail_productlist', $data);
                $last_productlist = $this->db->insert_id();
                // ============== Log_Detail ============== //
                $log_query = $this->db->last_query();
                $last_id = $this->session->userdata('log_id');
                $detail = "Insert Product List Code : " . $this->session->userdata('useradminid') . " Name : " . $this->session->userdata('useradminname');
                $type = "Insert";
                $arraylog = array(
                    'log_id'            => $last_id,
                    'detail'           => $detail,
                    'logquery'       => $log_query,
                    'type'               => $type,
                    'date_starts'    => date('Y-m-d H:i:s')
                );
                updateLog($arraylog);
                $code = 0;
                $txt = "Insert Success";
                $getid = $last_productlist;
            }
        } else {
            $code = 1;
            $txt = "ERROR";
            $getid = 0;
        }

        $data = array(
            "error_code"         => "",
            "txt"                 => $txt,
            "getid"             => $getid
        );

        $data = json_encode($data);
        return $data;
    }
}
