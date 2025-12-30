<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    public function total_kelompok()
    {
        return $this->db->where('status', 1)->count_all_results('kelompok');
    }

    public function total_anggota($id_kelompok = null)
    {
        if ($id_kelompok) {
            $this->db->where('id_kelompok', $id_kelompok);
        }
        return $this->db->where('status', 1)->count_all_results('anggota');
    }

    public function summary_aktivitas($bulan, $tahun, $id_kelompok = null)
    {
        $this->db->select('ak.kode, ak.nama, COUNT(ab.id) as total');
        $this->db->from('aktivitas ak');
        $this->db->join('absensi ab', 'ab.id_aktivitas = ak.id', 'left');
        $this->db->where('ab.bulan', $bulan);
        $this->db->where('ab.tahun', $tahun);

        if ($id_kelompok) {
            $this->db->where('ab.id_kelompok', $id_kelompok);
        }

        $this->db->group_by('ak.id');
        return $this->db->get()->result();
    }
}
