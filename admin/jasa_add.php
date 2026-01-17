<?php
$requireAdmin = true;
$pageTitle = "Tambah Jasa Baru"; // Ubah judul menjadi lebih deskriptif
include "../includes/config.php";
include "../includes/header.php";

$message = '';
$messageType = '';

if (isset($_POST['submit'])) {
  $nama_jasa = $_POST['nama_jasa'];
  $deskripsi = $_POST['deskripsi'];
  $harga = $_POST['harga'];

  // Upload gambar
  $gambar = null;
  if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $gambar = uniqid() . '.' . $ext;
    // Pastikan direktori 'uploads' ada di level yang benar
    move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/$gambar");
  }

  $sql = "INSERT INTO jasa (nama_jasa, deskripsi, harga, gambar) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  // Harga disimpan sebagai string (s) jika menggunakan step="0.01" atau double (d) jika database menggunakan FLOAT/DOUBLE
  // Di sini saya asumsikan harga adalah DOUBLE/DECIMAL (d)
  $stmt->bind_param("ssds", $nama_jasa, $deskripsi, $harga, $gambar);

  if ($stmt->execute()) {
    $message = "🎉 Jasa berhasil ditambahkan! Anda dapat melihatnya di daftar jasa.";
    $messageType = "success";

    // Reset form data setelah sukses
    $nama_jasa = $deskripsi = $harga = '';
  } else {
    $message = "❌ Gagal menambahkan jasa: " . $stmt->error;
    $messageType = "danger";
  }
}
?>

<div class="p-4">

  <div class="card bg-info text-white border-0 shadow-sm mb-4">
    <div class="card-body">
      <h3 class="mb-0 fw-bold fs-4 fs-md-3">
        <i class="fas fa-plus-square me-2"></i> Formulir Tambah Jasa
      </h3>
      <p class="mb-0 small opacity-75">Masukkan detail layanan kebersihan yang baru.</p>
    </div>
  </div>

  <?php if ($message): ?>
    <div class="alert alert-<?= $messageType ?> alert-dismissible fade show shadow-sm" role="alert">
      <?= $message ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <div class="card shadow">
    <div class="card-body p-4">
      <form method="POST" enctype="multipart/form-data">

        <div class="row">
          <div class="col-md-6">
            <div class="mb-4">
              <label class="form-label fw-bold text-primary"><i class="fas fa-tag me-2"></i> Nama Jasa</label>
              <input type="text" name="nama_jasa" class="form-control form-control-lg" placeholder="Contoh: General Cleaning Rumah" value="<?= $nama_jasa ?? '' ?>" required>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold text-primary"><i class="fas fa-file-alt me-2"></i> Deskripsi Lengkap</label>
              <textarea name="deskripsi" class="form-control" rows="5" placeholder="Jelaskan secara singkat ruang lingkup pekerjaan ini..."><?= $deskripsi ?? '' ?></textarea>
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-4">
              <label class="form-label fw-bold text-primary"><i class="fas fa-money-bill-wave me-2"></i> Harga (Rp)</label>
              <input type="number" step="1000" name="harga" class="form-control form-control-lg" placeholder="Contoh: 150000 (tanpa titik/koma)" value="<?= $harga ?? '' ?>" required>
              <div class="form-text">Gunakan angka penuh (misal: 150000).</div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold text-primary"><i class="fas fa-camera me-2"></i> Gambar Jasa (Thumbnail)</label>
              <input type="file" name="gambar" class="form-control" accept="image/*">
              <div class="form-text">Format yang diterima: JPG, PNG. Ukuran maksimal: 2MB.</div>
            </div>

            <hr class="my-4">

            <div class="d-grid gap-3 d-md-flex justify-content-md-between">
              <a href="jasa_list.php" class="btn btn-outline-secondary btn-lg order-2 order-md-1">
                <i class="fas fa-arrow-left me-2"></i> Kembali
              </a>
              <button type="submit" name="submit" class="btn btn-primary btn-lg shadow-sm order-1 order-md-2">
                <i class="fas fa-save me-2"></i> Simpan Jasa
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

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