<?php include "header.php" ?>

<div class="main-content-inner">
    
    <!-- Content Header seperti guru.php -->
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Data Pengguna</h2>
        <p style="color: #666;">Kelola akun pengguna admin dan super admin</p>
    </div>

    <div class="box" style="margin-top: 20px;">
        <div class="box-body">

            <!-- Action Header seperti guru.php -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <a href="tambah-pengguna.php" class="btn-login" style="padding: 10px 20px; text-decoration: none; width: auto; font-size: 14px;">
                    <i class="fa fa-plus"></i> Tambah Pengguna
                </a>

                <form action="" style="width: 300px;">
                    <div class="input-group" style="display: flex;">
                        <input type="text" name="key" placeholder="Cari nama pengguna..." class="input-control" style="border-radius: 10px 0 0 10px; border: 1px solid #ddd;">
                        <button type="submit" style="padding: 0 15px; background: #2E7D32; color: white; border: none; border-radius: 0 10px 10px 0; cursor: pointer;">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Success Alert -->
            <?php if(isset($_GET['success'])){ ?>
                <div class="alert-error" style="background: #e8f5e9; color: #2E7D32; border: 1px solid #c8e6c9;">
                    <?= $_GET['success'] ?>
                </div>
            <?php } ?>

            <!-- Data Table -->
            <table class="table">
                <thead>
                    <tr>
                        <th width="50px">No.</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th width="100px">Level</th>
                        <th width="120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $where = " WHERE 1=1 ";
                    if(isset($_GET['key'])){
                        $where .= " AND nama LIKE '%".addslashes($_GET['key'])."%'";
                    }  
                    $pengguna = mysqli_query($conn, "SELECT * FROM pengguna $where ORDER BY id DESC");
                    if(mysqli_num_rows($pengguna) > 0){
                        while($p = mysqli_fetch_array($pengguna)){
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td style="font-weight: 600; color: #333;"><?= $p['nama'] ?></td>
                        <td><?= $p['username'] ?></td>
                        <td>
                            <span style="background: #f0f0f0; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                <?= ucwords($p['level']) ?>
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <a href="edit-pengguna.php?id=<?= $p['id'] ?>" title="Edit" style="color: #ef6c00; font-size: 18px;"><i class="fa fa-edit"></i></a>
                                <a href="hapus.php?idpengguna=<?= $p['id'] ?>" onclick="return confirm('Hapus pengguna ini?')" title="Hapus" style="color: #d32f2f; font-size: 18px;"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php }} else { ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #999; font-style: italic;">Tidak ada data pengguna ditemukan</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "footer.php" ?>

