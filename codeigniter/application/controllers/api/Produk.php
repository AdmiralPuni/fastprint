<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {
    //load sensors model
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelProduk');

        $this->load->helper('global');
        header('Content-Type: application/json');

        //call helper cors check
        if(!cors_check()){
            $response = array(
                'status' => 403,
                'message' => 'Invalid/Expired key',
                'data' => null
            );
            reply($response);
        }
    }

    public function index(){
        $data = json_decode(file_get_contents('php://input'), TRUE);

        $response = array(
            'status' => 400,
            'message' => 'Bad request',
            'data' => null
        );

        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                //if get param with displayWhich set
                $displayWhich = $this->input->get('displayWhich');
                $response['status']  = 200;
                $response['data']    = $this->ModelProduk->get($displayWhich);
                $response['message'] = 'Fetch all produk';
                break;
            case 'POST':
                if(!array_empty_check($data)){
                    $response['message'] = 'Invalid data';
                    break;
                }

                if($this->ModelProduk->insert($data)){
                    $response['status']  = 201;
                    $response['message'] = 'produk created';
                } else {
                    $response['message'] = 'Failed to create produk';
                }
                break;
            case 'PUT':
                $id = $data['id'];

                //unset id from data
                unset($data['id']);

                if(empty($id) || !array_empty_check($data)) {
                    $response['message'] = 'Invalid data';
                    break;
                }

                if($this->ModelProduk->update($id, $data)){
                    $response['status']  = 200;
                    $response['message'] = 'produk updated';
                } else {
                    $response['message'] = 'Failed to update produk';
                }
                break;
            case 'DELETE':
                if($this->ModelProduk->delete($data['id'])){
                    $response['status']  = 200;
                    $response['message'] = 'produk deleted';
                } else {
                    $response['message'] = 'Failed to delete produk';
                }
                break;
            default:
                break;
        }

        reply($response);
    }
}
