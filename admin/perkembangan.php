<?php include "header.php" ?>

<div class="main-content-inner">
    
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Laporan Perkembangan</h2>
        <p style="color: #666;">Kelola laporan perkembangan siswa</p>
    </div>

    <div class="box" style="margin-top: 20px;">
        <div class="box-body">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                <a href="tambah-perkembangan.php" class="btn-login" style="padding: 10px 20px; text-decoration: none; width: auto; font-size: 14px;">
                    <i class="fa fa-plus"></i> Tambah Laporan
                </a>

                <form action="" style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <select name="siswa_id" class="input-control" style="width: 200px; border: 1px solid #ddd;">
                        <option value="">Semua Siswa</option>
                        <?php 
                            $siswa_list = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nama_lengkap ASC");
                            while($sl = mysqli_fetch_array($siswa_list)){
                        ?>
                        <option value="<?= $sl['id'] ?>" <?= (isset($_GET['siswa_id']) && $_GET['siswa_id'] == $sl['id']) ? 'selected' : '' ?>><?= $sl['nama_lengkap'] ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" style="padding: 8px 15px; background: #2E7D32; color: white; border: none; border-radius: 10px; cursor: pointer;">
                        <i class="fa fa-filter"></i> Filter
                    </button>
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
                        <th width="40px">No.</th>
                        <th>Siswa</th>
                        <th>Tanggal</th>
                        <th>Semester</th>
                        <th>Kategori</th>
                        <th>Aspek</th>
                        <th>Capaian</th>
                        <th width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $where = " WHERE 1=1 ";
                    if(isset($_GET['siswa_id']) && $_GET['siswa_id'] != ''){
                        $where .= " AND p.siswa_id = '".addslashes($_GET['siswa_id'])."'";
                    }  
                    $pkb = mysqli_query($conn, "SELECT p.*, s.nama_lengkap FROM perkembangan p LEFT JOIN siswa s ON p.siswa_id = s.id $where ORDER BY p.id DESC");
                    if(mysqli_num_rows($pkb) > 0){
                        while($r = mysqli_fetch_array($pkb)){
                            // Warna capaian
                            $warna = ['BB' => '#f44336', 'MB' => '#ff9800', 'BSH' => '#2196F3', 'BSB' => '#4CAF50'];
                            $label = ['BB' => 'Belum Berkembang', 'MB' => 'Mulai Berkembang', 'BSH' => 'Sesuai Harapan', 'BSB' => 'Sangat Baik'];
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td style="font-weight: 600;"><?= $r['nama_lengkap'] ?></td>
                        <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                        <td><span style="font-size: 12px;"><?= $r['semester'] ?></span></td>
                        <td><span style="font-size: 12px;"><?= $r['kategori'] ?></span></td>
                        <td><span style="font-size: 12px;"><?= $r['aspek'] ?></span></td>
                        <td>
                            <span style="background: <?= $warna[$r['capaian']] ?>; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                <?= $r['capaian'] ?>
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <a href="edit-perkembangan.php?id=<?= $r['id'] ?>" title="Edit" style="color: #ef6c00; font-size: 18px;"><i class="fa fa-edit"></i></a>
                                <a href="hapus.php?idperkembangan=<?= $r['id'] ?>" onclick="return confirm('Hapus laporan ini?')" title="Hapus" style="color: #d32f2f; font-size: 18px;"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php }} else { ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #999; font-style: italic;">Tidak ada data perkembangan ditemukan</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "footer.php" ?>
