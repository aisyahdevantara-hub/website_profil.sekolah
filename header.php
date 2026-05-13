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
    <link rel="stylesheet" href="assets/css/user-sidebar.css">

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
                <li><a href="#" onclick="showLoginModal(); hideMobileMenu();" style="background:#2E7D32; color:white; border-radius:10px;">Login</a></li>
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
                <li><a href="#" onclick="showLoginModal()" class="btn-login-nav">Login</a></li>
            </ul>

            <div class="mobile-menu-btn">
                <a href="#" onclick="showMobileMenu()">☰ Menu</a>
            </div>
            
            <div class="clearfix"></div> 
        </div>
    </div>

    <!-- Modal Pilihan Login -->
    <div class="login-modal-overlay" id="loginModal">
        <div class="login-modal-box">
            <span class="login-modal-close" onclick="hideLoginModal()">&times;</span>
            <div class="login-modal-header">
                <h3>Masuk Sebagai</h3>
                <p>Pilih jenis akun untuk melanjutkan</p>
            </div>
            <div class="login-modal-options">
                <a href="login.php" class="login-option-card">
                    <div class="login-option-icon">🛡️</div>
                    <div class="login-option-text">
                        <strong>Admin / Super Admin</strong>
                        <span>Kelola data website sekolah</span>
                    </div>
                    <div class="login-option-arrow">→</div>
                </a>
                <a href="login-ortu.php" class="login-option-card login-option-ortu">
                    <div class="login-option-icon">👨‍👩‍👧‍👦</div>
                    <div class="login-option-text">
                        <strong>Orang Tua Murid</strong>
                        <span>Pantau perkembangan anak</span>
                    </div>
                    <div class="login-option-arrow">→</div>
                </a>
            </div>
        </div>
    </div>

    <style>
        .login-modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.2s ease;
        }
        .login-modal-overlay.active {
            display: flex;
        }
        .login-modal-box {
            background: white;
            border-radius: 20px;
            padding: 35px;
            width: 420px;
            max-width: 90vw;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            position: relative;
            animation: slideUp 0.3s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .login-modal-close {
            position: absolute;
            top: 15px; right: 20px;
            font-size: 28px;
            color: #999;
            cursor: pointer;
            transition: 0.2s;
            line-height: 1;
        }
        .login-modal-close:hover { color: #333; }
        .login-modal-header {
            text-align: center;
            margin-bottom: 25px;
        }
        .login-modal-header h3 {
            color: #2E7D32;
            font-size: 22px;
            margin-bottom: 5px;
        }
        .login-modal-header p {
            color: #999;
            font-size: 14px;
        }
        .login-modal-options {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .login-option-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px 20px;
            border-radius: 14px;
            text-decoration: none;
            border: 2px solid #e8e8e8;
            transition: all 0.25s ease;
            background: #fafafa;
        }
        .login-option-card:hover {
            border-color: #2E7D32;
            background: #e8f5e9;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(46,125,50,0.15);
        }
        .login-option-icon {
            font-size: 32px;
            flex-shrink: 0;
        }
        .login-option-text {
            flex: 1;
        }
        .login-option-text strong {
            display: block;
            color: #333;
            font-size: 15px;
            margin-bottom: 2px;
        }
        .login-option-text span {
            color: #888;
            font-size: 12px;
        }
        .login-option-arrow {
            font-size: 20px;
            color: #ccc;
            transition: 0.2s;
        }
        .login-option-card:hover .login-option-arrow {
            color: #2E7D32;
            transform: translateX(3px);
        }
    </style>

    <script>
        var mobileMenu = document.getElementById('mobileMenu');
        var loginModal = document.getElementById('loginModal');
        
        function showMobileMenu(){
            mobileMenu.style.display = "block";
        }
        function hideMobileMenu(){
            mobileMenu.style.display = "none";
        }
        function showLoginModal(){
            loginModal.classList.add('active');
        }
        function hideLoginModal(){
            loginModal.classList.remove('active');
        }
        // Tutup modal kalo klik di luar box
        loginModal.addEventListener('click', function(e){
            if(e.target === loginModal) hideLoginModal();
        });
    </script>