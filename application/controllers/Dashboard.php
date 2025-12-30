<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        auth_check();
        // Load Model yang dibutuhkan
        $this->load->model(['Dashboard_model', 'Kelompok_model']);
    }

    public function index()
    {
        $bulan = date('n');
        $tahun = date('Y');

        $data['title'] = 'Dashboard';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        if (is_admin()) {
            $data['is_admin'] = true;
            $data['total_kelompok'] = $this->Dashboard_model->total_kelompok();
            $data['total_anggota'] = $this->Dashboard_model->total_anggota();
            $data['total_nonaktif'] = $this->Dashboard_model->total_nonaktif();
            $data['monitoring'] = $this->Dashboard_model->get_monitoring_kelompok();
            $data['summary'] = $this->Dashboard_model->summary_aktivitas($bulan, $tahun);

            // [BARU] Ambil jumlah minggu global
            $data['minggu_berjalan'] = $this->Dashboard_model->get_jumlah_minggu_input_global($bulan, $tahun);

            $data['isi'] = 'dashboard/admin';
        } else {
            // --- DATA KHUSUS PENGURUS ---
            $id_kelompok = $this->session->userdata('id_kelompok');
            $data['is_admin'] = false;
            $data['detail_kelompok'] = $this->Kelompok_model->get_by_id($id_kelompok);
            $data['total_anggota'] = $this->Dashboard_model->total_anggota($id_kelompok);
            $data['summary'] = $this->Dashboard_model->summary_aktivitas($bulan, $tahun, $id_kelompok);

            // [BARU] Ambil jumlah minggu yang sudah diinput
            $data['minggu_berjalan'] = $this->Dashboard_model->get_jumlah_minggu_input($bulan, $tahun, $id_kelompok);

            $data['isi'] = 'dashboard/pengurus';
        }

        $this->load->view('layout/wrapper', $data);
    }
}
