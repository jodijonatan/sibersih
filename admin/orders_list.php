<?php
$requireAdmin = true;
$pageTitle = "Manajemen Orders";
include "../includes/auth_check.php";
include "../includes/config.php";

// Query ambil semua order + join user & jasa
$sql = "
SELECT 
    o.id, 
    o.full_name AS nama_lengkap,
    o.lokasi, 
    o.phone AS no_hp, 
    o.tanggal_layanan, 
    o.metode_pembayaran, 
    o.status, /* Tambahkan kolom status */
    o.tanggal_order AS created_at,
    u.username,
    j.nama_jasa, 
    j.harga
FROM orders o
JOIN users u ON o.user_id = u.id
JOIN jasa j ON o.jasa_id = j.id
ORDER BY o.id DESC
";


$result = $conn->query($sql);

if (!$result) {
  echo "<div class='alert alert-danger m-4'>
            <strong>Error Query:</strong> " . $conn->error . "
          </div>";
  // Asumsi header.php sudah dipanggil
  echo '</main></div></div>';
  include "../includes/footer.php";
  exit;
}

// Tambahkan definisi fungsi helper untuk badge status
function getStatusBadge($status)
{
  $status = strtolower($status);
  $text = ucwords($status);
  $class = '';

  switch ($status) {
    case 'pending':
      $class = 'bg-warning text-dark';
      break;
    case 'confirmed':
      $class = 'bg-primary';
      break;
    case 'completed':
      $class = 'bg-success';
      break;
    case 'cancelled':
      $class = 'bg-danger';
      break;
    default:
      $class = 'bg-secondary';
      $text = 'Unknown';
  }
  return "<span class='badge {$class}'>{$text}</span>";
}

// CSS custom yang diperbarui
echo '
<style>
    .order-table th {
        font-weight: 700;
        color: #2c3e50; /* Warna header lebih tegas */
        border-bottom: 2px solid #3498db !important; /* Garis bawah biru */
    }
    .order-table td {
        background-color: #ffffff;
        padding: 15px 12px; /* Padding lebih besar */
        border-bottom: 1px solid #ecf0f1 !important; /* Garis abu-abu muda */
        transition: background-color 0.3s;
    }
    .order-table tbody tr:hover td {
        background-color: #f7f9fa; /* Efek hover ringan */
    }
    .status-badge, .payment-badge {
        font-size: 0.85rem;
        padding: 0.5em 0.7em;
        border-radius: 20px; /* Badge berbentuk pil */
        font-weight: 600;
    }
    .card-header-modern {
        border-bottom: none;
        background-color: white;
    }
    .card-header-modern h3 {
        color: #2c3e50;
    }
</style>
';

include "../includes/header.php";
?>

<div class="p-4">

  <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <h1 class="fw-bolder text-dark mb-0">
      <i class="fas fa-cubes me-2 text-primary"></i> Order Dashboard
    </h1>
    <a href="orders_list.php" class="btn btn-outline-primary btn-sm rounded-pill">
      <i class="fas fa-sync-alt me-1"></i> Refresh Data
    </a>
  </div>

  <?php if ($result->num_rows > 0): ?>

    <div class="card shadow border-0">
      <div class="card-header-modern p-4">
        <h3 class="fw-bold mb-0">Daftar Order Masuk</h3>
        <p class="text-muted small mb-0">Total <?= $result->num_rows ?> pesanan tercatat.</p>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table align-middle order-table mb-0">
            <thead>
              <tr>
                <th class="py-3 ps-4" style="width: 5%;">ID</th>
                <th class="py-3" style="width: 20%;">Layanan & Harga</th>
                <th class="py-3" style="width: 20%;">Pemesan</th>
                <th class="py-3" style="width: 25%;">Detail Lokasi & Kontak</th>
                <th class="py-3" style="width: 15%;">Status</th>
                <th class="py-3 pe-4" style="width: 15%;">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td class="ps-4 text-muted small fw-bold">#<?= $row['id'] ?></td>

                  <td>
                    <div class="fw-bold text-dark"><?= htmlspecialchars($row['nama_jasa']) ?></div>
                    <div class="text-success fw-bolder fs-5">
                      Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                    </div>
                    <small class="text-muted">Tgl Layanan: <?= date('d M Y', strtotime($row['tanggal_layanan'])) ?></small>
                  </td>

                  <td>
                    <div class="fw-bold"><i class="fas fa-user-circle me-1 text-secondary"></i> <?= htmlspecialchars($row['nama_lengkap']) ?></div>
                    <small class="text-muted">@<?= htmlspecialchars($row['username']) ?></small><br>
                    <?= getStatusBadge(htmlspecialchars($row['metode_pembayaran'])) ?>
                  </td>

                  <td>
                    <small class="d-block text-muted"><i class="fas fa-map-marker-alt me-1"></i> Lokasi:</small>
                    <div class="mb-1 small"><?= substr(htmlspecialchars($row['lokasi']), 0, 40) ?>...</div>
                    <small class="d-block text-muted"><i class="fas fa-phone me-1"></i> HP: <?= htmlspecialchars($row['no_hp']) ?></small>
                    <small class="d-block text-muted mt-1"><i class="fas fa-clock me-1"></i> Order Masuk: <?= date('H:i, d M', strtotime($row['created_at'])) ?></small>
                  </td>

                  <td class="fw-bold">
                    <?= getStatusBadge(htmlspecialchars($row['status'] ?? 'Pending')) ?>
                  </td>

                  <td class="pe-4">
                    <a href="orders_edit.php?id=<?= $row['id'] ?>"
                      class="btn btn-sm btn-outline-info me-1"
                      title="Edit Order">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="orders_delete.php?id=<?= $row['id'] ?>"
                      class="btn btn-sm btn-outline-danger"
                      onclick="return confirm('Yakin ingin menghapus order #<?= $row['id'] ?>?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>

          </table>
        </div>
      </div>
    </div>

  <?php else: ?>

    <div class="alert alert-info text-center py-4 shadow-sm rounded-3 border-0">
      <h4 class="alert-heading"><i class="fas fa-info-circle me-2"></i> Belum ada order.</h4>
      <p class="mb-0">Belum ada pesanan jasa yang masuk. Saatnya berpromosi!</p>
    </div>

  <?php endif; ?>

</div>

<?php
// Tutup layout dari header.php
?>
</div>
</main>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>