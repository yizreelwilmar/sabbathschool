<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelompok_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->order_by('id', 'DESC')->get('kelompok')->result();
    }

    public function insert($data)
    {
        return $this->db->insert('kelompok', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('kelompok', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('kelompok');
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('kelompok', ['id' => $id])->row();
    }
}
