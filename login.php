<?php
include "includes/config.php";
session_start();

// Redirect jika sudah login
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit;
}

$error = '';

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();

  $result = $stmt->get_result();
  if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];
      header("Location: dashboard.php");
      exit;
    } else {
      $error = "Password salah. Silakan coba lagi.";
    }
  } else {
    $error = "Akun tidak ditemukan. Periksa kembali Username Anda.";
  }
}

// Pastikan BASE_URL didefinisikan
if (!defined('BASE_URL')) {
  define('BASE_URL', '/sibersih/');
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sibersih - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary-color: #3498db;
      /* Warna biru bersih */
      --secondary-color: #2c3e50;
      /* Warna gelap */
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--secondary-color);
      /* Latar belakang gelap */
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .login-wrapper {
      max-width: 850px;
      /* Ukuran keseluruhan yang lebih besar */
      width: 90%;
      border-radius: 15px;
      overflow: hidden;
      /* Penting untuk visual */
    }

    .visual-panel {
      background: linear-gradient(135deg, var(--primary-color), #2ecc71);
      /* Gradien warna */
      color: white;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .form-panel {
      background: white;
      padding: 40px;
    }

    .form-panel .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      transition: background-color 0.3s;
    }

    .form-panel .btn-primary:hover {
      background-color: #2980b9;
      border-color: #2980b9;
    }
  </style>
</head>

<body>

  <div class="login-wrapper shadow-lg d-flex">
    <div class="visual-panel d-none d-md-flex col-md-6">
      <i class="fas fa-broom fa-5x mb-3"></i>
      <h2 class="fw-bold mb-3">Sibersih Admin Panel</h2>
      <p class="lead">Kelola layanan kebersihan Anda dengan antarmuka yang modern dan terorganisir.</p>
    </div>

    <div class="form-panel col-12 col-md-6">
      <div class="text-center mb-5">
        <h1 class="fw-bold text-dark mb-0">Login</h1>
        <p class="text-muted">Masukkan detail akun Anda untuk melanjutkan</p>
      </div>

      <?php if ($error): ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <i class="fas fa-exclamation-triangle me-2"></i>
          <div><?= $error ?></div>
        </div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label fw-bold" for="username"><i class="fas fa-user me-2"></i> Username</label>
          <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Masukkan username" required autofocus>
        </div>
        <div class="mb-4">
          <label class="form-label fw-bold" for="password"><i class="fas fa-lock me-2"></i> Password</label>
          <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Masukkan password" required>
        </div>

        <button type="submit" name="login" class="btn btn-primary btn-lg w-100 shadow-sm fw-bold">
          <i class="fas fa-sign-in-alt me-2"></i> MASUK
        </button>
      </form>

      <p class="mt-4 text-center text-muted">
        Belum punya akun?
        <a href="<?= BASE_URL ?>register.php" class="text-primary fw-bold text-decoration-none">Daftar di sini</a>
      </p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>