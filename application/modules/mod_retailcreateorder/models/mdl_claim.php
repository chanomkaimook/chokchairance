<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_claim extends CI_Model {
    
    //---------------------------- CREATEORDER ----------------------------//
        var $order_column = array("CODE", "NAME", "TEXT_NUMBER", "NET_TOTAL", "DELIVERY_FORMID");  
        function make_query() {  
            
            $this->db->select('*');  
            $this->db->from('retail_claim'); 
             
            if(!empty($_POST["search"]["value"])) {  
                $this->db->like("retail_claim.CODE", $_POST["search"]["value"]);  
                $this->db->or_like("retail_claim.NAME", $_POST["search"]["value"]);  
                $this->db->or_like("retail_claim.TEXT_NUMBER", $_POST["search"]["value"]);  
                $this->db->or_like("retail_claim.PHONE_NUMBER", $_POST["search"]["value"]); 
                $this->db->or_like("retail_claim.TextCode", $_POST["search"]["value"]);   
            }  
            if(!empty($_POST["order"])) {  
                $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
            } else {  
                $this->db->order_by('retail_claim.DATE_UPDATE', 'DESC'); 
            }  
            
            if(!empty($_POST["valdate"]) && !empty($_POST["valdateTo"])) {  
                $this->db->where('retail_claim.DATE_STARTS BETWEEN "'.$_POST["valdate"]. ' 00:00:00" and "'.$_POST["valdateTo"].' 23:59:59"');  
            } else if(!empty($_POST["valdate"]) && empty($_POST["valdateTo"])) {  
                $this->db->where('retail_claim.DATE_STARTS BETWEEN "'.$_POST["valdate"]. ' 00:00:00" and "'.$_POST["valdate"].' 23:59:59"');  
            } 
    
            if(!empty($_POST["deliveryid"])){
                $this->db->where('retail_claim.DELIVERY_FORMID', $_POST["deliveryid"]); 
            }
    
        }  
        function make_datatables(){  
            $this->make_query();  
            if($_POST["length"] != -1) {  
                $this->db->limit($_POST['length'], $_POST['start']);  
            }  
            
            // echo $this->db->get_compiled_select();
            $query = $this->db->get();  
            return $query->result();  
        }  
        function get_filtered_data(){  
            $this->make_query();  
            $query = $this->db->get();  
            return $query->num_rows();  
        }       
        function get_all_data()  
        {  
            $this->db->select("*");  
            $this->db->from('retail_claim');  
            return $this->db->count_all_results();  
        }  

        // ========================================  //

        function datebilldetail($id){

            $this->db->select('retail_claim.ID AS ID, retail_claim.CODE AS CODE, retail_claim.DELIVERY_FORMID AS DELIVERYFORMID, retail_claim.NAME AS NAME, retail_claim.PHONE_NUMBER AS PHONENUMBER, 
                retail_claim.ADDRESS AS ADDRESS, retail_claim.ZIPCODE AS ZIPCODE, retail_claim.TEXT_NUMBER AS TEXTNUMBER, retail_claim.TOTAL_PRICE AS TOTALPRICE, retail_claim.PARCEL_COST AS PARCELCOST, retail_claim.DELIVERY_FEE AS DELIVERYFEE,
                retail_claim.DISCOUNT_PRICE AS DISCOUNTPRICE, retail_claim.NET_TOTAL AS NETTOTAL, retail_claim.PIC_PAYMENT AS PICPAYMENT, retail_claim.PIC_PAYMENT2 AS PICPAYMENT2, retail_claim.STATUS_APPROVE1 AS STATUSAPPROVE1, 
                retail_claim.STATUS_APPROVE2 AS STATUSAPPROVE2, retail_claim.STATUS_COMPLETE AS STATUSCOMPLETE, retail_claim.REMARK AS REMARK, retail_claim.DATE_STARTS AS DATE_STARTS, retail_claim.STATUS AS BILLSTATUS,
                  
                retail_productmain.ID AS PRONAME_MAINID, retail_productmain.NAME_TH AS PRONAME_MAIN, 
                retail_productlist.ID AS PRONAME_LISTID, retail_productlist.NAME_TH AS PRONAME_LIST, retail_productlist.PRICE AS PRICE, retail_claim.REMARK_ORDER AS REMARKORDER,
                retail_claimdetail.ID AS BD_ID, retail_claimdetail.QUANTITY AS QUANTITY, retail_claimdetail.TOTAL_PRICE AS RBD_TOTALPRICE,
                retail_claim.STATUS_CLAIM AS STATUS_CLAIM, retail_claim.STATUS_CLAIMCOMPLETE AS STATUS_CLAIMCOMPLETE, retail_claim.REMARK_CLAIM AS REMARK_CLAIM,
                retail_claim.USER_STARTS AS USER_STARTS, staff.NAME_TH AS S_NAME_TH, staff.LASTNAME_TH AS S_LASTNAME_TH ,
                retail_bill.TOTAL_PRICE AS 	RC_TOTALPRICE, retail_bill.NET_TOTAL AS RC_NETTOTAL, , retail_bill.SHOR_MONEY AS SHORMONEY, retail_bill.TAX AS TAX,
                retail_methodorder.TOPIC AS METHODORDER_TOPIC, retail_methodorder.ID AS METHODORDER_ID,

                retail_claim.TRANSFERED_BANIK_ID AS BANIKID, bank.NAME_TH AS BANIKNAME, retail_claim.TRANSFERED_DAYTIME AS TRANSFEREDDAYTIME, 
                retail_claim.TRANSFERED_AMOUNT AS TRANSFEREDAMOUNT, retail_claim.TRANSFERED_REMARK AS TRANSFEREDREMARK,
                retail_billimg.ID AS IMGID, retail_billimg.IMGNAME AS IMGNAME,

                retail_claim.BILLSTATUS AS BillStatus_Collect, retail_bill.TextCode as TextCode
            ');
            $this->db->from("retail_claim");
            $this->db->join('retail_claimdetail','retail_claim.ID = retail_claimdetail.CLAIM_ID ','left'); 
            $this->db->join('retail_productmain','retail_claimdetail.PROMAIN_ID = retail_productmain.ID ','left'); 
            $this->db->join('retail_productlist','retail_claimdetail.PROLIST_ID = retail_productlist.ID ','left');
            $this->db->join('staff','retail_claim.USER_STARTS = staff.CODE ','left');
            $this->db->join('retail_bill','retail_claim.BILL_ID = retail_bill.ID ','left');
            $this->db->join('bank','retail_claim.TRANSFERED_BANIK_ID = bank.ID ','left');
            $this->db->join('retail_billimg','retail_claim.BILL_ID = retail_billimg.BILLID ','left');
            $this->db->join('retail_methodorder','retail_bill.METHODORDER_ID = retail_methodorder.ID ','left');
            // $this->db->where("retail_claim.status", 1);
            $this->db->where("retail_productmain.status", 1);
            $this->db->where("retail_productlist.status", 1);
            $this->db->where("retail_claim.ID", $id);
            $Query = $this->db->get();
            
            $items = [];
            foreach($Query->result() AS $row){
                if($row->DELIVERYFORMID == 1){
                    $DELIVERYFORMID = 'KERRY';
                } else if($row->DELIVERYFORMID == 2){
                    $DELIVERYFORMID = 'EMS';
                } else if($row->DELIVERYFORMID == 3){
                    $DELIVERYFORMID = 'FLASH';
                } else if($row->DELIVERYFORMID == 4){
                    $DELIVERYFORMID = 'DHL';
                } else if($row->DELIVERYFORMID == 5){
                    $DELIVERYFORMID = 'SCG';
                } 
                // DATA Bill MAIN //
                $items['ID'] = $row->ID;
                $items['CODE'] = $row->CODE;
                $items['TextCode'] = $row->TextCode;
                $items['DELIVERYFORMID'] = $DELIVERYFORMID;
                $items['DELIVERY_FORM'] = $row->DELIVERYFORMID;
                $items['NAME'] = $row->NAME;
                $items['PHONENUMBER'] = $row->PHONENUMBER;
                $items['ADDRESS'] = $row->ADDRESS;
                $items['ZIPCODE'] = $row->ZIPCODE;
                $items['TEXTNUMBER'] = $row->TEXTNUMBER;
                $items['METHODORDER_TOPIC'] = $row->METHODORDER_TOPIC;
                $items['METHODORDER_ID'] = $row->METHODORDER_ID;
                // ===== NUMBER FORMAT ===== //
                $items['TOTALPRICE'] = number_format($row->RC_TOTALPRICE, 2);
                $items['PARCELCOST'] = number_format($row->PARCELCOST, 2);
                $items['DELIVERYFEE'] = number_format($row->DELIVERYFEE, 2);
                $items['DISCOUNTPRICE'] = number_format($row->DISCOUNTPRICE, 2);
                $items['SHORMONEY'] = number_format($row->SHORMONEY, 2);
                $items['TAX'] = number_format($row->TAX, 2);
                $items['NETTOTAL'] = number_format($row->RC_NETTOTAL, 2);

                //  TRANSFERED //
                $items['BANIKID'] = $row->BANIKID;
                $items['BANIKNAME'] = $row->BANIKNAME;
                
                if($row->TRANSFEREDDAYTIME == '0000-00-00 00:00:00' || $row->TRANSFEREDDAYTIME == NULL){ $TRANSFEREDDAYTIMETHAI = ''; } else { $TRANSFEREDDAYTIMETHAI = thai_date($row->TRANSFEREDDAYTIME)." เวลา ".date('H:i:s',strtotime($row->TRANSFEREDDAYTIME))." น.";}
                $items['TRANSFEREDDAYTIMETHAI'] = $TRANSFEREDDAYTIMETHAI;
                $items['TRANSFEREDDAYTIME'] = $row->TRANSFEREDDAYTIME;
                $items['TRANSFEREDAMOUNT'] = $row->TRANSFEREDAMOUNT;
                $items['TRANSFEREDAMOUNTNumber'] = number_format($row->TRANSFEREDAMOUNT,2);
                $items['TRANSFEREDREMARK'] = $row->TRANSFEREDREMARK;
                
                // ===== ADMIN CRATE BILL ===== //
                $items['USER_STARTS'] = $row->USER_STARTS;
                $items['S_NAME_TH'] = $row->S_NAME_TH;
                $items['S_LASTNAME_TH'] = $row->S_LASTNAME_TH;

                $items['TOTALPRICE_LANG'] = $row->TOTALPRICE;
                $items['PARCELCOST_LANG'] = $row->PARCELCOST;
                $items['DELIVERYFEE_LANG'] = $row->DELIVERYFEE;
                $items['DISCOUNTPRICE_LANG'] = $row->DISCOUNTPRICE;
                $items['SHORMONEY_LANG'] = $row->SHORMONEY;
                $items['NETTOTAL_LANG'] = $row->NETTOTAL;
                // ===== END NUMBER FORMAT ===== // 
    
                $items['PICPAYMENT'] = $row->PICPAYMENT;
                $items['PICPAYMENT2'] = $row->PICPAYMENT2;
                $items['DATE_STARTS'] = thai_date($row->DATE_STARTS);
                $items['DATE_STARTS_strtotime'] = $row->DATE_STARTS;
                $items['BILLSTATUS'] = $row->BILLSTATUS;
                // Bill Status //
                $items['STATUSAPPROVE1'] = $row->STATUSAPPROVE1;
                $items['STATUSAPPROVE2'] = $row->STATUSAPPROVE2;
                $items['STATUSCOMPLETE'] = $row->STATUSCOMPLETE;
                $items['REMARK'] = $row->REMARK;
                $items['REMARKORDER'] = $row->REMARKORDER;

                $items['STATUSCLAIM'] = $row->STATUS_CLAIM;
                $items['STATUSCLAIMCOMPLETE'] = $row->STATUS_CLAIMCOMPLETE;
                $items['REMARKCLAIM'] = $row->REMARK_CLAIM;
                $items['BillStatus_Collect'] = $row->BillStatus_Collect;

                // Bill List //
                $items['billist'][$row->PRONAME_MAINID]['PRONAME_MAINID'] = $row->PRONAME_MAINID;
                $items['billist'][$row->PRONAME_MAINID]['PRONAME_MAIN'] = $row->PRONAME_MAIN;
                $items['billist'][$row->PRONAME_MAINID]['PRONAME_LIST'][$row->PRONAME_LISTID.'-'.$row->QUANTITY]['BILLDETAIL_ID'] = $row->BD_ID;
                $items['billist'][$row->PRONAME_MAINID]['PRONAME_LIST'][$row->PRONAME_LISTID.'-'.$row->QUANTITY]['PRONAME_LISTID'] = $row->PRONAME_LISTID;
                $items['billist'][$row->PRONAME_MAINID]['PRONAME_LIST'][$row->PRONAME_LISTID.'-'.$row->QUANTITY]['PRONAME_LIST'] = $row->PRONAME_LIST;
                $items['billist'][$row->PRONAME_MAINID]['PRONAME_LIST'][$row->PRONAME_LISTID.'-'.$row->QUANTITY]['PRICE'] =  number_format($row->PRICE, 2);
                $items['billist'][$row->PRONAME_MAINID]['PRONAME_LIST'][$row->PRONAME_LISTID.'-'.$row->QUANTITY]['QUANTITY'] =  number_format($row->QUANTITY);
                $items['billist'][$row->PRONAME_MAINID]['PRONAME_LIST'][$row->PRONAME_LISTID.'-'.$row->QUANTITY]['RBD_TOTALPRICE'] =  number_format($row->RBD_TOTALPRICE, 2);
                $items['billist'][$row->PRONAME_MAINID]['PRONAME_LIST'][$row->PRONAME_LISTID.'-'.$row->QUANTITY]['RBD_TOTALPRICE_LANG'] = $row->RBD_TOTALPRICE;

                // IMG Multiple //
                $items['IMGNAME'][$row->IMGID]['IMGNAME_ID'] = $row->IMGID;
                $items['IMGNAME'][$row->IMGID]['IMGNAME_NAME'] = $row->IMGNAME;
            }
            
            // echo '<pre>'; print_r($items); exit;
            $data =  $items;
            return $data;
        }

        //---------------------------- CLAIM LIST ----------------------------//
        var $order_columncalaim= array("CODE", "NAME", "TEXT_NUMBER", "NET_TOTAL", "DELIVERY_FORMID");  
        function make_queryclaim() {  
            
            $this->db->select('*');  
            $this->db->from('retail_claim'); 
            $this->db->where('retail_claim.STATUS_CLAIM', 2); 
            $this->db->where('retail_claim.STATUS_CLAIMCOMPLETE != 1');
             
            if(!empty($_POST["search"]["value"])) {  
                $this->db->like("retail_claim.CODE", $_POST["search"]["value"]);  
                $this->db->or_like("retail_claim.NAME", $_POST["search"]["value"]);  
                $this->db->or_like("retail_claim.TEXT_NUMBER", $_POST["search"]["value"]);  
                $this->db->or_like("retail_claim.PHONE_NUMBER", $_POST["search"]["value"]);  
            }  
            if(!empty($_POST["order"])) {  
                $this->db->order_by($this->order_columncalaim[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
            } else {  
                $this->db->order_by('retail_claim.DATE_STARTS', 'DESC');  
            }  
            
            if(!empty($_POST["valdate"]) && !empty($_POST["valdateTo"])) {  
                $this->db->where('retail_claim.DATE_STARTS BETWEEN "'.$_POST["valdate"]. ' 00:00:00" and "'.$_POST["valdateTo"].' 23:59:59"');  
            } else if(!empty($_POST["valdate"]) && empty($_POST["valdateTo"])) {  
                $this->db->where('retail_claim.DATE_STARTS BETWEEN "'.$_POST["valdate"]. ' 00:00:00" and "'.$_POST["valdate"].' 23:59:59"');  
            } 
    
            if(!empty($_POST["deliveryid"])){
                $this->db->where('retail_claim.DELIVERY_FORMID', $_POST["deliveryid"]); 
            }
    
        }  
        function make_datatables_claimorderlist(){  
            $this->make_queryclaim();  
            if($_POST["length"] != -1) {  
                $this->db->limit($_POST['length'], $_POST['start']);  
            }  
            
            // echo $this->db->get_compiled_select();
            $query = $this->db->get();  
            return $query->result();  
        }  
        function get_filtered_data_claimorderlist(){  
            $this->make_queryclaim();  
            $query = $this->db->get();  
            return $query->num_rows();  
        }       
        function get_all_data_claimorderlist()  
        {  
            $this->db->select("*");  
            $this->db->from('retail_claim');  
            return $this->db->count_all_results();  
        }  

        // ========================================  //

        function statusapprove(){
            $billID = $this->input->post('id');
            $bntVAL = $this->input->post('val');

            $this->db->select('*');
            $this->db->from('retail_claim');
            $this->db->where('retail_claim.ID', $billID);
            $Query = $this->db->get();
            $row = $Query->row();

            // ============== Update Status อนุมัติการเคลม =============== //
            $data = array(
                'STATUS_CLAIMCOMPLETE' => 1, 
                'DATE_UPDATE'       => date('Y-m-d H:i:s') ,
                'USER_UPDATE' 	    => $this->session->userdata('useradminid')
            );
            $this->db->where('ID', $row->ID);
            $this->db->update('retail_claim', $data);
            // ============== Update TBL retail_bill =============== //
            $data = array(
                'STATUS_COMPLETE' => 2, 
                'STATUS' => 1,
                'DATE_UPDATE'       => date('Y-m-d H:i:s') ,
                'USER_UPDATE' 	    => $this->session->userdata('useradminid')
            );
            $this->db->where('ID', $row->BILL_ID);
            $this->db->update('retail_bill', $data);

            $this->db->select('*');
            $this->db->from('retail_billdetail');
            $this->db->where('retail_billdetail.BILL_ID', $row->BILL_ID);
            $QueryDetail = $this->db->get();
            foreach($QueryDetail->result() AS $row){
                $data = array(
                    'STATUS' => 1,
                    'DATE_UPDATE'       => date('Y-m-d H:i:s') ,
                    'USER_UPDATE' 	    => $this->session->userdata('useradminid')
                );
                $this->db->where('BILL_ID', $row->BILL_ID);
                $this->db->update('retail_billdetail', $data);
            }
            $data = array(
                'error_code' => 0,
                'txt' => 'ตรวจสอบรายการเคลมสำเร็จ'
            );
            $data = json_encode($data);
            return $data;
        }
}
?>