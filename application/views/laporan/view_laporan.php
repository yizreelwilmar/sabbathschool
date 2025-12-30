<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Laporan Aktivitas</h1>
        <button class="btn btn-sm btn-success shadow-sm px-4 rounded-pill">
            <i class="fas fa-file-excel fa-sm text-white-50 mr-2"></i> Export Excel
        </button>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="" method="GET" class="row align-items-end">
                <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold">Pilih Kelompok</label>
                        <select name="id_kelompok" class="form-control border-0 bg-light">
                            <option value="">-- Semua Kelompok --</option>
                            <?php foreach ($kelompok_list as $k): ?>
                                <option value="<?= $k->id ?>" <?= ($id_kelompok == $k->id) ? 'selected' : '' ?>><?= $k->nama_kelompok ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="col-md-3 mb-3">
                    <label class="small font-weight-bold">Bulan</label>
                    <select name="bulan" class="form-control border-0 bg-light">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>" <?= ($bulan == $i) ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-block shadow-sm">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-gradient-primary text-white text-center">
                        <tr>
                            <th rowspan="2" class="align-middle border-0" style="min-width: 200px;">Nama Anggota</th>
                            <?php foreach ($aktivitas as $akt): ?>
                                <th colspan="5" class="border-0 bg-dark-50" style="border-left: 1px solid rgba(255,255,255,0.1) !important;">
                                    <?= strtoupper($akt->nama_aktivitas) ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                        <tr class="small text-uppercase">
                            <?php foreach ($aktivitas as $akt): ?>
                                <th class="border-0">M1</th>
                                <th class="border-0">M2</th>
                                <th class="border-0">M3</th>
                                <th class="border-0">M4</th>
                                <th class="border-0">M5</th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rekap)): ?>
                            <tr>
                                <td colspan="100" class="text-center py-5 text-muted">Silakan pilih kelompok untuk melihat data</td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($rekap as $row): ?>
                            <tr>
                                <td class="font-weight-bold text-indigo"><?= $row['nama_anggota'] ?></td>
                                <?php foreach ($aktivitas as $akt): ?>
                                    <?php for ($m = 1; $m <= 5; $m++): ?>
                                        <td class="text-center border-left">
                                            <?php if (isset($row['matrix'][$akt->id][$m])): ?>
                                                <div class="badge badge-success-soft p-1 rounded-circle">
                                                    <i class="fas fa-check-circle text-success"></i>
                                                </div>
                                            <?php else: ?>
                                                <i class="fas fa-times text-light" style="font-size: 0.7rem;"></i>
                                            <?php endif; ?>
                                        </td>
                                    <?php endfor; ?>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
    }

    .badge-success-soft {
        background-color: #e1fcef;
    }

    .text-indigo {
        color: #4e73df;
    }

    th {
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }

    td {
        vertical-align: middle !important;
        border-bottom: 1px solid #f1f5f9;
    }
</style>