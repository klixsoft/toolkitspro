<div class="beadcrum textture_background py-4">
    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <h1>Blog</h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo get_site_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4 mb-4 pb-2 contact_form">
    <div class="row">
        <?php
            global $db;
            $db->where("type", "post");
            $blogs = $db->objectBuilder()->paginate("posts", $paged);
            foreach($blogs as $blog){
                $featuredImage = get_meta("post", $blog->id, "featured_image");
                include get_theme_path() . "parts/single/post.php";
            }
        ?>
    </div>
</div>