<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        auth_check();
        $this->load->model('Dashboard_model');
    }

    public function index()
    {
        $bulan = date('n');
        $tahun = date('Y');

        // Data Dasar (Global)
        $data['title'] = 'Dashboard';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        if (is_admin()) {
            // Data Khusus Admin
            $data['is_admin'] = true;
            $data['total_kelompok'] = $this->Dashboard_model->total_kelompok();
            $data['total_anggota'] = $this->Dashboard_model->total_anggota();
            $data['summary'] = $this->Dashboard_model->summary_aktivitas($bulan, $tahun);

            // Arahkan ke view konten admin
            $data['isi'] = 'dashboard/admin';
        } else {
            // Data Khusus Pengurus
            $id_kelompok = $this->session->userdata('id_kelompok');
            $data['is_admin'] = false;
            $data['total_anggota'] = $this->Dashboard_model->total_anggota($id_kelompok);
            $data['summary'] = $this->Dashboard_model->summary_aktivitas($bulan, $tahun, $id_kelompok);

            // Arahkan ke view konten pengurus
            $data['isi'] = 'dashboard/pengurus';
        }

        // LOAD WRAPPER, BUKAN VIEW LANGSUNG
        $this->load->view('layout/wrapper', $data);
    }
}
