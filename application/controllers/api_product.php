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
            if (!$id && $event != 'add') {
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
                $dataarray['name'] = array_keys(array_column($data, 'name'), 'name_th');

                foreach ($dataarray as $key => $val) {
                    if (!$data[$val[0]]->value) {
                        $result = array(
                            'error_code'  => 1,
                            'data'  => 'โปรดระบุ ' . $key
                        );
                        $this->response($result);
                    }
                }

                $arrayset['table'] = $tb;
                $arrayset['data'] = array(
                    'name_th'   => $data[$dataarray['name'][0]]->value
                );
                $result = $this->model->addItem($arrayset);
                $this->response($result);
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

    }
}
