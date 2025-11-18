<?php
$pageTitle = "Dashboard";
include "includes/config.php"; // Pastikan file ini mendefinisikan koneksi database: $conn
include "includes/header.php";

// --------------------------------------------------------------------------
// PENGAMBILAN DATA DARI DATABASE (INTEGRASI BACKEND)
// --------------------------------------------------------------------------
$stats = [];
$role = $_SESSION['role'];
// Asumsi 'user_id' disimpan di session saat proses login
$user_id = $_SESSION['user_id'] ?? 0;

// Fungsi untuk eksekusi query dengan aman (sederhana)
function getDbValue($conn, $query, $default = 0)
{
  $result = $conn->query($query);
  if ($result && $result->num_rows > 0) {
    // 1. Ambil array hasil ke dalam variabel $row
    $row = $result->fetch_assoc();

    // 2. Gunakan variabel $row dengan reset() atau array_shift()
    // array_shift() adalah cara yang lebih baik untuk mengambil elemen pertama dari array
    return array_shift($row);

    // ATAU jika tetap ingin menggunakan reset(), gunakan variabel:
    // return reset($row);
  }
  return $default;
}

if ($role == 'admin') {
  // Statistik untuk ADMIN
  $total_jasa = getDbValue($conn, "SELECT COUNT(id) FROM jasa");
  $total_users = getDbValue($conn, "SELECT COUNT(id) FROM users WHERE role = 'user'");
  $total_orders = getDbValue($conn, "SELECT COUNT(id) FROM orders");

  // Jasa Paling Laris (Mengembalikan Nama Jasa)
  $query_laris = "SELECT j.nama_jasa 
                    FROM orders o 
                    JOIN jasa j ON o.jasa_id = j.id 
                    GROUP BY j.id 
                    ORDER BY COUNT(o.id) DESC 
                    LIMIT 1";
  $jasa_laris = getDbValue($conn, $query_laris, 'Belum Ada');

  // Susun data untuk kartu statistik Admin
  $stats = [
    ['icon' => 'fas fa-cogs', 'title' => 'Total Jasa', 'value' => $total_jasa, 'color' => 'primary'],
    ['icon' => 'fas fa-users', 'title' => 'Total Pengguna', 'value' => $total_users, 'color' => 'success'],
    ['icon' => 'fas fa-shopping-cart', 'title' => 'Total Transaksi', 'value' => $total_orders, 'color' => 'info'],
    ['icon' => 'fas fa-star', 'title' => 'Jasa Paling Laris', 'value' => $jasa_laris, 'color' => 'warning'],
  ];
} else {
  // Statistik untuk USER
  $my_total_orders = getDbValue($conn, "SELECT COUNT(id) FROM orders WHERE user_id = {$user_id}");

  // Jasa yang Paling Sering Saya Pesan (Mengembalikan Nama Jasa)
  $query_my_favorite = "SELECT j.nama_jasa
                          FROM orders o
                          JOIN jasa j ON o.jasa_id = j.id
                          WHERE o.user_id = {$user_id}
                          GROUP BY j.id
                          ORDER BY COUNT(o.id) DESC
                          LIMIT 1";
  $my_favorite_jasa = getDbValue($conn, $query_my_favorite, 'Belum Ada');

  // Susun data untuk kartu statistik User
  $stats = [
    ['icon' => 'fas fa-shopping-bag', 'title' => 'Transaksi Saya', 'value' => $my_total_orders . ' Transaksi', 'color' => 'info'],
    ['icon' => 'fas fa-heart', 'title' => 'Jasa Favorit Saya', 'value' => $my_favorite_jasa, 'color' => 'danger'],
  ];
}
// --------------------------------------------------------------------------
?>

<div class="p-4 mb-4 bg-light rounded-3 border-start border-5 border-primary shadow-sm">
  <div class="container-fluid py-2">
    <h1 class="display-5 fw-bold text-dark">👋 Selamat Datang, <?= $_SESSION['username'] ?? 'Pengguna' ?>!</h1>
    <p class="fs-6 text-muted">
      <?php if ($role == 'admin'): ?>
        Pantau kinerja dan kelola semua layanan di platform Sibersih.
      <?php else: ?>
        Siap membuat lingkungan Anda lebih bersih? Cari layanan terbaik sekarang.
      <?php endif; ?>
    </p>
  </div>
</div>

<h4 class="mt-4 mb-3 text-secondary border-bottom pb-2">📊 Data dan Statistik Utama</h4>
<div class="row mb-4">
  <?php foreach ($stats as $stat): ?>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-0 shadow h-100 py-2" style="border-left: 5px solid var(--bs-<?= $stat['color'] ?>);">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col me-2">
              <div class="text-xs font-weight-bold text-<?= $stat['color'] ?> text-uppercase mb-1 small">
                <?= $stat['title'] ?>
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stat['value'] ?></div>
            </div>
            <div class="col-auto">
              <i class="<?= $stat['icon'] ?> fa-3x text-gray-300 opacity-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<h4 class="mt-4 mb-3 text-secondary border-bottom pb-2">⚡ Aksi Cepat</h4>
<div class="row">
  <?php if ($role == 'admin'): ?>
    <div class="col-md-4 mb-3">
      <a href="<?= BASE_URL ?>admin/jasa_add.php" class="btn btn-primary btn-lg w-100 shadow-sm rounded-3 py-3">
        <i class="fas fa-plus-circle me-2"></i> **Tambah Jasa Baru**
      </a>
    </div>
    <div class="col-md-4 mb-3">
      <a href="<?= BASE_URL ?>admin/jasa_list.php" class="btn btn-outline-secondary btn-lg w-100 rounded-3 py-3">
        <i class="fas fa-list-alt me-2"></i> Kelola Jasa
      </a>
    </div>
    <div class="col-md-4 mb-3">
      <a href="<?= BASE_URL ?>admin/orders_list.php" class="btn btn-warning btn-lg w-100 rounded-3 py-3">
        <i class="fas fa-receipt me-2"></i> Lihat Semua Order
      </a>
    </div>
  <?php else: ?>
    <div class="col-md-6 mb-3">
      <a href="<?= BASE_URL ?>user/jasa_list.php" class="btn btn-success btn-lg w-100 py-3 shadow-lg rounded-3">
        <i class="fas fa-search me-2"></i> **Cari Layanan Sekarang**
      </a>
    </div>
    <div class="col-md-6 mb-3">
      <a href="<?= BASE_URL ?>user/jasa_order.php" class="btn btn-info btn-lg w-100 py-3 rounded-3 text-white">
        <i class="fas fa-history me-2"></i> Lihat Pesanan Saya
      </a>
    </div>
  <?php endif; ?>
</div>


<?php
// Tutup div 'main-content' dan elemen layout dari header.php
?>
</div>
</main>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>