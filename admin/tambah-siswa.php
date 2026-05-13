<?php include "header.php" ?>
<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Tambah Siswa Baru</h2>
        <p style="color: #666;">Daftarkan siswa baru ke dalam sistem.</p>
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

        // Cek NIS unik
        $cek = mysqli_query($conn, "SELECT id FROM siswa WHERE nis = '$nis'");
        if(mysqli_num_rows($cek) > 0){
            $error = 'NIS sudah digunakan!';
        } else {
            // Upload foto
            $foto = '';
            if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $foto = 'siswa_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], '../uploads/siswa/' . $foto);
            }

            $simpan = mysqli_query($conn, "INSERT INTO siswa (nis, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, kelas, foto, status) VALUES (
                '$nis', '$nama', '$jk', '$tempat_lahir', '$tgl_lahir', '$kelas', '$foto', '$status'
            )");
            if($simpan){
                echo '<div class="alert-error" style="background: #e8f5e9; color: #2E7D32; border: 1px solid #c8e6c9;">✅ Siswa berhasil ditambahkan!</div>';
                echo "<script>setTimeout(() => window.location='siswa.php?success=Siswa baru berhasil ditambahkan', 2000);</script>";
            } else {
                $error = 'Gagal disimpan: '.mysqli_error($conn);
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
                    <input type="text" name="nis" class="input-control" placeholder="Contoh: 2025001" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Nama Lengkap</label>
                    <input type="text" name="nama" class="input-control" placeholder="Nama lengkap siswa" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Jenis Kelamin</label>
                    <select name="jk" class="input-control" required>
                        <option value="">Pilih</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="input-control" placeholder="Contoh: Jakarta">
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="input-control" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Kelas</label>
                    <select name="kelas" class="input-control" required>
                        <option value="">Pilih Kelas</option>
                        <option value="TK-A">TK-A</option>
                        <option value="TK-B">TK-B</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Status</label>
                    <select name="status" class="input-control" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Lulus">Lulus</option>
                        <option value="Keluar">Keluar</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Foto Siswa (Opsional)</label>
                    <input type="file" name="foto" class="input-control" accept="image/*">
                </div>

                <div style="margin-top: 25px;">
                    <button type="submit" name="submit" class="btn-submit" style="width: 100%; padding: 14px; background: #2E7D32; border: none; border-radius: 10px; color: white; font-weight: 600; font-size: 16px;">
                        <i class="fa fa-user-plus"></i> Simpan Data Siswa
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
