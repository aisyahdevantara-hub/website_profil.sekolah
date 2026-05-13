<?php
    session_start();
    include '../koneksi.php';
    if(!isset($_SESSION['ortu_login'])){
        echo "<script>window.location ='../login-ortu.php?msg=Harap Login Terlebih Dahulu!'</script>";
        exit;
    }
    date_default_timezone_set('Asia/Jakarta');

    $identitas = mysqli_query($conn, "SELECT * FROM pengaturan ORDER BY id DESC LIMIT 1");
    $d = mysqli_fetch_object($identitas);

    // Data anak
    $siswa_data = mysqli_query($conn, "SELECT * FROM siswa WHERE id = '".$_SESSION['ortu_siswa_id']."'");
    $anak = mysqli_fetch_object($siswa_data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../uploads/identitas/<?= $d->favicon ?>">
    <title>Portal Orang Tua - <?= $d->nama ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/ortu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <script>
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-open');
        }
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
        <div class="sidebar" style="background: linear-gradient(180deg, #2E7D32 0%, #1B5E20 100%);">
            <div class="sidebar-logo">
                <img src="../uploads/identitas/<?= $d->logo ?>" width="50">
                <h3>Portal Orang Tua</h3>
            </div>
            
            <div style="text-align: center; padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 10px;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(255,255,255,0.2); margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                    👨‍👩‍👧
                </div>
                <p style="font-size: 13px; opacity: 0.8;">Anak:</p>
                <p style="font-weight: 600; font-size: 14px;"><?= $anak->nama_lengkap ?></p>
                <span style="background: rgba(255,255,255,0.2); padding: 3px 12px; border-radius: 20px; font-size: 11px;"><?= $anak->kelas ?></span>
            </div>

            <ul class="sidebar-menu">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="perkembangan.php"><i class="fa fa-chart-line"></i> Perkembangan Anak</a></li>
                
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
                        Halo, <strong><?= $_SESSION['ortu_nama'] ?></strong> 👋
                    </div>
                    <a href="../index.php" target="_blank" class="btn-view-site"><i class="fa fa-external-link"></i> Lihat Website</a>
                </div>
