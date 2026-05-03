<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Buku - <?= esc($buku['id_buku']) ?></h4>
        </div>
        <div class="card-body p-4">
            <form action="<?= base_url('buku/update/' . esc($buku['id_buku'])) ?>" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_buku" class="form-label fw-bold">ID Buku</label>
                        <input type="text" class="form-control bg-light" id="id_buku" name="id_buku" value="<?= esc($buku['id_buku']) ?>" readonly>
                        <small class="text-muted">ID Buku tidak dapat diubah.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="judul" class="form-label fw-bold">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="<?= esc($buku['judul']) ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="pengarang" class="form-label fw-bold">Pengarang</label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?= esc($buku['pengarang']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="penerbit" class="form-label fw-bold">Penerbit</label>
                        <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?= esc($buku['penerbit']) ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="tahun" class="form-label fw-bold">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" value="<?= esc($buku['tahun']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="stok" class="form-label fw-bold">Jumlah Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" value="<?= esc($buku['stok']) ?>" required min="0">
                    </div>
                </div>

                <button type="submit" class="btn btn-warning px-4 text-white">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="<?= base_url('buku') ?>" class="btn btn-secondary px-4 ms-2">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>