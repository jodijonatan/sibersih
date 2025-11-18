<?php
$requireAdmin = true;
$pageTitle = "Edit Jasa";
include "../includes/config.php";
include "../includes/header.php"; // header sudah include auth_check

if (!isset($_GET['id'])) {
  header("Location: jasa_list.php");
  exit;
}

$jasa_id = $_GET['id'];

// Ambil data jasa dari database
$sql = "SELECT * FROM jasa WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $jasa_id);
$stmt->execute();
$result = $stmt->get_result();
$jasa = $result->fetch_assoc();

if (!$jasa) {
  echo "<div class='alert alert-danger mt-3'>Jasa tidak ditemukan.</div>";
  exit;
}

$message = '';
$messageType = '';

// Proses update
if (isset($_POST['submit'])) {
  $nama_jasa = $_POST['nama_jasa'];
  $deskripsi = $_POST['deskripsi'];
  $harga = $_POST['harga'];

  // Upload gambar baru jika ada
  $gambar = $jasa['gambar']; // default pakai gambar lama
  if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $gambar = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/$gambar");
  }

  // Update database
  $sql = "UPDATE jasa SET nama_jasa=?, deskripsi=?, harga=?, gambar=? WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sdssi", $nama_jasa, $deskripsi, $harga, $gambar, $jasa_id);

  if ($stmt->execute()) {
    $message = "Jasa berhasil diperbarui!";
    $messageType = "success";
    // Refresh data
    $jasa['nama_jasa'] = $nama_jasa;
    $jasa['deskripsi'] = $deskripsi;
    $jasa['harga'] = $harga;
    $jasa['gambar'] = $gambar;
  } else {
    $message = "Gagal update: " . $stmt->error;
    $messageType = "danger";
  }
}
?>

<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-body">
      <h2 class="mb-4">Edit Jasa</h2>

      <?php if ($message): ?>
        <div class="alert alert-<?= $messageType ?>"><?= $message ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Nama Jasa</label>
          <input type="text" name="nama_jasa" class="form-control" value="<?= $jasa['nama_jasa'] ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control"><?= $jasa['deskripsi'] ?></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Harga</label>
          <input type="number" step="0.01" name="harga" class="form-control" value="<?= $jasa['harga'] ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Gambar Jasa</label>
          <?php if ($jasa['gambar']): ?>
            <div class="mb-2">
              <img src="../uploads/<?= $jasa['gambar'] ?>" alt="<?= $jasa['nama_jasa'] ?>" style="width:120px; height:90px; object-fit:cover; border-radius:4px;">
            </div>
          <?php endif; ?>
          <input type="file" name="gambar" class="form-control" accept="image/*">
          <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
        </div>
        <button type="submit" name="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="jasa_list.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>

<?php
// Tutup main dan layout dari header.php
?>
</main>
</div>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>