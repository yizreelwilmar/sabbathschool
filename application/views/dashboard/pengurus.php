<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Dashboard Pengurus</h1>
        <p class="mb-0 text-muted">Selamat datang, Pengurus <strong><?= $detail_kelompok->nama_kelompok ?></strong>!</p>
    </div>

    <div class="d-none d-sm-block">
        <span class="badge badge-primary px-3 py-2 shadow-sm">
            <i class="fas fa-calendar-alt mr-1"></i> <?= date('d M Y') ?>
        </span>
    </div>
</div>

<div class="row">

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Anggota</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_anggota ?> Jiwa</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
                <a href="<?= base_url('anggota') ?>" class="btn btn-sm btn-link pl-0 mt-2">Lihat Data Anggota &rarr;</a>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 bg-success text-white">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Kegiatan Minggu Ini</div>
                        <div class="h5 mb-0 font-weight-bold">Input Absensi</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-edit fa-2x text-white-50"></i>
                    </div>
                </div>
                <?php
                // Logika mencari Sabtu terdekat untuk tombol Quick Action
                $next_saturday = (date('N') == 6) ? date('Y-m-d') : date('Y-m-d', strtotime('next saturday'));
                ?>
                <a href="<?= base_url('absensi?tanggal=' . $next_saturday) ?>" class="btn btn-light btn-sm mt-3 text-success font-weight-bold shadow-sm w-100">
                    <i class="fas fa-pen mr-1"></i> Isi Absen (<?= date('d M', strtotime($next_saturday)) ?>)
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Laporan Bulanan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rekapitulasi</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
                <a href="<?= base_url('laporan') ?>" class="btn btn-sm btn-link pl-0 mt-2">Lihat Rapor Kelompok &rarr;</a>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Rata-rata Keaktifan Mingguan (<?= date('F Y') ?>)</h6>
    </div>
    <div class="card-body">
        <?php if (empty($summary)): ?>
            <div class="text-center py-5 text-muted">
                <img src="https://img.icons8.com/ios/100/cccccc/empty-box.png" width="60" class="mb-3">
                <p>Belum ada data absensi bulan ini.</p>
                <a href="<?= base_url('absensi?tanggal=' . $next_saturday) ?>" class="btn btn-primary btn-sm">Mulai Input</a>
            </div>
        <?php else: ?>

            <div class="alert alert-light border small text-muted mb-4">
                <i class="fas fa-info-circle mr-1"></i> Data berdasarkan <strong><?= $minggu_berjalan ?> minggu</strong> yang sudah diinput bulan ini.
            </div>

            <div class="row">
                <?php foreach ($summary as $s):
                    // LOGIKA BARU: Rata-rata Mingguan

                    // 1. Hindari pembagian dengan nol jika belum ada minggu yang diinput (walau summary ada isinya, just in case)
                    $pembagi_minggu = ($minggu_berjalan > 0) ? $minggu_berjalan : 1;

                    // 2. Hitung Rata-rata orang per minggu
                    // round(..., 1) artinya ambil 1 angka belakang koma. Misal: 10.5
                    $rata_rata_orang = round($s->total / $pembagi_minggu, 1);

                    // 3. Hitung Persentase Partisipasi (Rata-rata / Total Anggota)
                    $total_anggota_safe = ($total_anggota > 0) ? $total_anggota : 1;
                    $percent = ($rata_rata_orang / $total_anggota_safe) * 100;

                    // 4. Warna Progress Bar
                    if ($percent >= 75) $color = 'bg-success';      // Hijau (Bagus)
                    elseif ($percent >= 50) $color = 'bg-primary';  // Biru (Oke)
                    elseif ($percent >= 25) $color = 'bg-warning';  // Kuning (Kurang)
                    else $color = 'bg-danger';                     // Merah (Buruk)
                ?>
                    <div class="col-lg-6 mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="font-weight-bold text-dark"><?= $s->nama ?></div>
                            <div class="text-primary font-weight-bold small">
                                Rata-rata: <?= $rata_rata_orang ?> Org
                            </div>
                        </div>

                        <div class="progress mb-1" style="height: 10px;">
                            <div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= $percent ?>%"
                                aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>

                        <div class="small text-muted">
                            Partisipasi: <strong><?= round($percent) ?>%</strong> dari total anggota (Total Checklist: <?= $s->total ?>)
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>