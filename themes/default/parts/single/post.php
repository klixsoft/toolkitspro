<div class="col-md-4">
    <div class="post-box card-box">
        <a href="<?php echo get_post_url("slug", $blog->slug); ?>">
            <img src="<?php echo $featuredImage; ?>" alt="<?php echo $blog->title; ?>" class="img">
        </a>
        <div class="bp-content">
            <a href="<?php echo get_post_url("slug", $blog->slug); ?>" class="title"><?php echo $blog->title; ?></a>
            <p>
                <span class="post_date"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date("d M, Y", strtotime($blog->date)); ?></span>
                <span class="float-end">
                    <a href="<?php echo get_post_url("slug", $blog->slug); ?>" class="readmoreBtn"> Read More</a>
                </span>
            </p>
        </div>
    </div>
</div>