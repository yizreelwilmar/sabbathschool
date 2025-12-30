<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengurus extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Cek Login & Role Admin
        if (!$this->session->userdata('user_id')) redirect('auth/login');
        if ($this->session->userdata('role') != 'admin') redirect('dashboard');

        $this->load->model('Pengurus_model');
    }

    public function index()
    {
        $data['title'] = 'Master Pengurus';
        $data['pengurus'] = $this->Pengurus_model->get_all_pengurus();
        $data['list_kelompok'] = $this->Pengurus_model->get_list_kelompok();

        $data['isi'] = 'pengurus/index';
        $this->load->view('layout/wrapper', $data);
    }

    public function store()
    {
        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'username'     => $this->input->post('username'),
            'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT), // Hash Password
            'role'         => 'pengurus',
            'id_kelompok'  => $this->input->post('id_kelompok'),
            'status'       => 1
        ];

        $this->Pengurus_model->insert($data);
        $this->session->set_flashdata('success', 'Akun pengurus berhasil dibuat!');
        redirect('pengurus');
    }

    public function update()
    {
        $id = $this->input->post('id');

        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'username'     => $this->input->post('username'),
            'id_kelompok'  => $this->input->post('id_kelompok'),
        ];

        // Cek apakah password diubah?
        $password_baru = $this->input->post('password');
        if (!empty($password_baru)) {
            $data['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
        }

        $this->Pengurus_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data pengurus berhasil diperbarui!');
        redirect('pengurus');
    }

    public function delete($id)
    {
        $this->Pengurus_model->delete($id);
        $this->session->set_flashdata('success', 'Akun pengurus dihapus.');
        redirect('pengurus');
    }
}
