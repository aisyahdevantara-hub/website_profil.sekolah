<?php include "header.php" ?>

<?php
// Fix memory limit for large uploads
ini_set('memory_limit', '128M');
?>


<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Tambah Pengurus</h2>
        <p style="color: #666;">Silakan isi formulir di bawah untuk menambah data guru/staf baru.</p>
    </div>

    <div class="box" style="margin-top: 20px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 800px;">
        <div class="box-body">
            
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Contoh: Aisyah, S.Pd" class="input-control" required>
                </div>

                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan" class="input-control" placeholder="Contoh: Wali Kelas B1" required>
                </div>

                <div class="form-group">
                    <label>Foto Pengurus</label>
                    <input type="file" name="gambar" class="input-control" required>
<small style="color: #999;">* Ukuran maksimal 5MB. Gambar akan di-resize otomatis ke 800x800px. Format: JPG, JPEG, PNG, GIF.</small>

                </div>

                <div style="margin-top: 30px; display: flex; gap: 10px;">
                    <a href="guru.php" class="btn-back" style="text-align: center; flex: 1;">Kembali</a>
                    <button type="submit" name="submit" class="btn-submit" style="flex: 2;">
                        <i class="fa fa-save"></i> Simpan Data
                    </button>
                </div>
            </form>

                <?php 
                if(isset($_POST['submit'])){ 
                    $nama = addslashes(ucwords($_POST['nama']));
                    $jabatan = addslashes($_POST['jabatan']);

                    $filename = $_FILES['gambar']['name'];
                    $tmpname = $_FILES['gambar']['tmp_name'];
                    $filesize = $_FILES['gambar']['size'];

                    $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
                    $rename = 'guru'.time().'.'.$formatfile;

                    $allowedtype = array('png', 'jpg', 'jpeg', 'gif');

                    echo '<div style="margin-top: 20px;">';
                    if(!in_array(strtolower($formatfile), $allowedtype)){
                        echo '<div class="alert-error" style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 10px;">Format File Tidak Diizinkan</div>';
                    } elseif($filesize > 5000000){  // Increased to 5MB
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

                        $upload_path = "../uploads/guru/" . $rename;
                        if (resizeImage($tmpname, $upload_path)) {
                            $simpan = mysqli_query($conn, "INSERT INTO guru VALUES (
                                null,
                                '".$nama."',
                                '".$jabatan."',
                                '".$rename."',
                                null,
                                null
                            )");
                            if($simpan){
                                echo "<script>window.location='guru.php?success=Data Berhasil Disimpan (Gambar di-resize otomatis)'</script>";
                            } else {
                                echo '<div class="alert-error">Gagal Disimpan: '.mysqli_error($conn).'</div>';
                            }
                        } else {
                            echo '<div class="alert-error" style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 10px;">Gagal memproses gambar</div>';
                        }
                    }
                    echo '</div>';
                }
            ?>

        </div>
    </div>
</div>

<?php include "footer.php" ?>