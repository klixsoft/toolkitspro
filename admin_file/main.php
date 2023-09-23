<?php

if( ! defined("ASTROOTPATH") ){
    echo "Not Allowed to access this page.";
    die();
}
?>
<div class="content-wrapper admin_dashboard_main_wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="col-12">
                        <h1 class="m-0"><?php echo @$active['title']; ?></h1>
                    </div>
                    <div class="col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-white" href="<?php echo get_admin_url("/", false); ?>">Home</a></li>
                            <li class="breadcrumb-item active text-white"><?php echo @$active['title']; ?></li>
                        </ol>
                    </div>
                </div>

                <?php if( isset( $active['button'] ) ): ?>
                <div class="col-sm-6" style="text-align:end;">
                    <button class="<?php echo $active['button']['class']; ?>" data-type="<?php echo $active['button']['data-type']; ?>" type="button">
                        <?php echo $active['button']['text']; ?>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <?php
                    if( file_exists( $requirepath ) ){
                        require_once $requirepath;
                    }else{
                        $requirepath = str_replace(array(get_admin_path(), "index.php", ".php"), "", $requirepath);
                        $requirepath = str_replace("/", "_", $requirepath);
                        $requirepath = trim($requirepath, "_");
                        do_action( "admin_template_$requirepath" );
                    }
                ?>
            </div>
        </div>
    </div>
</div>