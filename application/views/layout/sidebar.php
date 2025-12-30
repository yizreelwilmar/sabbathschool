<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
        <div class="sidebar-brand-icon">
            <i class="fas fa-church fa-2x"></i>
        </div>
        <div class="sidebar-brand-text mx-3">UKSS APP</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item <?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span>
        </a>
    </li>

    <?php if ($this->session->userdata('role') == 'admin'): ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Master Data</div>

        <li class="nav-item <?= $this->uri->segment(1) == 'kelompok' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('kelompok') ?>">
                <i class="fas fa-fw fa-users"></i><span>Data Kelompok</span>
            </a>
        </li>

        <li class="nav-item <?= $this->uri->segment(1) == 'pengurus' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('pengurus') ?>">
                <i class="fas fa-fw fa-user-tie"></i><span>Data Pengurus</span>
            </a>
        </li>
    <?php endif; ?>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Kegiatan</div>

    <li class="nav-item <?= $this->uri->segment(1) == 'anggota' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('anggota') ?>">
            <i class="fas fa-fw fa-user-friends"></i><span>Anggota Kelompok</span>
        </a>
    </li>

    <li class="nav-item <?= $this->uri->segment(1) == 'absensi' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('absensi') ?>">
            <i class="fas fa-fw fa-calendar-check"></i><span>Absensi Mingguan</span>
        </a>
    </li>

    <li class="nav-item <?= $this->uri->segment(1) == 'laporan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('laporan') ?>">
            <i class="fas fa-fw fa-file-excel"></i><span>Laporan</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>