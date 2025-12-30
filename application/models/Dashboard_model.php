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

    // [BARU] Ambil Total Checklist per Kelompok untuk Grafik
    public function grafik_per_kelompok($bulan, $tahun)
    {
        $this->db->select('k.nama_kelompok, COUNT(a.id) as total');
        $this->db->from('kelompok k');

        // Join dengan filter Tanggal & Poin=1
        // Ditaruh di ON agar kelompok yang nilainya 0 tetap muncul
        $join_condition = "a.id_kelompok = k.id AND a.poin = 1 AND MONTH(a.tanggal) = '$bulan' AND YEAR(a.tanggal) = '$tahun'";

        $this->db->join('absensi a', $join_condition, 'left');
        $this->db->where('k.status', 1); // Hanya kelompok aktif
        $this->db->group_by('k.id');
        $this->db->order_by('total', 'DESC'); // Urutkan dari yang paling rajin

        return $this->db->get()->result();
    }

    // [BARU] Hitung populasi anggota per kelompok (untuk Card Kelompok)
    public function get_populasi_kelompok()
    {
        $this->db->select('k.nama_kelompok, COUNT(a.id) as total_anggota');
        $this->db->from('kelompok k');
        $this->db->join('anggota a', 'a.id_kelompok = k.id AND a.status="aktif"', 'left');
        $this->db->where('k.status', 1);
        $this->db->group_by('k.id');
        $this->db->order_by('total_anggota', 'DESC'); // Urutkan dari yg anggotanya terbanyak
        return $this->db->get()->result();
    }

    // [BARU] Hitung Anggota Non-Aktif
    public function total_nonaktif()
    {
        // Asumsi di database statusnya 'nonaktif' atau 0
        // Sesuaikan value-nya dengan database kamu (misal 'nonaktif' atau 0)
        return $this->db->where('status', 'nonaktif')->count_all_results('anggota');
    }

    // [BARU] Monitoring Kapan Terakhir Kelompok Input Data
    public function get_monitoring_kelompok()
    {
        $this->db->select('k.nama_kelompok, MAX(a.created_at) as waktu_input, COUNT(a.id) as total_aktivitas');
        $this->db->from('kelompok k');
        $this->db->join('absensi a', 'k.id = a.id_kelompok', 'left');
        $this->db->where('k.status', 1);
        $this->db->group_by('k.id');
        $this->db->order_by('waktu_input', 'DESC'); // Yang baru input muncul paling atas
        return $this->db->get()->result();
    }

    // [BARU] Hitung ada berapa hari sabtu yang datanya sudah masuk bulan ini
    public function get_jumlah_minggu_input($bulan, $tahun, $id_kelompok)
    {
        $this->db->select('tanggal');
        $this->db->from('absensi');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->where('id_kelompok', $id_kelompok);
        $this->db->group_by('tanggal'); // Group by tanggal biar yang dihitung jumlah harinya
        return $this->db->get()->num_rows();
    }

    // [BARU] Hitung jumlah minggu (tanggal unik) yang sudah ada datanya secara Global
    public function get_jumlah_minggu_input_global($bulan, $tahun)
    {
        $this->db->select('tanggal');
        $this->db->from('absensi');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->group_by('tanggal'); // Grouping biar tgl yang sama dihitung 1
        return $this->db->get()->num_rows();
    }
}
