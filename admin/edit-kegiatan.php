<?php include "header.php" ?>

<?php
// Fix memory limit for large uploads
ini_set('memory_limit', '128M');
?>

<?php
    // Ambil data kegiatan berdasarkan ID
    $kegiatan = mysqli_query($conn, "SELECT * FROM kegiatan WHERE id = '".$_GET['id']."'");

    if(mysqli_num_rows($kegiatan) == 0){
        echo "<script>window.location='kegiatan.php'</script>";
    }

    $p = mysqli_fetch_object($kegiatan);
?>

<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Edit Kegiatan Sekolah</h2>
        <p style="color: #666;">Perbarui dokumentasi kegiatan TK Al-Muhajirin</p>
    </div>

    <div class="box" style="margin-top: 20px; border-radius: 15px; max-width: 800px;">
        <div class="box-body">
            
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label style="font-weight: bold;">Judul Kegiatan</label>
                    <input type="text" name="judul" class="input-control" placeholder="Contoh: Hari Anak Nasional 2024" value="<?= $p->judul ?>" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Keterangan / Deskripsi</label>
                    <textarea name="keterangan" class="input-control" id="keterangan" rows="5" placeholder="Tulis deskripsi lengkap kegiatan..." ><?= $p->keterangan ?></textarea>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Foto Kegiatan Saat Ini</label>
                    <div style="margin-bottom: 15px;">
                        <img src="../uploads/kegiatan/<?= $p->gambar ?>" style="width: 250px; border-radius: 12px; border: 3px solid #eee; object-fit: cover; display: block;">
                    </div>
                    <label>Ganti Foto Baru <small style="color: #999;">(Kosongkan jika tidak ingin mengubah foto)</small></label>
                    <input type="hidden" name="gambar2" value="<?= $p->gambar ?>">
                    <input type="file" name="gambar" class="input-control">
                    <small style="color: #999; display: block; margin-top: 8px;">* Max 5MB. JPG/PNG otomatis di-resize ke 800px</small>
                </div>

                <div style="margin-top: 30px; display: flex; gap: 15px;">
                    <a href="kegiatan.php" class="btn-back" style="flex: 1; text-align: center; padding: 14px;">← Kembali</a>
                    <button type="submit" name="submit" class="btn-submit" style="flex: 2;">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>


                <?php 
                    if(isset($_POST['submit'])){ 
                        $judul   = addslashes(ucwords($_POST['judul']));
                        $ket     = addslashes($_POST['keterangan']);
                        $curdate = date('Y-m-d H:i:s');

                        if($_FILES['gambar']['name'] != ''){
                            
                            $filename = $_FILES['gambar']['name'];
                            $tmpname  = $_FILES['gambar']['tmp_name'];
                            $filesize = $_FILES['gambar']['size'];

                            $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
                            $rename     = 'kegiatan'.time().'.'.$formatfile;

                            $allowedtype = array('png', 'jpg', 'jpeg', 'gif');

                            if(!in_array(strtolower($formatfile), $allowedtype)){
                                echo '<div class="alert alert-error">Format File Tidak Diizinkan</div>';
                                return false;
                            } elseif($filesize > 5000000){
                                echo '<div class="alert alert-error">Ukuran File Tidak Boleh Lebih dari 5MB</div>';
                                return false;
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

                                if(file_exists("../uploads/kegiatan/" .$_POST['gambar2'])){
                                    unlink("../uploads/kegiatan/" .$_POST['gambar2']);
                                }

                                $upload_path = "../uploads/kegiatan/" . $rename;
                                if (resizeImage($tmpname, $upload_path)) {
                                    // Success, continue to DB update
                                } else {
                                    echo '<div class="alert alert-error">Gagal memproses gambar</div>';
                                    return false;
                                }
                            }

                        } else {
                            $rename = $_POST['gambar2'];
                        }
                        $update = mysqli_query($conn, "UPDATE kegiatan SET
                            judul       = '".$judul."',
                            keterangan  = '".$ket."',
                            gambar      = '".$rename."',
                            updated_at  = '".$curdate."'
                            WHERE id    = '".$_GET['id']."'
                        ");

                        if($update){
                            echo "<script>window.location='kegiatan.php?success=Perubahan Berhasil Disimpan'</script>";
                        } else {
                            echo '<div class="alert alert-error">Perubahan Gagal Disimpan: ' . mysqli_error($conn) . '</div>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php" ?>