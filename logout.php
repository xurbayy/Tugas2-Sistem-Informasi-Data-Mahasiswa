<?php
// logout.php
// Mengakhiri sesi login. Pilihan bahasa tetap dipertahankan.
require_once 'fungsi.php';

$bahasa = bahasa_aktif();

// Hapus seluruh data sesi lalu buat ID sesi baru (sesi lama ikut dihapus)
$_SESSION = [];
session_regenerate_id(true);

$_SESSION['bahasa'] = $bahasa;
flash_set('info', 'logout_sukses');

header('Location: login.php');
exit;
