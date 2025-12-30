<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Rekapitulasi Bulanan</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body bg-light border-left-success">
        <form action="" method="GET">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="font-weight-bold">Bulan:</label>
                    <select name="bulan" class="form-control">
                        <?php foreach ($list_bulan as $angka => $nama): ?>
                            <option value="<?= $angka ?>" <?= ($bulan_pilih == $angka) ? 'selected' : '' ?>>
                                <?= $nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label class="font-weight-bold">Tahun:</label>
                    <select name="tahun" class="form-control">
                        <?php for ($t = date('Y'); $t >= 2024; $t--): ?>
                            <option value="<?= $t ?>" <?= ($tahun_pilih == $t) ? 'selected' : '' ?>>
                                <?= $t ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold">Kelompok:</label>
                        <select name="id_kelompok" class="form-control" required>
                            <option value="">-- Pilih Kelompok --</option>
                            <?php foreach ($list_kelompok as $k): ?>
                                <option value="<?= $k->id ?>" <?= ($id_kelompok_pilih == $k->id) ? 'selected' : '' ?>>
                                    <?= $k->nama_kelompok ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="col-md-3 mb-3">
                    <label class="d-none d-md-block">&nbsp;</label>
                    <button type="submit" class="btn btn-success btn-block shadow-sm">
                        <i class="fas fa-search mr-1"></i> Tampilkan Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (isset($anggota)): ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-success mb-2 mb-md-0">
                Rekap: <?= $list_bulan[$bulan_pilih] ?> <?= $tahun_pilih ?>
                <span class="text-dark ml-2">(<?= $detail_kelompok->nama_kelompok ?>)</span>
            </h6>

            <div>
                <a href="<?= base_url('laporan/export_excel?bulan=' . $bulan_pilih . '&tahun=' . $tahun_pilih . '&id_kelompok=' . $id_kelompok_pilih) ?>"
                    target="_blank" class="btn btn-sm btn-success shadow-sm mr-2">
                    <i class="fas fa-file-excel fa-sm"></i> Excel (.xlsx)
                </a>

                <button type="button" id="btnDownloadImage" class="btn btn-sm btn-info shadow-sm">
                    <i class="fas fa-image fa-sm"></i> Gambar
                </button>
            </div>
        </div>

        <div class="card-body" id="areaLaporan">
            <div class="table-responsive" id="tableContainer">
                <table class="table table-bordered table-striped table-hover table-sm" width="100%" cellspacing="0" style="font-size: 12px; background-color: #fff;">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th class="align-middle" rowspan="2" width="3%">No</th>
                            <th class="align-middle text-left sticky-col" rowspan="2" style="min-width: 150px;">Nama Anggota</th>

                            <?php foreach ($list_aktivitas as $akt): ?>
                                <th class="align-middle" colspan="<?= $total_minggu ?>" data-toggle="tooltip" title="<?= $akt->nama_aktivitas ?>">
                                    <?= $akt->kode ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>

                        <tr>
                            <?php foreach ($list_aktivitas as $akt): ?>
                                <?php for ($m = 1; $m <= $total_minggu; $m++): ?>
                                    <th class="text-center bg-secondary text-white" style="width: 25px;"><?= $m ?></th>
                                <?php endfor; ?>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($anggota)): ?>
                            <tr>
                                <td colspan="<?= 2 + (count($list_aktivitas) * $total_minggu) ?>" class="text-center py-4">
                                    Data tidak ditemukan.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1;
                            foreach ($anggota as $a): ?>
                                <tr>
                                    <td class="text-center align-middle"><?= $no++ ?></td>
                                    <td class="font-weight-bold align-middle sticky-col"><?= $a['nama_anggota'] ?></td>

                                    <?php foreach ($list_aktivitas as $akt): ?>
                                        <?php for ($m = 1; $m <= $total_minggu; $m++):
                                            $is_checked = isset($rekap[$a['id']][$akt->id][$m]);
                                        ?>
                                            <td class="text-center align-middle p-0">
                                                <?php if ($is_checked): ?>
                                                    <i class="fas fa-check text-success font-weight-bold" style="font-size: 10px;"></i>
                                                <?php else: ?>
                                                    <span class="text-muted" style="opacity: 0.1; font-size:10px;">•</span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endfor; ?>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3 small text-muted">
                * Kolom 1-<?= $total_minggu ?> menunjukkan minggu ke-berapa aktivitas dilakukan (Sabat ke-X).
            </div>
        </div>
    </div>

    <style>
        /* Style default sticky column (saat normal view) */
        .sticky-col {
            position: sticky;
            left: 0;
            background-color: #f8f9fc;
            z-index: 5;
            border-right: 2px solid #dee2e6 !important;
        }

        /* Style khusus saat capture mode aktif 
           Ini kuncinya agar gambar full di HP 
        */
        .capture-mode .table-responsive {
            overflow: visible !important;
            /* Matikan scroll */
            display: block !important;
        }

        .capture-mode .sticky-col {
            position: static !important;
            /* Matikan sticky agar tidak error di html2canvas */
            border-right: 1px solid #dee2e6 !important;
        }

        .capture-mode {
            width: fit-content !important;
            /* Paksa lebar menyesuaikan konten tabel */
            min-width: 100%;
            background: white;
            padding: 10px;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        window.addEventListener('load', function() {
            var $ = window.jQuery;

            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();

                $('#btnDownloadImage').click(function() {
                    var btn = $(this);
                    var originalText = btn.html();
                    var element = document.querySelector("#areaLaporan");
                    var table = document.querySelector("table");

                    // 1. Ubah Button jadi loading
                    btn.html('<i class="fas fa-spinner fa-spin"></i> Proses...');
                    btn.prop('disabled', true);

                    // 2. Persiapan Capture: Tambahkan class mode capture
                    // Ini akan mematikan scroll dan sticky column via CSS
                    element.classList.add('capture-mode');

                    // Ambil dimensi asli tabel agar capture pas
                    var tableWidth = table.scrollWidth;
                    var tableHeight = table.scrollHeight + 50; // +padding

                    // 3. Eksekusi html2canvas dengan opsi khusus
                    html2canvas(element, {
                        scale: 2, // HD Quality
                        useCORS: true,
                        allowTaint: true,
                        width: tableWidth, // Paksa lebar canvas sesuai lebar tabel (bukan layar HP)
                        height: tableHeight,
                        windowWidth: tableWidth, // Simulasi window browser yang lebar
                        scrollX: 0,
                        scrollY: 0,
                        backgroundColor: '#ffffff'
                    }).then(canvas => {
                        // 4. Download Hasil
                        var link = document.createElement('a');
                        link.download = 'Rekap_<?= $detail_kelompok->nama_kelompok ?>_<?= $list_bulan[$bulan_pilih] ?>.png';
                        link.href = canvas.toDataURL("image/png");
                        link.click();

                        // 5. Kembalikan Tampilan seperti semula
                        element.classList.remove('capture-mode');
                        btn.html(originalText);
                        btn.prop('disabled', false);
                    }).catch(err => {
                        console.error("Gagal capture:", err);
                        alert("Gagal membuat gambar.");
                        element.classList.remove('capture-mode');
                        btn.html(originalText);
                        btn.prop('disabled', false);
                    });
                });
            });
        });
    </script>

<?php endif; ?>