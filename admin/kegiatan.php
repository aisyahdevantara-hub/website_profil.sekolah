<?php include "header.php" ?>

<div class="main-content-inner">
    
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Data Kegiatan</h2>
        <p style="color: #666;">Kelola dokumentasi program dan kegiatan sekolah</p>
    </div>

    <div class="box" style="margin-top: 20px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <a href="tambah-kegiatan.php" class="btn-login" style="padding: 10px 20px; text-decoration: none; width: auto; font-size: 14px;">
                    <i class="fa fa-plus"></i> Tambah Kegiatan
                </a>

                <form action="" style="width: 300px;">
                    <div class="input-group" style="display: flex;">
                        <input type="text" name="key" placeholder="Cari judul kegiatan..." class="input-control" style="border-radius: 10px 0 0 10px; border: 1px solid #ddd;">
                        <button type="submit" style="padding: 0 15px; background: #2E7D32; color: white; border: none; border-radius: 0 10px 10px 0; cursor: pointer;">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <?php
            if(isset($_GET['success'])){
                echo "<div class='alert-error' style='background: #e8f5e9; color: #2E7D32; border: 1px solid #c8e6c9; padding: 10px; border-radius: 10px; margin-bottom: 20px;'>".$_GET['success']."</div>";
            }
            ?>

            <table class="table">
                <thead>
                    <tr>
                        <th width="50px">No.</th>
                        <th width="150px">Gambar</th>
                        <th>Judul Kegiatan</th>
                        <th>Keterangan</th>
                        <th width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $where = " WHERE 1=1 ";
                    if(isset($_GET['key'])){
                        $where .= " AND judul LIKE '%".addslashes($_GET['key'])."%'";
                    }  
                    $kegiatan = mysqli_query($conn, "SELECT * FROM kegiatan $where ORDER BY id DESC");
                    
                    if(mysqli_num_rows($kegiatan) > 0){
                        while($p = mysqli_fetch_array($kegiatan)){
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>
                            <img src="../uploads/kegiatan/<?= $p['gambar'] ?>" style="width: 100px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
                        </td>
                        <td style="font-weight: 600; color: #2E7D32;"><?= $p['judul'] ?></td>
                        <td style="font-size: 13px; color: #666;">
                            <?= substr(strip_tags($p['keterangan']), 0, 80) ?>...
                        </td>
                        <td>
                            <div style="display: flex; gap: 12px;">
                                <a href="edit-kegiatan.php?id=<?= $p['id'] ?>" title="Edit Data" style="color: #ef6c00; font-size: 18px;"><i class="fa fa-edit"></i></a>
                                <a href="hapus.php?idkegiatan=<?= $p['id'] ?>" onclick="return confirm('Hapus Data Ini?')" title="Hapus Data" style="color: #d32f2f; font-size: 18px;"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {  
                    ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: #999;">Belum ada data kegiatan.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "footer.php" ?>