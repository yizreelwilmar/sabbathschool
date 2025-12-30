<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelompok extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Cek login & role admin
        if (!$this->session->userdata('user_id')) redirect('login');
        if ($this->session->userdata('role') != 'admin') redirect('dashboard');

        $this->load->model('Kelompok_model');
    }

    public function index()
    {
        $data['title'] = 'Master Kelompok';
        $data['kelompok'] = $this->Kelompok_model->get_all();

        // PENTING: Gunakan 'isi' untuk konten dinamis di wrapper
        $data['isi'] = 'kelompok/index';

        $this->load->view('layout/wrapper', $data);
    }

    public function store()
    {
        $data = [
            'nama_kelompok' => $this->input->post('nama_kelompok'),
            'deskripsi'     => $this->input->post('deskripsi'), // Opsional
        ];

        $this->Kelompok_model->insert($data);
        $this->session->set_flashdata('success', 'Data kelompok berhasil ditambahkan!');
        redirect('kelompok');
    }

    public function update()
    {
        $id = $this->input->post('id');
        $data = [
            'nama_kelompok' => $this->input->post('nama_kelompok'),
            'deskripsi'     => $this->input->post('deskripsi'),
        ];

        $this->Kelompok_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data kelompok berhasil diperbarui!');
        redirect('kelompok');
    }

    public function delete($id)
    {
        $this->Kelompok_model->delete($id);
        $this->session->set_flashdata('success', 'Data kelompok berhasil dihapus!');
        redirect('kelompok');
    }
}
