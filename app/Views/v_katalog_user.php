<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('failed')) : ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('failed') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-collection me-2"></i>Katalog Buku Perpustakaan</h4>
    </div>

    <div class="row">
        <?php if (!empty($buku)): ?>
            <?php foreach ($buku as $item): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm border-0" style="transition: transform 0.2s;">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle mb-2">
                                    ID: <?= esc($item['id_buku']) ?>
                                </span>
                            </div>
                            <h5 class="card-title fw-bold text-dark mb-1"><?= esc($item['judul']) ?></h5>
                            <p class="card-text text-muted small mb-2">
                                <i class="bi bi-person me-1"></i> <?= esc($item['pengarang']) ?>
                            </p>
                            <p class="card-text small mb-3">
                                <i class="bi bi-building me-1"></i> <?= esc($item['penerbit']) ?> (<?= esc($item['tahun']) ?>)
                            </p>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="small fw-bold">Tersedia: 
                                        <?php if($item['stok'] > 0): ?>
                                            <span class="text-success"><?= esc($item['stok']) ?> Buku</span>
                                        <?php else: ?>
                                            <span class="text-danger">Habis</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                
                                <?php if($item['stok'] > 0): ?>
                                    <a href="<?= base_url('buku/pinjam/' . esc($item['id_buku'])) ?>" class="btn btn-sm btn-primary w-100" onclick="return confirm('Apakah kamu yakin ingin meminjam buku <?= esc($item['judul']) ?>?')">
                                        <i class="bi bi-bookmark-plus"></i> Pinjam Buku
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-secondary w-100" disabled>
                                        <i class="bi bi-x-circle"></i> Stok Habis
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                <h5 class="text-muted">Belum ada buku di perpustakaan.</h5>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>

<?= $this->endSection() ?>