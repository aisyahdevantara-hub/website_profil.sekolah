<?php include 'header.php'; ?>

<div class="section">
    <div class="container text-center">
        <h3>Fasilitas</h3>
        <div class="grid-container">
        
        <?php
            $fasilitas = mysqli_query($conn, "SELECT * FROM fasilitas ORDER BY id DESC");
            
            if(mysqli_num_rows($fasilitas) > 0){
                while($p = mysqli_fetch_array($fasilitas)){
        ?>
                <a href="uploads/fasilitas/<?= $p['foto'] ?>" target="_blank" class="thumbnail-link">
                    <div class="thumbnail-box">
                        <div class="thumbnail-img" style="background-image: url('uploads/fasilitas/<?= $p['foto'] ?>');">
                        </div>
                        <div class="thumbnail-text">
                            <?= $p['keterangan'] ?>
                        </div>
                    </div>
                </a>
        <?php 
                }
            }else{ 
        ?>
            Tidak ada data fasilitas.
        <?php } ?>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>