<?php include 'header.php'; ?>
<div class="section" style="padding-top: 0;">
    <div class="container">
        <div class="hero" style="background: linear-gradient(rgba(46, 125, 50, 0.75), rgba(46, 125, 50, 0.75)), url('uploads/identitas/<?= $d->foto_sekolah ?>'); background-size: cover; background-position: center; height: 400px; display: flex; flex-direction: column; justify-content: center; align-items: center; color: white; text-align: center; border-radius: 0 0 50px 50px;">
            <h2 style="font-size: 2.5rem; margin-bottom: 10px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Tentang Sekolah Kami</h2>
            <p style="font-size: 1.2rem; max-width: 600px; opacity: 0.95;">Mengenal lebih dekat visi, misi, dan perjalanan <?= $d->nama ?></p>
        </div>
        
        <div class="card-item" style="max-width: 900px; margin: 40px auto; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 20px; overflow: hidden; animation: fadeInUp 1s ease-out;">
            <div class="card-body" style="padding: 50px; line-height: 1.8; font-size: 1.1rem; color: #444; text-align: justify;">
                <?= $d->tentang_sekolah ?>
            </div>
        </div>
    </div>
</div>
 <?php include 'footer.php'; ?>       