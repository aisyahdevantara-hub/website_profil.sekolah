<aside class="user-sidebar">
    <div class="sidebar-widget">
        <h4>📍 Informasi Sekolah</h4>
        <div class="widget-content">
            <p><strong><?= $d->nama ?></strong></p>
            <p style="font-size: 13px; color: #666; line-height: 1.6;"><?= $d->alamat ?></p>
            <p style="font-size: 13px; margin-top: 8px;">📞 <?= $d->telepon ?></p>
            <p style="font-size: 13px;">✉️ <?= $d->email ?></p>
        </div>
    </div>

    <div class="sidebar-widget">
        <h4>🔗 Navigasi Cepat</h4>
        <ul class="quick-links">
            <li><a href="index.php">🏠 Beranda</a></li>
            <li><a href="tentang-sekolah.php">📖 Tentang Sekolah</a></li>
            <li><a href="guru.php">👨‍🏫 Pengurus</a></li>
            <li><a href="fasilitas.php">🏫 Fasilitas</a></li>
            <li><a href="kegiatan.php">📋 Program Kegiatan</a></li>
            <li><a href="kontak.php">📞 Kontak</a></li>
        </ul>
    </div>

    <div class="sidebar-widget">
        <h4>📰 Kegiatan Terbaru</h4>
        <?php
            $recent = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY id DESC LIMIT 3");
            if(mysqli_num_rows($recent) > 0){
                while($r = mysqli_fetch_array($recent)){
        ?>
        <a href="detail-kegiatan.php?id=<?= $r['id'] ?>" class="recent-item">
            <div class="recent-img" style="background-image: url('uploads/kegiatan/<?= $r['gambar'] ?>');"></div>
            <div class="recent-text"><?= substr($r['judul'], 0, 40) ?>...</div>
        </a>
        <?php }}else{ echo "<p style='color:#999; font-size:13px;'>Belum ada kegiatan.</p>"; } ?>
    </div>

    <div class="sidebar-widget">
        <a href="login-ortu.php" class="btn-login-ortu">
            👨‍👩‍👧 Login Orang Tua
        </a>
    </div>
</aside>
