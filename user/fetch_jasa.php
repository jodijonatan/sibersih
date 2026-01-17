<?php
header('Content-Type: application/json'); // Penting: memberitahu browser bahwa respons adalah JSON

// Masukkan file konfigurasi database
include "../includes/config.php";

// Pastikan koneksi tersedia ($conn)

$search_query = $_POST['search'] ?? '';

// Inisialisasi variabel SQL
$sql = "SELECT id, nama_jasa, deskripsi, harga, gambar FROM jasa";
$params = []; // Array untuk menyimpan parameter prepared statement
$types = "";   // String untuk tipe data parameter

if (!empty(trim($search_query))) {
  // Tambahkan klausa WHERE jika ada query pencarian
  $sql .= " WHERE nama_jasa LIKE ? OR deskripsi LIKE ?";

  // Siapkan parameter untuk prepared statement
  $search_param = '%' . $search_query . '%';
  $params[] = $search_param;
  $params[] = $search_param;
  $types = "ss"; // Dua string (s)
}

// Tambahkan pengurutan
$sql .= " ORDER BY nama_jasa ASC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
  // Bind parameter secara dinamis
  $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$jasa_data = [];
while ($row = $result->fetch_assoc()) {
  $jasa_data[] = $row;
}

$stmt->close();
$conn->close();

// Kembalikan hasil dalam format JSON
echo json_encode($jasa_data);
