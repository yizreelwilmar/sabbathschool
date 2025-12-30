<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi_model extends CI_Model
{
    // Ambil semua daftar aktivitas (12 item tadi)
    public function get_aktivitas()
    {
        return $this->db->order_by('urutan', 'ASC')->get('master_aktivitas')->result();
    }

    // Ambil data absensi yang SUDAH tersimpan di tanggal & kelompok tertentu
    // Tujuannya agar saat dibuka lagi, checklist yang sudah dicentang tetap muncul
    public function get_existing_absen($tanggal, $id_kelompok)
    {
        $this->db->select('id_anggota, id_aktivitas');
        $this->db->where('tanggal', $tanggal);
        $this->db->where('id_kelompok', $id_kelompok);
        $query = $this->db->get('absensi')->result_array();

        // Kita ubah formatnya jadi array mapping biar mudah dicek di View
        // Format: [id_anggota][id_aktivitas] = true
        $data = [];
        foreach ($query as $row) {
            $data[$row['id_anggota']][$row['id_aktivitas']] = true;
        }
        return $data;
    }

    // Simpan Data (Hapus dulu yang lama di hari itu, baru simpan yang baru)
    // Ini cara paling aman untuk update checklist (termasuk yang di-uncheck)
    public function simpan_batch($tanggal, $id_kelompok, $data_insert)
    {
        $this->db->trans_start(); // Mulai Transaksi Database

        // 1. Hapus data lama di tanggal & kelompok tersebut
        $this->db->where('tanggal', $tanggal);
        $this->db->where('id_kelompok', $id_kelompok);
        $this->db->delete('absensi');

        // 2. Masukkan data baru (jika ada yang dicentang)
        if (!empty($data_insert)) {
            $this->db->insert_batch('absensi', $data_insert);
        }

        $this->db->trans_complete(); // Selesai Transaksi
        return $this->db->trans_status();
    }
}
