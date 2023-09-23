<div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Share this link via</p>
                <div class="d-flex align-items-center icons">
                    <a href="#" aria-label="Share to Facebook" class="fs-5 d-flex align-items-center justify-content-center facebook"> 
                        <span class="lab la-facebook-f"></span> 
                    </a>
                    <a href="#" aria-label="Share to Facebook Messanger" class="fs-5 d-flex align-items-center justify-content-center messenger">
                        <span class="lab la-facebook-messenger"></span> 
                    </a>
                    <a href="#" aria-label="Share to Facebook Twitter" target="_blank" class="fs-5 d-flex align-items-center justify-content-center twitter">
                        <span class="lab la-twitter"></span> 
                    </a>
                    <a href="#" aria-label="Share to Pinterest" target="_blank" class="fs-5 d-flex align-items-center justify-content-center pinterest">
                        <span class="lab la-pinterest"></span> 
                    </a>
                    <a href="#" aria-label="Share to Whatsapp" target="_blank" class="fs-5 d-flex align-items-center justify-content-center whatsapp">
                        <span class="lab la-whatsapp"></span> 
                    </a>
                    <a href="#" aria-label="Share via Email" target="_blank" class="fs-5 d-flex align-items-center justify-content-center email">
                        <span class="la la-envelope"></span> 
                    </a>
                </div>
                <p>Or copy link</p>
                <div class="field d-flex align-items-center justify-content-between"> 
                    <span class="las la-link text-center"></span> 
                    <input aria-labelledby="shareInputBtn" id="copyURL" type="text" value="some.com/share">
                    <button type="button" id="shareInputBtn" class="copyURLBtn">Copy</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="alertModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alert</h5> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<?php
$settings = get_settings("basic");
?>

<footer class="footer pt-3 mt-3 pb-0 d-print-none">
    <div class="social_container">
        <h5 class="text-center mb-4">Follow us</h5>
        <div class="social-share text-center">
            <div class="share-icons relative">
                <?php
                    foreach(array("facebook", "twitter", "instagram", "pinterest", "github", "youtube") as $social){
                        if( filter_var( @$settings->$social, FILTER_VALIDATE_URL ) ){
                            echo sprintf('<a href="%s" class="btn btn-%s btn-icon me-2" target="_blank">
                                <span class="lab la-%s"></span> %s
                            </a>', $settings->$social, $social, $social, ucfirst($social));
                        }
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="container pt-5">
        <div class="row">

            <?php
                $footersettings = (array) get_settings("footercolumns");
                $defaultSettings = array(
                    "title" => "",
                    "type" => "text",
                    "text" => ""
                );
                $columnHelper = new \AST\Helper\ColumnHelper();
                foreach(array("one", "two", "three", "four", "five") as $col){
                    $colsettings = isset($footersettings[$col]) && is_array($footersettings[$col]) && !empty( $footersettings[$col] ) ? $footersettings[$col] : array();
                    $colsettings = array_merge($defaultSettings, $colsettings);

                    $part = $col == 'one' || $col == 'five' ? '3' : '2';
                    $extraclass = $col == 'one' ? '' : 'col-6';
                    echo sprintf('<div class="col-md-%s %s mb-3">', $part, $extraclass);
                    $columnHelper->front($colsettings['type'], $col, $colsettings);
                    echo '</div>';
                }
            ?>
        </div>
    </div>

    <div class="footer-copyright">
        <div class="text-center">
            <p class="py-3 m-0"><?php echo @$settings->copyright; ?></p>
        </div>
    </div>
</footer>


<script>
<?php
    $footerConfig = array(
        "adminurl" => get_admin_url(),
        "siteurl" => get_site_url(),
        "ajaxurl" => get_site_url("ajax.php"),
        "scripts" => array(
            "css" => array(
                "https://fonts.googleapis.com/css?family=Roboto",
                "https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css",
                get_site_url("admin_file/assets/modules/alert/toastStyle.min.css")
            ),
            "js" => array(
                "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js",
                get_site_url("admin_file/assets/modules/alert/toast.min.js")
            )
        )
    );
    $footerConfig = apply_filters("ast/front/footer/config", $footerConfig);
?>
const allsmarttools = <?php echo json_encode($footerConfig); ?>;
</script>

<!-- FOOTER INCLUDE CODE -->
<?php
    /**
    * Include any code to front header
    */
    do_action("ast_front_footer");
?>
<!-- FOOTER INCLUDE CODE END -->

</body>

</html>