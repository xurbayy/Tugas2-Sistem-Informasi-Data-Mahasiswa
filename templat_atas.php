<?php
// templat_atas.php
// Bagian kepala halaman (HTML head + navigasi). Variabel $judul_halaman
// harus sudah diset oleh halaman yang memanggil file ini.
$bahasa_sekarang = bahasa_aktif();
?>
<!DOCTYPE html>
<html lang="<?= e($bahasa_sekarang) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($judul_halaman) ?> | <?= e(t('app_judul')) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="navbar">
    <div class="brand"><?= e(t('app_judul')) ?></div>
    <nav>
        <?php if (sudah_login()): ?>
            <a href="index.php"><?= e(t('menu_data')) ?></a>
            <a href="tambah.php"><?= e(t('menu_tambah')) ?></a>
            <a href="logout.php"><?= e(t('menu_keluar')) ?></a>
        <?php endif; ?>

        <span class="pilih-bahasa">
            <?= e(t('bahasa_label')) ?>:
            <a href="ganti_bahasa.php?lang=id" class="<?= $bahasa_sekarang === 'id' ? 'aktif' : '' ?>">ID</a>
            |
            <a href="ganti_bahasa.php?lang=en" class="<?= $bahasa_sekarang === 'en' ? 'aktif' : '' ?>">EN</a>
        </span>
    </nav>
</header>

<main>
