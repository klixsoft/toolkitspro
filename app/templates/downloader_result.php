<em class="text-center my-3 d-block">*** To download, right-click on the download button (or tap and hold if using mobile) and choose the Save/Download option. ***</em>

<div class="card rounded-0">
    <div class="card-header">
        <strong>Title:</strong> <?php echo @$this->title; ?>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="sticky_content left_sticky_content">
                    <img class="img-fluid rounded" src="<?php echo @$this->image; ?>" alt="Featured Image">

                    <div class="button_rows text-center mt-3">
                        <a href="<?php echo @$this->link; ?>" target="_blank" class="originalbtn btn btn-danger">View Original Link</a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="sticky_content" style="border: 1px solid #dee2e6;">
                    <?php
                        foreach($this->output as $key => $out){
                            $mediaData = $out->data;
                            include APP_PATH . "templates/downloader/".$out->key.".php";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>