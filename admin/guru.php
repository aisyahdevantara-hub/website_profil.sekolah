<?php include "header.php" ?>

<div class="main-content-inner">
    
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Data Pengurus</h2>
        <p style="color: #666;">Kelola data guru dan staf TK Al-Muhajirin</p>
    </div>

    <div class="box" style="margin-top: 20px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <a href="tambah-guru.php" class="btn-login" style="padding: 10px 20px; text-decoration: none; width: auto; font-size: 14px;">
                    <i class="fa fa-plus"></i> Tambah Pengurus
                </a>

                <form action="" style="width: 300px;">
                    <div class="input-group" style="display: flex;">
                        <input type="text" name="key" placeholder="Cari nama pengurus..." class="input-control" style="border-radius: 10px 0 0 10px; border: 1px solid #ddd;">
                        <button type="submit" style="padding: 0 15px; background: #2E7D32; color: white; border: none; border-radius: 0 10px 10px 0; cursor: pointer;">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <?php
            if(isset($_GET['success'])){
                echo "<div class='alert-error' style='background: #e8f5e9; color: #2E7D32; border: 1px solid #c8e6c9;'>".$_GET['success']."</div>";
            }
            ?>

            <table class="table">
                <thead>
                    <tr>
                        <th width="50px">No.</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan</th>
                        <th width="120px">Foto</th>
                        <th width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $where = " WHERE 1=1 ";
                    if(isset($_GET['key'])){
                        $where .= " AND nama_lengkap LIKE '%".addslashes($_GET['key'])."%'";
                    }  
                    $guru = mysqli_query($conn, "SELECT * FROM guru $where ORDER BY id DESC");
                    if(mysqli_num_rows($guru) > 0){
                        while($p = mysqli_fetch_array($guru)){
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td style="font-weight: 600; color: #333;"><?= $p['nama_lengkap'] ?></td>
                        <td><span style="background: #f0f0f0; padding: 5px 10px; border-radius: 5px; font-size: 12px;"><?= $p['jabatan'] ?></span></td>
                        <td>
                            <img src="../uploads/guru/<?= $p['gambar']?>" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 2px solid #eee;">
                        </td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <a href="edit-guru.php?id=<?= $p['id']?>" title="Edit Data" style="color: #ef6c00; font-size: 18px;"><i class="fa fa-edit"></i></a>
                                <a href="hapus.php?idguru=<?= $p['id']?>" onclick="return confirm('Hapus Data Ini?')" title="Hapus Data" style="color: #d32f2f; font-size: 18px;"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php }} else { ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: #999;">Data tidak ditemukan.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "footer.php" ?>