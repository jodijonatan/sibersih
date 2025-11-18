<?php
session_start();

// Kalau belum login
if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

// Kalau role spesifik dibutuhkan
if (isset($requireAdmin) && $requireAdmin === true) {
  if ($_SESSION['role'] != 'admin') {
    header("Location: /dashboard.php");
    exit;
  }
}
