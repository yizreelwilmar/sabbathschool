<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Pengurus</h1>
    <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#modalTambah">
        <i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Pengurus
    </button>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Akun Pengurus</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Mengelola Kelompok</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($pengurus as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="font-weight-bold text-dark"><?= $p->nama_lengkap ?></td>
                            <td>
                                <span class="badge badge-light border px-2"><?= $p->username ?></span>
                            </td>
                            <td>
                                <?php if ($p->nama_kelompok): ?>
                                    <span class="badge badge-info"><?= $p->nama_kelompok ?></span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Belum Assign</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info btn-circle btn-edit"
                                    data-id="<?= $p->id ?>"
                                    data-nama="<?= $p->nama_lengkap ?>"
                                    data-user="<?= $p->username ?>"
                                    data-kelompok="<?= $p->id_kelompok ?>">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <a href="<?= base_url('pengurus/delete/' . $p->id) ?>" class="btn btn-sm btn-danger btn-circle" onclick="return confirm('Hapus akun pengurus ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (empty($pengurus)): ?>
                <div class="text-center p-3 text-muted">Belum ada data pengurus.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Buat Akun Pengurus</h5>
                <button class="close text-white" type="button" data-dismiss="modal">×</button>
            </div>
            <form action="<?= base_url('pengurus/store') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kelompok yang Dikelola</label>
                        <select name="id_kelompok" class="form-control" required>
                            <option value="">-- Pilih Kelompok --</option>
                            <?php foreach ($list_kelompok as $lk): ?>
                                <option value="<?= $lk->id ?>"><?= $lk->nama_kelompok ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
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
                <h5 class="modal-title">Edit Pengurus</h5>
                <button class="close text-white" type="button" data-dismiss="modal">×</button>
            </div>
            <form action="<?= base_url('pengurus/update') ?>" method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kelompok</label>
                        <select name="id_kelompok" id="edit_kelompok" class="form-control" required>
                            <option value="">-- Pilih Kelompok --</option>
                            <?php foreach ($list_kelompok as $lk): ?>
                                <option value="<?= $lk->id ?>"><?= $lk->nama_kelompok ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" id="edit_user" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password Baru <small class="text-muted">(Kosongkan jika tidak ingin ubah)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="***">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-edit').on('click', function() {
            $('#edit_id').val($(this).data('id'));
            $('#edit_nama').val($(this).data('nama'));
            $('#edit_user').val($(this).data('user'));
            $('#edit_kelompok').val($(this).data('kelompok'));
            $('#modalEdit').modal('show');
        });
    });
</script>