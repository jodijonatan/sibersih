<?php

require_once __DIR__ . "./auth_check.php";

// Judul halaman dinamis
if (!isset($pageTitle)) {
  $pageTitle = "Dashboard";
}

define('BASE_URL', '/sibersih/');

// Simulasikan data sesi untuk role (ganti dengan logic otentikasi Anda yang sebenarnya)
// Contoh: $_SESSION['role'] = 'admin';
if (!isset($_SESSION['role'])) {
  $_SESSION['role'] = 'user'; // Default jika belum login/set
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sibersih - <?= $pageTitle ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      /* Menggunakan font modern */
      background-color: #f8f9fa;
      /* Latar belakang body sedikit abu-abu */
    }

    /* Styling untuk Sidebar Gelap (Dark Sidebar) */
    .modern-sidebar {
      width: 260px;
      /* Sedikit lebih lebar */
      background-color: #2c3e50;
      /* Warna gelap yang modern */
      color: #ecf0f1;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .modern-sidebar .nav-link {
      color: #bdc3c7;
      padding: 10px 15px;
      margin-bottom: 5px;
      border-radius: 5px;
      transition: all 0.3s;
    }

    .modern-sidebar .nav-link:hover,
    .modern-sidebar .nav-link.active {
      background-color: #34495e;
      /* Latar belakang hover/active */
      color: #ffffff;
    }

    .modern-sidebar .sidebar-logo {
      font-weight: 700;
      font-size: 1.5rem;
      color: #3498db;
      /* Aksen warna logo */
      text-align: center;
      padding: 15px 0;
      margin-bottom: 10px;
    }

    /* Styling untuk Header */
    .modern-header {
      background-color: #ffffff;
      border-bottom: 1px solid #e0e0e0;
      padding: 15px 25px;
    }

    /* Styling untuk Konten Utama */
    .main-content {
      background-color: #ffffff;
      /* Konten putih bersih */
      border-radius: 8px;
      /* Sudut membulat */
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
      margin: 20px;
      padding: 25px;
    }
  </style>
</head>

<body>
  <div class="d-flex vh-100">

    <nav class="modern-sidebar d-flex flex-column">
      <div class="sidebar-logo">
        <i class="fas fa-broom"></i> Sibersih
      </div>
      <hr class="text-white-50 mx-3">
      <div class="p-3 flex-grow-1">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="<?= BASE_URL ?>dashboard.php">
              <i class="fas fa-th-large me-2"></i> Dashboard
            </a>
          </li>
          <h6 class="text-uppercase text-white-50 mt-3 mb-2">Manajemen Layanan</h6>
          <?php if ($_SESSION['role'] == 'admin'): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>admin/jasa_list.php">
                <i class="fas fa-list-ul me-2"></i> Daftar Jasa
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>admin/jasa_add.php">
                <i class="fas fa-plus-circle me-2"></i> Tambah Jasa
              </a>
            </li>
            <h6 class="text-uppercase text-white-50 mt-3 mb-2">Pelanggan</h6>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>admin/users.php">
                <i class="fas fa-users me-2"></i> Kelola Pengguna
              </a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>user/jasa_list.php">
                <i class="fas fa-search me-2"></i> Cari Layanan
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>user/jasa_order.php">
                <i class="fas fa-receipt me-2"></i> Pesanan Saya
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
      <div class="p-3 border-top border-secondary">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link text-danger" href="<?= BASE_URL ?>logout.php">
              <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="d-flex flex-column flex-grow-1 overflow-auto">
      <header class="modern-header sticky-top">
        <h3 class="mb-0 text-muted" style="font-weight: 500; font-size: 1.5rem;">
          <i class="fas fa-fw fa-<?= $_SESSION['role'] == 'admin' ? 'user-shield' : 'user' ?> text-primary me-2"></i>
          <?= $pageTitle ?>
        </h3>
      </header>

      <main class="flex-grow-1 p-0">
        <div class="main-content">