<?php
// 1. Load Header & Sidebar
$this->load->view('layout/header');
$this->load->view('layout/sidebar');
?>

<div id="content-wrapper" class="d-flex flex-column">

    <div id="content">

        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <ul class="navbar-nav ml-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                            Halo, <b><?= $this->session->userdata('username') ?></b>
                        </span>
                        <div class="img-profile rounded-circle bg-gray-200 d-flex align-items-center justify-content-center text-gray-600 font-weight-bold" style="width: 32px; height: 32px;">
                            <?= substr($this->session->userdata('username'), 0, 2) ?>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?= base_url('auth/logout') ?>" onclick="return confirm('Yakin ingin keluar?')">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="container-fluid">
            <?php
            if (isset($isi) && $isi) {
                $this->load->view($isi);
            }
            ?>
        </div>
        <?php $this->load->view('layout/footer'); ?>