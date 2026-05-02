<?php include 'header.php'; ?>
<div class="section">
<div class="container text-center">
        <h3>Pengurus</h3>
        <div class="grid-container">
        <?php
            $guru = mysqli_query($conn, "SELECT * FROM guru ORDER BY id DESC");
            if(mysqli_num_rows($guru) > 0){
                while($j = mysqli_fetch_array($guru)){
        ?>
                    <div class="thumbnail-box">
                        <div class="thumbnail-img" style="background-image: url('uploads/guru/<?= $j['gambar'] ?>');">
                        </div>
                        <div class="thumbnail-text">
                            <?= $j['nama_lengkap'] ?>
                            <br>
                            <small><?= $j['jabatan'] ?></small>
                        </div>
                    </div>
        <?php }}else{ ?>
            Tidak ada Data
        <?php } ?>
        </div>
    </div>
</div>
 <?php include 'footer.php'; ?>        
