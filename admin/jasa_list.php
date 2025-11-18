<?php
$requireAdmin = true;
$pageTitle = "Kelola Daftar Jasa";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/config.php";

$sql = "SELECT * FROM jasa";
$result = $conn->query($sql);
?>

<style>
  /* CSS Kustom untuk tampilan tabel yang lebih bersih */
  .service-table {
    border-collapse: separate;
    border-spacing: 0 10px;
    /* Jarak antar baris */
  }

  .service-table th {
    font-weight: 600;
    color: #34495e;
    border-bottom: 2px solid #e0e0e0;
  }

  .service-table td {
    background-color: #ffffff;
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
  }

  /* Mengatur tinggi dan lebar gambar di tabel */
  .jasa-img {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  }

  /* Batasi deskripsi agar tabel rapi */
  .desc-cell {
    max-width: 250px;
    /* Batasi lebar kolom */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>

<div class="p-4">

  <div class="card bg-light border-0 shadow-sm mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
      <h2 class="mb-0 text-primary fw-bold">
        <i class="fas fa-list-ul me-2"></i> Daftar & Kelola Jasa
      </h2>
      <a href="jasa_add.php" class="btn btn-success btn-lg shadow-sm">
        <i class="fas fa-plus-circle me-2"></i> Tambah Jasa Baru
      </a>
    </div>
  </div>

  <?php if ($result->num_rows > 0): ?>
    <div class="card shadow">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table align-middle service-table mb-0">
            <thead class="table-light">
              <tr>
                <th class="py-3 ps-4">ID</th>
                <th class="py-3">Gambar</th>
                <th class="py-3">Nama Jasa</th>
                <th class="py-3">Deskripsi</th>
                <th class="py-3">Harga</th>
                <th class="py-3 pe-4 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($jasa = $result->fetch_assoc()): ?>
                <tr>
                  <td class="ps-4"><?= $jasa['id'] ?></td>
                  <td>
                    <?php if ($jasa['gambar']): ?>
                      <img src="../uploads/<?= $jasa['gambar'] ?>" alt="<?= $jasa['nama_jasa'] ?>" class="jasa-img">
                    <?php else: ?>
                      <span class="text-muted small">N/A</span>
                    <?php endif; ?>
                  </td>
                  <td class="fw-bold"><?= $jasa['nama_jasa'] ?></td>
                  <td class="text-muted desc-cell" title="<?= $jasa['deskripsi'] ?>">
                    <?= $jasa['deskripsi'] ?>
                  </td>
                  <td class="text-success fw-bold">Rp <?= number_format($jasa['harga'], 0, ',', '.') ?></td>
                  <td class="text-center pe-4">
                    <div class="d-flex justify-content-center">
                      <a href="jasa_edit.php?id=<?= $jasa['id'] ?>" class="btn btn-sm btn-outline-warning me-2" title="Edit">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="jasa_delete.php?id=<?= $jasa['id'] ?>" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus jasa <?= $jasa['nama_jasa'] ?>? Tindakan ini tidak dapat dibatalkan.')">
                        <i class="fas fa-trash"></i>
                      </a>
                    </div>
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
      <h4 class="alert-heading"><i class="fas fa-info-circle me-2"></i> Belum ada jasa yang terdaftar.</h4>
      <p>Silakan klik tombol "Tambah Jasa Baru" untuk mulai menambahkan layanan.</p>
    </div>
  <?php endif; ?>

</div> <?php
        // Tutup layout dari header.php
        ?>
</div>
</main>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>