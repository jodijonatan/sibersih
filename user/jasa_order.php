<?php
$requireAdmin = false;
$pageTitle = "Konfirmasi Order Jasa";
include "../includes/config.php";
include "../includes/header.php";

$message = '';
$messageType = '';

if (!isset($_GET['id'])) {
  $message = "ID jasa tidak ditemukan. Kembali ke daftar jasa.";
  $messageType = "warning";
} else {
  $jasa_id = $_GET['id'];
  // Pastikan user_id tersedia
  $user_id = $_SESSION['user_id'] ?? 0;

  // Check if user_id is valid before proceeding
  if ($user_id == 0) {
    // Redirect atau berikan pesan error jika user_id tidak ada
    $message = "Sesi pengguna berakhir. Silakan login kembali.";
    $messageType = "danger";
    $jasa = null;
  } else {
    // Ambil data jasa (Menggunakan prepared statement)
    $sql = "SELECT * FROM jasa WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $jasa_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $jasa = $result->fetch_assoc();
    $stmt->close();

    if (!$jasa) {
      $message = "Jasa tidak ditemukan.";
      $messageType = "danger";
    }

    // Proses submit order
    if (isset($_POST['submit']) && $jasa) {
      $full_name = htmlspecialchars($_POST['full_name']);
      $lokasi = htmlspecialchars($_POST['lokasi']);
      $phone = htmlspecialchars($_POST['phone']);
      $tanggal_layanan = $_POST['tanggal_layanan'];
      $metode_pembayaran = $_POST['metode_pembayaran'];

      $sqlInsert = "INSERT INTO orders 
                          (user_id, jasa_id, full_name, lokasi, phone, tanggal_layanan, metode_pembayaran)
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmtInsert = $conn->prepare($sqlInsert);
      $stmtInsert->bind_param("iisssss", $user_id, $jasa_id, $full_name, $lokasi, $phone, $tanggal_layanan, $metode_pembayaran);

      if ($stmtInsert->execute()) {
        $message = "🎉 Order berhasil dibuat! Anda akan dihubungi untuk konfirmasi layanan. Terima kasih!";
        $messageType = "success";
      } else {
        $message = "Gagal membuat order. Silakan coba lagi. Error: " . $stmtInsert->error;
        $messageType = "danger";
      }
      $stmtInsert->close();
    }
  }
}
?>

<div class="container-fluid py-4">
  <?php if ($message): ?>
    <div class="alert alert-<?= $messageType ?> alert-dismissible fade show" role="alert">
      <i class="fas fa-<?= ($messageType == 'success' ? 'check-circle' : 'exclamation-triangle') ?> me-2"></i>
      <?= $message ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <?php if (isset($jasa) && $jasa): ?>
    <div class="row g-4">

      <div class="col-lg-5">
        <div class="card shadow-lg h-100 border-0">
          <div class="card-header bg-primary text-white text-center py-3 rounded-top-3">
            <h4 class="mb-0 fw-bold"><i class="fas fa-box-open me-2"></i> Rincian Pesanan</h4>
          </div>
          <?php if ($jasa['gambar']): ?>
            <img src="../uploads/<?= $jasa['gambar'] ?>" class="card-img-top" alt="<?= $jasa['nama_jasa'] ?>" style="height:300px; object-fit:cover;">
          <?php else: ?>
            <div class="bg-light d-flex justify-content-center align-items-center" style="height:300px;">
              <i class="fas fa-broom fa-5x text-muted opacity-50"></i>
            </div>
          <?php endif; ?>
          <div class="card-body">
            <h3 class="card-title text-primary fw-bold mb-3"><?= $jasa['nama_jasa'] ?></h3>

            <p class="text-muted border-bottom pb-2"><?= $jasa['deskripsi'] ?></p>

            <div class="d-flex justify-content-between align-items-center mt-3 p-3 bg-light rounded-3 border">
              <h5 class="mb-0 text-secondary">Total Biaya Jasa:</h5>
              <h2 class="mb-0 text-success fw-bolder">Rp <?= number_format($jasa['harga'], 0, ',', '.') ?></h2>
            </div>
            <p class="mt-2 small text-muted text-center">Biaya ini belum termasuk biaya tambahan tak terduga (jika ada).</p>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="card shadow h-100 border-0">
          <div class="card-header bg-secondary text-white py-3 rounded-top-3">
            <h4 class="mb-0 fw-bold"><i class="fas fa-clipboard-list me-2"></i> Lengkapi Detail Order</h4>
          </div>
          <div class="card-body p-4">
            <form method="POST">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold"><i class="fas fa-user me-2 text-primary"></i> Nama Lengkap</label>
                  <input type="text" name="full_name" class="form-control form-control-lg" placeholder="Nama Anda" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold"><i class="fas fa-phone me-2 text-primary"></i> Nomor HP</label>
                  <input type="tel" name="phone" class="form-control form-control-lg" placeholder="Contoh: 0812xxxx" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Lokasi Layanan (Alamat Lengkap)</label>
                <textarea name="lokasi" class="form-control" rows="3" required placeholder="Masukkan alamat lengkap Anda..."></textarea>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold"><i class="fas fa-calendar-alt me-2 text-primary"></i> Tanggal Layanan</label>
                  <input type="date" name="tanggal_layanan" class="form-control form-control-lg" required min="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold"><i class="fas fa-money-check-alt me-2 text-primary"></i> Metode Pembayaran</label>
                  <select name="metode_pembayaran" class="form-select form-select-lg" required>
                    <option value="">Pilih Metode</option>
                    <option value="Cash">Cash (Bayar di tempat)</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="E-Wallet">E-Wallet</option>
                  </select>
                </div>
              </div>

              <div class="d-flex justify-content-between mt-4 border-top pt-3">
                <a href="jasa_list.php" class="btn btn-outline-secondary btn-lg">
                  <i class="fas fa-times me-2"></i> Batal
                </a>
                <button type="submit" name="submit" class="btn btn-success btn-lg shadow-sm">
                  <i class="fas fa-check-circle me-2"></i> Konfirmasi & Pesan Sekarang
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  <?php else: ?>
    <div class="text-center py-5">
      <?php if ($messageType != 'success'): ?>
        <h2 class="text-danger mb-4">Akses Gagal</h2>
      <?php endif; ?>
      <a href="jasa_list.php" class="btn btn-primary btn-lg mt-3">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Jasa
      </a>
    </div>
  <?php endif; ?>
</div>

<?php
// Tutup main dan layout dari header.php
?>
</main>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>