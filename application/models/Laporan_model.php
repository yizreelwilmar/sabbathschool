<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    // Ambil Data Rekap Matrix
    public function get_rekap_bulanan_mingguan($bulan, $tahun, $id_kelompok)
    {
        // 1. Ambil Anggota
        $anggota = $this->db->where('id_kelompok', $id_kelompok)
            ->where('status', 'aktif')
            ->order_by('nama_anggota', 'ASC')
            ->get('anggota')
            ->result_array();

        // 2. Ambil Transaksi (PENTING: Ambil tanggalnya juga)
        $this->db->select('id_anggota, id_aktivitas, tanggal');
        $this->db->from('absensi');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->where('id_kelompok', $id_kelompok);
        $this->db->where('poin', 1);
        $transaksi = $this->db->get()->result_array();

        // 3. Mapping Data (Penyusunan Array Matrix Mingguan)
        // Format: $data_rekap[ID_ANGGOTA][ID_AKTIVITAS][MINGGU_KE] = 1 (Checklist)
        $data_rekap = [];

        foreach ($transaksi as $t) {
            // Hitung Minggu ke berapa tanggal ini dalam bulan tersebut
            // Logika: Week Number = ceiling((Day of Month) / 7) atau logika khusus Sabat
            // Karena ini Sekolah Sabat, biasanya dihitung Sabtu ke-1, Sabtu ke-2, dst.

            $day = date('j', strtotime($t['tanggal'])); // Tanggal (1-31)

            // Logika Sederhana:
            // Tgl 1-7   = Minggu 1
            // Tgl 8-14  = Minggu 2
            // Tgl 15-21 = Minggu 3
            // Tgl 22-28 = Minggu 4
            // Tgl 29-31 = Minggu 5
            $minggu_ke = ceil($day / 7);

            $data_rekap[$t['id_anggota']][$t['id_aktivitas']][$minggu_ke] = true;
        }

        return [
            'anggota' => $anggota,
            'rekap'   => $data_rekap
        ];
    }
}
