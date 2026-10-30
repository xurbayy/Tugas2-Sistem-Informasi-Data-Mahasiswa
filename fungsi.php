<?php
// fungsi.php
// Fungsi bantuan bersama: sesi, keamanan output (escape), token CSRF,
// flash message, proteksi login, sanitasi & validasi input, dan bahasa.
// File ini di-include di setiap halaman.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/lang.php';

// Pilihan nilai yang diizinkan (whitelist untuk validasi)
const PILIHAN_HOBI   = ['Gamer', 'Nonton', 'Olahraga', 'Musik', 'Membaca'];
const PILIHAN_PRODI  = ['TEKNIK INFORMATIKA', 'SASTRA JEPANG', 'SISTEM INFORMASI', 'TEKNIK ARSITEKTUR'];
const PILIHAN_JK     = ['Pria', 'Wanita'];

// ------------------------------------------------------------
// KEAMANAN OUTPUT
// ------------------------------------------------------------

// Semua data yang ditampilkan ke HTML wajib melewati fungsi ini
// (memakai htmlspecialchars agar karakter <, >, ", ' tidak dieksekusi browser).
function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

// ------------------------------------------------------------
// SANITASI & VALIDASI INPUT
// ------------------------------------------------------------

// Menghitung panjang teks (karakter UTF-8).
// Memakai mb_strlen jika tersedia, jika tidak memakai strlen (tetap berjalan tanpa mbstring).
function panjang_teks($teks)
{
    return function_exists('mb_strlen') ? mb_strlen($teks, 'UTF-8') : strlen($teks);
}

// Membersihkan input: buang tag HTML dan spasi di awal/akhir.
function bersihkan($nilai)
{
    if (!is_string($nilai)) {
        return '';
    }
    return trim(strip_tags($nilai));
}

// Struktur data kosong, dipakai untuk form baru dan sebagai bentuk default.
function data_kosong()
{
    return [
        'nama_siswa'    => '',
        'asal_sekolah'  => '',
        'no_handphone'  => '',
        'jenis_kelamin' => '',
        'hoby'          => '',
        'prodi'         => '',
        'keterangan'    => '',
    ];
}

// Memvalidasi seluruh data formulir mahasiswa dengan struktur if-elseif.
// Mengembalikan ['error' => [nama_field => pesan], 'data' => [kolom_db => nilai]].
function validasi_mahasiswa(array $input)
{
    $error = [];
    $data  = data_kosong();

    // 1. Nama siswa (wajib, maks 100, hanya huruf dan tanda umum)
    $data['nama_siswa'] = bersihkan($input['namasiswa'] ?? '');
    if ($data['nama_siswa'] === '') {
        $error['namasiswa'] = t('err_nama_kosong');
    } elseif (panjang_teks($data['nama_siswa']) > 100) {
        $error['namasiswa'] = t('err_nama_panjang');
    } elseif (!preg_match('/^[\p{L}\s.\'-]+$/u', $data['nama_siswa'])) {
        $error['namasiswa'] = t('err_nama_format');
    }

    // 2. Asal sekolah (wajib, maks 100)
    $data['asal_sekolah'] = bersihkan($input['asalsekola'] ?? '');
    if ($data['asal_sekolah'] === '') {
        $error['asalsekola'] = t('err_sekolah_kosong');
    } elseif (panjang_teks($data['asal_sekolah']) > 100) {
        $error['asalsekola'] = t('err_sekolah_panjang');
    }

    // 3. Nomor handphone (wajib, 8-14 digit, boleh diawali +)
    $data['no_handphone'] = bersihkan($input['nohandphone'] ?? '');
    if ($data['no_handphone'] === '') {
        $error['nohandphone'] = t('err_hp_kosong');
    } elseif (!preg_match('/^\+?[0-9]{8,14}$/', $data['no_handphone'])) {
        $error['nohandphone'] = t('err_hp_format');
    }

    // 4. Jenis kelamin (wajib, harus salah satu pilihan)
    $jk = $input['jeniskelamin'] ?? '';
    if (!is_string($jk) || !in_array($jk, PILIHAN_JK, true)) {
        $error['jeniskelamin'] = t('err_jk');
    } else {
        $data['jenis_kelamin'] = $jk;
    }

    // 5. Hobi (opsional, hanya nilai dari daftar yang diizinkan)
    $hobi_input = $input['hoby'] ?? [];
    if (!is_array($hobi_input)) {
        $hobi_input = [];
    }
    $hobi_bersih = [];
    foreach ($hobi_input as $hobi) {
        if (is_string($hobi) && in_array($hobi, PILIHAN_HOBI, true)) {
            $hobi_bersih[] = $hobi;
        }
    }
    $data['hoby'] = implode(', ', array_unique($hobi_bersih));

    // 6. Program studi (wajib, harus salah satu pilihan)
    $prodi = $input['prodi'] ?? '';
    if (!is_string($prodi) || !in_array($prodi, PILIHAN_PRODI, true)) {
        $error['prodi'] = t('err_prodi');
    } else {
        $data['prodi'] = $prodi;
    }

    // 7. Keterangan (opsional, maks 1000)
    $data['keterangan'] = bersihkan($input['keterangan'] ?? '');
    if (panjang_teks($data['keterangan']) > 1000) {
        $error['keterangan'] = t('err_ket_panjang');
    }

    return ['error' => $error, 'data' => $data];
}

// Menampilkan pesan error validasi di bawah input tertentu.
function tampil_error(array $errors, $kunci)
{
    if (isset($errors[$kunci])) {
        return '<span class="err">' . e($errors[$kunci]) . '</span>';
    }
    return '';
}

// Mengubah nilai tersimpan (mis. "Pria") menjadi label sesuai bahasa aktif.
function label_nilai($nilai, $awalan)
{
    $kunci = $awalan . strtolower((string) $nilai);
    $hasil = t($kunci);
    return $hasil === $kunci ? (string) $nilai : $hasil;
}

// Menampilkan daftar hobi (dipisah koma) dengan label sesuai bahasa.
function tampil_hobi($tersimpan)
{
    if ($tersimpan === '' || $tersimpan === null) {
        return '';
    }
    $daftar = array_map(function ($h) {
        return label_nilai(trim($h), 'hobi_');
    }, explode(',', $tersimpan));
    return implode(', ', $daftar);
}

// ------------------------------------------------------------
// TOKEN CSRF (melindungi form POST dari permintaan palsu)
// ------------------------------------------------------------

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Menghasilkan input hidden berisi token untuk disisipkan di form.
function csrf_input()
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

// Memeriksa token yang dikirim form cocok dengan token di session.
function csrf_valid()
{
    $token = $_POST['csrf_token'] ?? '';
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

// ------------------------------------------------------------
// FLASH MESSAGE (pesan sekali tampil, dibawa lewat redirect)
// ------------------------------------------------------------

// $tipe: 'sukses', 'gagal', atau 'info'. $kunci: kunci terjemahan.
function flash_set($tipe, $kunci)
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'kunci' => $kunci];
}

function flash_tampilkan()
{
    if (empty($_SESSION['flash'])) {
        return;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    $kelas = in_array($flash['tipe'], ['sukses', 'gagal', 'info'], true) ? $flash['tipe'] : 'info';
    echo '<div class="pesan ' . $kelas . '">' . e(t($flash['kunci'])) . '</div>';
}

// ------------------------------------------------------------
// OTENTIKASI & BAHASA
// ------------------------------------------------------------

function sudah_login()
{
    return isset($_SESSION['user_id']);
}

// Proteksi halaman: pengguna yang belum login dialihkan ke login.php.
function wajib_login()
{
    if (!sudah_login()) {
        flash_set('info', 'login_wajib');
        header('Location: login.php');
        exit;
    }
}

function bahasa_aktif()
{
    return $_SESSION['bahasa'] ?? 'id';
}

// Hanya kode bahasa yang terdaftar yang boleh disimpan ke session.
function set_bahasa($kode)
{
    if (in_array($kode, ['id', 'en'], true)) {
        $_SESSION['bahasa'] = $kode;
    }
}
