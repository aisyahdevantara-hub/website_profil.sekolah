<?php include "header.php" ?>

<div class="main-content-inner">
    
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Data Siswa</h2>
        <p style="color: #666;">Kelola data siswa TK</p>
    </div>

    <div class="box" style="margin-top: 20px;">
        <div class="box-body">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                <a href="tambah-siswa.php" class="btn-login" style="padding: 10px 20px; text-decoration: none; width: auto; font-size: 14px;">
                    <i class="fa fa-plus"></i> Tambah Siswa
                </a>

                <form action="" style="width: 300px;">
                    <div class="input-group" style="display: flex;">
                        <input type="text" name="key" placeholder="Cari nama siswa..." class="input-control" style="border-radius: 10px 0 0 10px; border: 1px solid #ddd;" value="<?= isset($_GET['key']) ? htmlspecialchars($_GET['key']) : '' ?>">
                        <button type="submit" style="padding: 0 15px; background: #2E7D32; color: white; border: none; border-radius: 0 10px 10px 0; cursor: pointer;">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <?php if(isset($_GET['success'])){ ?>
                <div class="alert-error" style="background: #e8f5e9; color: #2E7D32; border: 1px solid #c8e6c9;">
                    <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php } ?>

            <table class="table">
                <thead>
                    <tr>
                        <th width="50px">No.</th>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>L/P</th>
                        <th>Kelas</th>
                        <th width="80px">Status</th>
                        <th width="120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $where = " WHERE 1=1 ";
                    if(isset($_GET['key']) && $_GET['key'] != ''){
                        $where .= " AND nama_lengkap LIKE '%".addslashes($_GET['key'])."%'";
                    }  
                    $siswa = mysqli_query($conn, "SELECT * FROM siswa $where ORDER BY id DESC");
                    if(mysqli_num_rows($siswa) > 0){
                        while($s = mysqli_fetch_array($siswa)){
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $s['nis'] ?></td>
                        <td style="font-weight: 600; color: #333;"><?= $s['nama_lengkap'] ?></td>
                        <td><?= $s['jenis_kelamin'] ?></td>
                        <td><?= $s['kelas'] ?></td>
                        <td>
                            <span style="background: <?= $s['status']=='Aktif' ? '#e8f5e9' : ($s['status']=='Lulus' ? '#e3f2fd' : '#ffebee') ?>; color: <?= $s['status']=='Aktif' ? '#2E7D32' : ($s['status']=='Lulus' ? '#1565C0' : '#c62828') ?>; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                <?= $s['status'] ?>
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <a href="edit-siswa.php?id=<?= $s['id'] ?>" title="Edit" style="color: #ef6c00; font-size: 18px;"><i class="fa fa-edit"></i></a>
                                <a href="hapus.php?idsiswa=<?= $s['id'] ?>" onclick="return confirm('Hapus siswa ini? Data orang tua dan perkembangan juga akan terhapus!')" title="Hapus" style="color: #d32f2f; font-size: 18px;"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php }} else { ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #999; font-style: italic;">Tidak ada data siswa ditemukan</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "footer.php" ?>
