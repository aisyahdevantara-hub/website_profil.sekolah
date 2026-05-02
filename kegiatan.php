<?php include 'header.php'; ?>

<div class="section">
    <div class="container text-center">
        <h3>Program Kegiatan</h3>
        <div class="grid-container">
        
        <?php
            $kegiatan = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY id DESC");
            
            if(mysqli_num_rows($kegiatan) > 0){
                while($p = mysqli_fetch_array($kegiatan)){
        ?>
                <a href="detail-kegiatan.php?id=<?= $p['id'] ?>" class="thumbnail-link">
                    <div class="thumbnail-box">
                        <div class="thumbnail-img" style="background-image: url('uploads/kegiatan/<?= $p['gambar'] ?>');">
                        </div>
                        <div class="thumbnail-text">
                            <?= substr($p['judul'], 0, 50) ?>
                        </div>
                    </div>
                </a>
        <?php 
                }
            }else{ 
        ?>
            Tidak ada data kegiatan.
        <?php } ?>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>