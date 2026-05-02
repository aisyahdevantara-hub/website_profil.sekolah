<?php include "header.php" ?>

<?php
// Proses update password
if(isset($_POST['submit'])){ 
    $pass1 = addslashes($_POST['pass1']);
    $pass2 = addslashes($_POST['pass2']);
    $curdate = date('Y-m-d H:i:s');

    if($pass2 != $pass1){
        $error = 'Password Tidak Sesuai!';
    }else{
        $update = mysqli_query($conn, "UPDATE pengguna SET
            password ='".MD5($pass1)."',
            updated_at ='".$curdate."'
            WHERE id = '".$_SESSION['uid']."'
        ");

        if($update){
            $success = 'Password Berhasil Diubah';
        }else{
            $error = 'Gagal: '.mysqli_error($conn);
        }
    }
}
?>

<div class="main-content-inner">
    
    <!-- Page Header -->
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Ubah Password</h2>
        <p style="color: #666;">Gunakan password kuat untuk keamanan akun Anda</p>
    </div>

    <div class="box" style="margin-top: 20px; max-width: 500px;">
        <div class="box-body">
            
            <!-- Messages -->
            <?php if(isset($error)){ ?>
                <div class="alert-error" style="background: #FFEBEE !important; color: #C62828 !important; border: 1px solid #C62828;">
                    <?= $error ?>
                </div>
            <?php } ?>
            <?php if(isset($success)){ ?>
                <div class="alert-error" style="background: #e8f5e9 !important; color: #2E7D32 !important; border: 1px solid #c8e6c9;">
                    <?= $success ?>
                </div>
            <?php } ?>

            <form action="" method="POST">
                
                <div class="form-group">
                    <label style="font-weight: bold;">Password Baru</label>
                    <input type="password" name="pass1" class="input-control" placeholder="Masukkan password baru (min 6 karakter)" required>
                </div>

                <div class="form-group">
                    <label style="font-weight: bold;">Ulangi Password Baru</label>
                    <input type="password" name="pass2" class="input-control" placeholder="Ketik ulang untuk konfirmasi" required>
                </div>

                <div style="margin-top: 20px;">
                    <button type="submit" name="submit" class="btn-submit" style="background: #2E7D32; padding: 14px 30px; width: 100%;">
                        <i class="fa fa-lock"></i> Simpan Password Baru
                    </button>
                    <a href="index.php" class="btn-back" style="margin-top: 10px; display: inline-block;">
                        <i class="fa fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
                
            </form>
        </div>
    </div>
</div>

<?php include "footer.php" ?>

