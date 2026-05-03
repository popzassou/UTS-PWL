<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">✏️ Edit User - <?= esc($user['username']) ?></h4>
        </div>
        <div class="card-body">
            <form action="<?= base_url('users/update/' . esc($user['username'])) ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label fw-bold">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= esc($user['username']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password Baru (Opsional)</label>
                         <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                              <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                     <i class="fas fa-eye"></i>
                              </button>
                         </div>
                        <small class="text-muted">Biarkan kosong jika password tidak ingin diganti.</small>
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label fw-bold">Role</label>
                    <select class="form-select" id="role" name="role">
                        <option value="user" <?= ($user['role'] == 'user') ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Toggle password visibility -->
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordField = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>

<?= $this->endSection() ?>
