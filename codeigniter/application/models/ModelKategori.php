<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelKategori extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = 'kategori';
        $this->load->helper('global');
    }

    public function insert($data){
        if ($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $data){
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id){
        $this->db->where('id', $id);
        if ($this->db->delete($this->table)) {
            return true;
        } else {
            return false;
        }
    }

    public function get(){
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function single($id){
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function get_in($ids){
        $this->db->where_in('id', $ids);
        $query = $this->db->get($this->table);
        return $query->result();
    }
}

?>