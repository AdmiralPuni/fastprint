<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {
    //load sensors model
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelKategori');

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
                $response['status']  = 200;
                $response['data']    = $this->ModelKategori->get();
                $response['message'] = 'Fetch all kategori';
                break;
            case 'POST':
                if(!array_empty_check($data)){
                    $response['message'] = 'Invalid data';
                    break;
                }

                if($this->ModelKategori->insert($data)){
                    $response['status']  = 201;
                    $response['message'] = 'kategori created';
                } else {
                    $response['message'] = 'Failed to create kategori';
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

                if($this->ModelKategori->update($id, $data)){
                    $response['status']  = 200;
                    $response['message'] = 'kategori updated';
                } else {
                    $response['message'] = 'Failed to update kategori';
                }
                break;
            case 'DELETE':
                if($this->ModelKategori->delete($data['id'])){
                    $response['status']  = 200;
                    $response['message'] = 'kategori deleted';
                } else {
                    $response['message'] = 'Failed to delete kategori';
                }
                break;
            default:
                break;
        }

        reply($response);
    }
}
