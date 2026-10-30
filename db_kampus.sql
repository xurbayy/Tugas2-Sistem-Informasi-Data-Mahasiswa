-- ============================================================
-- Skrip ekspor database: db_kampus
-- Tugas 2 - Sistem Informasi Manajemen Data Sederhana
-- Nama   : Akbar Karunia Putra
-- NIM    : 10124035
-- Kelas  : IF1
--
-- Cara impor: buka phpMyAdmin > Import > pilih file ini > Go
-- atau jalankan: mysql -u root -p < db_kampus.sql
--
-- Akun admin default:
--   username : admin
--   password : admin123
-- ============================================================

CREATE DATABASE IF NOT EXISTS `db_kampus`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE `db_kampus`;

SET NAMES utf8mb4;
SET time_zone = "+00:00";

-- ------------------------------------------------------------
-- Tabel pendaftaran (data mahasiswa)
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `pendaftaran`;

CREATE TABLE `pendaftaran` (
  `id`            int(11)      NOT NULL AUTO_INCREMENT,
  `nama_siswa`    varchar(100) NOT NULL,
  `asal_sekolah`  varchar(100) NOT NULL,
  `no_handphone`  varchar(15)  NOT NULL,
  `jenis_kelamin` varchar(10)  NOT NULL,
  `hoby`          varchar(100) NOT NULL,
  `prodi`         varchar(50)  NOT NULL,
  `keterangan`    text         DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data contoh (boleh dihapus)
INSERT INTO `pendaftaran`
    (`nama_siswa`, `asal_sekolah`, `no_handphone`, `jenis_kelamin`, `hoby`, `prodi`, `keterangan`)
VALUES
    ('Budi Santoso',  'SMA Negeri 1 Cimahi',   '081234567890', 'Pria',   'Gamer, Musik',      'TEKNIK INFORMATIKA', 'Ketua OSIS'),
    ('Siti Aisyah',   'SMK Negeri 2 Bogor',    '085712345678', 'Wanita', 'Membaca, Nonton',   'SISTEM INFORMASI',   NULL),
    ('Rama Wijaya',   'SMA Pasundan 3',        '081398765432', 'Pria',   'Olahraga',          'TEKNIK ARSITEKTUR',  'Mengikuti jalur beasiswa');

-- ------------------------------------------------------------
-- Tabel users (akun untuk login)
-- Password disimpan dalam bentuk hash bcrypt (bukan teks biasa)
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id`       int(11)      NOT NULL AUTO_INCREMENT,
  `username` varchar(50)  NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Akun default: admin / admin123
INSERT INTO `users` (`username`, `password`) VALUES
    ('admin', '$2y$10$ZU/0.2Ug700lV3H8h2zVEO.TkO4Mv0fLDnC/AtTRPvYcG.N9cOyO.');
