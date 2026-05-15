<?php include 'header.php'; ?>

<div class="banner" style="background-image: url('uploads/identitas/<?= $d->foto_sekolah ?>');">
    <div class="container banner-text">
        <h3>Selamat Datang di Website <?= $d->nama ?></h3>
        <p>Selamat Datang di TK Al-Muhajirin, daftarkan anakmu untuk dasar pemahaman yang mantap.Membentuk generasi cerdas, berakhlak mulia, dan bertaqwa sejak dini bersama pendidik yang penuh kasih.</p>
    </div>
</div>

<div class="section">
    <div class="container text-center">
        <h3>Sambutan Kepsek</h3>
        <br>
        <img src="uploads/identitas/<?= $d->foto_kepsek ?>" width="150px" class="foto-kepsek">
        <h4><?= $d->nama_kepsek ?></h4>
        <p style="max-width: 800px; margin: 10px auto; color: #666;"><?= $d->sambutan_kepsek ?></p>
    </div>
</div>

<div class="section" id="kelas" style="background-color: #f9f9f9;">
    <div class="container text-center">
        <h3>Pengurus Sekolah</h3>
        <?php
            $guru = mysqli_query($conn, "SELECT * FROM guru ORDER BY id DESC");
            $guru_data = [];
            while($j = mysqli_fetch_array($guru)){ $guru_data[] = $j; }
            if(count($guru_data) > 0){
        ?>
        <div class="carousel-wrapper">
            <button class="carousel-btn carousel-prev" onclick="moveSlide('guru', -1)">&#10094;</button>
            <div class="carousel-track-container">
                <div class="carousel-track" id="guruTrack">
                    <?php foreach($guru_data as $j){ ?>
                    <div class="carousel-slide">
                        <div class="thumbnail-box">
                            <div class="thumbnail-img" style="background-image: url('uploads/guru/<?= $j['gambar'] ?>');"></div>
                            <div class="thumbnail-text">
                                <?= $j['nama_lengkap'] ?>
                                <br><small style="color: #888;"><?= $j['jabatan'] ?></small>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <button class="carousel-btn carousel-next" onclick="moveSlide('guru', 1)">&#10095;</button>
        </div>
        <div class="carousel-dots" id="guruDots"></div>
        <?php } else { echo "<p style='color:#999;'>Tidak ada Data</p>"; } ?>
    </div>
</div>

<div class="section">
    <div class="container text-center">
        <h3>Program Kegiatan</h3>
        <?php
            $kegiatan = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY id DESC LIMIT 12");
            $kegiatan_data = [];
            while($p = mysqli_fetch_array($kegiatan)){ $kegiatan_data[] = $p; }
            if(count($kegiatan_data) > 0){
        ?>
        <div class="carousel-wrapper">
            <button class="carousel-btn carousel-prev" onclick="moveSlide('kegiatan', -1)">&#10094;</button>
            <div class="carousel-track-container">
                <div class="carousel-track" id="kegiatanTrack">
                    <?php foreach($kegiatan_data as $p){ ?>
                    <div class="carousel-slide">
                        <a href="detail-kegiatan.php?id=<?= $p['id'] ?>" class="thumbnail-link">
                            <div class="thumbnail-box">
                                <div class="thumbnail-img" style="background-image: url('uploads/kegiatan/<?= $p['gambar'] ?>');"></div>
                                <div class="thumbnail-text"><?= substr($p['judul'], 0, 50) ?></div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <button class="carousel-btn carousel-next" onclick="moveSlide('kegiatan', 1)">&#10095;</button>
        </div>
        <div class="carousel-dots" id="kegiatanDots"></div>
        <?php } else { echo "<p style='color:#999;'>Tidak ada data kegiatan.</p>"; } ?>
    </div>
</div>

<!-- Carousel CSS -->
<style>
    .carousel-wrapper {
        position: relative;
        overflow: hidden;
        margin: 20px 0 10px;
        padding: 0 50px;
    }
    .carousel-track-container {
        overflow: hidden;
        border-radius: 15px;
    }
    .carousel-track {
        display: flex;
        transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        gap: 20px;
    }
    .carousel-slide {
        min-width: calc(33.333% - 14px);
        flex-shrink: 0;
    }
    .carousel-slide .thumbnail-box {
        margin-top: 0;
        height: 100%;
    }
    .carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: none;
        background: #2E7D32;
        color: white;
        font-size: 18px;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(46,125,50,0.3);
    }
    .carousel-btn:hover {
        background: #1B5E20;
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 6px 18px rgba(46,125,50,0.4);
    }
    .carousel-prev { left: 0; }
    .carousel-next { right: 0; }
    .carousel-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 15px;
        padding-bottom: 5px;
    }
    .carousel-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ccc;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        padding: 0;
    }
    .carousel-dot.active {
        background: #2E7D32;
        transform: scale(1.3);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .carousel-slide {
            min-width: calc(50% - 10px);
        }
    }
    @media (max-width: 600px) {
        .carousel-slide {
            min-width: 100%;
        }
        .carousel-wrapper {
            padding: 0 40px;
        }
        .carousel-btn {
            width: 34px;
            height: 34px;
            font-size: 14px;
        }
    }
</style>

<!-- Carousel JS -->
<script>
    const carousels = {};

    function initCarousel(name, trackId, dotsId) {
        const track = document.getElementById(trackId);
        if (!track) return;
        const slides = track.querySelectorAll('.carousel-slide');
        const dotsContainer = document.getElementById(dotsId);
        
        function getPerView() {
            if (window.innerWidth <= 600) return 1;
            if (window.innerWidth <= 991) return 2;
            return 3;
        }

        const perView = getPerView();
        const totalPages = Math.max(1, Math.ceil(slides.length / perView));

        carousels[name] = { track, slides, current: 0, perView, totalPages, autoTimer: null };

        // Build dots
        dotsContainer.innerHTML = '';
        for (let i = 0; i < totalPages; i++) {
            const dot = document.createElement('button');
            dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
            dot.onclick = () => goToPage(name, i);
            dotsContainer.appendChild(dot);
        }

        // Auto slide every 4 seconds
        startAuto(name);

        // Pause on hover
        track.parentElement.parentElement.addEventListener('mouseenter', () => stopAuto(name));
        track.parentElement.parentElement.addEventListener('mouseleave', () => startAuto(name));
    }

    function goToPage(name, page) {
        const c = carousels[name];
        if (!c) return;
        c.current = page;
        if (c.current >= c.totalPages) c.current = 0;
        if (c.current < 0) c.current = c.totalPages - 1;

        const slideWidth = c.slides[0].offsetWidth + 20; // 20 = gap
        const offset = c.current * c.perView * slideWidth;
        // Don't scroll beyond last slide
        const maxOffset = (c.slides.length - c.perView) * slideWidth;
        c.track.style.transform = `translateX(-${Math.min(offset, Math.max(0, maxOffset))}px)`;

        // Update dots
        const dots = c.track.parentElement.parentElement.parentElement.querySelector('.carousel-dots');
        dots.querySelectorAll('.carousel-dot').forEach((d, i) => {
            d.classList.toggle('active', i === c.current);
        });
    }

    function moveSlide(name, dir) {
        const c = carousels[name];
        if (!c) return;
        goToPage(name, c.current + dir);
    }

    function startAuto(name) {
        const c = carousels[name];
        if (!c) return;
        stopAuto(name);
        c.autoTimer = setInterval(() => moveSlide(name, 1), 4000);
    }

    function stopAuto(name) {
        const c = carousels[name];
        if (!c || !c.autoTimer) return;
        clearInterval(c.autoTimer);
        c.autoTimer = null;
    }

    // Initialize carousels
    document.addEventListener('DOMContentLoaded', () => {
        initCarousel('guru', 'guruTrack', 'guruDots');
        initCarousel('kegiatan', 'kegiatanTrack', 'kegiatanDots');
    });

    // Recalculate on resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            initCarousel('guru', 'guruTrack', 'guruDots');
            initCarousel('kegiatan', 'kegiatanTrack', 'kegiatanDots');
        }, 250);
    });
</script>

<?php include 'footer.php'; ?>