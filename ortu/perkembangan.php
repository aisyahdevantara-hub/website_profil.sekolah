<?php include "header.php"; ?>

<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Perkembangan Anak</h2>
        <p style="color: #666;">Laporan perkembangan lengkap <strong><?= $anak->nama_lengkap ?></strong></p>
    </div>

    <!-- Filter Semester -->
    <div class="box" style="margin-top: 20px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body">
            <form action="" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <label style="font-weight: 600; color: #333;">Filter Semester:</label>
                <select name="semester" class="input-control" style="width: 250px; border: 1px solid #ddd;">
                    <option value="">Semua Semester</option>
                    <?php 
                        // Ambil semester yang tersedia
                        $semesters = mysqli_query($conn, "SELECT DISTINCT semester FROM perkembangan WHERE siswa_id = '".$anak->id."' ORDER BY semester");
                        while($sm = mysqli_fetch_array($semesters)){
                    ?>
                    <option value="<?= $sm['semester'] ?>" <?= (isset($_GET['semester']) && $_GET['semester'] == $sm['semester']) ? 'selected' : '' ?>><?= $sm['semester'] ?></option>
                    <?php } ?>
                </select>
                <button type="submit" style="padding: 10px 20px; background: #2E7D32; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600;">
                    <i class="fa fa-filter"></i> Filter
                </button>
            </form>
        </div>
    </div>

    <?php
        $where = " WHERE p.siswa_id = '".$anak->id."' ";
        if(isset($_GET['semester']) && $_GET['semester'] != ''){
            $where .= " AND p.semester = '".addslashes($_GET['semester'])."'";
        }

        $warna = ['BB' => '#f44336', 'MB' => '#ff9800', 'BSH' => '#2196F3', 'BSB' => '#4CAF50'];
        $label = ['BB' => 'Belum Berkembang', 'MB' => 'Mulai Berkembang', 'BSH' => 'Berkembang Sesuai Harapan', 'BSB' => 'Berkembang Sangat Baik'];
        $nilai = ['BB' => 25, 'MB' => 50, 'BSH' => 75, 'BSB' => 100];

        // Group by kategori
        $kategoris = ['Nilai Agama dan Moral', 'Fisik-Motorik', 'Kognitif', 'Bahasa', 'Sosial-Emosional', 'Seni'];
        $icons = ['Nilai Agama dan Moral' => '🕌', 'Fisik-Motorik' => '🏃', 'Kognitif' => '🧠', 'Bahasa' => '📖', 'Sosial-Emosional' => '🤝', 'Seni' => '🎨'];
        
        $has_data = false;
    ?>

    <?php foreach($kategoris as $kat): ?>
        <?php
            $items = mysqli_query($conn, "SELECT p.*, g.nama_lengkap as nama_guru FROM perkembangan p LEFT JOIN guru g ON p.guru_id = g.id $where AND p.kategori = '$kat' ORDER BY p.tanggal DESC");
            if(mysqli_num_rows($items) > 0){
                $has_data = true;
        ?>
    <div class="box" style="margin-top: 20px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body">
            <h4 style="margin-bottom: 15px; color: #2E7D32; font-size: 16px;">
                <?= $icons[$kat] ?> <?= $kat ?>
            </h4>
            
            <?php while($r = mysqli_fetch_array($items)): ?>
            <div style="background: #f9f9f9; border-radius: 12px; padding: 15px; margin-bottom: 10px; border-left: 4px solid <?= $warna[$r['capaian']] ?>;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; flex-wrap: wrap; gap: 5px;">
                    <span style="font-weight: 600; font-size: 14px; color: #333;"><?= $r['aspek'] ?></span>
                    <span style="background: <?= $warna[$r['capaian']] ?>; color: white; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                        <?= $label[$r['capaian']] ?>
                    </span>
                </div>
                
                <!-- Progress Bar -->
                <div style="background: #e0e0e0; border-radius: 10px; height: 8px; margin-bottom: 8px; overflow: hidden;">
                    <div style="background: <?= $warna[$r['capaian']] ?>; height: 100%; width: <?= $nilai[$r['capaian']] ?>%; border-radius: 10px; transition: width 0.5s ease;"></div>
                </div>
                
                <?php if($r['catatan']): ?>
                    <p style="font-size: 13px; color: #666; margin-bottom: 5px;">💬 <em><?= $r['catatan'] ?></em></p>
                <?php endif; ?>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 5px;">
                    <span style="font-size: 11px; color: #aaa;">📅 <?= date('d M Y', strtotime($r['tanggal'])) ?></span>
                    <?php if($r['nama_guru']): ?>
                        <span style="font-size: 11px; color: #aaa;">👨‍🏫 <?= $r['nama_guru'] ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php } endforeach; ?>

    <?php if(!$has_data): ?>
    <div class="box" style="margin-top: 20px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body" style="text-align: center; padding: 50px;">
            <div style="font-size: 60px; margin-bottom: 15px;">📋</div>
            <h4 style="color: #999;">Belum Ada Data Perkembangan</h4>
            <p style="color: #bbb; margin-top: 10px;">Guru akan mengisi laporan perkembangan anak Anda secara berkala.</p>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include "footer.php" ?>
