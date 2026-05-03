<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
    .custom-header {
        background-color: #b095fc;
        color: white;
        padding: 1rem;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .custom-card {
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        background-color: #fdfdff;
    }

    .btn-custom {
        background-color: #b095fc;
        color: white;
    }

    .btn-custom:hover {
        background-color: #9b82f0;
        color: white;
    }

    .table thead {
        background-color: #f0eaff;
    }

    .table tbody tr:hover {
        background-color: #f7f3ff;
    }
</style>

<div class="container mt-4">
    <div class="custom-card">
        <div class="custom-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Manajemen Katalog Buku</h5>
            <a href="<?= base_url('buku/create') ?>" class="btn btn-light text-dark">
                <i class="bi bi-plus-circle"></i> Tambah Buku
            </a>
        </div>
        <div class="p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID Buku</th>
                            <th>Judul Buku</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($buku)): ?>
                            <?php foreach ($buku as $index => $item): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><span class="badge bg-secondary"><?= esc($item['id_buku']) ?></span></td>
                                    <td class="fw-bold"><?= esc($item['judul']) ?></td>
                                    <td><?= esc($item['pengarang']) ?></td>
                                    <td><?= esc($item['penerbit']) ?></td>
                                    <td><?= esc($item['tahun']) ?></td>
                                    <td>
                                        <?php if($item['stok'] > 0): ?>
                                            <span class="badge bg-success"><?= esc($item['stok']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Habis</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('buku/edit/' . esc($item['id_buku'])) ?>" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('buku/delete/' . esc($item['id_buku'])) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Belum ada data buku di perpustakaan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>  