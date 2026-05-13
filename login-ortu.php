<?php
    session_start();
    include 'koneksi.php';
    
    $identitas = mysqli_query($conn, "SELECT * FROM pengaturan ORDER BY id DESC LIMIT 1");
    $d = mysqli_fetch_object($identitas);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="uploads/identitas/<?= $d->favicon ?>">
    <title>Login Orang Tua | <?= $d->nama ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="login-container" style="background: linear-gradient(135deg, #66BB6A 0%, #2E7D32 50%, #1B5E20 100%);">

        <div class="login-box" style="width: 380px;">

            <div class="box-header">
                <div style="font-size: 48px; margin-bottom: 10px;">👨‍👩‍👧‍👦</div>
                <h2>Portal Orang Tua</h2>
                <p>Pantau perkembangan putra/putri Anda</p>
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

                    <button type="submit" name="submit" class="btn-login" style="margin-top: 10px;">Masuk</button>
                </form>

                <?php
                    if(isset($_POST['submit'])){
                        $user = mysqli_real_escape_string($conn, $_POST['user']);
                        $pass = mysqli_real_escape_string($conn, $_POST['pass']);

                        $cek = mysqli_query($conn, "SELECT o.*, s.nama_lengkap as nama_anak FROM ortu o JOIN siswa s ON o.siswa_id = s.id WHERE o.username = '".$user."'");
                        if (mysqli_num_rows($cek) > 0){
                            $data = mysqli_fetch_object($cek); 
                            if(md5($pass) == $data->password){ 
                                $_SESSION['ortu_login'] = true;
                                $_SESSION['ortu_id'] = $data->id;
                                $_SESSION['ortu_nama'] = $data->nama;
                                $_SESSION['ortu_siswa_id'] = $data->siswa_id;
                                
                                echo '<script>window.location = "ortu/index.php"</script>';
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
                <br><br>
                <a href="login.php" style="color: rgba(255,255,255,0.7); text-decoration: none; font-size: 12px;">Login sebagai Admin →</a>
            </div>
        </div>
    </div>

</body>
</html>
