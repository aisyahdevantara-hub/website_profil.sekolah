<?php include "header.php" ?>

<div class="main-content-inner">
    
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Data Orang Tua</h2>
        <p style="color: #666;">Kelola akun login orang tua murid</p>
    </div>

    <div class="box" style="margin-top: 20px;">
        <div class="box-body">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                <a href="tambah-ortu.php" class="btn-login" style="padding: 10px 20px; text-decoration: none; width: auto; font-size: 14px;">
                    <i class="fa fa-plus"></i> Tambah Akun Ortu
                </a>

                <form action="" style="width: 300px;">
                    <div class="input-group" style="display: flex;">
                        <input type="text" name="key" placeholder="Cari nama orang tua..." class="input-control" style="border-radius: 10px 0 0 10px; border: 1px solid #ddd;" value="<?= isset($_GET['key']) ? htmlspecialchars($_GET['key']) : '' ?>">
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
                        <th>Nama Orang Tua</th>
                        <th>Username</th>
                        <th>No HP</th>
                        <th>Anak (Siswa)</th>
                        <th width="120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $where = " WHERE 1=1 ";
                    if(isset($_GET['key']) && $_GET['key'] != ''){
                        $where .= " AND o.nama LIKE '%".addslashes($_GET['key'])."%'";
                    }  
                    $ortu = mysqli_query($conn, "SELECT o.*, s.nama_lengkap as nama_anak, s.kelas FROM ortu o LEFT JOIN siswa s ON o.siswa_id = s.id $where ORDER BY o.id DESC");
                    if(mysqli_num_rows($ortu) > 0){
                        while($p = mysqli_fetch_array($ortu)){
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td style="font-weight: 600; color: #333;"><?= $p['nama'] ?></td>
                        <td><?= $p['username'] ?></td>
                        <td><?= $p['no_hp'] ?></td>
                        <td>
                            <span style="background: #e8f5e9; color: #2E7D32; padding: 4px 10px; border-radius: 20px; font-size: 12px;">
                                <?= $p['nama_anak'] ?> (<?= $p['kelas'] ?>)
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <a href="edit-ortu.php?id=<?= $p['id'] ?>" title="Edit" style="color: #ef6c00; font-size: 18px;"><i class="fa fa-edit"></i></a>
                                <a href="hapus.php?idortu=<?= $p['id'] ?>" onclick="return confirm('Hapus akun orang tua ini?')" title="Hapus" style="color: #d32f2f; font-size: 18px;"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php }} else { ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #999; font-style: italic;">Tidak ada data orang tua ditemukan</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "footer.php" ?>
