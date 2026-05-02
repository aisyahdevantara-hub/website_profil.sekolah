<?php
    session_start();
    include 'koneksi.php';
    
    $identitas = mysqli_query($conn, "SELECT * FROM pengaturan ORDER BY id DESC LIMIT 1");
    $d = mysqli_fetch_object($identitas);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="uploads/identitas/<?= $d->favicon ?>">
    <title>Halaman Login | <?= $d->nama ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="login-container">

        <div class="login-box">

            <div class="box-header">
                <h2>Login</h2>
                <p>Silakan masuk ke panel admin</p>
            </div>

            <div class="box-body">
                <?php
                    if(isset($_GET['msg'])){
                        echo "<div class='alert-error'>" . htmlspecialchars($_GET['msg']) . "</div>";
                    }
                ?>

                <form action="" method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="user" placeholder="Masukkan Username" class="input-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="pass" placeholder="Masukkan Password" class="input-control" required>
                    </div>

                    <button type="submit" name="submit" class="btn-login">Masuk Sekarang</button>
                </form>

                <?php
                    if(isset($_POST['submit'])){
                        $user = mysqli_real_escape_string($conn, $_POST['user']);
                        $pass = mysqli_real_escape_string($conn, $_POST['pass']);

                        $cek = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '".$user."'");
                        if (mysqli_num_rows($cek) > 0){
                            $d = mysqli_fetch_object($cek); 
                            if(md5($pass) == $d->password){ 
                                $_SESSION['status_login'] = true;
                                $_SESSION['uid'] = $d->id;
                                $_SESSION['uname'] = $d->nama;
                                $_SESSION['ulevel'] = $d->level;
                                
                                echo '<script>window.location = "admin/index.php"</script>';
                            }else{
                                echo '<div class="alert">Password Salah</div>';
                            }
                        }else{
                           echo '<div class="alert">Username Tidak Ditemukan</div>'; 
                        };
                    }
                ?>
            </div>

            <div class="box-footer">
                <hr>
                <a href="index.php" style="color: white; text-decoration: none; font-size: 14px;">← Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>

</body>
</html>