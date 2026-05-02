<?php include "header.php"; ?>
<?php
// Proses update
if(isset($_POST['submit'])){ 
    $tentang = addslashes($_POST['tentang']);
    $curdate = date('Y-m-d H:i:s');
    
    // Proses Foto Sekolah
    if($_FILES['foto_baru']['name'] != ''){
        $filename = $_FILES['foto_baru']['name'];
        $tmpname  = $_FILES['foto_baru']['tmp_name'];
        $filesize = $_FILES['foto_baru']['size'];
        $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
        $rename = 'sekolah'.time().'.'.$formatfile;
        $allowedtype = array('png', 'jpg', 'jpeg', 'gif');

        if(!in_array(strtolower($formatfile), $allowedtype)){
            echo "<script>alert('Format file tidak diizinkan')</script>";
        } elseif($filesize > 1000000){
            echo "<script>alert('Ukuran file maksimal 1MB')</script>";
        } else {
            // Hapus foto lama
            if(file_exists("../uploads/identitas/".$_POST['foto_lama'])){
                unlink("../uploads/identitas/".$_POST['foto_lama']);
            }
            move_uploaded_file($tmpname, "../uploads/identitas/".$rename);
            
            $update = mysqli_query($conn, "UPDATE pengaturan SET
                tentang_sekolah ='".$tentang."',
                foto_sekolah ='".$rename."',
                updated_at ='".$curdate."'
                WHERE id = '".$d->id."'");
        }
    } else {
        $rename = $_POST['foto_lama'];
        $update = mysqli_query($conn, "UPDATE pengaturan SET
            tentang_sekolah ='".$tentang."',
            foto_sekolah ='".$rename."',
            updated_at ='".$curdate."'
            WHERE id = '".$d->id."'");
    }

    if($update){
        echo "<script>window.location='tentang-sekolah.php?success=Perubahan Berhasil Disimpan'</script>";
    } else {
        echo "Gagal update: ".mysqli_error($conn);
    }
}
?>

<div class="main-content-inner">
    
    <!-- Page Header seperti identitas-sekolah.php -->
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Tentang Sekolah</h2>
        <p style="color: #666;">Kelola deskripsi profil dan foto utama sekolah</p>
    </div>

    <div class="box" style="margin-top: 20px;">
        <div class="box-body">
            
            <!-- Success Message styled like identitas -->
            <?php if(isset($_GET['success'])){ ?>
                <div class="alert-error" style="background: #e8f5e9 !important; color: #2E7D32 !important; border: 1px solid #c8e6c9;">
                    <?= $_GET['success'] ?>
                </div>
            <?php } ?>

            <form action="" method="POST" enctype="multipart/form-data">
                
                <!-- Deskripsi Section -->
                <div class="form-group">
                    <label style="font-weight: bold;">Deskripsi Tentang Sekolah</label>
                    <textarea name="tentang" class="input-control" id="keterangan" placeholder="Tulis deskripsi lengkap tentang sekolah..." rows="12"><?= $d->tentang_sekolah ?></textarea>
                    <small style="color: #888;">Gunakan editor untuk format teks, bold, italic, dll.</small>
                </div>

                <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

                <!-- Foto Section - Consistent dengan identitas -->
                <h4 style="color: #2E7D32; margin-bottom: 20px;"><i class="fa fa-image"></i> Foto Sekolah</h4>
                
                <div class="form-group">
                    <label style="font-weight: bold; display: block; margin-bottom: 10px;">Preview Foto Saat Ini</label>
                    <img src="../uploads/identitas/<?= $d->foto_sekolah ?>" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 2px solid #eee; margin-bottom: 10px; display: block;">
                    <input type="hidden" name="foto_lama" value="<?= $d->foto_sekolah ?>">
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

