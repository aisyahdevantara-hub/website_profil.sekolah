<?php include "header.php" ?>

<?php
// Fix memory limit for large uploads
ini_set('memory_limit', '128M');
?>

<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Tambah Kegiatan Sekolah</h2>
        <p style="color: #666;">Dokumentasikan kegiatan menarik di TK Al-Muhajirin</p>
    </div>

    <div class="box" style="margin-top: 20px; border-radius: 15px; max-width: 800px;">
        <div class="box-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label style="font-weight: bold;">Judul Kegiatan</label>
                    <input type="text" name="judul" class="input-control" placeholder="Contoh: Hari Anak Nasional 2024" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Keterangan / Deskripsi</label>
                    <textarea name="keterangan" class="input-control" id="keterangan" rows="5" placeholder="Tulis deskripsi lengkap kegiatan..."></textarea>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Foto Kegiatan</label>
                    <input type="file" name="gambar" class="input-control" required>
                    <small style="color: #999; display: block; margin-top: 8px;">* Max 5MB. JPG/PNG otomatis di-resize ke 800px. Format: JPG, PNG, GIF</small>
                </div>

                <div style="margin-top: 30px; display: flex; gap: 15px;">
                    <a href="kegiatan.php" class="btn-back" style="flex: 1; text-align: center; padding: 14px;">← Kembali</a>
                    <button type="submit" name="submit" class="btn-submit" style="flex: 2;">
                        <i class="fa fa-save"></i> Publikasikan Kegiatan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


                <?php 
                    if(isset($_POST['submit'])){ 


                        
                        $judul = addslashes(ucwords($_POST['judul']));
                        $ket   = addslashes($_POST['keterangan']);

                        $filename = $_FILES['gambar']['name'];
                        $tmpname  = $_FILES['gambar']['tmp_name'];
                        $filesize = $_FILES['gambar']['size'];

                        $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
                        $rename     = 'kegiatan'.time().'.'.$formatfile;

                        $allowedtype = array('png', 'jpg', 'jpeg', 'gif');

                        if(!in_array(strtolower($formatfile), $allowedtype)){
                            echo '<div class="alert alert-error">Format File Tidak Diizinkan</div>';
                        }elseif($filesize > 5000000){
                            echo '<div class="alert alert-error">Ukuran File Tidak Boleh Lebih dari 5MB</div>';
                        }else{
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

                            $upload_path = "../uploads/kegiatan/" . $rename;
                            if (resizeImage($tmpname, $upload_path)) {
                                // Pastikan sesuaikan $_SESSION['uid'] dengan nama session ID di login kamu
                                $simpan = mysqli_query($conn, "INSERT INTO kegiatan (judul, keterangan, gambar, created_by) VALUES (
                                        '".$judul."',
                                        '".$ket."',
                                        '".$rename."',
                                        '".$_SESSION['uid']."'
                                )");

if($simpan){
                                    echo "<script>window.location='kegiatan.php?success=Kegiatan Berhasil Disimpan (Gambar di-resize otomatis)'</script>";
                                }else{
                                    echo '<div class="alert-error" style="background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; padding: 12px; border-radius: 10px; margin: 20px 0;">Gagal Disimpan: '.mysqli_error($conn).'</div>';
                                }
                            } else {
                                echo '<div class="alert alert-error">Gagal memproses gambar</div>';
                            }
                        }

                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?>