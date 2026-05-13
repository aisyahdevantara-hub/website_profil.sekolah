<?php include "header.php"; 
    $id = $_GET['id'];
    $data = mysqli_query($conn, "SELECT * FROM perkembangan WHERE id = '$id'");
    if(mysqli_num_rows($data) == 0){
        echo "<script>window.location='perkembangan.php'</script>";
        exit;
    }
    $p = mysqli_fetch_object($data);
?>
<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Edit Laporan Perkembangan</h2>
        <p style="color: #666;">Ubah data laporan perkembangan siswa.</p>
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

        $update = mysqli_query($conn, "UPDATE perkembangan SET 
            siswa_id = '$siswa_id', 
            tanggal = '$tanggal', 
            semester = '$semester', 
            kategori = '$kategori', 
            aspek = '$aspek', 
            capaian = '$capaian', 
            catatan = '$catatan'
            WHERE id = '$id'
        ");
        if($update){
            echo '<div class="alert-error" style="background: #e8f5e9; color: #2E7D32; border: 1px solid #c8e6c9; padding: 12px; border-radius: 10px; margin-bottom: 20px;">✅ Laporan berhasil diupdate!</div>';
            echo "<script>setTimeout(() => window.location='perkembangan.php?success=Laporan berhasil diupdate', 2000);</script>";
        } else {
            $error = 'Gagal diupdate: '.mysqli_error($conn);
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
                        <?php 
                            $siswa = mysqli_query($conn, "SELECT * FROM siswa WHERE status = 'Aktif' ORDER BY nama_lengkap ASC");
                            while($s = mysqli_fetch_array($siswa)){
                        ?>
                        <option value="<?= $s['id'] ?>" <?= $s['id'] == $p->siswa_id ? 'selected' : '' ?>><?= $s['nama_lengkap'] ?> - <?= $s['kelas'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Tanggal Penilaian</label>
                    <input type="date" name="tanggal" class="input-control" value="<?= $p->tanggal ?>" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Semester</label>
                    <select name="semester" class="input-control" required>
                        <option value="Semester 1 2025/2026" <?= $p->semester == 'Semester 1 2025/2026' ? 'selected' : '' ?>>Semester 1 2025/2026</option>
                        <option value="Semester 2 2025/2026" <?= $p->semester == 'Semester 2 2025/2026' ? 'selected' : '' ?>>Semester 2 2025/2026</option>
                        <option value="Semester 1 2026/2027" <?= $p->semester == 'Semester 1 2026/2027' ? 'selected' : '' ?>>Semester 1 2026/2027</option>
                        <option value="Semester 2 2026/2027" <?= $p->semester == 'Semester 2 2026/2027' ? 'selected' : '' ?>>Semester 2 2026/2027</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Kategori Perkembangan</label>
                    <select name="kategori" class="input-control" required>
                        <?php 
                            $kategoris = ['Nilai Agama dan Moral', 'Fisik-Motorik', 'Kognitif', 'Bahasa', 'Sosial-Emosional', 'Seni'];
                            foreach($kategoris as $k){
                        ?>
                        <option value="<?= $k ?>" <?= $p->kategori == $k ? 'selected' : '' ?>><?= $k ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Aspek yang Dinilai</label>
                    <input type="text" name="aspek" class="input-control" value="<?= $p->aspek ?>" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Capaian</label>
                    <select name="capaian" class="input-control" required>
                        <option value="BB" <?= $p->capaian == 'BB' ? 'selected' : '' ?>>BB - Belum Berkembang</option>
                        <option value="MB" <?= $p->capaian == 'MB' ? 'selected' : '' ?>>MB - Mulai Berkembang</option>
                        <option value="BSH" <?= $p->capaian == 'BSH' ? 'selected' : '' ?>>BSH - Berkembang Sesuai Harapan</option>
                        <option value="BSB" <?= $p->capaian == 'BSB' ? 'selected' : '' ?>>BSB - Berkembang Sangat Baik</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Catatan Guru</label>
                    <textarea name="catatan" class="input-control" rows="4" style="resize: vertical;"><?= $p->catatan ?></textarea>
                </div>

                <div style="margin-top: 25px;">
                    <button type="submit" name="submit" class="btn-submit" style="width: 100%; padding: 14px; background: #2E7D32; border: none; border-radius: 10px; color: white; font-weight: 600; font-size: 16px;">
                        <i class="fa fa-save"></i> Update Laporan
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
