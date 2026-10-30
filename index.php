<?php
// index.php
// Halaman utama: menampilkan seluruh data mahasiswa (operasi READ).
// Halaman ini hanya bisa diakses setelah login.
require_once 'fungsi.php';
require_once 'koneksi.php';

wajib_login();

$semua_data = [];
$gagal_muat = false;

try {
    // Data diurutkan dari yang paling baru
    $stmt = $pdo->query("SELECT * FROM pendaftaran ORDER BY id DESC");
    $semua_data = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Gagal mengambil data: " . $e->getMessage());
    $gagal_muat = true;
}

$judul_halaman = t('menu_data');
require 'templat_atas.php';
?>

<section class="wadah lebar">
    <h2><?= e(t('judul_data')) ?></h2>

    <?php flash_tampilkan(); ?>

    <?php if ($gagal_muat): ?>
        <div class="pesan gagal"><?= e(t('gagal_muat_data')) ?></div>
    <?php endif; ?>

    <p>
        <a class="tombol" href="tambah.php">+ <?= e(t('menu_tambah')) ?></a>
    </p>

    <div class="tabel-responsif">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th><?= e(t('no')) ?></th>
                    <th><?= e(t('th_nama')) ?></th>
                    <th><?= e(t('th_sekolah')) ?></th>
                    <th><?= e(t('th_hp')) ?></th>
                    <th><?= e(t('th_gender')) ?></th>
                    <th><?= e(t('th_hobi')) ?></th>
                    <th><?= e(t('th_prodi')) ?></th>
                    <th><?= e(t('th_ket')) ?></th>
                    <th><?= e(t('aksi')) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($semua_data)): ?>
                    <tr>
                        <td colspan="9" class="tengah"><?= e(t('belum_ada')) ?></td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; ?>
                    <?php foreach ($semua_data as $data): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= e($data['nama_siswa']) ?></td>
                            <td><?= e($data['asal_sekolah']) ?></td>
                            <td><?= e($data['no_handphone']) ?></td>
                            <td><?= e(label_nilai($data['jenis_kelamin'], 'jk_')) ?></td>
                            <td><?= e(tampil_hobi($data['hoby'])) ?></td>
                            <td><?= e($data['prodi']) ?></td>
                            <td><?= e($data['keterangan']) ?></td>
                            <td class="aksi">
                                <a class="tombol kecil" href="edit.php?id=<?= (int) $data['id'] ?>">
                                    <?= e(t('edit')) ?>
                                </a>
                                <form method="POST" action="hapus.php"
                                      data-konfirmasi="<?= e(t('konfirmasi_hapus')) ?>">
                                    <?= csrf_input() ?>
                                    <input type="hidden" name="id" value="<?= (int) $data['id'] ?>">
                                    <button type="submit" class="tombol kecil merah"><?= e(t('hapus')) ?></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<script>
    // Konfirmasi sebelum menghapus data
    document.querySelectorAll('form[data-konfirmasi]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!confirm(form.dataset.konfirmasi)) {
                event.preventDefault();
            }
        });
    });
</script>

<?php require 'templat_bawah.php'; ?>
