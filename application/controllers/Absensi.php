<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        auth_check();
        $this->load->model(['Absensi_model', 'Anggota_model', 'Kelompok_model']);
    }

    public function index()
    {
        $data['title'] = 'Absensi Mingguan';

        // --- LOGIKA BARU: AUTO SELECT SABTU ---

        // 1. Cek apakah user memilih tanggal lewat filter?
        $tanggal_filter = $this->input->get('tanggal');

        if ($tanggal_filter) {
            // Jika user memilih tanggal manual, pakai itu
            $tanggal = $tanggal_filter;
        } else {
            // Jika baru buka halaman (belum pilih), cari Sabtu terdekat
            if (date('N') == 6) {
                // Jika hari ini Sabtu (6), pakai hari ini
                $tanggal = date('Y-m-d');
            } else {
                // Jika bukan Sabtu, ambil Sabtu depan (Next Saturday)
                $tanggal = date('Y-m-d', strtotime('next saturday'));
            }
        }

        // --------------------------------------

        // Penentuan Kelompok (Admin bisa pilih, Pengurus otomatis)
        if ($this->session->userdata('role') == 'pengurus') {
            $id_kelompok = $this->session->userdata('id_kelompok');
        } else {
            $id_kelompok = $this->input->get('id_kelompok');
        }

        // ... Sisa kodingan ke bawah SAMA PERSIS, tidak usah diubah ...
        // (Mulai dari $data['tanggal_pilih'] = $tanggal; dst...)

        $data['tanggal_pilih'] = $tanggal;
        $data['id_kelompok_pilih'] = $id_kelompok;

        $data['list_aktivitas'] = $this->Absensi_model->get_aktivitas();

        if ($id_kelompok) {
            $data['anggota'] = $this->Anggota_model->get_by_kelompok($id_kelompok);
            $data['absen_data'] = $this->Absensi_model->get_existing_absen($tanggal, $id_kelompok);
            $data['detail_kelompok'] = $this->Kelompok_model->get_by_id($id_kelompok);
        }

        if ($this->session->userdata('role') == 'admin') {
            $data['list_kelompok'] = $this->Kelompok_model->get_all();
        }

        $data['isi'] = 'absensi/index';
        $this->load->view('layout/wrapper', $data);
    }

    public function store()
    {
        $tanggal = $this->input->post('tanggal');
        $id_kelompok = $this->input->post('id_kelompok');
        $checklist = $this->input->post('absen'); // Array 2 Dimensi dari View

        // Security Check Pengurus
        if ($this->session->userdata('role') == 'pengurus') {
            $id_kelompok = $this->session->userdata('id_kelompok');
        }

        // Susun Data Batch
        $data_insert = [];

        // Loop checklist yang dikirim (Format: absen[id_anggota][id_aktivitas])
        if ($checklist) {
            foreach ($checklist as $id_anggota => $aktivitas_array) {
                foreach ($aktivitas_array as $id_aktivitas => $val) {
                    // Hanya masukkan yang dicentang
                    if ($val == 1) {
                        $data_insert[] = [
                            'tanggal'      => $tanggal,
                            'id_kelompok'  => $id_kelompok,
                            'id_anggota'   => $id_anggota,
                            'id_aktivitas' => $id_aktivitas,
                            'poin'         => 1
                        ];
                    }
                }
            }
        }

        // Simpan ke Model
        $this->Absensi_model->simpan_batch($tanggal, $id_kelompok, $data_insert);

        $this->session->set_flashdata('success', 'Data absensi tanggal ' . date('d M Y', strtotime($tanggal)) . ' berhasil disimpan!');

        // Redirect balik
        if ($this->session->userdata('role') == 'admin') {
            redirect('absensi?tanggal=' . $tanggal . '&id_kelompok=' . $id_kelompok);
        } else {
            redirect('absensi?tanggal=' . $tanggal);
        }
    }
}
