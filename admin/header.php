<?php
    session_start();
    include '../koneksi.php';
    if(!isset($_SESSION['status_login'])){
        echo "<script>window.location ='../login.php?msg=Harap Login Terlebih Dahulu!'</script>";
    }
    date_default_timezone_set('Asia/Jakarta');

    $identitas = mysqli_query($conn, "SELECT * FROM pengaturan ORDER BY id DESC LIMIT 1");
    $d = mysqli_fetch_object($identitas);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../uploads/identitas/<?= $d->favicon ?>">
    <title>Panel Admin - <?= $d->nama ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <script src="https://cdn.tiny.cloud/1/i3y6m8lobit9w9pl0szyh29l9qxiyqn6waxcb19x7ywqpoag/tinymce/8/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="../assets/css/admin-mobile.css">
    <script>
        tinymce.init({
            selector: '#keterangan',
            mobile: {
                plugins: 'lists quickbars'
            }
        });

        // Mobile sidebar toggle
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-open');
        }

        // Close sidebar when clicking overlay
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            overlay.onclick = toggleSidebar;
            document.body.appendChild(overlay);
        });
    </script>

</head>
<body class="bg-light">

    <div class="admin-wrapper">
        <div class="sidebar">
            <div class="sidebar-logo">
                <img src="../uploads/identitas/<?= $d->logo ?>" width="50">
                <h3>Admin Panel</h3>
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>

                <?php if($_SESSION['ulevel'] == 'Super Admin'){ ?>
                    <li><a href="pengguna.php"><i class="fa fa-users"></i> Data Pengguna</a></li>
                <?php } elseif($_SESSION['ulevel'] == 'Admin'){ ?>
                    
                    <small class="menu-label">MANAJEMEN DATA</small>
                    <li><a href="guru.php"><i class="fa fa-user-tie"></i> Data Pengurus</a></li>
                    <li><a href="fasilitas.php"><i class="fa fa-school"></i> Data Fasilitas</a></li>
                    <li><a href="kegiatan.php"><i class="fa fa-calendar-alt"></i> Data Kegiatan</a></li>
                    <li><a href="pesan.php"><i class="fa fa-envelope"></i> 📨 Pesan Masuk</a></li>

                    <small class="menu-label">PENGATURAN</small>


                    <li><a href="identitas-sekolah.php"><i class="fa fa-info-circle"></i> Identitas Sekolah</a></li>
                    <li><a href="tentang-sekolah.php"><i class="fa fa-book"></i> Tentang Sekolah</a></li>
                    <li><a href="kepala-sekolah.php"><i class="fa fa-user-graduate"></i> Kepala Sekolah</a></li>
                <?php } ?>

                <small class="menu-label">AKUN</small>

                <li><a href="ubah-password.php"><i class="fa fa-lock"></i> Ubah Password</a></li>
                <li><a href="logout.php" onclick="return confirm('Yakin ingin keluar?')"><i class="fa fa-sign-out-alt"></i> Keluar</a></li>
            </ul>
        </div>

        <div class="content">
                <div class="content-header">
                    <button class="mobile-menu-btn" onclick="toggleSidebar()">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="user-info">
                        Selamat Datang, <strong><?= $_SESSION['uname'] ?></strong> (<?= $_SESSION['ulevel'] ?>)
                    </div>
                    <a href="../index.php" target="_blank" class="btn-view-site"><i class="fa fa-external-link"></i> Lihat Website</a>
                </div>
