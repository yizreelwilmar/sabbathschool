<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Master Kelompok</h1>
    <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#modalTambah">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Kelompok
    </button>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kelompok</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Kelompok</th>
                        <th>Deskripsi</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($kelompok as $k): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="font-weight-bold text-dark"><?= $k->nama_kelompok ?></td>
                            <td><?= $k->deskripsi ?? '-' ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info btn-circle btn-edit"
                                    data-id="<?= $k->id ?>"
                                    data-nama="<?= $k->nama_kelompok ?>"
                                    data-desc="<?= $k->deskripsi ?>">
                                    <i class="fas fa-pen"></i>
                                </button>

                                <a href="<?= base_url('kelompok/delete/' . $k->id) ?>" class="btn btn-sm btn-danger btn-circle" onclick="return confirm('Yakin ingin menghapus kelompok ini? Data anggota di dalamnya juga akan terdampak.')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (empty($kelompok)): ?>
                <div class="text-center p-3 text-muted">Belum ada data kelompok.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kelompok Baru</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('kelompok/store') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kelompok</label>
                        <input type="text" name="nama_kelompok" class="form-control" placeholder="Contoh: Kelompok A (Sektor 1)" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Edit Kelompok</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('kelompok/update') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Nama Kelompok</label>
                        <input type="text" name="nama_kelompok" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" id="edit_desc" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Logic untuk melempar data ke Modal Edit
        $('.btn-edit').on('click', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const desc = $(this).data('desc');

            $('#edit_id').val(id);
            $('#edit_nama').val(nama);
            $('#edit_desc').val(desc);

            $('#modalEdit').modal('show');
        });
    });
</script>