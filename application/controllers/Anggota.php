<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

            // Styles
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

        $data = [
            'id_kelompok'   => $id_kelompok,
            'nama_anggota'  => $this->input->post('nama_anggota'),
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

        $data = [
            'nama_anggota' => $this->input->post('nama_anggota'),
            'no_hp'        => $this->clean_number($this->input->post('no_hp'))
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

    // --- FITUR IMPORT ---
    public function download_template()
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="Template_Anggota.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['NAMA ANGGOTA', 'NO HP (Opsional)']);
        fputcsv($output, ['Budi Santoso', '08123456789']);
        fclose($output);
    }

    public function import()
    {
        $id_kelompok = $this->input->post('id_kelompok');
        if ($this->session->userdata('role') == 'pengurus') {
            $id_kelompok = $this->session->userdata('id_kelompok');
        }

        if (isset($_FILES["file_csv"]["name"])) {
            $path = $_FILES["file_csv"]["tmp_name"];
            $object = fopen($path, 'r');
            $data_batch = [];
            $row = 0;
            while (($line = fgetcsv($object, 1000, ",")) !== FALSE) {
                $row++;
                if ($row == 1 || empty($line[0])) continue;

                $data_batch[] = [
                    'id_kelompok'   => $id_kelompok,
                    'nama_anggota'  => filter_var($line[0], FILTER_SANITIZE_STRING),
                    'no_hp'         => isset($line[1]) ? $this->clean_number($line[1]) : '',
                    'status'        => 'aktif'
                ];
            }
            fclose($object);

            if (!empty($data_batch)) {
                $this->Anggota_model->insert_batch($data_batch);
                $this->session->set_flashdata('success', count($data_batch) . ' Anggota diimport!');
            }
        }
        $this->_redirect_back($id_kelompok);
    }

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
