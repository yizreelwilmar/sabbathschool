<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    public function total_kelompok()
    {
        // Pastikan status sesuai database (aktif/nonaktif atau 1/0)
        return $this->db->where('status', 1)->count_all_results('kelompok');
    }

    public function total_anggota($id_kelompok = null)
    {
        if ($id_kelompok) {
            $this->db->where('id_kelompok', $id_kelompok);
        }
        // Sesuaikan 'status' dengan enum di database ('aktif')
        return $this->db->where('status', 'aktif')->count_all_results('anggota');
    }

    public function summary_aktivitas($bulan, $tahun, $id_kelompok = null)
    {
        // 1. SELECT: Ambil nama_aktivitas (bukan nama)
        $this->db->select('ak.kode, ak.nama_aktivitas as nama, COUNT(ab.id) as total');

        // 2. FROM: Tabel master_aktivitas (bukan aktivitas)
        $this->db->from('master_aktivitas ak');

        // 3. JOIN KHUSUS: Filter tanggal ditaruh DI DALAM JOIN
        // Kenapa? Supaya aktivitas yang TOTALNYA 0 (belum ada yang checklist) TETAP MUNCUL di dashboard
        $join_condition = "ab.id_aktivitas = ak.id AND MONTH(ab.tanggal) = '$bulan' AND YEAR(ab.tanggal) = '$tahun'";

        if ($id_kelompok) {
            $join_condition .= " AND ab.id_kelompok = '$id_kelompok'";
        }

        $this->db->join('absensi ab', $join_condition, 'left');

        $this->db->group_by('ak.id');
        $this->db->order_by('ak.urutan', 'ASC'); // Urutkan biar rapi (TW/L duluan)

        return $this->db->get()->result();
    }
}
