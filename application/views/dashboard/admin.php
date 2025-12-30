<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Monitoring</h1>
    <span class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm cursor-default">
        <i class="fas fa-clock fa-sm text-white-50 mr-1"></i> Data: <?= date('d M Y') ?>
    </span>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Anggota Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_anggota) ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-user-check fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Non-Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_nonaktif) ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-user-times fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Kelompok</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_kelompok ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-sitemap fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Bulan Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= date('M') ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar-day fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-5 mb-4">
        <div class="card shadow mb-4 h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Monitoring Input Data</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped mb-0">
                        <thead class="bg-light text-dark sticky-top">
                            <tr>
                                <th class="pl-4">Nama Kelompok</th>
                                <th>Status Input</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($monitoring)): foreach ($monitoring as $m): ?>
                                    <?php
                                    // Logic Label Waktu
                                    if ($m->waktu_input) {
                                        $last_date = strtotime($m->waktu_input);
                                        $diff = time() - $last_date;
                                        $days = floor($diff / (60 * 60 * 24));

                                        if ($days < 2) {
                                            $badge = '<span class="badge badge-success">Baru saja</span>';
                                            $text_color = 'text-success';
                                        } elseif ($days < 7) {
                                            $badge = '<span class="badge badge-warning">Minggu ini</span>';
                                            $text_color = 'text-dark';
                                        } else {
                                            $badge = '<span class="badge badge-danger">Lama (' . $days . ' hari)</span>';
                                            $text_color = 'text-muted';
                                        }
                                        $waktu_display = date('d M H:i', $last_date);
                                    } else {
                                        $badge = '<span class="badge badge-secondary">Belum Input</span>';
                                        $text_color = 'text-muted';
                                        $waktu_display = "-";
                                    }
                                    ?>
                                    <tr>
                                        <td class="pl-4 font-weight-bold text-dark align-middle">
                                            <?= $m->nama_kelompok ?>
                                            <div class="small text-muted" style="font-size: 10px;">Total Data: <?= $m->total_aktivitas ?></div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="font-weight-bold small <?= $text_color ?>"><?= $waktu_display ?></div>
                                            <div class="mt-1"><?= $badge ?></div>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="2" class="text-center p-4">Belum ada kelompok.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 mb-4">
        <div class="card shadow mb-4 h-100">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Total Aktivitas (Akumulasi)</h6>
                <a href="<?= base_url('laporan') ?>" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-expand mr-1"></i> Full Report
                </a>
            </div>
            <div class="card-body">

                <div class="p-3 mb-3 rounded" style="background-color: #e0f7fa; border: 1px solid #b2ebf2; color: #006064; font-size: 0.875rem;">
                    <i class="fas fa-info-circle mr-1"></i> <strong>Info:</strong>
                    Grafik ini menunjukkan jumlah total "Centang" yang terkumpul dari seluruh anggota dan seluruh kelompok di bulan ini.
                </div>
                <div class="chart-area" style="height: 320px;">
                    <canvas id="myBarChart"></canvas>
                </div>

                <?php if (empty($summary)): ?>
                    <div class="text-center mt-3 small text-muted">
                        <em>Belum ada data aktivitas bulan ini.</em>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rata-rata Keaktifan Global (Per Minggu)</h6>
            </div>
            <div class="card-body">

                <div class="alert alert-light border small text-muted mb-4">
                    <i class="fas fa-info-circle mr-1"></i>
                    Statistik ini menghitung rata-rata kehadiran seluruh jemaat berdasarkan <strong><?= isset($minggu_berjalan) ? $minggu_berjalan : 0 ?> minggu</strong> data yang masuk bulan ini.
                </div>

                <?php if (empty($summary)): ?>
                    <div class="text-center text-muted py-4">
                        <img src="https://img.icons8.com/ios/50/cccccc/empty-box.png" class="mb-2"><br>
                        Belum ada data aktivitas.
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($summary as $s):
                            // 1. Validasi pembagi
                            $minggu_safe = (isset($minggu_berjalan) && $minggu_berjalan > 0) ? $minggu_berjalan : 1;

                            // 2. Hitung Rata-rata Global
                            $rata_rata_global = round($s->total / $minggu_safe, 1);

                            // 3. Hitung Persentase Partisipasi
                            $total_anggota_safe = ($total_anggota > 0) ? $total_anggota : 1;
                            $percent = ($rata_rata_global / $total_anggota_safe) * 100;

                            // 4. Warna Indikator
                            if ($percent >= 75) $color = 'bg-success';
                            elseif ($percent >= 50) $color = 'bg-primary';
                            elseif ($percent >= 25) $color = 'bg-warning';
                            else $color = 'bg-danger';
                        ?>
                            <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="font-weight-bold text-dark text-uppercase small text-truncate" title="<?= $s->nama ?>">
                                                <?= $s->kode ?> - <?= substr($s->nama, 0, 15) ?>...
                                            </div>
                                            <span class="badge badge-white border shadow-sm text-primary">
                                                <?= $rata_rata_global ?> Org
                                            </span>
                                        </div>

                                        <div class="progress mb-2" style="height: 6px;">
                                            <div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= $percent ?>%"
                                                aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                        <div class="d-flex justify-content-between small text-muted" style="font-size: 11px;">
                                            <span>Total: <?= $s->total ?></span>
                                            <span><strong><?= round($percent) ?>%</strong> Jemaat</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 1. DATA DARI PHP
    var labelAkt = [];
    var dataVal = [];

    <?php foreach ($summary as $s): ?>
        labelAkt.push('<?= $s->kode ?>');
        dataVal.push(<?= $s->total ?>);
    <?php endforeach; ?>

    // 2. SETUP CHART (BAR CHART)
    var ctx = document.getElementById("myBarChart");
    if (ctx) {
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labelAkt,
                datasets: [{
                    label: "Total Checklist",
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: dataVal,
                    barPercentage: 0.6,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 20
                        },
                        maxBarThickness: 50,
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value) {
                                return value;
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            return 'Terlaksana: ' + tooltipItem.yLabel + ' kali';
                        }
                    }
                },
            }
        });
    }
</script>