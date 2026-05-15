<?php include "header.php" ?>
<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Tambah Laporan Perkembangan</h2>
        <p style="color: #666;">Input perkembangan siswa berdasarkan 6 aspek PAUD.</p>
    </div>

    <div class="box" style="margin-top: 20px; max-width: 600px;">
        <div class="box-body">
            
<?php 
    if(isset($_POST['submit'])){
        $siswa_id = $_POST['siswa_id'];
        $tanggal = $_POST['tanggal'];
        $semester = addslashes($_POST['semester']);
        $kategori = addslashes($_POST['kategori']);
        $aspek = addslashes($_POST['aspek']);
        $capaian = $_POST['capaian'];
        $catatan = addslashes($_POST['catatan']);
        
        $guru_id = $_POST['guru_id'];

        $simpan = mysqli_query($conn, "INSERT INTO perkembangan (siswa_id, tanggal, semester, kategori, aspek, capaian, catatan, guru_id) VALUES (
            '$siswa_id', '$tanggal', '$semester', '$kategori', '$aspek', '$capaian', '$catatan', '$guru_id'
        )");
        if($simpan){
            echo '<div class="alert-error" style="background: #e8f5e9; color: #2E7D32; border: 1px solid #c8e6c9; padding: 12px; border-radius: 10px; margin-bottom: 20px;">✅ Laporan perkembangan berhasil ditambahkan!</div>';
            echo "<script>setTimeout(() => window.location='perkembangan.php?success=Laporan berhasil ditambahkan', 2000);</script>";
        } else {
            $error = 'Gagal disimpan: '.mysqli_error($conn);
        }
    }
?>

            <?php if(isset($error)): ?>
                <div class="alert-error" style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 10px; border: 1px solid #ffcdd2; margin-bottom: 20px;">
                    ❌ <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label style="font-weight: bold;">Pilih Siswa</label>
                    <select name="siswa_id" class="input-control" required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php 
                            $siswa = mysqli_query($conn, "SELECT * FROM siswa WHERE status = 'Aktif' ORDER BY nama_lengkap ASC");
                            while($s = mysqli_fetch_array($siswa)){
                        ?>
                        <option value="<?= $s['id'] ?>"><?= $s['nama_lengkap'] ?> - <?= $s['kelas'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Tanggal Penilaian</label>
                    <input type="date" name="tanggal" class="input-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Semester</label>
                    <select name="semester" class="input-control" required>
                        <option value="">-- Pilih Semester --</option>
                        <option value="Semester 1 2025/2026">Semester 1 2025/2026</option>
                        <option value="Semester 2 2025/2026">Semester 2 2025/2026</option>
                        <option value="Semester 1 2026/2027">Semester 1 2026/2027</option>
                        <option value="Semester 2 2026/2027">Semester 2 2026/2027</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Kategori Perkembangan</label>
                    <select name="kategori" class="input-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Nilai Agama dan Moral">Nilai Agama dan Moral</option>
                        <option value="Fisik-Motorik">Fisik-Motorik</option>
                        <option value="Kognitif">Kognitif</option>
                        <option value="Bahasa">Bahasa</option>
                        <option value="Sosial-Emosional">Sosial-Emosional</option>
                        <option value="Seni">Seni</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Guru Penilai</label>
                    <select name="guru_id" class="input-control" required>
                        <option value="">-- Pilih Guru --</option>
                        <?php 
                            $guru_list = mysqli_query($conn, "SELECT * FROM guru ORDER BY nama_lengkap ASC");
                            while($g = mysqli_fetch_array($guru_list)){
                        ?>
                        <option value="<?= $g['id'] ?>"><?= $g['nama_lengkap'] ?> - <?= $g['jabatan'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Aspek yang Dinilai</label>
                    <input type="text" name="aspek" class="input-control" placeholder="Contoh: Mampu membaca huruf hijaiyah" required>
                    <small style="color: #999; font-size: 12px;">Tuliskan aspek spesifik yang dinilai</small>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Capaian</label>
                    <select name="capaian" class="input-control" required>
                        <option value="">-- Pilih Capaian --</option>
                        <option value="BB">BB - Belum Berkembang</option>
                        <option value="MB">MB - Mulai Berkembang</option>
                        <option value="BSH">BSH - Berkembang Sesuai Harapan</option>
                        <option value="BSB">BSB - Berkembang Sangat Baik</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Catatan Guru (Opsional)</label>
                    <textarea name="catatan" class="input-control" rows="4" placeholder="Catatan tambahan tentang perkembangan anak..." style="resize: vertical;"></textarea>
                </div>

                <div style="margin-top: 25px;">
                    <button type="submit" name="submit" class="btn-submit" style="width: 100%; padding: 14px; background: #2E7D32; border: none; border-radius: 10px; color: white; font-weight: 600; font-size: 16px;">
                        <i class="fa fa-clipboard-check"></i> Simpan Laporan
                    </button>
                    <a href="perkembangan.php" class="btn-back" style="margin-top: 12px; display: block; text-align: center; padding: 12px; background: #f5f5f5; border-radius: 10px; text-decoration: none; color: #666;">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Perkembangan
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php" ?>
