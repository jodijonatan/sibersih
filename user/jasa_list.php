<?php
$requireAdmin = false;
$pageTitle = "Daftar Jasa Terbaik";
include "../includes/config.php";
include "../includes/header.php"; // Ini membuka <div class="main-content">
?>

<style>
  .jasa-card {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    border-radius: 12px;
    overflow: hidden;
    border: none;
  }

  .jasa-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  }

  .jasa-card .card-img-top {
    height: 220px;
    object-fit: cover;
    border-bottom: 3px solid var(--bs-primary);
  }

  .jasa-card .card-body {
    padding: 20px;
  }

  .jasa-card .card-title {
    font-weight: 600;
    color: #34495e;
  }

  .jasa-card .price-tag {
    font-size: 1.5rem;
    font-weight: 700;
    color: #27ae60;
    margin-top: 10px;
    margin-bottom: 15px;
  }

  .jasa-card .card-text {
    font-size: 0.95rem;
    color: #7f8c8d;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>

<div class="p-0">

  <div class="row mb-5 align-items-center p-4">
    <div class="col-md-8">
      <h1 class="fw-bold text-primary">🧹 Layanan Kebersihan Kami</h1>
      <p class="lead text-muted">Jelajahi berbagai pilihan jasa yang dapat membuat lingkungan Anda lebih bersih dan nyaman.</p>
    </div>
    <div class="col-md-4">
      <div class="input-group shadow-sm">
        <input type="text" class="form-control form-control-lg" placeholder="Cari jasa..." aria-label="Cari Jasa">
        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
      </div>
    </div>
  </div>

  <div class="row g-4 p-4"> <?php
                            $sql = "SELECT * FROM jasa";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                              while ($jasa = $result->fetch_assoc()):
                            ?>
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 jasa-card shadow">
            <?php if ($jasa['gambar']): ?>
              <img src="../uploads/<?= $jasa['gambar'] ?>" class="card-img-top" alt="<?= $jasa['nama_jasa'] ?>">
            <?php else: ?>
              <div class="bg-light d-flex justify-content-center align-items-center" style="height:220px;">
                <i class="fas fa-broom fa-3x text-muted opacity-50"></i>
              </div>
            <?php endif; ?>

            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= $jasa['nama_jasa'] ?></h5>
              <p class="card-text text-muted"><?= $jasa['deskripsi'] ?></p>

              <div class="price-tag mt-auto">
                Rp <?= number_format($jasa['harga'], 0, ',', '.') ?>
              </div>

              <a href="jasa_order.php?id=<?= $jasa['id'] ?>" class="btn btn-success btn-lg mt-2">
                <i class="fas fa-cart-plus me-2"></i> Pesan Sekarang
              </a>
            </div>
          </div>
        </div>
      <?php endwhile;
                            else:
      ?>
      <div class="col-12">
        <div class="alert alert-info text-center" role="alert">
          <i class="fas fa-info-circle me-2"></i> Belum ada layanan jasa yang tersedia saat ini.
        </div>
      </div>
    <?php endif; ?>
  </div>
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