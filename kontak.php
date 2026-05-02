<?php include 'header.php'; ?>
<div class="section">
    <div class="container">
        <h3 class="text-center">Kontak</h3>
        <div class="col-4">
            <p style="margin-bottom: 10px"><b>Alamat</b> : <br> <?= $d->alamat ?> </p>
            <p style="margin-bottom: 10px"><b>Telepon</b> : <br> <strong><?= $d->telepon ?></strong></p>
            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $d->telepon) ?>?text=Halo%20Admin%20<?= $d->nama ?>,%20saya%20ingin%20bertanya" class="btn-kontak" target="_blank" style="display: inline-block; background: #25D366; color: white; padding: 12px 24px; border-radius: 25px; text-decoration: none; font-weight: bold; margin-bottom: 10px; box-shadow: 0 4px 12px rgba(37,211,102,0.3); transition: 0.3s;">📱 Kirim Pesan WhatsApp</a>
            <p style="margin-bottom: 10px"><b>Email</b> : <br> <?= $d->email ?> </p>
        </div>
        <div class="box-gmaps">
            <iframe src="<?= $d->google_maps ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        
        <!-- Form Tambah Pesan - Di bawah Google Maps -->
        <div class="col-12" style="margin-top: 40px;">
            <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border: 1px solid #dee2e6;">
                <h3 class="text-center mb-4" style="color: #2E7D32; font-weight: 700; font-size: 28px;">📝 Hubungi Kami Langsung</h3>
                <p class="text-center mb-5" style="color: #6c757d; font-size: 16px;">Isi form di bawah ini untuk mengirim pesan. Admin akan merespon dalam 24 jam via WhatsApp atau Email.</p>
                
                <?php
                include 'koneksi.php';
                $success = $error = '';
                if(isset($_POST['submit_pesan'])){
                    $nama = addslashes(ucwords($_POST['nama']));
                    $wa = addslashes(preg_replace('/[^0-9]/', '', $_POST['wa']));
                    $email = addslashes($_POST['email']);
                    $subject = addslashes($_POST['subject']);
                    $pesan = addslashes($_POST['pesan']);
                    
                    $simpan = mysqli_query($conn, "INSERT INTO pesan (nama_pengirim, nomor_wa, email, pesan) VALUES (
                        '$nama', '$wa', '$email', '$pesan'
                    )");
                    
                    if($simpan){
                        $success = '✅ Pesan berhasil dikirim! Silakan tunggu balasan dari admin.';
                    } else {
                        $error = '❌ Gagal mengirim: ' . mysqli_error($conn);
                    }
                }
                ?>
                
                <?php if($success): ?>
                    <div class="alert shadow-sm border-0" role="alert" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; border-radius: 15px; padding: 20px; margin-bottom: 20px; font-weight: 500;">
                        <i class="fa fa-check-circle me-2"></i><?= $success ?>
                    </div>
                <?php endif; ?>
                
                <?php if($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 15px; border: none; padding: 20px; margin-bottom: 20px;">
                        <i class="fa fa-exclamation-triangle me-2"></i><?= $error ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="row g-0">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control form-control-lg" placeholder="Masukkan nama lengkap" required style="border-radius: 12px 0 0 12px; padding: 18px; border: 2px solid #e9ecef; font-size: 16px; height: 60px;">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input type="tel" name="wa" class="form-control form-control-lg" placeholder="+628123..." required style="border-radius: 0 12px 12px 0; padding: 18px; border: 2px solid #e9ecef; font-size: 16px; height: 60px;">
                        </div>
                    </div>
                    <div class="row g-0 mt-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="contoh@email.com" required style="border-radius: 12px 0 0 12px; padding: 18px; border: 2px solid #e9ecef; font-size: 16px; height: 60px;">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">Subjek (Opsional)</label>
                            <input type="text" name="subject" class="form-control form-control-lg" placeholder="Pendaftaran / Informasi / Lainnya" style="border-radius: 0 12px 12px 0; padding: 18px; border: 2px solid #e9ecef; font-size: 16px; height: 60px;">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="form-label fw-bold">Pesan <span class="text-danger">*</span></label>
                        <textarea name="pesan" class="form-control form-control-lg" rows="6" placeholder="Ceritakan apa yang ingin Anda sampaikan secara detail..." required style="border-radius: 12px; padding: 20px; border: 2px solid #e9ecef; font-size: 16px; font-family: inherit; resize: vertical; height: 160px;"></textarea>
                    </div>
                    <button type="submit" name="submit_pesan" class="btn btn-success btn-lg w-100 mt-4 py-4" style="border-radius: 15px; font-size: 20px; font-weight: 700; height: 70px; box-shadow: 0 8px 25px rgba(46,125,50,0.3); border: none; transition: all 0.3s;">
                        📤 Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

