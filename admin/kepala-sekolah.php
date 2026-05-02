<?php include "header.php"; ?>
<?php
// Proses update - dipindah ke atas sebelum header
if(isset($_POST['submit'])){ 
    $nama = addslashes(ucwords($_POST['nama']));
    $sambutan = addslashes($_POST['sambutan']);
    $curdate = date('Y-m-d H:i:s');
    
    // Proses Upload Foto
    if($_FILES['foto_baru']['name'] != ''){
        $filename = $_FILES['foto_baru']['name'];
        $tmpname  = $_FILES['foto_baru']['tmp_name'];
        $filesize = $_FILES['foto_baru']['size'];
        $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
        $rename = 'kepsek'.time().'.'.$formatfile;
        $allowedtype = array('png', 'jpg', 'jpeg', 'gif');

        if(!in_array(strtolower($formatfile), $allowedtype)){
            echo "<script>alert('Format file tidak diizinkan')</script>";
        } elseif($filesize > 1000000){
            echo "<script>alert('Ukuran file maksimal 1MB')</script>";
        } else {
            if(file_exists("../uploads/identitas/".$_POST['foto_lama'])){
                unlink("../uploads/identitas/".$_POST['foto_lama']);
            }
            move_uploaded_file($tmpname, "../uploads/identitas/".$rename);
            
            $update = mysqli_query($conn, "UPDATE pengaturan SET
                nama_kepsek ='".$nama."',
                sambutan_kepsek ='".$sambutan."',
                foto_kepsek ='".$rename."',
                updated_at ='".$curdate."'
                WHERE id = '".$d->id."'");
        }
    } else {
        $rename = $_POST['foto_lama'];
        $update = mysqli_query($conn, "UPDATE pengaturan SET
            nama_kepsek ='".$nama."',
            sambutan_kepsek ='".$sambutan."',
            foto_kepsek ='".$rename."',
                updated_at ='".$curdate."'
            WHERE id = '".$d->id."'");
    }

    if(isset($update) && $update){
        echo "<script>window.location='kepala-sekolah.php?success=Perubahan Berhasil Disimpan'</script>";
    } else {
        echo "Gagal update: ".mysqli_error($conn);
    }
}
?>

<div class="main-content-inner">
    
    <!-- Page Header seperti identitas/tentang -->
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Kepala Sekolah</h2>
        <p style="color: #666;">Kelola profil dan sambutan resmi kepala sekolah</p>
    </div>

    <div class="box" style="margin-top: 20px;">
        <div class="box-body">
            
            <!-- Success Message -->
            <?php if(isset($_GET['success'])){ ?>
                <div class="alert-error" style="background: #e8f5e9 !important; color: #2E7D32 !important; border: 1px solid #c8e6c9;">
                    <?= $_GET['success'] ?>
                </div>
            <?php } ?>

            <form action="" method="POST" enctype="multipart/form-data">
                
                <!-- Nama Section -->
                <div class="form-group">
                    <label style="font-weight: bold;">Nama Kepala Sekolah</label>
                    <input type="text" name="nama" class="input-control" placeholder="Nama Lengkap & Gelar" value="<?= $d->nama_kepsek ?>" required>
                </div>

                <!-- Sambutan Section -->
                <div class="form-group">
                    <label style="font-weight: bold;">Sambutan Kepala Sekolah</label>
                    <textarea name="sambutan" class="input-control" id="keterangan" placeholder="Tulis sambutan resmi kepala sekolah..." rows="12"><?= $d->sambutan_kepsek ?></textarea>
                    <small style="color: #888;">Gunakan editor untuk format teks (bold, italic, list, dll).</small>
                </div>

                <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

                <!-- Foto Section -->
                <h4 style="color: #2E7D32; margin-bottom: 20px;"><i class="fa fa-user"></i> Foto Profil</h4>
                
                <div class="form-group">
                    <label style="font-weight: bold; display: block; margin-bottom: 10px;">Foto Saat Ini</label>
                    <img src="../uploads/identitas/<?= $d->foto_kepsek ?>" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 2px solid #eee; margin-bottom: 10px; display: block;">
                    <input type="hidden" name="foto_lama" value="<?= $d->foto_kepsek ?>">
                    <input type="file" name="foto_baru" accept="image/*" class="input-control">
                    <small style="color: #888; margin-top: 5px; display: block;">JPG, PNG, GIF | Maks 1MB</small>
                </div>

                <div style="text-align: right;">
                    <button type="submit" name="submit" class="btn-submit" style="background: #2E7D32; padding: 12px 30px;">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="index.php" class="btn-back" style="margin-right: 10px;">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                
            </form>
        </div>
    </div>
</div>

<?php include "footer.php" ?>

