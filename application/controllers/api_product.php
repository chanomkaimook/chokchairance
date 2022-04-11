<?php
defined('BASEPATH') or exit('No direct script access allowed');



require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;


class Api_product extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_product');
        $this->load->library('session');
        $this->load->library('Permiss');
        $this->load->helper(array('form', 'url', 'myfunction_helper', 'sql_helper', 'permiss_helper'));

        $this->model  = $this->mdl_product;
    }


    public function product_post($id = "")
    {

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $tb = $this->uri->segment(3);
        $event = $this->uri->segment(4);

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            if (!$id) {
                $result = array(
                    'error_code'    => 1,
                    'data'          => 'Not found id'
                );
                $this->response($result);
            }
                // 
                //  delete
            if ($event == 'delete') {
                
                $arrayset = array(
                    'id'        => $id,
                    'table'     => $tb
                );
                $result = $this->model->deleteItem($arrayset);
                $this->response($result);

                // 
                //  edit
            } else if ($event == 'edit') {
                $dataarray['name'] = array_keys(array_column($data, 'name'), 'edit_name_th');

                foreach ($dataarray as $key => $val) {
                    if (!$data[$val[0]]->value) {
                        $result = array(
                            'error_code'  => 1,
                            'data'  => 'โปรดระบุ ' . $key
                        );
                        $this->response($result);
                    }
                }

                $arrayset = array(
                    'id'        => $id,
                    'table'     => $tb,
                );
                $result = $this->model->updateItem($arrayset);
                $this->response($result);

            } else {
                $result = array(
                    'error_code'  => 3,
                    'data'  => 'ไม่มีการทำงาน'
                );
                $this->response($result);
            }
        }
        exit;
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //  page event
            $event = $this->uri->segment(3);

            if ($event == 'delete') {
                if (!$id) {
                    $result = array(
                        'error_code'    => 1,
                        'data'          => 'Not found userid'
                    );
                    $this->response($result);
                }

                $result = $this->mdl_staff->deleteStaff($id);
                $this->response($result);
            } else if ($event == 'add') {
                //  get data
                $json = file_get_contents('php://input');
                $data = json_decode($json);

                $dataarray['username'] = array_keys(array_column($data, 'name'), 'add_username');
                $dataarray['password'] = array_keys(array_column($data, 'name'), 'add_password');
                $dataarray['franshine'] = array_keys(array_column($data, 'name'), 'add_franshine_id');

                foreach ($dataarray as $key => $val) {
                    if (!$data[$val[0]]->value) {
                        $result = array(
                            'error_code'  => 1,
                            'data'  => 'โปรดระบุ ' . $key
                        );
                        $this->response($result);
                    }
                }

                //  check duplicate
                if ($dataarray['username']) {
                    $sql = $this->db->from('staff')
                        ->where('username', $data[$dataarray['username'][0]]->value)
                        ->where('status', 1);
                    $q = $sql->get();
                    $num = $q->num_rows();
                    if ($num) {
                        $result = array(
                            'error_code'  => 2,
                            'data'  => 'username มีการใช้งานแล้ว '
                        );
                        $this->response($result);
                    }
                }

                $result = $this->mdl_staff->addStaff();
                $this->response($result);
            } else if ($event == 'edit') {

                //  get data
                $json = file_get_contents('php://input');
                $data = json_decode($json);

                $dataarray['username'] = array_keys(array_column($data, 'name'), 'username');
                $dataarray['password'] = array_keys(array_column($data, 'name'), 'password');
                $dataarray['franshine'] = array_keys(array_column($data, 'name'), 'franshine_id');

                foreach ($dataarray as $key => $val) {
                    if (!$data[$val[0]]->value) {
                        $result = array(
                            'error_code'  => 1,
                            'data'  => 'โปรดระบุ ' . $key
                        );
                        $this->response($result);
                    }
                }

                //  check duplicate
                if ($dataarray['username']) {
                    $sql = $this->db->from('staff')
                        ->where('username', $data[$dataarray['username'][0]]->value)
                        ->where('id !=', $id)
                        ->where('status', 1);
                    $q = $sql->get();
                    $num = $q->num_rows();
                    if ($num) {
                        $result = array(
                            'error_code'  => 2,
                            'data'  => 'username มีการใช้งานแล้ว '
                        );
                        $this->response($result);
                    }
                }

                $result = $this->mdl_staff->updateStaff($id);
                $this->response($result);
            } else {
                $result = array(
                    'error_code'  => 3,
                    'data'  => 'ไม่มีการทำงาน'
                );
                $this->response($result);
            }
        } else {
            $json = file_get_contents('php://input');
            $result = json_decode($json);

            $this->response($result);
        }
    }
}
