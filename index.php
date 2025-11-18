<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sibersih - Jasa Cleaning Services Terbaik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary-color: #3498db;
      /* Biru Laut/Bersih */
      --secondary-color: #2ecc71;
      /* Hijau Segar */
      --dark-color: #2c3e50;
      /* Abu Gelap */
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7f6;
      /* Background halus */
    }

    .navbar {
      border-bottom: 3px solid var(--primary-color);
    }

    .navbar-brand {
      font-size: 1.5rem;
      color: var(--dark-color) !important;
      font-weight: 700;
    }

    /* Menggunakan visual latar belakang yang lebih bersih dan modern */
    .hero {
      min-height: 100vh;
      background:
        linear-gradient(rgba(44, 62, 80, 0.7), rgba(44, 62, 80, 0.7)),
        url('assets/hero-bg.jpg') center/cover fixed no-repeat;
      /* Gunakan gambar latar belakang yang berkualitas */
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding-top: 56px;
      /* Jarak dari navbar */
    }

    .hero h1 {
      font-size: 4.5rem;
      /* Lebih besar */
      font-weight: 700;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .hero p {
      font-size: 1.4rem;
      font-weight: 300;
      max-width: 600px;
      margin: 0 auto 2rem;
    }

    .btn-cta-primary {
      background-color: var(--secondary-color);
      border-color: var(--secondary-color);
      padding: 15px 30px;
      font-size: 1.2rem;
      font-weight: 600;
      transition: all 0.3s;
    }

    .btn-cta-primary:hover {
      background-color: #27ae60;
      border-color: #27ae60;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-cta-secondary {
      border: 2px solid white;
      color: white;
      padding: 15px 30px;
      font-size: 1.2rem;
      font-weight: 600;
      transition: all 0.3s;
    }

    .btn-cta-secondary:hover {
      background-color: rgba(255, 255, 255, 0.1);
      color: var(--primary-color);
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">
        <i class="fas fa-magic me-2 text-warning"></i> Sibersih
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <div class="navbar-nav">
          <a class="btn btn-outline-light me-2 fw-bold" href="login.php">
            <i class="fas fa-sign-in-alt me-1"></i> Login
          </a>
          <a class="btn btn-success fw-bold" href="register.php">
            <i class="fas fa-user-plus me-1"></i> Daftar Gratis
          </a>
        </div>
      </div>
    </div>
  </nav>

  <section class="hero">
    <div class="container">
      <h1 class="mb-4 animate__animated animate__fadeInDown">
        Bersih Maksimal, Hidup Optimal.
      </h1>
      <p class="mb-5 animate__animated animate__fadeInUp">
        Temukan layanan *cleaning services* profesional yang cepat, handal, dan mudah dipesan, khusus untuk kenyamanan rumah Anda.
      </p>
      <div class="animate__animated animate__fadeInUp animate__delay-1s">
        <a href="register.php" class="btn btn-lg btn-cta-primary me-3 shadow-lg">
          <i class="fas fa-heart me-2"></i> Pesan Jasa Pertama Anda!
        </a>
        <a href="login.php" class="btn btn-lg btn-cta-secondary">
          <i class="fas fa-arrow-right me-2"></i> Sudah Punya Akun?
        </a>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>