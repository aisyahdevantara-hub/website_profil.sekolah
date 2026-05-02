<?php include 'header.php'; ?>

<div class="section">
    <div class="container">
        <?php 
            $kegiatan = mysqli_query($conn, "SELECT * FROM kegiatan WHERE id = '".$_GET['id']."'");

            
            if(mysqli_num_rows($kegiatan) == 0){
                echo "<script>window.location='index.php'</script>";
            }

            $p = mysqli_fetch_object($kegiatan);
        ?>
        
        <h3 class="text-center"><?= $p->judul ?></h3>
        
        <div style="margin-bottom: 20px; color: #666;">
            <small>Diposting pada: <?= date('d/m/Y', strtotime($p->created_at)) ?></small>
        </div>

        <div class="thumbnail-box" style="margin-bottom: 20px;">
            <div class="thumbnail-img" style="background-image: url('uploads/kegiatan/<?= $p->gambar ?>'); height: 400px; border-radius: 5px;"></div>
        </div>
        
        <div class="detail-keterangan" style="margin-top: 20px; line-height: 1.6;">
            <?= $p->keterangan ?>
        </div>

        <div style="margin-top: 50px;">
            <button type="button" class="btn" onclick="window.location='kegiatan.php'"> Kembali ke Daftar Kegiatan</button>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>