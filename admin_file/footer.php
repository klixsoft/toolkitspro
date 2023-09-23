<!-- Main Footer -->
<footer class="main-footer text-center">Copyright &copy; <?php echo date("Y"); ?> <a target="_blank" href="https://product.toolkitspro.com">ToolKitsPRO.com</a>. All rights reserved.</footer>
</div>
<!-- ./wrapper -->

<script src="<?php echo get_admin_url_path("assets/js/jquery.min.js"); ?>"></script>
<script src="<?php echo get_admin_url_path("assets/modules/colorpicker/jquery.minicolors.min.js"); ?>"></script>
<script src="<?php echo get_admin_url_path("assets/modules/fancybox/jquery.fancybox-1.3.4.js?v=1.3.4"); ?>"></script>
<script src="<?php echo get_admin_url_path("assets/modules/datatable/datatables.min.js?v=1.13.1"); ?>"></script>
<script src="<?php echo get_admin_url_path("assets/modules/datatable/datatable-bootstrap/js/dataTables.bootstrap4.min.js?v=1.13.1"); ?>"></script>
<script src="<?php echo get_admin_url_path("assets/modules/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
<script src="<?php echo get_admin_url_path("assets/modules/alert/toast.min.js"); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?php echo get_admin_url_path("assets/modules/tinymce/tinymce.min.js?v=6"); ?>"></script>
<script src="<?php echo get_admin_url_path("assets/js/adminlte.min.js"); ?>"></script>
<script src="<?php echo get_admin_url_path("assets/modules/iziToast/dist/js/iziToast.min.js"); ?>"></script>
<script src="<?php echo get_admin_url_path("assets/modules/alertifyjs/alertify.min.js"); ?>"></script>
<script src="<?php echo get_admin_url_path("assets/modules/tagify/dist/tagin.min.js"); ?>"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script src="<?php echo get_admin_url_path("assets/js/jquery.mjs.nestedSortable.js"); ?>"></script>

<script>const allsmarttools = {
  adminurl : "<?php echo get_admin_url_path(); ?>",
  siteurl : "<?php echo get_site_url(); ?>",
  ajaxurl : "<?php echo get_site_url("ajax.php"); ?>"
};</script>

<?php $version = filemtime(get_admin_path("assets/js/admin.js", true)); ?>
<script src="<?php echo get_admin_url_path("assets/js/admin.js?ver=$version"); ?>"></script>

<?php
    /**
     * Include any code to admin footer
     */
    do_action("admin_footer");
?>
</body>
</html>