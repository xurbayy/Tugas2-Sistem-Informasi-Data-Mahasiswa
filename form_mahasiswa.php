<?php
// form_mahasiswa.php
// Partial formulir data mahasiswa, dipakai oleh tambah.php dan edit.php.
// Variabel yang dibutuhkan:
//   $data     : array nilai form (kolom database)
//   $errors   : array pesan error validasi
//   $aksi     : tujuan action form
//   $id_data  : id record (null jika form tambah)
//   $tombol   : teks tombol submit

$hobi_terpilih = $data['hoby'] !== '' ? explode(', ', $data['hoby']) : [];
?>
<form method="POST" action="<?= e($aksi) ?>" class="form-mahasiswa">
    <?= csrf_input() ?>
    <?php if ($id_data !== null): ?>
        <input type="hidden" name="id" value="<?= (int) $id_data ?>">
    <?php endif; ?>

    <div class="baris">
        <label for="namasiswa"><?= e(t('lbl_nama')) ?> *</label>
        <div>
            <input type="text" id="namasiswa" name="namasiswa" maxlength="100"
                   value="<?= e($data['nama_siswa']) ?>" required>
            <?= tampil_error($errors, 'namasiswa') ?>
        </div>
    </div>

    <div class="baris">
        <label for="asalsekola"><?= e(t('lbl_sekolah')) ?> *</label>
        <div>
            <input type="text" id="asalsekola" name="asalsekola" maxlength="100"
                   value="<?= e($data['asal_sekolah']) ?>" required>
            <?= tampil_error($errors, 'asalsekola') ?>
        </div>
    </div>

    <div class="baris">
        <label for="nohandphone"><?= e(t('lbl_hp')) ?> *</label>
        <div>
            <input type="text" id="nohandphone" name="nohandphone" maxlength="15"
                   value="<?= e($data['no_handphone']) ?>" required>
            <?= tampil_error($errors, 'nohandphone') ?>
        </div>
    </div>

    <div class="baris">
        <span class="label"><?= e(t('lbl_jk')) ?> *</span>
        <div>
            <label class="pilihan">
                <input type="radio" name="jeniskelamin" value="Pria"
                       <?= $data['jenis_kelamin'] === 'Pria' ? 'checked' : '' ?> required>
                <?= e(t('jk_pria')) ?>
            </label>
            <label class="pilihan">
                <input type="radio" name="jeniskelamin" value="Wanita"
                       <?= $data['jenis_kelamin'] === 'Wanita' ? 'checked' : '' ?> required>
                <?= e(t('jk_wanita')) ?>
            </label>
            <?= tampil_error($errors, 'jeniskelamin') ?>
        </div>
    </div>

    <div class="baris">
        <span class="label"><?= e(t('lbl_hobi')) ?></span>
        <div>
            <?php foreach (PILIHAN_HOBI as $hobi): ?>
                <label class="pilihan">
                    <input type="checkbox" name="hoby[]" value="<?= e($hobi) ?>"
                           <?= in_array($hobi, $hobi_terpilih, true) ? 'checked' : '' ?>>
                    <?= e(t('hobi_' . strtolower($hobi))) ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="baris">
        <label for="prodi"><?= e(t('lbl_prodi')) ?> *</label>
        <div>
            <select id="prodi" name="prodi" required>
                <option value="" <?= $data['prodi'] === '' ? 'selected' : '' ?>>
                    <?= e(t('pilih_prodi')) ?>
                </option>
                <?php foreach (PILIHAN_PRODI as $prodi): ?>
                    <option value="<?= e($prodi) ?>" <?= $data['prodi'] === $prodi ? 'selected' : '' ?>>
                        <?= e($prodi) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?= tampil_error($errors, 'prodi') ?>
        </div>
    </div>

    <div class="baris">
        <label for="keterangan"><?= e(t('lbl_ket')) ?></label>
        <div>
            <textarea id="keterangan" name="keterangan" rows="4" maxlength="1000"><?= e($data['keterangan']) ?></textarea>
            <?= tampil_error($errors, 'keterangan') ?>
        </div>
    </div>

    <div class="tombol-aksi">
        <button type="submit" class="tombol"><?= e($tombol) ?></button>
        <button type="reset" class="tombol abu"><?= e(t('reset')) ?></button>
        <a href="index.php" class="tombol abu"><?= e(t('batal')) ?></a>
    </div>
</form>
