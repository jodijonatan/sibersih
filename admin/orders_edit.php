<?php
$requireAdmin = true;
$pageTitle = "Edit Order";
include "../includes/auth_check.php";
include "../includes/config.php";

// --- Validasi ID --- //
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die("<div class='alert alert-danger m-4'>ID order tidak valid.</div>");
}

$order_id = intval($_GET['id']);

// --- Ambil data order --- //
$sql = "
SELECT 
  o.*, 
  u.username, 
  j.nama_jasa, 
  j.harga
FROM orders o
JOIN users u ON o.user_id = u.id
JOIN jasa j ON o.jasa_id = j.id
WHERE o.id = $order_id
";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
  die("<div class='alert alert-danger m-4'>Data order tidak ditemukan.</div>");
}

$order = $result->fetch_assoc();

// --- PROSES UPDATE --- //
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $full_name        = $conn->real_escape_string($_POST['full_name']);
  $lokasi           = $conn->real_escape_string($_POST['lokasi']);
  $phone            = $conn->real_escape_string($_POST['phone']);
  $tanggal_layanan  = $conn->real_escape_string($_POST['tanggal_layanan']);
  $metode           = $conn->real_escape_string($_POST['metode_pembayaran']);
  $status           = $conn->real_escape_string($_POST['status']);

  $update = "
    UPDATE orders SET
      full_name = '$full_name',
      lokasi = '$lokasi',
      phone = '$phone',
      tanggal_layanan = '$tanggal_layanan',
      metode_pembayaran = '$metode',
      status = '$status'
    WHERE id = $order_id
  ";

  if ($conn->query($update)) {
    header("Location: orders_list.php?success=updated");
    exit;
  } else {
    echo "<div class='alert alert-danger m-4'>Gagal Update: {$conn->error}</div>";
  }
}

include "../includes/header.php";
?>

<div class="container mt-4">
  <div class="card shadow border-0">
    <div class="card-header bg-white py-3">
      <h3 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i> Edit Order #<?= $order['id'] ?></h3>
    </div>

    <div class="card-body">

      <form method="POST">

        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Pemesan</label>
          <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($order['full_name']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Lokasi</label>
          <textarea class="form-control" name="lokasi" rows="3" required><?= htmlspecialchars($order['lokasi']) ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Nomor HP</label>
          <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($order['phone']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Tanggal Layanan</label>
          <input type="date" class="form-control" name="tanggal_layanan" value="<?= $order['tanggal_layanan'] ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Metode Pembayaran</label>
          <select name="metode_pembayaran" class="form-select" required>
            <option value="COD" <?= $order['metode_pembayaran'] == "COD" ? "selected" : "" ?>>COD</option>
            <option value="Transfer Bank" <?= $order['metode_pembayaran'] == "Transfer Bank" ? "selected" : "" ?>>Transfer Bank</option>
            <option value="E-Wallet" <?= $order['metode_pembayaran'] == "E-Wallet" ? "selected" : "" ?>>E-Wallet</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Status Order</label>
          <select name="status" class="form-select" required>
            <option value="Pending" <?= $order['status'] == "Pending" ? "selected" : "" ?>>Pending</option>
            <option value="Confirmed" <?= $order['status'] == "Confirmed" ? "selected" : "" ?>>Confirmed</option>
            <option value="Completed" <?= $order['status'] == "Completed" ? "selected" : "" ?>>Completed</option>
            <option value="Cancelled" <?= $order['status'] == "Cancelled" ? "selected" : "" ?>>Cancelled</option>
          </select>
        </div>

        <div class="d-flex justify-content-between mt-4">
          <a href="orders_list.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
          </a>

          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Simpan Perubahan
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>