<?php include "header.php"; ?>

<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Dashboard</h2>
        <p style="color: #666;">Selamat Datang, <strong><?= $_SESSION['uname'] ?></strong> di Panel Admin <?= $d->nama ?></p>
    </div>

    <!-- Stat cards removed per user request -->

    <div class="box" style="margin-top: 30px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body">
            <h4>Panduan Singkat</h4>
            <p style="margin-top: 10px; color: #555; line-height: 1.6;">
                Gunakan menu di samping kiri untuk mengelola konten website. 
                Anda dapat menambah, mengubah, atau menghapus data pengurus, fasilitas, dan kegiatan sekolah. 
                Pastikan ukuran gambar yang diunggah tidak terlalu besar agar website tetap cepat.
            </p>
        </div>
    </div>
</div>

<?php include "footer.php" ?>