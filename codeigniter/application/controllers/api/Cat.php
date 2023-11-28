<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cat extends CI_Controller {
    //load sensors model
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Modelcat');
        $this->load->model('Modelsession');

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

    public function get(){
        $data = $this->Modelcat->get();

        $response = array(
            'status' => 200,
            'message' => 'Fetch all cat',
            'data' => $data
        );

        reply($response);
    }

    public function single(){
        $id = $this->input->get('id');

        if(empty($id)){
            $response = array(
                'status' => 400,
                'message' => 'Missing id',
                'data' => null
            );
            reply($response);
        }

        $data = $this->Modelcat->single($id);

        //if there's no data return 404
        if(empty($data)){
            $response = array(
                'status' => 404,
                'message' => 'cat not found',
                'data' => null
            );
        }
        else {
            $response = array(
                'status' => 200,
                'message' => 'Fetch single cat',
                'data' => $data
            );
        }

        reply($response);
    }

    public function create(){
        $data = array(
            'id' => $this->input->post('id'), //id cat
            'nama' => $this->input->post('nama'),
        );

        if(!array_empty_check($data)){
            $response = array(
                'status' => 400,
                'message' => 'Invalid data',
                'data' => $data
            );
            reply($response);
        }

        $status = $this->Modelcat->insert($data);

        if($status){
            $response = array(
                'status' => 201,
                'message' => 'cat created',
                'data' => $status
            );
        } else {
            $response = array(
                'status' => 500,
                'message' => 'Failed to create cat',
                'data' => null
            );
        }

        reply($response);
    }

    public function update(){
        $id = $this->input->post('id');

        $data = array(
            'nama' => $this->input->post('nama')
        );

        if(empty($id) || !array_empty_check($data)) {
            $response = array(
                'status' => 400,
                'message' => 'Invalid data',
                'data' => $data
            );
            reply($response);
        }

        if($this->Modelcat->update($id, $data)){
            $response = array(
                'status' => 200,
                'message' => 'cat updated',
                'data' => null
            );
        } else {
            $response = array(
                'status' => 500,
                'message' => 'Failed to update cat',
                'data' => null
            );
        }

        reply($response);
    }

    public function delete(){
        $id = $this->input->post('id');

        if(empty($id)) {
            $response = array(
                'status' => 400,
                'message' => 'Invalid data',
                'data' => null
            );
            reply($response);
        }

        if($this->Modelcat->delete($id)){
            $response = array(
                'status' => 200,
                'message' => 'cat deleted',
                'data' => null
            );
        } else {
            $response = array(
                'status' => 500,
                'message' => 'Failed to delete cat',
                'data' => null
            );
        }

        reply($response);
    }
}
