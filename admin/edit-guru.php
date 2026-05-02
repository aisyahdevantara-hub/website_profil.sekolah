<?php include "header.php" ?>

<?php
// Fix memory limit for large uploads
ini_set('memory_limit', '128M');
?>


<?php
  $guru   = mysqli_query($conn, "SELECT * FROM guru WHERE id = '".$_GET['id']."'");

  if(mysqli_num_rows($guru) == 0){
      echo "<script>window.location='guru.php'</script>";
  }

  $p = mysqli_fetch_object($guru);
?>

<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Edit Data Pengurus</h2>
        <p style="color: #666;">Perbarui informasi atau foto pengurus di sini.</p>
    </div>

    <div class="box" style="margin-top: 20px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 800px;">
        <div class="box-body">
            
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Nama Guru" value="<?= $p->nama_lengkap ?>" class="input-control" required>
                </div>

                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan" class="input-control" placeholder="Jabatan" value="<?= $p->jabatan ?>" required>
                </div>

                <div class="form-group">
                    <label>Foto Saat Ini</label>
                    <div style="margin-bottom: 10px;">
                        <img src="../uploads/guru/<?= $p->gambar ?>" style="width: 150px; border-radius: 10px; border: 3px solid #eee; display: block;">
                    </div>
                    <label>Ganti Foto Baru <small style="color: #999; font-weight: normal;">(Kosongkan jika tidak ingin mengubah foto)</small></label>
                    <input type="hidden" name="gambar2" value="<?= $p->gambar ?>">
<input type="file" name="gambar" class="input-control">
                    <small style="color: #999;">* Ukuran maksimal 5MB. Gambar akan di-resize otomatis.</small>

                </div>

                <div style="margin-top: 30px; display: flex; gap: 10px;">
                    <a href="guru.php" class="btn-back" style="text-align: center; flex: 1;">Batal</a>
                    <button type="submit" name="submit" class="btn-submit" style="flex: 2;">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

            <?php 
                if(isset($_POST['submit'])){ 
                    $nama = addslashes(ucwords($_POST['nama']));
                    $jabatan = addslashes($_POST['jabatan']);
                    $curdate = date('Y-m-d H:i:s');

                    echo '<div style="margin-top: 20px;">';
                    
                    if($_FILES['gambar']['name'] !=''){
                        $filename = $_FILES['gambar']['name'];
                        $tmpname = $_FILES['gambar']['tmp_name'];
                        $filesize = $_FILES['gambar']['size'];

                        $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
                        $rename = 'guru'.time().'.'.$formatfile;
                        $allowedtype = array('png', 'jpg', 'jpeg', 'gif');

                        if(!in_array(strtolower($formatfile), $allowedtype)){
                            echo '<div class="alert-error" style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 10px;">Format File Tidak Diizinkan</div>';
                        } elseif($filesize > 5000000){
                            echo '<div class="alert-error" style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 10px;">Ukuran File Terlalu Besar (Maks 5MB)</div>';
                        } else {
                            // Image resize function to prevent memory issues
                            function resizeImage($tmpname, $destination, $max_width = 800, $max_height = 800) {
                                if (!function_exists('imagecreatefromstring')) {
                                    return move_uploaded_file($tmpname, $destination);  // Fallback if GD not available
                                }
                                $image_info = getimagesize($tmpname);
                                $width = $image_info[0];
                                $height = $image_info[1];
                                $type = $image_info[2];
                                $output_format = 'jpg';

                                // Calculate new dimensions
                                $ratio = min($max_width/$width, $max_height/$height);
                                $new_width = $width * $ratio;
                                $new_height = $height * $ratio;

                                // Create source image
                                switch($type) {
                                    case IMAGETYPE_JPEG: $src = imagecreatefromjpeg($tmpname); break;
                                    case IMAGETYPE_PNG: $src = imagecreatefrompng($tmpname); $output_format = 'png'; break;
                                    case IMAGETYPE_GIF: $src = imagecreatefromgif($tmpname); break;
                                    default: return false;
                                }

                                // Create destination image
                                $dst = imagecreatetruecolor($new_width, $new_height);
                                imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                                // Save
                                if ($output_format == 'jpg') {
                                    imagejpeg($dst, $destination, 90);
                                } else {
                                    imagepng($dst, $destination);
                                }
                                imagedestroy($src);
                                imagedestroy($dst);
                                return true;
                            }

                            if(file_exists("../uploads/guru/" .$_POST['gambar2'])){
                                unlink("../uploads/guru/" .$_POST['gambar2']);
                            }
                            $upload_path = "../uploads/guru/" . $rename;
                            if (resizeImage($tmpname, $upload_path)) {
                                // Success, continue to DB update
                            } else {
                                echo '<div class="alert-error" style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 10px;">Gagal memproses gambar</div>';
                            }
                        }

                    } else {
                        $rename = $_POST['gambar2'];
                    }

                    $update = mysqli_query($conn, "UPDATE guru SET
                        nama_lengkap ='".$nama."',
                        jabatan ='".$jabatan."',
                        gambar ='".$rename."',
                        updated_at ='".$curdate."'
                        WHERE id = '".$_GET['id']."'
                    ");

                    if($update){
                        echo "<script>window.location='guru.php?success=Data Berhasil Diperbarui'</script>";
                    } else {
                        echo '<div class="alert-error">Gagal Memperbarui: '.mysqli_error($conn).'</div>';
                    }
                    echo '</div>';
                }
            ?>
        </div>
    </div>
</div>

<?php include "footer.php" ?>