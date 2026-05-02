<footer>
    <div class="container text-center">
        <div class="footer-info">
            <h3 style="margin-bottom: 10px;"><?= $d->nama ?></h3>
            <p style="opacity: 0.8; font-size: 14px; margin-bottom: 20px;">Mendidik dengan Hati, Membentuk Karakter Islami yang Mandiri.</p>
        </div>
        <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px;">
        <div class="copyright">
            Copyright &copy; 2026 - <?= $d->nama ?>. All Rights Reserved.
        </div>
    </div>
</footer>

<script type="text/javascript">
    var mobileMenu = document.getElementById("mobileMenu"); // Pastikan 'm' kecil agar sinkron
    function showMobileMenu(){
        mobileMenu.style.display = "block";
    }
    function hideMobileMenu(){
        mobileMenu.style.display = "none";
    }
</script>
</body>
</html>