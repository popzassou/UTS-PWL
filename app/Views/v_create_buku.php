<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-journal-plus me-2"></i>Tambah Buku Baru</h4>
        </div>
        <div class="card-body p-4">
            <div class="card-body p-4">
            <?php if (session()->getFlashdata('failed')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    <?= session()->getFlashdata('failed') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('buku/store') ?>" method="post">

            <form action="<?= base_url('buku/store') ?>" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_buku" class="form-label fw-bold">ID Buku</label>
                        <input type="text" class="form-control" id="id_buku" name="id_buku" required placeholder="Contoh: B003">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="judul" class="form-label fw-bold">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" required placeholder="Masukkan judul buku">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="pengarang" class="form-label fw-bold">Pengarang</label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang" required placeholder="Nama pengarang">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="penerbit" class="form-label fw-bold">Penerbit</label>
                        <input type="text" class="form-control" id="penerbit" name="penerbit" required placeholder="Nama penerbit">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="tahun" class="form-label fw-bold">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" required placeholder="Contoh: 2023">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="stok" class="form-label fw-bold">Jumlah Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" required min="0" placeholder="0">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan Data Buku</button>
                <a href="<?= base_url('buku') ?>" class="btn btn-secondary px-4 ms-2">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>