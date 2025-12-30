<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ringkasan Statistik</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-calendar-alt fa-sm text-white-50"></i> Periode: <?= date('F Y') ?>
    </a>
</div>

<div class="row">

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Kelompok</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_kelompok ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users-rectangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Anggota</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_anggota ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-group fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Bulan Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= date('M Y') ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Rekap Aktivitas Bulan Ini</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th width="10%">Kode</th>
                                <th>Nama Aktivitas</th>
                                <th class="text-center" width="20%">Total Checklist</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($summary)): foreach ($summary as $s): ?>
                                    <tr>
                                        <td><span class="badge badge-secondary"><?= $s->kode ?></span></td>
                                        <td class="font-weight-bold text-dark"><?= $s->nama ?></td>
                                        <td class="text-center">
                                            <span class="btn btn-sm btn-circle btn-primary font-weight-bold">
                                                <?= $s->total ?: 0 ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                                        Belum ada data aktivitas bulan ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>