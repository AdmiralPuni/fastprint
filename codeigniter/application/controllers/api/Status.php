<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller {
    //load sensors model
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelStatus');

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
                $response['data']    = $this->ModelStatus->get();
                $response['message'] = 'Fetch all status';
                break;
            case 'POST':
                if(!array_empty_check($data)){
                    $response['message'] = 'Invalid data';
                    break;
                }

                if($this->ModelStatus->insert($data)){
                    $response['status']  = 201;
                    $response['message'] = 'status created';
                } else {
                    $response['message'] = 'Failed to create status';
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

                if($this->ModelStatus->update($id, $data)){
                    $response['status']  = 200;
                    $response['message'] = 'status updated';
                } else {
                    $response['message'] = 'Failed to update status';
                }
                break;
            case 'DELETE':
                if($this->ModelStatus->delete($data['id'])){
                    $response['status']  = 200;
                    $response['message'] = 'status deleted';
                } else {
                    $response['message'] = 'Failed to delete status';
                }
                break;
            default:
                break;
        }

        reply($response);
    }
}
