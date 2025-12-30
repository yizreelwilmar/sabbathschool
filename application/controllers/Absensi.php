<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        auth_check();
        $this->load->model('Absensi_model');
    }

    public function index()
    {
        $bulan = date('n');
        $tahun = date('Y');
        $minggu = $this->input->get('minggu') ?: 1;

        $id_kelompok = is_admin()
            ? $this->input->get('id_kelompok')
            : $this->session->userdata('id_kelompok');

        if (!$id_kelompok) redirect('dashboard');

        $data = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'minggu' => $minggu,
            'anggota' => $this->Absensi_model->get_anggota($id_kelompok),
            'aktivitas' => $this->Absensi_model->get_aktivitas(),
            'id_kelompok' => $id_kelompok
        ];

        $this->load->view('absensi/index', $data);
    }

    public function toggle()
    {
        $this->Absensi_model->toggle([
            'id_kelompok' => $this->input->post('id_kelompok'),
            'id_anggota' => $this->input->post('id_anggota'),
            'id_aktivitas' => $this->input->post('id_aktivitas'),
            'bulan' => $this->input->post('bulan'),
            'tahun' => $this->input->post('tahun'),
            'minggu_ke' => $this->input->post('minggu_ke')
        ]);
    }
}
