<?php include 'header.php'; ?>
<style>
.modal-display {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}
.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 25px;
    border-radius: 15px;
    width: 80%;
    max-width: 600px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
}
.close-modal {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}
.close-modal:hover { color: #000; }
</style>

<div id="page-wrapper">
    <div class="container">
        <h3 class="text-center">Manajemen Pesan</h3>
        
        <!-- Notifikasi sukses/hapus -->
        <?php if(isset($_GET['hapus'])): ?>
            <div class="alert alert-success shadow-sm border-0" role="alert" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; border-radius: 10px; padding: 15px 20px; margin-bottom: 20px; font-weight: 500;">
                <i class="fa fa-check-circle me-2"></i>Pesan berhasil dihapus!
            </div>
        <?php endif; ?>
        
        <!-- Modal Popups -->
        <?php
        $pesan2 = mysqli_query($conn, "SELECT * FROM pesan ORDER BY tanggal DESC");
        $no2 = 1;
        if(mysqli_num_rows($pesan2) > 0){
            while($p2 = mysqli_fetch_array($pesan2)){
        ?>
        <div id="modal<?= $no2 ?>" class="modal-display">
            <div class="modal-content">
                <span class="close-modal" onclick="document.getElementById('modal<?= $no2 ?>').style.display='none'">&times;</span>
                <h4 style="color: #2E7D32; margin-bottom: 15px;">Pesan dari <?= htmlspecialchars($p2['nama_pengirim']) ?></h4>
                <p style="line-height: 1.8; white-space: pre-wrap;"><?= htmlspecialchars($p2['pesan']) ?></p>
                <hr style="margin: 20px 0;">
                <p style="color: #666; font-size: 14px;">
                    <i class="fa fa-phone"></i> <?= htmlspecialchars($p2['nomor_wa']) ?> | 
                    <i class="fa fa-envelope"></i> <?= htmlspecialchars($p2['email']) ?> | 
                    <i class="fa fa-clock"></i> <?= date('d/m/Y H:i', strtotime($p2['tanggal'])) ?>
                </p>
            </div>
        </div>
        <?php $no2++; } } ?>
        
        <!-- Tabel daftar pesan -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengirim</th>
                        <th>Nomor WA</th>
                        <th>Email</th>
                        <th>Pesan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pesan = mysqli_query($conn, "SELECT * FROM pesan ORDER BY tanggal DESC");
                    $no = 1;
                    if(mysqli_num_rows($pesan) > 0){
                        while($p = mysqli_fetch_array($pesan)){
?>
<tr>
                        <td><?= $no ?></td>
<td><?= htmlspecialchars($p['nama_pengirim']) ?></td>
<td><a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $p['nomor_wa']) ?>?text=Halo%20Admin%20<?= $d->nama ?>,%20saya%20ingin%20bertanya" target="_blank"><?= htmlspecialchars($p['nomor_wa']) ?></a></td>
                        <td><?= htmlspecialchars($p['email']) ?></td>
<td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><a href="#" onclick="document.getElementById('modal<?= $no ?>').style.display='block'" style="color: #2E7D32; text-decoration: underline; cursor: pointer;"><?= substr(htmlspecialchars($p['pesan']), 0, 30) ?>...</a></td>
                        <td><?= date('d/m/Y H:i', strtotime($p['tanggal'])) ?></td>
                        <td>
                            <a href="?hapus&id=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pesan ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php $no++; ?>
<?php } } else { ?>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada pesan masuk</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
// Proses hapus
if(isset($_GET['hapus']) && isset($_GET['id'])){
    $hapus = mysqli_query($conn, "DELETE FROM pesan WHERE id = '".$_GET['id']."'");
    if($hapus){
        echo "<script>window.location='pesan.php?hapus=sukses'</script>";
    }
}
?>
<?php include 'footer.php'; ?>
