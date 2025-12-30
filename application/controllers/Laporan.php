<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Memastikan user sudah login  
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
        $this->load->model(['Laporan_model', 'Absensi_model', 'Kelompok_model']);
    }

    public function index()
    {
        $data['title'] = "Laporan Mingguan";
        $data['bulan'] = $this->input->get('bulan') ?: date('m');
        $data['tahun'] = $this->input->get('tahun') ?: date('Y');

        // Security Gate: Pengurus tidak boleh intip kelompok lain
        if ($this->session->userdata('role') == 'pengurus') {
            $id_kelompok = $this->session->userdata('id_kelompok');
        } else {
            $id_kelompok = $this->input->get('id_kelompok');
        }

        $data['id_kelompok'] = $id_kelompok;
        $data['kelompok_list'] = $this->Kelompok_model->get_all();
        $data['aktivitas'] = $this->Absensi_model->get_aktivitas();

        // Mengambil data rekap (Full Query ada di Model)
        $data['rekap'] = $this->Laporan_model->get_rekap_bulanan($id_kelompok, $data['bulan'], $data['tahun']);

        $data['isi'] = 'laporan/view_laporan'; // Nama file view
        $this->load->view('layout/wrapper', $data);
    }
}
