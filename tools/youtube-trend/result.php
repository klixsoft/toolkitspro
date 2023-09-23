<div class="row">
    <?php foreach($output as $video): ?>
    <div class="col-md-6 mb-4">
        <div class="card">
            <iframe style="min-height:220px;border-top-right-radius: 6px;border-top-left-radius: 6px;" src="https://www.youtube.com/embed/<?php echo @$video->id; ?>" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
            <div class="card-body">
                <h5 class="card-title"><?php echo @$video->title; ?></h5>
                <p class="card-text line-4"><?php echo @$video->description; ?></p>
                <a rel="nofollow noindex" target="_blank" href="<?php echo @$video->link; ?>" class="btn btn-youtube btn-icon d-block"><span class="lab la-youtube"></span> View on Youtube</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>