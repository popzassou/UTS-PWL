<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <!-- Alert Notifikasi -->
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

    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3 d-flex align-items-center">
            <h5 class="mb-0"><i class="bi bi-collection me-2"></i>Katalog Buku Perpustakaan</h5>
        </div>
        <div class="card-body p-3">
            <!-- Tambahkan class datatable di sini -->
            <div class="table-responsive">
                <table class="table table-hover align-middle datatable">
                    <thead class="bg-light">
                        <tr>
                            <th width="10%">Cover</th>
                            <th width="35%">Informasi Buku</th>
                            <th width="25%">Penerbit & Tahun</th>
                            <th width="15%">Ketersediaan</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($buku)): ?>
                            <?php foreach ($buku as $item): ?>
                                <tr>
                                    <td>
                                        <div class="bg-primary bg-opacity-10 text-primary rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 65px;">
                                            <i class="bi bi-book fs-3"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="fw-bold mb-1 text-dark"><?= esc($item['judul']) ?></h6>
                                        <small class="text-muted"><i class="bi bi-person me-1"></i><?= esc($item['pengarang']) ?></small><br>
                                        <small class="text-muted"><i class="bi bi-upc-scan me-1"></i>ID: <?= esc($item['id_buku']) ?></small>
                                    </td>
                                    <td>
                                        <span><?= esc($item['penerbit']) ?></span><br>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle"><?= esc($item['tahun']) ?></span>
                                    </td>
                                    <td>
                                        <?php if($item['stok'] > 0): ?>
                                            <span class="badge bg-success rounded-pill px-3"><?= esc($item['stok']) ?> Tersedia</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger rounded-pill px-3">Habis</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($item['stok'] > 0): ?>
                                            <a href="<?= base_url('buku/pinjam/' . esc($item['id_buku'])) ?>" class="btn btn-sm btn-primary w-100" onclick="return confirm('Apakah kamu yakin ingin meminjam buku <?= esc($item['judul']) ?>?')">
                                                <i class="bi bi-bookmark-plus"></i> Pinjam
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary w-100" disabled>
                                                <i class="bi bi-x-circle"></i> Habis
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>