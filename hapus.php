<?php
// hapus.php
// Menghapus satu data mahasiswa (operasi DELETE).
// Hanya menerima metode POST dan memerlukan token CSRF yang valid.
require_once 'fungsi.php';
require_once 'koneksi.php';

wajib_login();

// Akses langsung lewat URL (GET) tidak diizinkan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (!csrf_valid()) {
    flash_set('gagal', 'err_csrf');
    header('Location: index.php');
    exit;
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if ($id === false) {
    flash_set('gagal', 'err_id');
    header('Location: index.php');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM pendaftaran WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        flash_set('sukses', 'sukses_hapus');
    } else {
        flash_set('gagal', 'err_id');
    }
} catch (PDOException $e) {
    error_log("Gagal menghapus data: " . $e->getMessage());
    flash_set('gagal', 'gagal_umum');
}

header('Location: index.php');
exit;
