<?php
defined('BASEPATH') or exit('No direct script access allowed');

// 1. Panggil Autoload Composer untuk PhpSpreadsheet
require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Anggota extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        auth_check();
        $this->load->model(['Anggota_model', 'Kelompok_model']);
    }

    public function index()
    {
        $data['title'] = 'Master Anggota';
        $this->load->library('pagination');

        $id_kelompok_selected = $this->input->get('id_kelompok');
        $keyword = $this->input->get('keyword');

        // Logic Filter
        if ($this->session->userdata('role') == 'pengurus') {
            $id_kelompok = $this->session->userdata('id_kelompok');
            $view_mode = 'list';
        } elseif ($id_kelompok_selected) {
            $id_kelompok = $id_kelompok_selected;
            $view_mode = 'list';
        } else {
            $view_mode = 'groups';
        }

        if ($view_mode == 'list') {
            // Pagination Config
            $config['base_url'] = base_url('anggota/index');
            $config['total_rows'] = $this->Anggota_model->count_members($id_kelompok, $keyword);
            $config['per_page'] = 20;
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page';
            $config['reuse_query_string'] = TRUE;

            // Styles Pagination
            $config['full_tag_open'] = '<ul class="pagination justify-content-center mt-4">';
            $config['full_tag_close'] = '</ul>';
            $config['first_tag_open'] = '<li class="page-item">';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tag_close'] = '</li>';
            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['attributes'] = array('class' => 'page-link');

            $this->pagination->initialize($config);

            $page = $this->input->get('page') ? $this->input->get('page') : 0;
            $data['anggota'] = $this->Anggota_model->get_members_paginated($id_kelompok, $config['per_page'], $page, $keyword);
            $data['pagination'] = $this->pagination->create_links();
            $data['detail_kelompok'] = $this->Kelompok_model->get_by_id($id_kelompok);
            $data['keyword'] = $keyword;
            $data['total_data'] = $config['total_rows'];
        } else {
            $data['groups'] = $this->Anggota_model->get_group_stats();
        }

        $data['view_type'] = $view_mode;
        $data['isi'] = 'anggota/index';
        $this->load->view('layout/wrapper', $data);
    }

    public function store()
    {
        $id_kelompok = $this->input->post('id_kelompok');
        if ($this->session->userdata('role') == 'pengurus') {
            $id_kelompok = $this->session->userdata('id_kelompok');
        }

        // [UPDATE] Tambah Tanggal Lahir
        $data = [
            'id_kelompok'   => $id_kelompok,
            'nama_anggota'  => $this->input->post('nama_anggota'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir') ?: NULL, // Ambil input tanggal
            'no_hp'         => $this->clean_number($this->input->post('no_hp')),
            'status'        => 'aktif'
        ];

        $this->Anggota_model->insert($data);
        $this->session->set_flashdata('success', 'Anggota berhasil ditambahkan');
        $this->_redirect_back($id_kelompok);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $id_kelompok = $this->input->post('id_kelompok');

        if ($this->session->userdata('role') == 'pengurus') {
            $id_kelompok = $this->session->userdata('id_kelompok');
        }

        // [UPDATE] Tambah Tanggal Lahir
        $data = [
            'nama_anggota'  => $this->input->post('nama_anggota'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir') ?: NULL, // Ambil input tanggal
            'no_hp'         => $this->clean_number($this->input->post('no_hp'))
        ];

        $this->Anggota_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data anggota berhasil diperbarui.');
        $this->_redirect_back($id_kelompok);
    }

    public function bulk_action()
    {
        $ids = $this->input->post('ids');
        $action = $this->input->post('action');
        $id_kelompok = $this->input->post('id_kelompok');

        if ($ids && $action) {
            $this->Anggota_model->bulk_action($ids, $action);
            $this->session->set_flashdata('success', count($ids) . ' Anggota berhasil diproses.');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada anggota dipilih.');
        }
        $this->_redirect_back($id_kelompok);
    }

    public function delete($id)
    {
        $anggota = $this->db->get_where('anggota', ['id' => $id])->row();
        if ($anggota) {
            $id_kelompok = $anggota->id_kelompok;
            $this->Anggota_model->delete($id);
            $this->session->set_flashdata('success', 'Anggota dihapus.');
            $this->_redirect_back($id_kelompok);
        } else {
            redirect('anggota');
        }
    }

    // --- FITUR IMPORT (UPDATE MENGGUNAKAN PHPSPREADSHEET) ---

    public function download_template()
    {
        // 1. Buat Spreadsheet Baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 2. Set Header Kolom
        $sheet->setCellValue('A1', 'Nama Anggota');
        $sheet->setCellValue('B1', 'Tanggal Lahir (YYYY-MM-DD)'); // Kolom Baru
        $sheet->setCellValue('C1', 'No HP (Opsional)');

        // 3. Set Contoh Data
        $sheet->setCellValue('A2', 'Contoh: Budi Santoso');
        $sheet->setCellValue('B2', '1995-12-25');
        $sheet->setCellValue('C2', '08123456789');

        // 4. Styling Sederhana
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // 5. Output file .xlsx
        $filename = 'Template_Anggota.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function import()
    {
        $id_kelompok = $this->input->post('id_kelompok');
        if ($this->session->userdata('role') == 'pengurus') {
            $id_kelompok = $this->session->userdata('id_kelompok');
        }

        // Gunakan nama input 'file_csv' agar sesuai dengan View, walau filenya bisa Excel
        if (isset($_FILES["file_csv"]["name"])) {
            $path = $_FILES["file_csv"]["tmp_name"];

            try {
                // 1. Load file Excel/CSV menggunakan IOFactory
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
                $sheet = $spreadsheet->getActiveSheet()->toArray();

                $data_batch = [];

                // 2. Loop data (Mulai index 1 untuk melewati Header)
                for ($i = 1; $i < count($sheet); $i++) {
                    $nama = $sheet[$i][0];    // Kolom A
                    $tgl_raw = $sheet[$i][1]; // Kolom B (Tanggal Lahir)
                    $hp = isset($sheet[$i][2]) ? $sheet[$i][2] : ''; // Kolom C

                    // Skip jika nama kosong
                    if (empty($nama)) continue;

                    // 3. Logika Konversi Tanggal Excel
                    $tanggal_lahir_db = NULL;
                    if (!empty($tgl_raw)) {
                        if (is_numeric($tgl_raw)) {
                            // Jika format serial number excel (contoh: 44562)
                            $tanggal_lahir_db = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tgl_raw)->format('Y-m-d');
                        } else {
                            // Jika format text "1995-12-25" atau "25-12-1995"
                            $ts = strtotime($tgl_raw);
                            if ($ts) $tanggal_lahir_db = date('Y-m-d', $ts);
                        }
                    }

                    $data_batch[] = [
                        'id_kelompok'   => $id_kelompok,
                        'nama_anggota'  => $nama,
                        'tanggal_lahir' => $tanggal_lahir_db, // Masukkan ke DB
                        'no_hp'         => $this->clean_number($hp),
                        'status'        => 'aktif'
                    ];
                }

                // 4. Simpan ke Database
                if (!empty($data_batch)) {
                    $this->Anggota_model->insert_batch($data_batch);
                    $this->session->set_flashdata('success', count($data_batch) . ' Anggota berhasil diimport!');
                } else {
                    $this->session->set_flashdata('error', 'File kosong atau format salah.');
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('error', 'Gagal membaca file: ' . $e->getMessage());
            }
        }
        $this->_redirect_back($id_kelompok);
    }

    // --- HELPER FUNCTIONS ---

    private function _redirect_back($id_kelompok)
    {
        if ($this->session->userdata('role') == 'admin') {
            redirect('anggota?id_kelompok=' . $id_kelompok);
        } else {
            redirect('anggota');
        }
    }

    private function clean_number($no)
    {
        return preg_replace('/[^0-9]/', '', $no);
    }
}
