<?php if ($view_type == 'groups'): ?>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Anggota Per Kelompok</h1>
    </div>

    <div class="row">
        <?php foreach ($groups as $g): ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="<?= base_url('anggota?id_kelompok=' . $g->id) ?>" class="text-decoration-none">
                    <div class="card border-left-primary shadow h-100 py-2 hover-scale">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?= $g->nama_kelompok ?></div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $g->total_anggota ?> <small class="text-muted" style="font-size: 12px">Anggota</small></div>
                                </div>
                                <div class="col-auto"><i class="fas fa-folder-open fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <style>
        .hover-scale {
            transition: transform 0.2s;
        }

        .hover-scale:hover {
            transform: scale(1.03);
            cursor: pointer;
        }
    </style>

<?php else: ?>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Anggota: <span class="text-primary"><?= $detail_kelompok->nama_kelompok ?></span></h1>
            <?php if ($this->session->userdata('role') == 'admin'): ?>
                <a href="<?= base_url('anggota') ?>" class="text-muted small"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Kelompok</a>
            <?php endif; ?>
        </div>
        <div>
            <button class="btn btn-success btn-sm shadow-sm mr-2" data-toggle="modal" data-target="#modalImport">
                <i class="fas fa-file-excel fa-sm"></i> Import Excel
            </button>
            <button class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-plus fa-sm"></i> Tambah Baru
            </button>
        </div>
    </div>

    <div class="card shadow mb-4 border-0">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="" method="GET" class="form-inline">
                        <?php if ($this->input->get('id_kelompok')): ?>
                            <input type="hidden" name="id_kelompok" value="<?= $this->input->get('id_kelompok') ?>">
                        <?php endif; ?>

                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control bg-light border-0 small" placeholder="Cari nama atau no hp..." value="<?= $keyword ?>" style="width: 250px;">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search fa-sm"></i></button>
                                <?php if ($keyword): ?>
                                    <a href="<?= base_url('anggota?id_kelompok=' . $detail_kelompok->id) ?>" class="btn btn-secondary" title="Reset Cari"><i class="fas fa-times"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right pt-2">
                    <span class="small text-muted">Total Data: <b><?= number_format($total_data) ?></b></span>
                </div>
            </div>

            <form action="<?= base_url('anggota/bulk_action') ?>" method="POST" id="formBulk">
                <input type="hidden" name="id_kelompok" value="<?= $detail_kelompok->id ?>">

                <div class="mb-3 p-2 bg-light border rounded" id="bulkOptions" style="display:none;">
                    <span class="mr-2 small font-weight-bold text-dark"><i class="fas fa-check-square"></i> Aksi Terpilih:</span>
                    <button type="submit" name="action" value="deactivate" class="btn btn-warning btn-sm text-white mr-1 shadow-sm"><i class="fas fa-ban"></i> Nonaktifkan</button>
                    <button type="submit" name="action" value="activate" class="btn btn-info btn-sm mr-1 shadow-sm"><i class="fas fa-check"></i> Aktifkan</button>
                    <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Yakin hapus data terpilih secara permanen?')"><i class="fas fa-trash"></i> Hapus</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                        <thead style="background-color: #4e73df; color: white;">
                            <tr>
                                <th width="5%" class="text-center align-middle">
                                    <input type="checkbox" id="checkAll" style="transform: scale(1.2);">
                                </th>
                                <th width="5%" class="align-middle">No</th>
                                <th class="align-middle">Nama Anggota</th>
                                <th class="align-middle">Tanggal Lahir</th>
                                <th class="align-middle">Status</th>
                                <th class="align-middle">No HP / WhatsApp</th>
                                <th width="10%" class="text-center align-middle">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($anggota)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
                                </tr>
                            <?php else: ?>
                                <?php
                                $page = $this->input->get('page') ? $this->input->get('page') : 0;
                                $no = $page + 1;
                                foreach ($anggota as $a):
                                ?>
                                    <tr class="<?= $a->status == 'nonaktif' ? 'text-muted' : '' ?>" style="<?= $a->status == 'nonaktif' ? 'background-color: #f8f9fa;' : '' ?>">
                                        <td class="text-center align-middle">
                                            <input type="checkbox" name="ids[]" value="<?= $a->id ?>" class="checkItem" style="transform: scale(1.2);">
                                        </td>
                                        <td class="align-middle"><?= $no++ ?></td>
                                        <td class="align-middle font-weight-bold"><?= $a->nama_anggota ?></td>
                                        <td class="align-middle"> <?php
                                                                    if ($a->tanggal_lahir && $a->tanggal_lahir != '0000-00-00') {
                                                                        echo date('d M Y', strtotime($a->tanggal_lahir));
                                                                    } else {
                                                                        echo '-';
                                                                    }
                                                                    ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php if ($a->status == 'aktif'): ?>
                                                <span class="badge badge-success px-2 py-1">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary px-2 py-1">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php if ($a->no_hp): $wa_num = preg_replace('/^0/', '62', $a->no_hp); ?>
                                                <a href="https://wa.me/<?= $wa_num ?>" target="_blank" class="btn btn-success btn-sm btn-icon-split shadow-sm">
                                                    <span class="icon text-white-50"><i class="fab fa-whatsapp"></i></span>
                                                    <span class="text small"><?= $a->no_hp ?></span>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-outline-info btn-sm btn-circle btn-edit mr-1"
                                                data-id="<?= $a->id ?>"
                                                data-nama="<?= $a->nama_anggota ?>"
                                                data-tgl="<?= $a->tanggal_lahir ?>" data-hp="<?= $a->no_hp ?>">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <a href="<?= base_url('anggota/delete/' . $a->id) ?>" class="btn btn-outline-danger btn-sm btn-circle" onclick="return confirm('Hapus anggota ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="row mt-3">
                <div class="col-md-12">
                    <nav aria-label="Page navigation"><?= $pagination; ?></nav>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Anggota Manual</h5>
                    <button class="close text-white" type="button" data-dismiss="modal">×</button>
                </div>
                <form action="<?= base_url('anggota/store') ?>" method="POST">
                    <input type="hidden" name="id_kelompok" value="<?= $detail_kelompok->id ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_anggota" class="form-control" required placeholder="Nama sesuai KTP">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>No HP (Opsional)</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="08...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-pen mr-2"></i>Edit Anggota</h5>
                    <button class="close text-white" type="button" data-dismiss="modal">×</button>
                </div>
                <form action="<?= base_url('anggota/update') ?>" method="POST">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="id_kelompok" value="<?= $detail_kelompok->id ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_anggota" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="edit_tgl" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>No HP / WhatsApp</label>
                            <input type="text" name="no_hp" id="edit_hp" class="form-control" placeholder="08...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalImport" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-file-excel mr-2"></i>Import Anggota</h5>
                    <button class="close text-white" type="button" data-dismiss="modal">×</button>
                </div>
                <form action="<?= base_url('anggota/import') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_kelompok" value="<?= $detail_kelompok->id ?>">
                    <div class="modal-body">
                        <div class="alert alert-info small">
                            <strong>Panduan Import:</strong><br>
                            1. Data akan masuk ke kelompok <b><?= $detail_kelompok->nama_kelompok ?></b>.<br>
                            2. Wajib gunakan template .csv.
                        </div>
                        <div class="form-group border-bottom pb-3">
                            <label class="font-weight-bold">Langkah 1: Download Template</label><br>
                            <a href="<?= base_url('anggota/download_template') ?>" class="btn btn-outline-success btn-sm btn-block">
                                <i class="fas fa-download mr-1"></i> Download Template (.csv)
                            </a>
                        </div>
                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Langkah 2: Upload File</label>
                            <input type="file" name="file_csv" class="form-control-file" required accept=".csv">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Upload & Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tunggu sampai window load agar jQuery dari footer pasti sudah ada
        window.addEventListener('load', function() {
            var $ = window.jQuery; // Pastikan menggunakan jQuery yang sudah dimuat

            $(document).ready(function() {

                // 1. LOGIC MODAL EDIT
                $(document).on('click', '.btn-edit', function(e) {
                    e.preventDefault(); // Mencegah reload halaman

                    var id = $(this).data('id');
                    var nama = $(this).data('nama');
                    var tgl = $(this).data('tgl'); // AMBIL DATA TGL
                    var hp = $(this).attr('data-hp'); // Pakai attr biar angka 0 depan tidak hilang

                    $('#edit_id').val(id);
                    $('#edit_nama').val(nama);
                    $('#edit_tgl').val(tgl); // ISI KE INPUT TGL
                    $('#edit_hp').val(hp);

                    $('#modalEdit').modal('show');
                });

                // 2. LOGIC CHECKLIST (BULK ACTION)

                // Klik "Check All"
                $(document).on('click', '#checkAll', function() {
                    var isChecked = $(this).prop('checked');
                    $('.checkItem').prop('checked', isChecked);
                    toggleBulkPanel();
                });

                // Klik Salah Satu Item
                $(document).on('change', '.checkItem', function() {
                    var totalCheckbox = $('.checkItem').length;
                    var totalChecked = $('.checkItem:checked').length;

                    // Jika semua dicentang, maka checkAll juga dicentang
                    if (totalChecked === totalCheckbox) {
                        $('#checkAll').prop('checked', true);
                    } else {
                        $('#checkAll').prop('checked', false);
                    }
                    toggleBulkPanel();
                });

                // Fungsi Menampilkan/Menyembunyikan Tombol Aksi
                function toggleBulkPanel() {
                    var checkedCount = $('.checkItem:checked').length;
                    if (checkedCount > 0) {
                        $('#bulkOptions').stop(true, true).fadeIn(200);
                    } else {
                        $('#bulkOptions').stop(true, true).fadeOut(200);
                    }
                }
            });
        });
    </script>

<?php endif; ?>