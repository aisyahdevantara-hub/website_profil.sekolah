<?php include "header.php"; ?>
<?php
// Proses update Identitas Sekolah
if(isset($_POST['submit'])){ 
    $nama = addslashes($_POST['nama']);
    $email = addslashes($_POST['email']);
    $telp = addslashes($_POST['telp']);
    $alamat = addslashes($_POST['alamat']);
    $gmaps = addslashes($_POST['gmaps']);
    $curdate = date('Y-m-d H:i:s');
    
    $update = mysqli_query($conn, "UPDATE pengaturan SET
        nama = '".$nama."',
        email = '".$email."',
        telepon = '".$telp."',
        alamat = '".$alamat."',
        google_maps = '".$gmaps."',
        updated_at = '".$curdate."'
        WHERE id = '".$d->id."'");
    
    // Proses Logo
    if($_FILES['logo_baru']['name'] != ''){
        $filename = $_FILES['logo_baru']['name'];
        $tmpname  = $_FILES['logo_baru']['tmp_name'];
        $filesize = $_FILES['logo_baru']['size'];
        $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
        $rename_logo = 'logo_sekolah'.time().'.'.$formatfile;
        $allowedtype = array('png', 'jpg', 'jpeg', 'gif');
        
        if(in_array(strtolower($formatfile), $allowedtype) && $filesize <= 1000000){
            if(file_exists("../uploads/identitas/".$_POST['logo_lama'])){
                unlink("../uploads/identitas/".$_POST['logo_lama']);
            }
            move_uploaded_file($tmpname, "../uploads/identitas/".$rename_logo);
            mysqli_query($conn, "UPDATE pengaturan SET logo = '".$rename_logo."' WHERE id = '".$d->id."'");
        }
    }
    
    // Proses Favicon
    if($_FILES['favicon_baru']['name'] != ''){
        $filename = $_FILES['favicon_baru']['name'];
        $tmpname  = $_FILES['favicon_baru']['tmp_name'];
        $filesize = $_FILES['favicon_baru']['size'];
        $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
        $rename_favicon = 'favicon_sekolah'.time().'.'.$formatfile;
        $allowedtype = array('png', 'jpg', 'jpeg', 'gif');
        
        if(in_array(strtolower($formatfile), $allowedtype) && $filesize <= 1000000){
            if(file_exists("../uploads/identitas/".$_POST['favicon_lama'])){
                unlink("../uploads/identitas/".$_POST['favicon_lama']);
            }
            move_uploaded_file($tmpname, "../uploads/identitas/".$rename_favicon);
            mysqli_query($conn, "UPDATE pengaturan SET favicon = '".$rename_favicon."' WHERE id = '".$d->id."'");
        }
    }

    if($update){
        echo "<script>window.location='identitas-sekolah.php?success=Perubahan Berhasil Disimpan'</script>";
    } else {
        echo "Gagal update: ".mysqli_error($conn);
    }
}
?>

<div class="main-content-inner">
    
    <!-- Page Header seperti guru.php -->
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Identitas Sekolah</h2>
        <p style="color: #666;">Kelola informasi dasar sekolah dan aset visual</p>
    </div>

    <div class="box" style="margin-top: 20px;">
        <div class="box-body">
            
            <!-- Success Message styled like guru.php -->
            <?php if(isset($_GET['success'])){ ?>
                <div class="alert-error" style="background: #e8f5e9 !important; color: #2E7D32 !important; border: 1px solid #c8e6c9;">
                    <?= $_GET['success'] ?>
                </div>
            <?php } ?>

            <form action="" method="POST" enctype="multipart/form-data">
                
                <!-- Basic Info Section -->
                <div class="form-group">
                    <label style="font-weight: bold;">Nama Sekolah</label>
                    <input type="text" name="nama" value="<?= $d->nama ?>" class="input-control" required>
                </div>

                <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <label style="font-weight: bold;">Email</label>
                        <input type="email" name="email" value="<?= $d->email ?>" class="input-control" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="font-weight: bold;">Telepon</label>
                        <input type="text" name="telp" value="<?= $d->telepon ?>" class="input-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Alamat Lengkap</label>
                    <textarea name="alamat" class="input-control" rows="3"><?= $d->alamat ?></textarea>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Google Maps Embed (Iframe)</label>
                    <textarea name="gmaps" class="input-control" rows="4"><?= $d->google_maps ?></textarea>
                </div>

                <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

                <!-- Image Upload Section - Styled like guru.php table previews -->
                <h4 style="color: #2E7D32; margin-bottom: 20px;"><i class="fa fa-images"></i> Aset Visual</h4>
                
                <div style="display: flex; gap: 30px; margin-bottom: 30px;">
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: bold; margin-bottom: 10px;">Logo Sekolah</label>
                        <img src="../uploads/identitas/<?= $d->logo ?>" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 2px solid #eee; margin-bottom: 10px; display: block;">
                        <input type="hidden" name="logo_lama" value="<?= $d->logo ?>">
                        <input type="file" name="logo_baru" accept="image/*" class="input-control">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: bold; margin-bottom: 10px;">Favicon</label>
                        <img src="../uploads/identitas/<?= $d->favicon ?>" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 2px solid #eee; margin-bottom: 10px; display: block;">
                        <input type="hidden" name="favicon_lama" value="<?= $d->favicon ?>">
                        <input type="file" name="favicon_baru" accept="image/*" class="input-control">
                    </div>
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

