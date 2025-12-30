<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        auth_check();
    }

    public function index()
    {
        if (is_admin()) {
            $this->load->view('dashboard/admin');
        } else {
            $this->load->view('dashboard/pengurus');
        }
    }
}
