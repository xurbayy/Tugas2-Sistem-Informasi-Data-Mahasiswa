<?php
// koneksi.php
// Membuat koneksi PDO ke database MySQL/MariaDB.

$host     = "localhost";
$nama_db  = "db_kampus";
$username = "root";
$password = ""; // Kosongkan jika menggunakan pengaturan bawaan XAMPP

$dsn = "mysql:host=$host;dbname=$nama_db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password, [
        // Error ditangani dengan exception
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        // Hasil query otomatis berbentuk array asosiatif
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Gunakan prepared statement sungguhan dari MySQL
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    // Detail error hanya dicatat di log, tidak ditampilkan ke pengguna
    error_log("Koneksi database gagal: " . $e->getMessage());
    die("Koneksi ke database gagal. Periksa pengaturan koneksi.");
}
