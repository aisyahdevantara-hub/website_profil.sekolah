<?php include "header.php"; ?>

<div class="main-content-inner">
    <div class="content-header-title">
        <h2 style="color: #2E7D32; font-weight: 700;">Dashboard</h2>
        <p style="color: #666;">Selamat datang, <strong><?= $_SESSION['ortu_nama'] ?></strong>! Berikut informasi putra/putri Anda.</p>
    </div>

    <!-- Profil Anak -->
    <div class="box" style="margin-top: 20px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body" style="display: flex; align-items: center; gap: 25px; flex-wrap: wrap;">
            <div style="flex-shrink: 0;">
                <?php if($anak->foto && file_exists('../uploads/siswa/'.$anak->foto)): ?>
                    <img src="../uploads/siswa/<?= $anak->foto ?>" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 4px solid #C8E6C9;">
                <?php else: ?>
                    <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #66BB6A, #2E7D32); display: flex; align-items: center; justify-content: center; font-size: 40px; color: white; border: 4px solid #C8E6C9;">
                        <?= $anak->jenis_kelamin == 'L' ? '👦' : '👧' ?>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <h3 style="color: #333; margin-bottom: 5px;"><?= $anak->nama_lengkap ?></h3>
                <p style="color: #666; font-size: 14px;">NIS: <?= $anak->nis ?> &nbsp;|&nbsp; Kelas: <strong><?= $anak->kelas ?></strong></p>
                <p style="color: #666; font-size: 14px;"><?= $anak->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' ?> &nbsp;|&nbsp; TTL: <?= $anak->tempat_lahir ?>, <?= date('d M Y', strtotime($anak->tanggal_lahir)) ?></p>
                <span style="display: inline-block; margin-top: 8px; background: <?= $anak->status=='Aktif' ? '#e8f5e9' : '#ffebee' ?>; color: <?= $anak->status=='Aktif' ? '#2E7D32' : '#c62828' ?>; padding: 4px 15px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                    <?= $anak->status ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Ringkasan Perkembangan Terbaru -->
    <div class="box" style="margin-top: 20px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body">
            <h4 style="margin-bottom: 15px; color: #2E7D32;"><i class="fa fa-chart-line"></i> Perkembangan Terbaru</h4>
            
            <?php
                $recent_pkb = mysqli_query($conn, "SELECT p.*, g.nama_lengkap as nama_guru FROM perkembangan p LEFT JOIN guru g ON p.guru_id = g.id WHERE p.siswa_id = '".$anak->id."' ORDER BY p.tanggal DESC, p.id DESC LIMIT 6");
                
                if(mysqli_num_rows($recent_pkb) > 0){
                    $warna = ['BB' => '#f44336', 'MB' => '#ff9800', 'BSH' => '#2196F3', 'BSB' => '#4CAF50'];
                    $label = ['BB' => 'Belum Berkembang', 'MB' => 'Mulai Berkembang', 'BSH' => 'Berkembang Sesuai Harapan', 'BSB' => 'Berkembang Sangat Baik'];
                    $emoji = ['BB' => '🔴', 'MB' => '🟠', 'BSH' => '🔵', 'BSB' => '🟢'];
            ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px;">
                <?php while($r = mysqli_fetch_array($recent_pkb)){ ?>
                <div style="background: #f9f9f9; border-radius: 12px; padding: 15px; border-left: 4px solid <?= $warna[$r['capaian']] ?>;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                        <span style="font-weight: 600; font-size: 13px; color: #333;"><?= $r['kategori'] ?></span>
                        <span style="background: <?= $warna[$r['capaian']] ?>; color: white; padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                            <?= $r['capaian'] ?>
                        </span>
                    </div>
                    <p style="font-size: 13px; color: #555; margin-bottom: 5px;"><?= $r['aspek'] ?></p>
                    <?php if($r['catatan']): ?>
                        <p style="font-size: 12px; color: #888; font-style: italic;">💬 <?= $r['catatan'] ?></p>
                    <?php endif; ?>
                    <p style="font-size: 11px; color: #aaa; margin-top: 8px;"><?= date('d M Y', strtotime($r['tanggal'])) ?></p>
                </div>
                <?php } ?>
            </div>

            <div style="margin-top: 15px; text-align: center;">
                <a href="perkembangan.php" style="color: #2E7D32; text-decoration: none; font-weight: 600; font-size: 14px;">Lihat Semua Perkembangan →</a>
            </div>

            <?php } else { ?>
                <div style="text-align: center; padding: 30px; color: #999;">
                    <div style="font-size: 48px; margin-bottom: 10px;">📋</div>
                    <p>Belum ada laporan perkembangan.</p>
                    <p style="font-size: 13px;">Guru akan mengisi laporan perkembangan secara berkala.</p>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Info Capaian Legend -->
    <div class="box" style="margin-top: 20px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body">
            <h4 style="margin-bottom: 15px; color: #333;"><i class="fa fa-info-circle"></i> Keterangan Level Capaian</h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 10px;">
                <div style="display: flex; align-items: center; gap: 10px; padding: 10px; background: #ffebee; border-radius: 10px;">
                    <span style="background: #f44336; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">BB</span>
                    <span style="font-size: 13px; color: #555;">Belum Berkembang</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; padding: 10px; background: #fff3e0; border-radius: 10px;">
                    <span style="background: #ff9800; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">MB</span>
                    <span style="font-size: 13px; color: #555;">Mulai Berkembang</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; padding: 10px; background: #e3f2fd; border-radius: 10px;">
                    <span style="background: #2196F3; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">BSH</span>
                    <span style="font-size: 13px; color: #555;">Berkembang Sesuai Harapan</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; padding: 10px; background: #e8f5e9; border-radius: 10px;">
                    <span style="background: #4CAF50; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">BSB</span>
                    <span style="font-size: 13px; color: #555;">Berkembang Sangat Baik</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php" ?>
