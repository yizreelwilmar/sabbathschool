<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi_model extends CI_Model
{

    public function get_anggota($id_kelompok)
    {
        return $this->db->where('id_kelompok', $id_kelompok)
            ->where('status', 1)
            ->get('anggota')->result();
    }

    public function get_aktivitas()
    {
        return $this->db->get('aktivitas')->result();
    }

    public function is_checked($id_anggota, $id_aktivitas, $bulan, $tahun, $minggu)
    {
        return $this->db->where([
            'id_anggota' => $id_anggota,
            'id_aktivitas' => $id_aktivitas,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'minggu_ke' => $minggu
        ])->get('absensi')->row();
    }

    public function toggle($data)
    {
        $exists = $this->db->where($data)->get('absensi')->row();

        if ($exists) {
            $this->db->where('id', $exists->id)->delete('absensi');
        } else {
            $this->db->insert('absensi', $data);
        }
    }
}
