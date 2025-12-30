<?php
class Laporan_model extends CI_Model
{

    public function get_rekap_bulanan($id_kelompok, $bulan, $tahun)
    {
        if (!$id_kelompok) return [];

        // Ambil semua anggota di kelompok tersebut
        $this->db->where('id_kelompok', $id_kelompok);
        $anggota = $this->db->get('anggota')->result_array();

        foreach ($anggota as $key => $a) {
            // Ambil data absensi untuk anggota ini pada bulan/tahun terkait
            $this->db->where('id_anggota', $a['id']);
            $this->db->where('bulan', $bulan);
            $this->db->where('tahun', $tahun);
            $absensi = $this->db->get('absensi')->result_array();

            // Format data agar mudah dibaca di View: [id_aktivitas][minggu_ke]
            $check_matrix = [];
            foreach ($absensi as $abs) {
                $check_matrix[$abs['id_aktivitas']][$abs['minggu_ke']] = true;
            }
            $anggota[$key]['matrix'] = $check_matrix;
        }
        return $anggota;
    }
}
