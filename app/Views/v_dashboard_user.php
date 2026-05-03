<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">Selamat Datang, <strong><?= esc($username) ?></strong></h2>
<p class="mb-5 text-muted">Role Anda: <span class="badge bg-info text-white"><?= esc($role) ?></span></p>

<div class="row mb-4">
    <div class="col-md-7 mb-4">
        <div class="card shadow border-0 h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0 text-white"><i class="bi bi-book-half me-2"></i>Status Peminjaman Terakhir</h5>
            </div>
            <div class="card-body pt-4">
                <?php if ($bukuTerakhir): ?>
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%" class="text-muted">Judul Buku</th>
                            <td class="fw-bold fs-5 text-primary"><?= esc($bukuTerakhir['judul']) ?></td>
                        </tr>
                        <tr>
                            <th class="text-muted">ID Transaksi</th>
                            <td><span class="badge bg-light text-dark border"><?= esc($bukuTerakhir['id_pinjam']) ?></span></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tanggal Peminjaman</th>
                            <td><?= date('d F Y', strtotime($bukuTerakhir['tgl_pinjam'])) ?></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Jatuh Tempo</th>
                            <td><span class="text-danger fw-bold"><?= date('d F Y', strtotime($bukuTerakhir['tgl_kembali'])) ?></span></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Status</th>
                            <td><span class="badge bg-success px-3 py-2"><?= esc($bukuTerakhir['status']) ?></span></td>
                        </tr>
                    </table>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-journal-x fs-1 text-muted"></i>
                        <p class="mt-3 text-muted">Belum ada buku yang sedang dipinjam.</p>
                        <a href="<?= base_url('katalog') ?>" class="btn btn-outline-primary mt-2">Lihat Katalog Buku</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Ringkasan Akun -->
    <div class="col-md-5 mb-4">
        <div class="card shadow border-0 h-100">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0 text-white"><i class="bi bi-person-lines-fill me-2"></i>Ringkasan Akun</h5>
            </div>
            <div class="card-body pt-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; flex-shrink: 0;">
                        <i class="bi bi-journal-bookmark-fill fs-3 text-primary"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Total Buku Dipinjam</h6>
                        <h3 class="fw-bold mb-0"><?= esc($totalDipinjam) ?> <span class="fs-6 fw-normal text-muted">Buku</span></h3>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Terlambat:</span>
                    <span class="fw-bold text-dark"><?= esc($totalTerlambat) ?> kali</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Tagihan Denda:</span>
                    <span class="fw-bold <?= $totalDenda > 0 ? 'text-danger' : 'text-success' ?>">
                        Rp <?= number_format($totalDenda, 0, ',', '.') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow border-0 mt-2">
    <div class="card-header bg-white border-bottom pt-3 pb-3">
        <h5 class="card-title mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Semua Transaksi</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($riwayat)): ?>
                        <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td class="ps-4 fw-bold"><?= esc($r['judul']) ?></td>
                                <td><?= date('d M Y', strtotime($r['tgl_pinjam'])) ?></td>
                                <td><?= date('d M Y', strtotime($r['tgl_kembali'])) ?></td>
                                <td>
                                    <?php if($r['status'] == 'Dipinjam'): ?>
                                        <span class="badge bg-success rounded-pill"><?= esc($r['status']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary rounded-pill"><?= esc($r['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada riwayat transaksi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
