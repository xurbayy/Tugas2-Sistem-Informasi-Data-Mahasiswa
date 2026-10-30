<?php
// ganti_bahasa.php
// Menyimpan pilihan bahasa (id/en) ke $_SESSION lalu kembali ke halaman asal.
require_once 'fungsi.php';

$kode = $_GET['lang'] ?? '';
set_bahasa(is_string($kode) ? $kode : '');

// Kembali ke halaman sebelumnya hanya jika berasal dari situs ini
// (mencegah pengalihan ke situs lain / open redirect).
$tujuan = 'index.php';

$referer = $_SERVER['HTTP_REFERER'] ?? '';
if ($referer !== '') {
    $host_asal   = parse_url($referer, PHP_URL_HOST);
    $host_sekarang = parse_url('http://' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST);

    if ($host_asal !== null && $host_asal === $host_sekarang) {
        $path  = parse_url($referer, PHP_URL_PATH) ?: '/index.php';
        $query = parse_url($referer, PHP_URL_QUERY);
        $tujuan = $path . ($query ? '?' . $query : '');
    }
}

header('Location: ' . $tujuan);
exit;
