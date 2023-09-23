<style>
.social_single_card *{
    color:#fff !important;
}

.social_single_card{
    min-width:33.33%;
}

.youtube_card{
    background:#ff0000;
}

.facebook_card{
    background:#1877f2;
}

.twitter_card{
    background:#1da1f2;
}

.instagram_card{
    background:#c32aa3;
}

.pinterest_card{
    background:#bd081c;
}

.tiktok_card{
    background:#010101;
}

.whatsapp_card{
    background:#25d366;
}
</style>

<div class="row mx-0 mt-3">
    <div class="col-12 p-4 border">
        <div class="result_icon me-2 float-start">
            <i class="las la-link"></i>
        </div>
        <div>
            <div class="fw-bold">Domain Name</div>
            <div class="checkurl"><?php echo extractHostname($_POST['link']); ?></div>
        </div>
    </div>
    <?php foreach($result as $k => $value): ?>
    <div class="col p-4 social_single_card <?php echo $k; ?>_card">
        <div class="result_icon me-2 float-start">
            <i class="lab la-<?php echo $k; ?>"></i>
        </div>
        <div>
            <div class="fw-bold"><?php echo strtoupper($k); ?></div>
            <div class="checkurl"><a target="_blank" href="<?php echo @$value->link; ?>" target="_blank" rel="nofollow noindex"><?php echo @$value->user; ?></a></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>