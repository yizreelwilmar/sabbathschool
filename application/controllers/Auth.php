<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }


    public function login()
    {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function process()
    {
        $username = trim($this->input->post('username', TRUE));
        $password = $this->input->post('password', TRUE);

        if (!$username || !$password) {
            $this->session->set_flashdata('error', 'Lengkapi username & password');
            redirect('login');
        }

        $user = $this->db
            ->where('username', $username)
            ->where('status', 1)
            ->get('users')
            ->row();

        if (!$user || !password_verify($password, $user->password)) {
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('login');
        }

        $this->session->set_userdata([
            'user_id'     => $user->id,
            'username'    => $user->username,
            'role'        => $user->role,
            'id_kelompok' => $user->id_kelompok
        ]);

        redirect('dashboard');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}
