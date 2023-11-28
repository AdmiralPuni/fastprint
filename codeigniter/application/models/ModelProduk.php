<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelProduk extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = 'produk';
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

    public function get($displayWhich = 1){
        //join on kategori and status for nama kategori and nama status
        $this->db->select('produk.*, kategori.nama as nama_kategori, status.nama as nama_status');
        $this->db->from($this->table);
        $this->db->join('kategori', 'kategori.id = produk.kategori_id');
        $this->db->join('status', 'status.id = produk.status_id');
        //1 is when status id is 1, 2 is when status id is 2, 3 for all
        if($displayWhich == 1 || $displayWhich == 2){
            $this->db->where('produk.status_id', $displayWhich);
        }
        $query = $this->db->get();
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