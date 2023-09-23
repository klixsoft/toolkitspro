<div class="beadcrum textture_background py-3">
    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <h1><?php echo $postdata->title; ?></h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo get_site_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo get_site_url("blog/"); ?>">Blog</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $postdata->title; ?></li>
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
                    do_action("ast/before/post/descrition", $postdata->id, "page");
                    $featuredImage = get_meta("post", $postdata->id, "featured_image");
                ?>

                <div class="card-box p-4">
                    <h2><?php echo $postdata->title; ?></h2>
                    <div class="post_meta d-flex align-items-center justify-content-between">
                        <div><i class="la la-clock"></i> <?php echo date("D M, Y", strtotime($postdata->date)); ?></div>
                        <button class="btn btn-primary shareBtn" data-title="<?php echo $postdata->title; ?>" data-image="<?php echo $featuredImage; ?>" data-url="<?php echo get_post_url("slug", $postdata->slug); ?>"><i class="las la-share"></i> Share</button>
                    </div>

                    <?php
                        if( ! empty( $featuredImage ) ){
                            echo sprintf('<figure class="thumb">
                                <img src="%s" alt="%s" width="100%%">
                            </figure>', $featuredImage, $postdata->title);
                        }
                    ?>
                    
                    <div class="tool_content">
                        <?php echo $postdata->description; ?>
                    </div>
                </div>

                <?php
                    /**
                     * After description for other section
                     * 
                     * @since 1.0
                     */
                    do_action("ast/after/post/descrition", $postdata, "page");
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
                        do_action("ast/post/sidebar", $postdata->id, "post");
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>