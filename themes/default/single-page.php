<?php
extract($params);
global $query;
?>

<div class="beadcrum textture_background py-5">
    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <h1><?php echo $tooldata->title; ?></h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo get_site_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo get_site_url(); ?>">Page</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $tooldata->title; ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="main_tool_content mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php
                    /**
                     * Before description for other section
                     * 
                     * @since 1.0
                     */
                    do_action("ast/before/page/descrition", $tooldata->id, "page");
                ?>

                <div class="card-box p-4">
                    <h2><?php echo $tooldata->title; ?></h2>
                    <div class="post_meta d-flex align-items-center justify-content-between">
                        <div><i class="la la-clock"></i> <?php echo date("D M, Y", strtotime($tooldata->date)); ?></div>
                        <button class="btn btn-primary shareBtn" data-title="<?php echo $tooldata->title; ?>" data-url="<?php echo get_page_url("slug", $tooldata->slug); ?>"><i class="las la-share"></i> Share</button>
                    </div>

                    <div class="tool_content">
                        <?php echo $tooldata->description; ?>
                    </div>
                </div>

                <?php
                    /**
                     * After description for other section
                     * 
                     * @since 1.0
                     */
                    do_action("ast/after/page/descrition", $tooldata->id, "page");
                ?>
            </div>

            <div class="col-md-3">
                <div class="sidebar_content">
                    <?php
                        /**
                         * After description for other section
                         * 
                         * @since 1.0
                         */
                        do_action("ast/post/sidebar", $tooldata->id, "page");
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>