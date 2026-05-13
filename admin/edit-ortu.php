<?php include "header.php"; 
    $id = $_GET['id'];
    $data = mysqli_query($conn, "SELECT * FROM ortu WHERE id = '$id'");
    if(mysqli_num_rows($data) == 0){
        echo "<script>window.location='ortu.php'</script>";
        exit;
    }
    $o = mysqli_fetch_object($data);
?>
<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Edit Akun Orang Tua</h2>
        <p style="color: #666;">Ubah data akun: <strong><?= $o->nama ?></strong></p>
    </div>

    <div class="box" style="margin-top: 20px; max-width: 500px;">
        <div class="box-body">
            
<?php 
    if(isset($_POST['submit'])){
        $nama = addslashes(ucwords($_POST['nama']));
        $user = addslashes($_POST['user']);
        $no_hp = addslashes($_POST['no_hp']);
        $siswa_id = $_POST['siswa_id'];

        // Cek username unik (exclude current)
        $cek = mysqli_query($conn, "SELECT username FROM ortu WHERE username = '$user' AND id != '$id'");
        if(mysqli_num_rows($cek) > 0){
            $error = 'Username sudah digunakan!';
        } else {
            // Update password jika diisi
            $pass_query = "";
            if(!empty($_POST['pass'])){
                $pass = $_POST['pass'];
                $pass2 = $_POST['pass2'];
                if(strlen($pass) < 6){
                    $error = 'Password minimal 6 karakter!';
                } elseif($pass != $pass2){
                    $error = 'Password tidak cocok!';
                } else {
                    $pass_query = ", password = '".MD5($pass)."'";
                }
            }

            if(!isset($error)){
                $update = mysqli_query($conn, "UPDATE ortu SET 
                    nama = '$nama', 
                    username = '$user', 
                    no_hp = '$no_hp', 
                    siswa_id = '$siswa_id',
                    updated_at = NOW()
                    $pass_query
                    WHERE id = '$id'
                ");
                if($update){
                    echo '<div class="alert-error" style="background: #e8f5e9; color: #2E7D32; border: 1px solid #c8e6c9; padding: 12px; border-radius: 10px; margin-bottom: 20px;">✅ Data berhasil diupdate!</div>';
                    echo "<script>setTimeout(() => window.location='ortu.php?success=Data orang tua berhasil diupdate', 2000);</script>";
                } else {
                    $error = 'Gagal diupdate: '.mysqli_error($conn);
                }
            }
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
                    <label style="font-weight: bold;">Nama Orang Tua</label>
                    <input type="text" name="nama" class="input-control" value="<?= $o->nama ?>" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Pilih Anak (Siswa)</label>
                    <select name="siswa_id" class="input-control" required>
                        <?php 
                            $siswa = mysqli_query($conn, "SELECT * FROM siswa WHERE status = 'Aktif' ORDER BY nama_lengkap ASC");
                            while($s = mysqli_fetch_array($siswa)){
                        ?>
                        <option value="<?= $s['id'] ?>" <?= $s['id'] == $o->siswa_id ? 'selected' : '' ?>><?= $s['nama_lengkap'] ?> - <?= $s['kelas'] ?> (NIS: <?= $s['nis'] ?>)</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" class="input-control" value="<?= $o->no_hp ?>">
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Username</label>
                    <input type="text" name="user" class="input-control" value="<?= $o->username ?>" required>
                </div>

                <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
                <p style="color: #999; font-size: 13px; margin-bottom: 15px;">Kosongkan password jika tidak ingin mengubahnya.</p>

                <div class="form-group">
                    <label style="font-weight: bold;">Password Baru (Opsional)</label>
                    <input type="password" name="pass" class="input-control" placeholder="Password baru">
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Konfirmasi Password Baru</label>
                    <input type="password" name="pass2" class="input-control" placeholder="Konfirmasi password baru">
                </div>

                <div style="margin-top: 25px;">
                    <button type="submit" name="submit" class="btn-submit" style="width: 100%; padding: 14px; background: #2E7D32; border: none; border-radius: 10px; color: white; font-weight: 600; font-size: 16px;">
                        <i class="fa fa-save"></i> Update Data Orang Tua
                    </button>
                    <a href="ortu.php" class="btn-back" style="margin-top: 12px; display: block; text-align: center; padding: 12px; background: #f5f5f5; border-radius: 10px; text-decoration: none; color: #666;">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Orang Tua
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php" ?>
