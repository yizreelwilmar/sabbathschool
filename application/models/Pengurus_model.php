<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengurus_model extends CI_Model
{
    // Ambil data pengurus beserta nama kelompoknya
    public function get_all_pengurus()
    {
        $this->db->select('users.*, kelompok.nama_kelompok');
        $this->db->from('users');
        $this->db->join('kelompok', 'kelompok.id = users.id_kelompok', 'left');
        $this->db->where('users.role', 'pengurus');
        $this->db->order_by('users.id', 'DESC');
        return $this->db->get()->result();
    }

    // Ambil list kelompok untuk Dropdown di Modal
    public function get_list_kelompok()
    {
        return $this->db->get('kelompok')->result();
    }

    public function insert($data)
    {
        return $this->db->insert('users', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('users');
    }
}
