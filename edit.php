<?php
// edit.php
// Form ubah data yang sudah ada (operasi UPDATE), berdasarkan id unik.
require_once 'fungsi.php';
require_once 'koneksi.php';

wajib_login();

// Id diambil dari GET (saat membuka form) atau POST (saat menyimpan)
$sumber = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
$id     = filter_var($sumber['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if ($id === false) {
    flash_set('gagal', 'err_id');
    header('Location: index.php');
    exit;
}

$pesan_gagal = '';
$errors      = [];

try {
    // Ambil data lama dari database
    $stmt = $pdo->prepare("SELECT * FROM pendaftaran WHERE id = ?");
    $stmt->execute([$id]);
    $record = $stmt->fetch();

    if (!$record) {
        flash_set('gagal', 'err_id');
        header('Location: index.php');
        exit;
    }

    // Kolom yang dibutuhkan form, diambil dari database
    $data = [
        'nama_siswa'    => $record['nama_siswa'],
        'asal_sekolah'  => $record['asal_sekolah'],
        'no_handphone'  => $record['no_handphone'],
        'jenis_kelamin' => $record['jenis_kelamin'],
        'hoby'          => $record['hoby'],
        'prodi'         => $record['prodi'],
        'keterangan'    => $record['keterangan'] ?? '',
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Langkah 1: periksa token CSRF
        if (!csrf_valid()) {
            $pesan_gagal = t('err_csrf');
        } else {

            // Langkah 2: sanitasi dan validasi
            $hasil  = validasi_mahasiswa($_POST);
            $data   = $hasil['data'];
            $errors = $hasil['error'];

            // Langkah 3: perbarui hanya jika valid
            if (empty($errors)) {
                $stmt = $pdo->prepare(
                    "UPDATE pendaftaran SET
                        nama_siswa    = :nama_siswa,
                        asal_sekolah  = :asal_sekolah,
                        no_handphone  = :no_handphone,
                        jenis_kelamin = :jenis_kelamin,
                        hoby          = :hoby,
                        prodi         = :prodi,
                        keterangan    = :keterangan
                     WHERE id = :id"
                );
                $stmt->execute($data + ['id' => $id]);

                flash_set('sukses', 'sukses_edit');
                header('Location: index.php');
                exit;
            }
        }
    }
} catch (PDOException $e) {
    error_log("Gagal memproses edit: " . $e->getMessage());
    flash_set('gagal', 'gagal_umum');
    header('Location: index.php');
    exit;
}

$judul_halaman = t('judul_edit');
require 'templat_atas.php';
?>

<section class="wadah">
    <h2><?= e(t('judul_edit')) ?></h2>

    <?php if ($pesan_gagal !== ''): ?>
        <div class="pesan gagal"><?= e($pesan_gagal) ?></div>
    <?php endif; ?>

    <?php
    $aksi    = 'edit.php';
    $id_data = $id;
    $tombol  = t('simpan');
    require 'form_mahasiswa.php';
    ?>
</section>

<?php require 'templat_bawah.php'; ?>
