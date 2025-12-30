<?php
$nama_hari   = date('l', strtotime($tanggal_pilih));
$tgl_display = date('d M Y', strtotime($tanggal_pilih));

$hari_map = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];
$hari_indo = $hari_map[$nama_hari] ?? $nama_hari;
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Input Absensi Mingguan</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body bg-white border-left-primary">
        <form action="" method="GET">
            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold">Tanggal Sabat:</label>
                    <input type="date" name="tanggal" id="inputTanggal" class="form-control" value="<?= $tanggal_pilih ?>" required>
                    <small class="text-muted mt-1 d-block" id="hariInfo">Hari: <?= $hari_indo ?></small>
                </div>

                <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <div class="col-md-4 mb-3">
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

                <div class="col-md-4 mb-3">
                    <label class="d-none d-md-block">&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block shadow-sm">
                        <i class="fas fa-filter mr-1"></i> Buka Absen
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<?php if (isset($anggota)): ?>

    <div class="card shadow mb-4 border-bottom-info">
        <a href="#collapseLegend" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseLegend">
            <h6 class="m-0 font-weight-bold text-info">
                <i class="fas fa-info-circle mr-1"></i> Keterangan Kode Aktivitas
            </h6>
        </a>
        <div class="collapse show" id="collapseLegend">
            <div class="card-body">
                <div class="row">
                    <?php foreach ($list_aktivitas as $akt): ?>
                        <div class="col-6 col-md-4 col-lg-3 mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-secondary mr-2" style="width: 60px; text-align:center;">
                                    <?= $akt->kode ?>
                                </span>
                                <span class="small text-dark font-weight-bold text-truncate" title="<?= $akt->nama_aktivitas ?>">
                                    <?= $akt->nama_aktivitas ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <form action="<?= base_url('absensi/store') ?>" method="POST" id="formAbsensi">
        <input type="hidden" name="tanggal" value="<?= $tanggal_pilih ?>">
        <input type="hidden" name="id_kelompok" value="<?= $id_kelompok_pilih ?>">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        Input: <span class="text-dark"><?= $detail_kelompok->nama_kelompok ?></span>
                    </h6>
                    <span class="badge badge-info mt-1" style="font-size: 0.9rem;">
                        <i class="fas fa-calendar-alt mr-1"></i> <?= $hari_indo ?>, <?= $tgl_display ?>
                    </span>
                </div>

                <button type="button" id="btnSimpanDesktop" class="btn btn-success btn-sm shadow-sm d-none d-md-block mt-2 mt-md-0">
                    <i class="fas fa-save mr-1"></i> Simpan Data
                </button>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive d-none d-md-block">
                    <table class="table table-bordered table-hover mb-0" width="100%" cellspacing="0">
                        <thead class="thead-light text-center">
                            <tr>
                                <th class="align-middle" width="5%">No</th>
                                <th class="align-middle text-left">Nama Anggota</th>
                                <?php foreach ($list_aktivitas as $akt): ?>
                                    <th class="align-middle" data-toggle="tooltip" title="<?= $akt->nama_aktivitas ?>">
                                        <?= $akt->kode ?>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($anggota)): ?>
                                <tr>
                                    <td colspan="<?= count($list_aktivitas) + 2 ?>" class="text-center py-4">Belum ada anggota.</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1;
                                foreach ($anggota as $a): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class="font-weight-bold"><?= $a->nama_anggota ?></td>
                                        <?php foreach ($list_aktivitas as $akt):
                                            $checked = isset($absen_data[$a->id][$akt->id]) ? 'checked' : '';
                                        ?>
                                            <td class="text-center">
                                                <input type="checkbox"
                                                    class="real-checkbox input-absen-<?= $a->id ?>"
                                                    data-id-anggota="<?= $a->id ?>"
                                                    data-id-aktivitas="<?= $akt->id ?>"
                                                    name="absen[<?= $a->id ?>][<?= $akt->id ?>]"
                                                    value="1"
                                                    <?= $checked ?>
                                                    style="transform: scale(1.3);">
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-md-none">
                    <?php if (empty($anggota)): ?>
                        <div class="text-center p-4 text-muted">Belum ada anggota.</div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($anggota as $a): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <div>
                                        <div class="font-weight-bold text-gray-800"><?= $a->nama_anggota ?></div>
                                        <div class="small text-muted mt-1">
                                            <span class="badge badge-light border" id="badge-count-<?= $a->id ?>">0</span> Aktivitas
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm btn-input-mobile rounded-pill px-3"
                                        data-id="<?= $a->id ?>"
                                        data-nama="<?= $a->nama_anggota ?>">
                                        Isi Absen <i class="fas fa-chevron-right ml-1"></i>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <div class="card-footer d-md-none fixed-bottom bg-white border-top shadow-lg p-3">
                <button type="button" id="btnSimpanMobile" class="btn btn-success btn-lg btn-block font-weight-bold">
                    <i class="fas fa-save mr-2"></i> SIMPAN SEMUA
                </button>
            </div>
        </div>
    </form>

    <div class="modal fade" id="modalInputMobile" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="mobileModalLabel">Nama Anggota</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="alert alert-info small mb-3">
                        Centang aktivitas yang dilakukan minggu ini (<?= $tgl_display ?>).
                    </div>

                    <div class="bg-white rounded shadow-sm p-2">
                        <?php foreach ($list_aktivitas as $akt): ?>
                            <div class="d-flex justify-content-between align-items-center border-bottom p-3">
                                <div>
                                    <div class="font-weight-bold text-dark"><?= $akt->nama_aktivitas ?></div>
                                    <div class="small text-muted"><?= $akt->kode ?></div>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input mobile-toggle" id="mob_switch_<?= $akt->id ?>">
                                    <label class="custom-control-label" for="mob_switch_<?= $akt->id ?>"></label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-block" data-dismiss="modal">Selesai</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            var $ = window.jQuery;

            $(document).ready(function() {

                // --- 1. VALIDASI HARI SABTU (SWEETALERT) ---
                $('#inputTanggal').on('change', function() {
                    var inputDate = new Date(this.value);
                    var day = inputDate.getDay();

                    // 6 = Sabtu
                    if (day !== 6) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Bukan Hari Sabtu',
                            text: 'Mohon maaf, sistem hanya menerima input untuk hari Sabtu.',
                            confirmButtonColor: '#4e73df',
                            confirmButtonText: 'Oke, Mengerti'
                        });
                        this.value = ''; // Reset tanggal
                        $('#hariInfo').text('Hari: -');
                        return;
                    }

                    var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $('#hariInfo').text('Hari: ' + days[day]);
                });

                // --- 2. KONFIRMASI SIMPAN (SWEETALERT) ---
                function confirmSimpan() {
                    Swal.fire({
                        title: 'Simpan Absensi?',
                        text: "Pastikan data yang diinput sudah benar untuk tanggal <?= $tgl_display ?>.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#1cc88a',
                        cancelButtonColor: '#858796',
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Tampilkan loading sebelum submit
                            Swal.fire({
                                title: 'Menyimpan...',
                                text: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            });
                            $('#formAbsensi').submit();
                        }
                    });
                }

                // Bind Tombol Simpan Desktop & Mobile
                $('#btnSimpanDesktop, #btnSimpanMobile').on('click', function(e) {
                    e.preventDefault();
                    confirmSimpan();
                });

                // --- 3. LOGIC SINKRONISASI MOBILE ---
                $('[data-toggle="tooltip"]').tooltip();

                var activeMemberId = null;

                $('.btn-input-mobile').click(function() {
                    activeMemberId = $(this).data('id');
                    var nama = $(this).data('nama');
                    $('#mobileModalLabel').text(nama);

                    $('.mobile-toggle').each(function() {
                        var aktId = $(this).attr('id').replace('mob_switch_', '');
                        var realCheckbox = $('input[name="absen[' + activeMemberId + '][' + aktId + ']"]');
                        $(this).prop('checked', realCheckbox.is(':checked'));
                    });

                    $('#modalInputMobile').modal('show');
                });

                $('.mobile-toggle').change(function() {
                    if (!activeMemberId) return;
                    var isChecked = $(this).is(':checked');
                    var aktId = $(this).attr('id').replace('mob_switch_', '');
                    var realCheckbox = $('input[name="absen[' + activeMemberId + '][' + aktId + ']"]');
                    realCheckbox.prop('checked', isChecked);
                    updateBadgeCount(activeMemberId);
                });

                function updateBadgeCount(memberId) {
                    var count = $('.input-absen-' + memberId + ':checked').length;
                    $('#badge-count-' + memberId).text(count);
                    if (count > 0) {
                        $('#badge-count-' + memberId).removeClass('badge-light').addClass('badge-success text-white');
                    } else {
                        $('#badge-count-' + memberId).removeClass('badge-success text-white').addClass('badge-light');
                    }
                }

                <?php foreach ($anggota as $a): ?>
                    updateBadgeCount(<?= $a->id ?>);
                <?php endforeach; ?>
            });
        });
    </script>

    <style>
        @media (max-width: 768px) {
            body {
                padding-bottom: 80px;
            }
        }
    </style>

<?php elseif (isset($id_kelompok_pilih)): ?>
    <div class="alert alert-info text-center shadow-sm">
        <i class="fas fa-info-circle mr-1"></i> Silakan pilih kelompok terlebih dahulu.
    </div>
<?php endif; ?>