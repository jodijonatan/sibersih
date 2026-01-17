<?php
include "includes/config.php";
session_start();

// Redirect jika sudah login
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit;
}

$error = '';
$success = '';

if (isset($_POST['register'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirm = $_POST['confirm'];

  if ($password !== $confirm) {
    $error = "Password dan konfirmasi tidak cocok";
  } else {
    // cek username sudah ada atau belum
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $error = "Username sudah digunakan. Silakan pilih username lain.";
    } else {
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $role = 'user'; // default role user
      $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sss", $username, $hashed, $role);

      if ($stmt->execute()) {
        $success = "🎉 Registrasi berhasil! Anda sekarang dapat login.";
      } else {
        $error = "Gagal registrasi: " . $stmt->error;
      }
    }
    $stmt->close();
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
  <title>Sibersih - Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary-color: #2ecc71;
      /* Warna hijau untuk register/success */
      --secondary-color: #34495e;
      /* Warna gelap */
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--secondary-color);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .register-wrapper {
      max-width: 850px;
      width: 90%;
      border-radius: 15px;
      overflow: hidden;
    }

    .visual-panel {
      background: linear-gradient(135deg, var(--primary-color), #27ae60);
      /* Gradien warna hijau */
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
      background-color: #27ae60;
      border-color: #27ae60;
    }
  </style>
</head>

<body>

  <div class="register-wrapper shadow-lg d-flex">
    <div class="visual-panel d-none d-md-flex col-md-6">
      <i class="fas fa-hand-holding-heart fa-5x mb-3"></i>
      <h2 class="fw-bold mb-3">Gabung Bersama Sibersih</h2>
      <p class="lead">Buat akun baru dan nikmati layanan kebersihan terbaik untuk lingkungan Anda!</p>
    </div>

    <div class="form-panel col-12 col-md-6">
      <div class="text-center mb-5">
        <h1 class="fw-bold text-dark mb-0">Daftar Akun</h1>
        <p class="text-muted">Isi detail di bawah untuk mendaftar sebagai pengguna baru</p>
      </div>

      <?php if ($error): ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <i class="fas fa-exclamation-triangle me-2"></i>
          <div><?= $error ?></div>
        </div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="alert alert-success d-flex align-items-center" role="alert">
          <i class="fas fa-check-circle me-2"></i>
          <div><?= $success ?></div>
        </div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label fw-bold" for="username"><i class="fas fa-user me-2"></i> Username</label>
          <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Pilih username" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold" for="password"><i class="fas fa-lock me-2"></i> Password</label>
          <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Buat password" required>
        </div>
        <div class="mb-4">
          <label class="form-label fw-bold" for="confirm"><i class="fas fa-lock me-2"></i> Konfirmasi Password</label>
          <input type="password" name="confirm" id="confirm" class="form-control form-control-lg" placeholder="Ulangi password" required>
        </div>

        <button type="submit" name="register" class="btn btn-primary btn-lg w-100 shadow-sm fw-bold">
          <i class="fas fa-user-plus me-2"></i> DAFTAR SEKARANG
        </button>
      </form>

      <p class="mt-4 text-center text-muted">
        Sudah punya akun?
        <a href="<?= BASE_URL ?>login.php" class="text-primary fw-bold text-decoration-none">Login di sini</a>
      </p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>