</div>
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; UKSS App <?= date('Y') ?></span>
        </div>
    </div>
</footer>
</div>
</div>
<a class="scroll-to-top rounded" href="#page-top" style="opacity: 0; transition: opacity 0.3s;">
    <i class="fas fa-angle-up"></i>
</a>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/js/sb-admin-2.min.js"></script>

<script>
    $(document).ready(function() {

        // 1. Mobile Responsiveness Logic
        if ($(window).width() < 768) {
            $('#accordionSidebar').addClass('toggled');
        }

        // 2. Alert Auto Close (Smooth Fade Out)
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);

        // 3. Smooth Scroll to Top Logic (Perbaikan UI)
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('.scroll-to-top').css('opacity', '1').fadeIn();
            } else {
                $('.scroll-to-top').fadeOut();
            }
        });

        // 4. Smooth Anchor Scrolling (Untuk semua link yang pakai #)
        $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: (target.offset().top - 70) // -70 biar gak ketutupan navbar
                    }, 1000, "easeInOutExpo");
                    return false;
                }
            }
        });
    });
</script>

</body>

</html>

</body>

</html>