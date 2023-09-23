<style>

</style>

<div class="check-gzip-compression_content">
    <form action="<?php echo get_full_url(); ?>" method="post" class="check-gzip-compression_submit_form">
        <div class="form-group">
            <label>Enter Domain</label>
            <div class="check-gzip-compression_input_container">
                <input class="form-control" name="url" type="url" placeholder="Enter url..." required />
            </div>
        </div>

        <?php
            /**
             * Render Captcha Settings
             */
            do_action("ast/captcha/render", $tool, $report); 
        ?>

        <div class="button-group text-center my-4">
            <input type="text" value="check-gzip-compression" name="tool" class="d-none">
            <input type="text" value="process_check-gzip-compression_checker" name="action" class="d-none">
            <button type="submit" id="check-gzip-compression_btn" class="btn btn-primary text-white">Submit</button>
        </div>

        <div class="form-group">
            <label>Result</label>

            <div class="check-gzip-compression_report_container">
                <div class="check-gzip-compression_report">
                    
                </div>
            </div>
        </div>
    </form>
</div>