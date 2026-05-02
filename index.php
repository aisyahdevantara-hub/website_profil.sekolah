<?php include 'header.php'; ?>

<div class="banner" style="background-image: url('uploads/identitas/<?= $d->foto_sekolah ?>');">
    <div class="container banner-text">
        <h3>Selamat Datang di Website <?= $d->nama ?></h3>
        <p>Selamat Datang di TK Al-Muhajirin, daftarkan anakmu untuk dasar pemahaman yang mantap.</p>
    </div>
</div>

<div class="section">
    <div class="container text-center">
        <h3>Sambutan Kepsek</h3>
        <br>
        <img src="uploads/identitas/<?= $d->foto_kepsek ?>" width="150px" class="foto-kepsek">
        <h4><?= $d->nama_kepsek ?></h4>
        <p style="max-width: 800px; margin: 10px auto; color: #666;"><?= $d->sambutan_kepsek ?></p>
    </div>
</div>

<div class="section" id="kelas" style="background-color: #f9f9f9;">
    <div class="container text-center">
        <h3>Pengurus Sekolah</h3>
        <div class="grid-container">
            <?php
                $guru = mysqli_query($conn, "SELECT * FROM guru ORDER BY id DESC");
                if(mysqli_num_rows($guru) > 0){
                    while($j = mysqli_fetch_array($guru)){
            ?>
                    <div class="thumbnail-box">
                        <div class="thumbnail-img" style="background-image: url('uploads/guru/<?= $j['gambar'] ?>');"></div>
                        <div class="thumbnail-text"><?= $j['nama_lengkap'] ?></div>
                    </div>
            <?php }}else{ echo "Tidak ada Data"; } ?>
        </div>
    </div>
</div>

<div class="section">
    <div class="container text-center">
        <h3>Program Kegiatan</h3>
        <div class="grid-container">
            <?php
                $kegiatan = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY id DESC LIMIT 8");
                if(mysqli_num_rows($kegiatan) > 0){
                    while($p = mysqli_fetch_array($kegiatan)){
            ?>
                <a href="detail-kegiatan.php?id=<?= $p['id'] ?>" class="thumbnail-link">
                    <div class="thumbnail-box">
                        <div class="thumbnail-img" style="background-image: url('uploads/kegiatan/<?= $p['gambar'] ?>');"></div>
                        <div class="thumbnail-text"><?= substr($p['judul'], 0, 50) ?></div>
                    </div>
                </a>
            <?php }}else{ echo "Tidak ada data kegiatan."; } ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>