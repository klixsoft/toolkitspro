<div class="row mx-0 mt-3">
    <div class="col-12 px-0">
        <div class="alert alert-danger">Oops! You haven't enabled GZIP compression on your server to achieve maximum compression on your website.</div>
    </div>

    <div class="col-md-8">
        <div class="row">
            <div class="col-12 p-4 border">
                <div class="result_icon me-2 float-start">
                    <i class="las la-link"></i>
                </div>
                <div>
                    <div class="fw-bold">Domain Name</div>
                    <div class="checkurl"><?php echo @$result->domain; ?></div>
                </div>
            </div>

            <div class="col p-4 border">
                <div class="result_icon me-2 float-start">
                    <i class="las la-hourglass-start"></i>
                </div>
                <div>
                    <div class="fw-bold">Could be compressed upto</div>
                    <div class="createddate"><?php echo @$result->gz_data_size; ?></div>
                </div>
            </div>

            <div class="col p-4 border">
                <div class="result_icon me-2 float-start">
                    <i class="las la-hourglass"></i>
                </div>
                <div>
                    <div class="fw-bold">Uncompressed size</div>
                    <div class="updatedate"><?php echo @$result->uncompressed_size; ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <?php
            echo get_svg_circle(@$result->percentage, 120, 4, "error", true);
        ?>
        <p class="mt-2"><em>cloud be saved by compressing this webpage with GZIP.</em></p>
    </div>
</div>