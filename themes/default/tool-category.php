<?php if( $enableBeadcrum ): ?>
<div class="beadcrum textture_background py-5">
    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <h1><?php echo $categorydata->title; ?></h1>
                <p style="max-width:550px;margin:0 auto;"><?php echo $categorydata->description; ?></p>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo get_site_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo get_site_url(); ?>">Page</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $categorydata->title; ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
/**
 * Before tool content hook
 */
do_action("ast/tool/category/before/content", $categorydata);
?>

<div class="category_section tools_section my-5">
    <div class="container">
        <div class="row">
            <div class="category mb-3">
                <div class="card-body pb-0">
                    <div class="tools">
                        <?php
                            $tools = get_tools_by_category($categorydata->id, -1, "title", "asc");
                            if( !empty( $tools ) ){
                                foreach($tools as $k => $tool){
                                    // update_post(array(
                                    //     "status" => "active"
                                    // ), array(
                                    //     "id" => $tool->id
                                    // ));
                                    echo get_tool_card_html($tool);
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/**
 * Before tool content hook
 */
do_action("ast/tool/category/after/content", $categorydata);
?>