<?php
// tambah.php
// Form input data baru (operasi CREATE) dengan validasi server-side.
require_once 'fungsi.php';
require_once 'koneksi.php';

wajib_login();

$data        = data_kosong();
$errors      = [];
$pesan_gagal = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Langkah 1: periksa token CSRF
    if (!csrf_valid()) {
        $pesan_gagal = t('err_csrf');
    } else {

        // Langkah 2: sanitasi dan validasi seluruh input
        $hasil  = validasi_mahasiswa($_POST);
        $data   = $hasil['data'];
        $errors = $hasil['error'];

        // Langkah 3: simpan hanya jika tidak ada error
        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare(
                    "INSERT INTO pendaftaran
                        (nama_siswa, asal_sekolah, no_handphone, jenis_kelamin, hoby, prodi, keterangan)
                     VALUES
                        (:nama_siswa, :asal_sekolah, :no_handphone, :jenis_kelamin, :hoby, :prodi, :keterangan)"
                );
                $stmt->execute($data);

                // Pola Post-Redirect-Get: refresh halaman tidak mengirim ulang data
                flash_set('sukses', 'sukses_tambah');
                header('Location: index.php');
                exit;
            } catch (PDOException $e) {
                error_log("Gagal menyimpan data: " . $e->getMessage());
                $pesan_gagal = t('gagal_umum');
            }
        }
    }
}

$judul_halaman = t('judul_tambah');
require 'templat_atas.php';
?>

<section class="wadah">
    <h2><?= e(t('judul_tambah')) ?></h2>

    <?php if ($pesan_gagal !== ''): ?>
        <div class="pesan gagal"><?= e($pesan_gagal) ?></div>
    <?php endif; ?>

    <?php
    $aksi     = 'tambah.php';
    $id_data  = null;
    $tombol   = t('simpan');
    require 'form_mahasiswa.php';
    ?>
</section>

<?php require 'templat_bawah.php'; ?>
