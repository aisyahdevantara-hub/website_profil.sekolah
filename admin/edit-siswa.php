<?php include "header.php"; 
    $id = $_GET['id'];
    $data = mysqli_query($conn, "SELECT * FROM siswa WHERE id = '$id'");
    if(mysqli_num_rows($data) == 0){
        echo "<script>window.location='siswa.php'</script>";
        exit;
    }
    $s = mysqli_fetch_object($data);
?>
<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Edit Data Siswa</h2>
        <p style="color: #666;">Ubah data siswa: <strong><?= $s->nama_lengkap ?></strong></p>
    </div>

    <div class="box" style="margin-top: 20px; max-width: 600px;">
        <div class="box-body">
            
<?php 
    if(isset($_POST['submit'])){
        $nis = addslashes($_POST['nis']);
        $nama = addslashes(ucwords($_POST['nama']));
        $jk = $_POST['jk'];
        $tempat_lahir = addslashes($_POST['tempat_lahir']);
        $tgl_lahir = $_POST['tgl_lahir'];
        $kelas = addslashes($_POST['kelas']);
        $status = $_POST['status'];

        // Cek NIS unik (exclude current)
        $cek = mysqli_query($conn, "SELECT id FROM siswa WHERE nis = '$nis' AND id != '$id'");
        if(mysqli_num_rows($cek) > 0){
            $error = 'NIS sudah digunakan oleh siswa lain!';
        } else {
            // Upload foto jika ada
            $foto_query = "";
            if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $foto = 'siswa_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], '../uploads/siswa/' . $foto);
                // Hapus foto lama
                if($s->foto && file_exists('../uploads/siswa/' . $s->foto)){
                    unlink('../uploads/siswa/' . $s->foto);
                }
                $foto_query = ", foto = '$foto'";
            }

            $update = mysqli_query($conn, "UPDATE siswa SET 
                nis = '$nis', 
                nama_lengkap = '$nama', 
                jenis_kelamin = '$jk', 
                tempat_lahir = '$tempat_lahir', 
                tanggal_lahir = '$tgl_lahir', 
                kelas = '$kelas', 
                status = '$status',
                updated_at = NOW()
                $foto_query
                WHERE id = '$id'
            ");
            if($update){
                echo '<div class="alert-error" style="background: #e8f5e9; color: #2E7D32; border: 1px solid #c8e6c9;">✅ Data siswa berhasil diupdate!</div>';
                echo "<script>setTimeout(() => window.location='siswa.php?success=Data siswa berhasil diupdate', 2000);</script>";
            } else {
                $error = 'Gagal diupdate: '.mysqli_error($conn);
            }
        }
    }
?>

            <?php if(isset($error)): ?>
                <div class="alert-error" style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 10px; border: 1px solid #ffcdd2; margin-bottom: 20px;">
                    ❌ <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label style="font-weight: bold;">NIS (Nomor Induk Siswa)</label>
                    <input type="text" name="nis" class="input-control" value="<?= $s->nis ?>" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Nama Lengkap</label>
                    <input type="text" name="nama" class="input-control" value="<?= $s->nama_lengkap ?>" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Jenis Kelamin</label>
                    <select name="jk" class="input-control" required>
                        <option value="L" <?= $s->jenis_kelamin == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= $s->jenis_kelamin == 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="input-control" value="<?= $s->tempat_lahir ?>">
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="input-control" value="<?= $s->tanggal_lahir ?>" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Kelas</label>
                    <select name="kelas" class="input-control" required>
                        <option value="TK-A" <?= $s->kelas == 'TK-A' ? 'selected' : '' ?>>TK-A</option>
                        <option value="TK-B" <?= $s->kelas == 'TK-B' ? 'selected' : '' ?>>TK-B</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Status</label>
                    <select name="status" class="input-control" required>
                        <option value="Aktif" <?= $s->status == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Lulus" <?= $s->status == 'Lulus' ? 'selected' : '' ?>>Lulus</option>
                        <option value="Keluar" <?= $s->status == 'Keluar' ? 'selected' : '' ?>>Keluar</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Foto Siswa</label>
                    <?php if($s->foto): ?>
                        <div style="margin-bottom: 10px;">
                            <img src="../uploads/siswa/<?= $s->foto ?>" width="100" style="border-radius: 10px;">
                            <p style="font-size: 12px; color: #999;">Foto saat ini</p>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="foto" class="input-control" accept="image/*">
                    <small style="color: #999;">Kosongkan jika tidak ingin mengubah foto</small>
                </div>

                <div style="margin-top: 25px;">
                    <button type="submit" name="submit" class="btn-submit" style="width: 100%; padding: 14px; background: #2E7D32; border: none; border-radius: 10px; color: white; font-weight: 600; font-size: 16px;">
                        <i class="fa fa-save"></i> Update Data Siswa
                    </button>
                    <a href="siswa.php" class="btn-back" style="margin-top: 12px; display: block; text-align: center; padding: 12px; background: #f5f5f5; border-radius: 10px; text-decoration: none; color: #666;">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Siswa
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php" ?>
