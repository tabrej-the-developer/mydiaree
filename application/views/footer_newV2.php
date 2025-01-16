

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/Chart.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/chartjs-plugin-datalabels.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/moment.min.js"></?version=1script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/fullcalendar.min.js?version=1"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/datatables.min.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/progressbar.min.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/jquery.barrating.min.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/select2.full.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/nouislider.min.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/bootstrap-datepicker.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/Sortable.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/mousetrap.min.js"></script>
    <script src="<?= base_url('assets/js/v2/vendor') ?>/glide.min.js"></script>
    <script src="<?= base_url('assets/js/v2/') ?>dore.script.js"></script>
    <script src="<?= base_url('assets/js/v2/') ?>scripts.js?v=c298c7f8233d"></script>

    <script>
        $(document).ready(function(){
            $('.show-drp-s').click(function(){
                $('.show-drp-f,.show-drp-t').toggleClass('show');
            });
            $('.header-icon-notifications').click(function(){
                $('.notification-on').toggleClass('show');
            });
            $('.theme-colors').hide();
        });
    </script>
    <script>
    $(document).ready(function(){
        $('.list-unstyled li').click(function(){
            $('.dashboard-active').removeClass('active');
            $(this).toggleClass('active');
        });
        
    });
</script>
</html>