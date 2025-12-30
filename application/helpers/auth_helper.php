<?php
defined('BASEPATH') or exit('No direct script access allowed');

function auth_check()
{
    $CI = &get_instance();
    if (!$CI->session->userdata('user_id')) {
        redirect('login');
    }
}

function is_admin()
{
    $CI = &get_instance();
    return $CI->session->userdata('role') === 'admin';
}

function is_pengurus()
{
    $CI = &get_instance();
    return $CI->session->userdata('role') === 'pengurus';
}
