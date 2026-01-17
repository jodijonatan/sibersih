<?php
$requireAdmin = true;
$pageTitle = "Manajemen Pengguna";
include "../includes/auth_check.php";
include "../includes/config.php";
include "../includes/header.php";

// Ambil semua user
$sql = "SELECT id, username, role FROM users ORDER BY id DESC";
$result = $conn->query($sql);

// CSS kustom
echo '
<style>
    .user-table th {
        font-weight: 600;
        color: #34495e;
        border-bottom: 2px solid #e0e0e0 !important;
    }
    .user-table td {
        background-color: #ffffff;
        padding: 12px;
        border-bottom: 1px solid #f0f0f0 !important;
    }
    .badge-admin {
        background-color: #3498db;
        color: white;
        padding: 0.5em 0.8em;
    }
    .badge-user {
        background-color: #2ecc71;
        color: white;
        padding: 0.5em 0.8em;
    }
    /* Sembunyikan kolom ID di mobile (di bawah medium) */
    @media (max-width: 767.98px) {
        .user-table th:nth-child(1),
        .user-table td:nth-child(1) {
            display: none;
        }
    }
</style>
';
?>

<div class="p-4">

  <div class="card bg-dark text-white border-0 shadow-sm mb-4">
    <div class="card-body">
      <h3 class="mb-0 fw-bold fs-4 fs-md-3">
        <i class="fas fa-users-cog me-2"></i> Kelola Daftar Pengguna
      </h3>
      <p class="mb-0 small opacity-75">Lihat atau hapus akun pengguna dan admin.</p>
    </div>
  </div>

  <?php if ($result->num_rows > 0): ?>
    <div class="card shadow">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table align-middle user-table mb-0">
            <thead>
              <tr>
                <th class="py-3 ps-4">ID</th>
                <th class="py-3">Username</th>
                <th class="py-3">Role</th>
                <th class="py-3 pe-4">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <?php while ($user = $result->fetch_assoc()): ?>
                <tr>
                  <td class="ps-4 text-muted small"><?= $user['id'] ?></td>
                  <td class="fw-bold"><?= htmlspecialchars($user['username']) ?></td>

                  <td>
                    <span class="badge badge-<?= $user['role'] == 'admin' ? 'admin' : 'user' ?>">
                      <i class="fas fa-<?= $user['role'] == 'admin' ? 'user-shield' : 'user' ?> me-1"></i>
                      <?= ucfirst($user['role']) ?>
                    </span>
                  </td>

                  <td>
                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                      <a href="users_delete.php?id=<?= $user['id'] ?>"
                        class="btn btn-sm btn-outline-danger"
                        title="Hapus Pengguna"
                        onclick="return confirm('Yakin ingin menghapus pengguna <?= htmlspecialchars($user['username']) ?>? Tindakan ini tidak dapat dibatalkan.')">

                        <i class="fas fa-trash"></i>
                        <span class="d-none d-md-inline"> Hapus</span>
                      </a>
                    <?php else: ?>
                      <span class="text-muted small">
                        <i class="fas fa-lock me-1"></i> Akun Anda
                      </span>
                    <?php endif; ?>
                  </td>

                </tr>
              <?php endwhile; ?>
            </tbody>

          </table>
        </div>
      </div>
    </div>

  <?php else: ?>
    <div class="alert alert-info text-center py-4 shadow-sm">
      <h4 class="alert-heading"><i class="fas fa-info-circle me-2"></i> Tidak ada pengguna terdaftar selain Anda.</h4>
      <p>Database pengguna kosong.</p>
    </div>
  <?php endif; ?>

</div>

</div>
</main>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>