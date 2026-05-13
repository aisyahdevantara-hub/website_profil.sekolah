<?php include "header.php"; ?>

<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Ubah Password</h2>
        <p style="color: #666;">Ganti password akun Anda</p>
    </div>

    <div class="box" style="margin-top: 20px; max-width: 450px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body">
            
<?php 
    if(isset($_POST['submit'])){
        $pass_lama = md5($_POST['pass_lama']);
        $pass_baru = $_POST['pass_baru'];
        $pass_konfirmasi = $_POST['pass_konfirmasi'];

        // Cek password lama
        $cek = mysqli_query($conn, "SELECT * FROM ortu WHERE id = '".$_SESSION['ortu_id']."' AND password = '$pass_lama'");
        if(mysqli_num_rows($cek) == 0){
            $error = 'Password lama tidak sesuai!';
        } elseif(strlen($pass_baru) < 6){
            $error = 'Password baru minimal 6 karakter!';
        } elseif($pass_baru != $pass_konfirmasi){
            $error = 'Konfirmasi password tidak cocok!';
        } else {
            $pass_encrypt = md5($pass_baru);
            $update = mysqli_query($conn, "UPDATE ortu SET password = '$pass_encrypt', updated_at = NOW() WHERE id = '".$_SESSION['ortu_id']."'");
            if($update){
                $success = 'Password berhasil diubah!';
            } else {
                $error = 'Gagal mengubah password.';
            }
        }
    }
?>

            <?php if(isset($success)): ?>
                <div style="background: #e8f5e9; color: #2E7D32; padding: 12px; border-radius: 10px; border: 1px solid #c8e6c9; margin-bottom: 20px;">
                    ✅ <?= $success ?>
                </div>
            <?php endif; ?>

            <?php if(isset($error)): ?>
                <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 10px; border: 1px solid #ffcdd2; margin-bottom: 20px;">
                    ❌ <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label style="font-weight: bold;">Password Lama</label>
                    <input type="password" name="pass_lama" class="input-control" placeholder="Masukkan password lama" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Password Baru</label>
                    <input type="password" name="pass_baru" class="input-control" placeholder="Masukkan password baru" required>
                    <small style="color: #999; font-size: 12px;">Minimal 6 karakter</small>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Konfirmasi Password Baru</label>
                    <input type="password" name="pass_konfirmasi" class="input-control" placeholder="Masukkan lagi password baru" required>
                </div>

                <div style="margin-top: 25px;">
                    <button type="submit" name="submit" class="btn-submit" style="width: 100%; padding: 14px; background: #2E7D32; border: none; border-radius: 10px; color: white; font-weight: 600; font-size: 16px;">
                        <i class="fa fa-save"></i> Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php" ?>
