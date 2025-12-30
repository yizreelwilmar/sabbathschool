<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota_model extends CI_Model
{
    public function get_group_stats()
    {
        $this->db->select('k.*, COUNT(a.id) as total_anggota');
        $this->db->from('kelompok k');
        $this->db->join('anggota a', 'a.id_kelompok = k.id AND a.status = "aktif"', 'left');
        $this->db->group_by('k.id');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('anggota', ['id' => $id])->row();
    }

    public function count_members($id_kelompok, $keyword = null)
    {
        $this->db->where('id_kelompok', $id_kelompok);
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('nama_anggota', $keyword);
            $this->db->or_like('no_hp', $keyword);
            $this->db->group_end();
        }
        return $this->db->count_all_results('anggota');
    }

    public function get_members_paginated($id_kelompok, $limit, $start, $keyword = null)
    {
        $this->db->where('id_kelompok', $id_kelompok);
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('nama_anggota', $keyword);
            $this->db->or_like('no_hp', $keyword);
            $this->db->group_end();
        }
        $this->db->limit($limit, $start);
        $this->db->order_by('nama_anggota', 'ASC');
        return $this->db->get('anggota')->result();
    }

    public function insert($data)
    {
        return $this->db->insert('anggota', $data);
    }
    public function insert_batch($data)
    {
        return $this->db->insert_batch('anggota', $data);
    }
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('anggota', $data);
    }
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('anggota');
    }

    public function bulk_action($ids, $action)
    {
        if (empty($ids)) return false;
        $this->db->where_in('id', $ids);
        if ($action == 'delete') return $this->db->delete('anggota');
        if ($action == 'deactivate') return $this->db->update('anggota', ['status' => 'nonaktif']);
        if ($action == 'activate') return $this->db->update('anggota', ['status' => 'aktif']);
        return false;
    }
}
