<?php
// login.php
// Halaman otentikasi. Jika berhasil, user_id disimpan di $_SESSION.
require_once 'fungsi.php';
require_once 'koneksi.php';

// Pengguna yang sudah login tidak perlu melihat halaman ini lagi
if (sudah_login()) {
    header('Location: index.php');
    exit;
}

$pesan_gagal = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!csrf_valid()) {
        $pesan_gagal = t('err_csrf');
    } else {
        $username = bersihkan($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        if (!is_string($password)) {
            $password = '';
        }

        if ($username === '' || $password === '') {
            $pesan_gagal = t('login_kosong');
        } else {
            try {
                $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ? LIMIT 1");
                $stmt->execute([$username]);
                $user = $stmt->fetch();

                // password_verify membandingkan dengan hash bcrypt di database
                if ($user && password_verify($password, $user['password'])) {
                    // Ganti ID sesi untuk mencegah session fixation
                    session_regenerate_id(true);
                    $_SESSION['user_id']  = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    header('Location: index.php');
                    exit;
                }

                // Pesan dibuat umum agar tidak membocorkan username yang valid
                $pesan_gagal = t('err_login');
            } catch (PDOException $e) {
                error_log("Gagal login: " . $e->getMessage());
                $pesan_gagal = t('gagal_umum');
            }
        }
    }
}

$judul_halaman = t('judul_login');
require 'templat_atas.php';
?>

<section class="wadah kecil">
    <h2><?= e(t('judul_login')) ?></h2>

    <?php flash_tampilkan(); ?>

    <?php if ($pesan_gagal !== ''): ?>
        <div class="pesan gagal"><?= e($pesan_gagal) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="form-mahasiswa">
        <?= csrf_input() ?>

        <div class="baris">
            <label for="username"><?= e(t('lbl_username')) ?></label>
            <div>
                <input type="text" id="username" name="username" maxlength="50" required autofocus>
            </div>
        </div>

        <div class="baris">
            <label for="password"><?= e(t('lbl_password')) ?></label>
            <div>
                <input type="password" id="password" name="password" maxlength="100" required>
            </div>
        </div>

        <div class="tombol-aksi">
            <button type="submit" class="tombol"><?= e(t('tombol_masuk')) ?></button>
        </div>
    </form>
</section>

<?php require 'templat_bawah.php'; ?>
