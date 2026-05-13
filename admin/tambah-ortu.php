<?php include "header.php" ?>
<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Tambah Akun Orang Tua</h2>
        <p style="color: #666;">Buat akun login untuk orang tua murid.</p>
    </div>

    <div class="box" style="margin-top: 20px; max-width: 500px;">
        <div class="box-body">
            
<?php 
    if(isset($_POST['submit'])){
        $nama = addslashes(ucwords($_POST['nama']));
        $user = addslashes($_POST['user']);
        $no_hp = addslashes($_POST['no_hp']);
        $siswa_id = $_POST['siswa_id'];
        $pass = $_POST['pass'];
        $pass2 = $_POST['pass2'];

        if(strlen($pass) < 6){
            $error = 'Password minimal 6 karakter!';
        } elseif($pass != $pass2){
            $error = 'Password tidak cocok!';
        } else {
            $pass_encrypt = MD5($pass);

            $cek = mysqli_query($conn, "SELECT username FROM ortu WHERE username = '".$user."'");
            if(mysqli_num_rows($cek) > 0){
                $error = 'Username sudah digunakan!';
            } else {
                $simpan = mysqli_query($conn, "INSERT INTO ortu (nama, username, password, no_hp, siswa_id) VALUES (
                    '$nama', '$user', '$pass_encrypt', '$no_hp', '$siswa_id'
                )");
                if($simpan){
                    echo '<div class="alert-error" style="background: #e8f5e9; color: #2E7D32; border: 1px solid #c8e6c9; padding: 12px; border-radius: 10px; margin-bottom: 20px;">✅ Akun orang tua berhasil dibuat!</div>';
                    echo "<script>setTimeout(() => window.location='ortu.php?success=Akun orang tua berhasil dibuat', 2000);</script>";
                } else {
                    $error = 'Gagal disimpan: '.mysqli_error($conn);
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
                    <input type="text" name="nama" class="input-control" placeholder="Nama lengkap orang tua" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Pilih Anak (Siswa)</label>
                    <select name="siswa_id" class="input-control" required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php 
                            $siswa = mysqli_query($conn, "SELECT * FROM siswa WHERE status = 'Aktif' ORDER BY nama_lengkap ASC");
                            while($s = mysqli_fetch_array($siswa)){
                        ?>
                        <option value="<?= $s['id'] ?>"><?= $s['nama_lengkap'] ?> - <?= $s['kelas'] ?> (NIS: <?= $s['nis'] ?>)</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" class="input-control" placeholder="Contoh: 08123456789">
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Username</label>
                    <input type="text" name="user" class="input-control" placeholder="Username untuk login (tanpa spasi)" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Password</label>
                    <input type="password" name="pass" class="input-control" placeholder="Masukkan password" required>
                    <small style="color: #999; font-size: 12px;">Minimal 6 karakter</small>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Konfirmasi Password</label>
                    <input type="password" name="pass2" class="input-control" placeholder="Masukkan password lagi" required>
                </div>

                <div style="margin-top: 25px;">
                    <button type="submit" name="submit" class="btn-submit" style="width: 100%; padding: 14px; background: #2E7D32; border: none; border-radius: 10px; color: white; font-weight: 600; font-size: 16px;">
                        <i class="fa fa-user-plus"></i> Buat Akun Orang Tua
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
