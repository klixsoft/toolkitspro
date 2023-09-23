    <script src="<?php echo get_admin_url_path("assets/js/jquery.min.js"); ?>"></script>
    <script src="<?php echo get_admin_url_path("assets/modules/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
    <script src="<?php echo get_admin_url_path("assets/js/adminlte.min.js"); ?>"></script>
    <script src="<?php echo get_admin_url_path("assets/modules/alert/toast.min.js"); ?>"></script>

    <script>
    const allsmarttools = {
        adminurl: "<?php echo get_admin_url(); ?>",
        siteurl: "<?php echo get_site_url(); ?>",
        ajaxurl: "<?php echo get_site_url("ajax.php"); ?>"
    };
    </script>

    <?php $version = filemtime(get_admin_path("assets/js/auth.js", true)); ?>
    <script src="<?php echo get_admin_url_path("assets/js/auth.js?ver=$version"); ?>"></script>

    <?php do_action("ast_auth_footer"); ?>
</body>

</html>