<div class="beadcrum textture_background py-3">
    <div class="container pt-3 pb-2">
        <div class="row">
            <div class="col-12">
                <h1><?php echo $tooldata->title; ?></h1>

                <nav aria-label="breadcrumb mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo get_site_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo get_category_url_by_tool($tooldata->id); ?>">Tools</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $tooldata->title; ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>