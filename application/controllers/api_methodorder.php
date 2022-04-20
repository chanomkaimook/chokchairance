<?php
defined('BASEPATH') or exit('No direct script access allowed');



require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;


class Api_methodorder extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_methodorder');
        $this->load->library('session');
        $this->load->library('Permiss');
        $this->load->helper(array('form', 'url', 'myfunction_helper', 'sql_helper', 'permiss_helper'));

        $this->model  = $this->mdl_methodorder;
    }


    public function method_post($id = "")
    {

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $event = $this->uri->segment(3);
        $tb = 'retail_methodorder';

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            if ($id == "" && $event != 'add') {
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
                //  add
            }  else if ($event == 'add') {
                $dataarray['bu'] = array_keys(array_column($data, 'name'), 'delivery_id');
                $dataarray['name'] = array_keys(array_column($data, 'name'), 'name');

                foreach ($dataarray as $key => $val) {
                    if (!$data[$val[0]]->value || empty(trim($data[$val[0]]->value))) {
                        $result = array(
                            'error_code'  => 1,
                            'data'  => 'โปรดระบุ ' . $key
                        );
                        $this->response($result);
                    }
                }

                $arrayset['table'] = $tb;
                $arrayset['data'] = array(
                    'delivery_id'   => $data[$dataarray['bu'][0]]->value,
                    'name'   => $data[$dataarray['name'][0]]->value
                );
                $result = $this->model->addItem($arrayset);
                $this->response($result);
            } else if ($event == 'edit') {
                $dataarray['bu'] = array_keys(array_column($data, 'name'), 'delivery_id');
                $dataarray['name'] = array_keys(array_column($data, 'name'), 'name');

                foreach ($dataarray as $key => $val) {
                    if (!$data[$val[0]]->value || empty(trim($data[$val[0]]->value))) {
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
    }
}
