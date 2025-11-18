CREATE DATABASE sibersih_db;

USE sibersih_db;

-- Tabel users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user'
);

-- Tabel jasa
CREATE TABLE jasa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_jasa VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga DECIMAL(10,2) NOT NULL
);

-- Tabel orders (user pakai jasa)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    jasa_id INT NOT NULL,
    tanggal_order DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(jasa_id) REFERENCES jasa(id)
);
