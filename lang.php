<?php
// lang.php
// Kamus terjemahan Bahasa Indonesia (id) dan Bahasa Inggris (en).
// Bahasa aktif disimpan di $_SESSION['bahasa'].

function daftar_terjemahan()
{
    return [
        'id' => [
            // Umum
            'app_judul'        => 'Sistem Informasi Data Mahasiswa',
            'menu_data'        => 'Data Mahasiswa',
            'menu_tambah'      => 'Tambah Data',
            'menu_keluar'      => 'Keluar',
            'bahasa_label'     => 'Bahasa',
            'judul_data'       => 'Data Mahasiswa Terdaftar',
            'judul_tambah'     => 'Tambah Data Mahasiswa',
            'judul_edit'       => 'Edit Data Mahasiswa',
            'judul_login'      => 'Login Admin',
            'belum_ada'        => 'Belum ada data pendaftar.',
            'gagal_muat_data'  => 'Gagal memuat data dari database.',
            'aksi'             => 'Aksi',
            'edit'             => 'Edit',
            'hapus'            => 'Hapus',
            'konfirmasi_hapus' => 'Yakin ingin menghapus data ini?',
            'simpan'           => 'Simpan',
            'reset'            => 'Reset',
            'batal'            => 'Batal',
            'no'               => 'No',

            // Header tabel
            'th_nama'          => 'Nama',
            'th_sekolah'       => 'Sekolah',
            'th_hp'            => 'HP',
            'th_gender'        => 'Gender',
            'th_hobi'          => 'Hobi',
            'th_prodi'         => 'Prodi',
            'th_ket'           => 'Keterangan',

            // Label formulir
            'lbl_nama'         => 'Nama Siswa',
            'lbl_sekolah'      => 'Asal Sekolah',
            'lbl_hp'           => 'Nomor Handphone',
            'lbl_jk'           => 'Jenis Kelamin',
            'jk_pria'          => 'Pria',
            'jk_wanita'        => 'Wanita',
            'lbl_hobi'         => 'Hobi',
            'hobi_gamer'       => 'Gamer',
            'hobi_nonton'      => 'Nonton',
            'hobi_olahraga'    => 'Olahraga',
            'hobi_musik'       => 'Musik',
            'hobi_membaca'     => 'Membaca',
            'lbl_prodi'        => 'Program Studi',
            'pilih_prodi'      => '-- Pilih Program Studi --',
            'lbl_ket'          => 'Keterangan',
            'wajib'            => 'Wajib diisi',

            // Login
            'lbl_username'     => 'Username',
            'lbl_password'     => 'Password',
            'tombol_masuk'     => 'Masuk',
            'err_login'        => 'Username atau password salah.',
            'login_kosong'     => 'Username dan password wajib diisi.',
            'login_wajib'      => 'Silakan login terlebih dahulu.',
            'logout_sukses'    => 'Anda telah keluar dari sistem.',

            // Pesan hasil operasi
            'sukses_tambah'    => 'Data berhasil disimpan ke database!',
            'sukses_edit'      => 'Data berhasil diperbarui.',
            'sukses_hapus'     => 'Data berhasil dihapus.',
            'err_id'           => 'Data tidak ditemukan.',
            'err_csrf'         => 'Token keamanan tidak valid. Silakan coba lagi.',
            'gagal_umum'       => 'Terjadi kesalahan pada server. Silakan coba lagi.',

            // Pesan validasi
            'err_nama_kosong'    => 'Nama siswa wajib diisi.',
            'err_nama_panjang'   => 'Nama siswa maksimal 100 karakter.',
            'err_nama_format'    => 'Nama hanya boleh berisi huruf, spasi, titik, apostrof, atau tanda hubung.',
            'err_sekolah_kosong' => 'Asal sekolah wajib diisi.',
            'err_sekolah_panjang'=> 'Asal sekolah maksimal 100 karakter.',
            'err_hp_kosong'      => 'Nomor handphone wajib diisi.',
            'err_hp_format'      => 'Nomor handphone harus 8 sampai 14 digit angka, boleh diawali tanda +.',
            'err_jk'             => 'Pilih jenis kelamin.',
            'err_prodi'          => 'Pilih program studi yang valid.',
            'err_ket_panjang'    => 'Keterangan maksimal 1000 karakter.',
        ],
        'en' => [
            // General
            'app_judul'        => 'Student Data Information System',
            'menu_data'        => 'Student Data',
            'menu_tambah'      => 'Add Data',
            'menu_keluar'      => 'Logout',
            'bahasa_label'     => 'Language',
            'judul_data'       => 'Registered Students',
            'judul_tambah'     => 'Add Student Data',
            'judul_edit'       => 'Edit Student Data',
            'judul_login'      => 'Admin Login',
            'belum_ada'        => 'No student records yet.',
            'gagal_muat_data'  => 'Failed to load data from the database.',
            'aksi'             => 'Actions',
            'edit'             => 'Edit',
            'hapus'            => 'Delete',
            'konfirmasi_hapus' => 'Are you sure you want to delete this record?',
            'simpan'           => 'Save',
            'reset'            => 'Reset',
            'batal'            => 'Cancel',
            'no'               => 'No',

            // Table headers
            'th_nama'          => 'Name',
            'th_sekolah'       => 'School',
            'th_hp'            => 'Phone',
            'th_gender'        => 'Gender',
            'th_hobi'          => 'Hobbies',
            'th_prodi'         => 'Program',
            'th_ket'           => 'Remarks',

            // Form labels
            'lbl_nama'         => 'Student Name',
            'lbl_sekolah'      => 'School of Origin',
            'lbl_hp'           => 'Phone Number',
            'lbl_jk'           => 'Gender',
            'jk_pria'          => 'Male',
            'jk_wanita'        => 'Female',
            'lbl_hobi'         => 'Hobbies',
            'hobi_gamer'       => 'Gaming',
            'hobi_nonton'      => 'Watching movies',
            'hobi_olahraga'    => 'Sports',
            'hobi_musik'       => 'Music',
            'hobi_membaca'     => 'Reading',
            'lbl_prodi'        => 'Study Program',
            'pilih_prodi'      => '-- Select Study Program --',
            'lbl_ket'          => 'Remarks',
            'wajib'            => 'Required',

            // Login
            'lbl_username'     => 'Username',
            'lbl_password'     => 'Password',
            'tombol_masuk'     => 'Log In',
            'err_login'        => 'Incorrect username or password.',
            'login_kosong'     => 'Username and password are required.',
            'login_wajib'      => 'Please log in first.',
            'logout_sukses'    => 'You have logged out.',

            // Operation messages
            'sukses_tambah'    => 'Data saved successfully!',
            'sukses_edit'      => 'Data updated successfully.',
            'sukses_hapus'     => 'Data deleted successfully.',
            'err_id'           => 'Record not found.',
            'err_csrf'         => 'Invalid security token. Please try again.',
            'gagal_umum'       => 'A server error occurred. Please try again.',

            // Validation messages
            'err_nama_kosong'    => 'Student name is required.',
            'err_nama_panjang'   => 'Student name must be at most 100 characters.',
            'err_nama_format'    => 'Name may only contain letters, spaces, dots, apostrophes, or hyphens.',
            'err_sekolah_kosong' => 'School of origin is required.',
            'err_sekolah_panjang'=> 'School name must be at most 100 characters.',
            'err_hp_kosong'      => 'Phone number is required.',
            'err_hp_format'      => 'Phone number must be 8 to 14 digits, optionally starting with +.',
            'err_jk'             => 'Please select a gender.',
            'err_prodi'          => 'Please select a valid study program.',
            'err_ket_panjang'    => 'Remarks must be at most 1000 characters.',
        ],
    ];
}

// Mengambil teks sesuai bahasa aktif.
// Jika kunci tidak ada, kunci itu sendiri yang dikembalikan.
function t($kunci)
{
    $bahasa = $_SESSION['bahasa'] ?? 'id';
    $kamus  = daftar_terjemahan();

    return $kamus[$bahasa][$kunci] ?? $kamus['id'][$kunci] ?? $kunci;
}
