<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0"><i class="bi bi-arrow-left-right me-2"></i>Transaksi Peminjaman</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">                       <thead class="bg-light">
                        <tr>
                            <th class="ps-3">ID Transaksi</th>
                            <th>Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Batas Waktu</th>
                            <th>Denda</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transaksi)): ?>
                            <?php foreach ($transaksi as $t): ?>
                                <tr>
                                    <td class="ps-3"><span class="badge bg-secondary"><?= esc($t['id_pinjam']) ?></span></td>
                                    <td class="fw-bold"><?= esc($t['username']) ?></td>
                                    <td><?= esc($t['judul']) ?></td>
                                    <td>
                                        <?= date('d M Y', strtotime($t['tgl_kembali'])) ?>
                                        <?php if ($t['status'] === 'Dipinjam' && $t['denda_berjalan'] > 0): ?>
                                            <br><small class="text-danger fw-bold">Telat!</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($t['status'] === 'Dipinjam' && $t['denda_berjalan'] > 0): ?>
                                            <span class="text-danger fw-bold">Rp <?= number_format($t['denda_berjalan'], 0, ',', '.') ?></span>
                                        <?php else: ?>
                                            <span class="text-success">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($t['status'] === 'Dipinjam'): ?>
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Dikembalikan</span>
                                            <br><small class="text-muted"><?= date('d M Y', strtotime($t['tgl_dikembalikan'] ?? '')) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($t['status'] === 'Dipinjam'): ?>
                                            <a href="<?= base_url('transaksi/kembali/' . esc($t['id_pinjam']) . '/' . esc($t['id_buku'])) ?>" class="btn btn-sm btn-primary" onclick="return confirm('Proses pengembalian buku? Pastikan denda (jika ada) sudah dibayar oleh user.')">
                                                <i class="bi bi-box-arrow-in-down"></i> Kembalikan
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-outline-secondary" disabled>Selesai</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada transaksi peminjaman.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>