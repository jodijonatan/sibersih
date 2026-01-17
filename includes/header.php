<?php
require_once __DIR__ . "/auth_check.php";

// Judul halaman dinamis
if (!isset($pageTitle)) {
  $pageTitle = "Dashboard";
}

define('BASE_URL', '/sibersih/');

// Default role jika belum login
if (!isset($_SESSION['role'])) {
  $_SESSION['role'] = 'user';
}

// Nama file halaman aktif
$current_page = basename($_SERVER['PHP_SELF']);
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
      background-color: #f8f9fa;
    }

    .modern-sidebar {
      width: 260px;
      background-color: #2c3e50;
      color: #ecf0f1;
      flex-shrink: 0;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    @media (min-width: 992px) {
      .modern-sidebar {
        position: sticky;
        top: 0;
        height: 100vh;
      }
    }

    .modern-sidebar .nav-link {
      color: #bdc3c7;
      padding: 10px 15px;
      margin-bottom: 5px;
      border-radius: 5px;
      transition: 0.2s;
    }

    .modern-sidebar .nav-link.active,
    .modern-sidebar .nav-link:hover {
      background-color: #34495e;
      color: white;
    }

    .sidebar-logo {
      font-weight: 700;
      font-size: 1.5rem;
      color: #3498db;
      text-align: center;
      padding: 15px 0;
    }

    .modern-header {
      background: white;
      border-bottom: 1px solid #e0e0e0;
      padding: 15px 25px;
      display: flex;
      align-items: center;
    }

    .main-content {
      background: white;
      border-radius: 8px;
      margin: 20px;
      padding: 25px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }
  </style>
</head>

<body>
  <div class="d-flex">

    <!-- SIDEBAR DESKTOP -->
    <nav class="modern-sidebar d-none d-lg-flex flex-column" id="mainSidebar">
      <div class="sidebar-logo">
        <i class="fas fa-broom"></i> Sibersih
      </div>
      <hr class="text-white-50">

      <div class="p-3 flex-grow-1">
        <ul class="nav flex-column">

          <!-- Dashboard -->
          <?php $dashboard_active = ($current_page == 'dashboard.php') ? 'active' : ''; ?>
          <li class="nav-item">
            <a class="nav-link <?= $dashboard_active ?>" href="<?= BASE_URL ?>dashboard.php">
              <i class="fas fa-th-large me-2"></i> Dashboard
            </a>
          </li>

          <h6 class="text-uppercase text-white-50 mt-3 mb-2">Manajemen Layanan</h6>

          <?php if ($_SESSION['role'] == 'admin'): ?>

            <!-- Daftar Jasa -->
            <?php $jasa_list_active = ($current_page == 'jasa_list.php') ? 'active' : ''; ?>
            <li class="nav-item">
              <a class="nav-link <?= $jasa_list_active ?>" href="<?= BASE_URL ?>admin/jasa_list.php">
                <i class="fas fa-list me-2"></i> Daftar Jasa
              </a>
            </li>

            <!-- Tambah Jasa -->
            <?php $jasa_add_active = ($current_page == 'jasa_add.php') ? 'active' : ''; ?>
            <li class="nav-item">
              <a class="nav-link <?= $jasa_add_active ?>" href="<?= BASE_URL ?>admin/jasa_add.php">
                <i class="fas fa-plus-circle me-2"></i> Tambah Jasa
              </a>
            </li>

            <!-- ORDERS LIST (MENU BARU) -->
            <h6 class="text-uppercase text-white-50 mt-3 mb-2">Pesanan</h6>

            <?php $orders_active = ($current_page == 'orders_list.php') ? 'active' : ''; ?>
            <li class="nav-item">
              <a class="nav-link <?= $orders_active ?>" href="<?= BASE_URL ?>admin/orders_list.php">
                <i class="fas fa-receipt me-2"></i> Orders List
              </a>
            </li>

            <!-- USERS -->
            <h6 class="text-uppercase text-white-50 mt-3 mb-2">Pelanggan</h6>

            <?php $users_active = ($current_page == 'users.php') ? 'active' : ''; ?>
            <li class="nav-item">
              <a class="nav-link <?= $users_active ?>" href="<?= BASE_URL ?>admin/users.php">
                <i class="fas fa-users me-2"></i> Kelola Pengguna
              </a>
            </li>

          <?php else: ?>

            <!-- USER: Cari Layanan -->
            <?php $cari_active = ($current_page == 'jasa_list.php') ? 'active' : ''; ?>
            <li class="nav-item">
              <a class="nav-link <?= $cari_active ?>" href="<?= BASE_URL ?>user/jasa_list.php">
                <i class="fas fa-search me-2"></i> Cari Layanan
              </a>
            </li>

            <!-- USER: Pesanan Saya -->
            <?php $pesanan_active = ($current_page == 'jasa_order.php') ? 'active' : ''; ?>
            <li class="nav-item">
              <a class="nav-link <?= $pesanan_active ?>" href="<?= BASE_URL ?>user/jasa_order.php">
                <i class="fas fa-receipt me-2"></i> Pesanan Saya
              </a>
            </li>

          <?php endif; ?>
        </ul>
      </div>

      <div class="p-3 border-top border-secondary">
        <a class="nav-link text-danger" href="<?= BASE_URL ?>logout.php">
          <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
      </div>
    </nav>

    <!-- OFFCANVAS (MOBILE SIDEBAR) -->
    <div class="offcanvas offcanvas-start bg-dark" id="offcanvasSidebar">
      <div class="offcanvas-header modern-sidebar">
        <h5 class="sidebar-logo">
          <i class="fas fa-broom"></i> Sibersih
        </h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
      </div>

      <div class="offcanvas-body modern-sidebar p-0">

        <ul class="nav flex-column p-3">

          <li class="nav-item">
            <a class="nav-link <?= $dashboard_active ?>" href="<?= BASE_URL ?>dashboard.php">
              <i class="fas fa-th-large me-2"></i> Dashboard
            </a>
          </li>

          <h6 class="text-uppercase text-white-50 mt-3 mb-2">Manajemen Layanan</h6>

          <?php if ($_SESSION['role'] == 'admin'): ?>

            <a class="nav-link <?= $jasa_list_active ?>" href="<?= BASE_URL ?>admin/jasa_list.php">
              <i class="fas fa-list me-2"></i> Daftar Jasa
            </a>

            <a class="nav-link <?= $jasa_add_active ?>" href="<?= BASE_URL ?>admin/jasa_add.php">
              <i class="fas fa-plus-circle me-2"></i> Tambah Jasa
            </a>

            <h6 class="text-uppercase text-white-50 mt-3 mb-2">Pesanan</h6>

            <a class="nav-link <?= $orders_active ?>" href="<?= BASE_URL ?>admin/orders_list.php">
              <i class="fas fa-receipt me-2"></i> Orders List
            </a>

            <h6 class="text-uppercase text-white-50 mt-3 mb-2">Pelanggan</h6>

            <a class="nav-link <?= $users_active ?>" href="<?= BASE_URL ?>admin/users.php">
              <i class="fas fa-users me-2"></i> Kelola Pengguna
            </a>

          <?php else: ?>

            <a class="nav-link <?= $cari_active ?>" href="<?= BASE_URL ?>user/jasa_list.php">
              <i class="fas fa-search me-2"></i> Cari Layanan
            </a>

            <a class="nav-link <?= $pesanan_active ?>" href="<?= BASE_URL ?>user/jasa_order.php">
              <i class="fas fa-receipt me-2"></i> Pesanan Saya
            </a>

          <?php endif; ?>
        </ul>

        <div class="p-3 border-top border-secondary">
          <a class="nav-link text-danger" href="<?= BASE_URL ?>logout.php">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
          </a>
        </div>

      </div>
    </div>

    <!-- HEADER -->
    <div class="flex-grow-1 d-flex flex-column">
      <header class="modern-header sticky-top">
        <button class="btn btn-outline-secondary d-lg-none me-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
          <i class="fas fa-bars"></i>
        </button>

        <h3 class="mb-0 text-muted fw-semibold">
          <i class="fas fa-fw fa-<?= ($_SESSION['role'] == 'admin' ? 'user-shield' : 'user') ?> text-primary me-2"></i>
          <?= $pageTitle ?>
        </h3>
      </header>

      <main class="flex-grow-1 p-0">
        <div class="main-content">