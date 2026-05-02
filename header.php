<?php
    include 'koneksi.php';
    date_default_timezone_set('Asia/Jakarta');

    $identitas = mysqli_query($conn, "SELECT * FROM pengaturan ORDER BY id DESC LIMIT 1");
    $d = mysqli_fetch_object($identitas);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="uploads/identitas/<?= $d->favicon ?>">
    <title>Website <?= $d->nama ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index-mobile.css">

</head>
<body>
    
    <div class="box-menu-mobile" id="mobileMenu">
        <div class="mobile-menu-content">
            <span class="close-menu" onclick="hideMobileMenu()">× Tutup</span>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="tentang-sekolah.php">Tentang Sekolah</a></li>
                <li><a href="guru.php">Pengurus</a></li>
                <li><a href="fasilitas.php">Fasilitas</a></li>
                <li><a href="kegiatan.php">Program</a></li>
                <li><a href="kontak.php">Kontak</a></li>
                <li><a href="login.php" style="background:#2E7D32; color:white; border-radius:10px;">Login</a></li>
            </ul>
        </div>
     </div>

    <div class="header">
        <div class="container">
            <div class="header-logo">
                <img src="uploads/identitas/<?= $d->logo ?>" alt="Logo">
                <h2><a href="index.php"><?= $d->nama ?></a></h2>
            </div>
            
            <ul class="header-menu">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="tentang-sekolah.php">Tentang Sekolah</a></li>
                <li><a href="guru.php">Pengurus</a></li>
                <li><a href="fasilitas.php">Fasilitas</a></li>
                <li><a href="kegiatan.php">Program</a></li>
                <li><a href="kontak.php">Kontak</a></li>
                <li><a href="login.php" class="btn-login-nav">Login</a></li>
            </ul>

            <div class="mobile-menu-btn">
                <a href="#" onclick="showMobileMenu()">☰ Menu</a>
            </div>
            
            <div class="clearfix"></div> 
        </div>
    </div>

    <script>
        var mobileMenu = document.getElementById('mobileMenu');
        function showMobileMenu(){
            mobileMenu.style.display = "block";
        }
        function hideMobileMenu(){
            mobileMenu.style.display = "none";
        }
    </script>