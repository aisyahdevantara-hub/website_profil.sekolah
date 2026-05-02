  <?php include "header.php" ?>
  <?php
    date_default_timezone_set('Asia/Jakarta');
    $pengguna   = mysqli_query($conn, "SELECT * FROM pengguna WHERE id = '".$_GET['id']."'");

    if(mysqli_num_rows($pengguna) == 0){
        echo "<script>window.location='pengguna.php'</script>";
    }

    $p          = mysqli_fetch_object($pengguna);
  ?>
<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Edit Data Pengguna</h2>
        <p style="color: #666;">Perbarui informasi akun pengguna dengan aman.</p>
    </div>

    <div class="box" style="margin-top: 20px; max-width: 500px;">
        <div class="box-body">
            
            <?php 
                if(isset($_POST['submit'])){ 
                    $nama = addslashes(ucwords($_POST['nama']));
                    $user = addslashes($_POST['user']);
                    $level = $_POST['level'];
                    $curdate = date('Y-m-d H:i:s');

                    // Cek username unik (kecuali user sendiri)
                    $cek_user = mysqli_query($conn, "SELECT id FROM pengguna WHERE username = '".$user."' AND id != '".$_GET['id']."'");
                    if(mysqli_num_rows($cek_user) > 0){
                        $error = 'Username sudah digunakan oleh pengguna lain!';
                    } else {
                        $update = mysqli_query($conn, "UPDATE pengguna SET
                            nama ='".$nama."',
                            username ='".$user."',
                            level ='".$level."',
                            updated_at ='".$curdate."'
                            WHERE id = '".$_GET['id']."'
                        ");

                        if($update){
                            echo '<div class="alert-success" style="background: #e8f5e9; color: #2E7D32; padding: 12px; border-radius: 10px; border: 1px solid #c8e6c9; margin-bottom: 20px;">✅ Data pengguna berhasil diperbarui!</div>';
                            echo "<script>setTimeout(() => window.location='pengguna.php?success=Data pengguna berhasil diupdate', 1500);</script>";
                        } else {
                            $error = 'Gagal update: '.mysqli_error($conn);
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
                    <label style="font-weight: bold;">Nama Lengkap</label>
                    <input type="text" name="nama" class="input-control" placeholder="Nama lengkap admin" value="<?= $p->nama ?>" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Username</label>
                    <input type="text" name="user" class="input-control" placeholder="Username unik" value="<?= $p->username ?>" required>
                    <small style="color: #999; font-size: 12px;">Username harus unik di seluruh sistem</small>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Level Akses</label>
                    <select name="level" class="input-control" required>
                        <option value="">Pilih Level</option>
                        <option value="Super Admin" <?= ($p->level == 'Super Admin') ? 'selected' : '' ?>>🔐 Super Admin (Full Access)</option>
                        <option value="Admin" <?= ($p->level == 'Admin') ? 'selected' : '' ?>>👤 Admin (Limited Access)</option>
                    </select>
                </div>

                <div style="margin-top: 25px;">
                    <button type="submit" name="submit" class="btn-submit" style="width: 100%; padding: 14px; background: #2E7D32; border: none; border-radius: 10px; color: white; font-weight: 600; font-size: 16px;">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="pengguna.php" class="btn-back" style="margin-top: 12px; display: block; text-align: center; padding: 12px; background: #f5f5f5; border-radius: 10px; text-decoration: none; color: #666;">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Pengguna
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php" ?>