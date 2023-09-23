<style>

</style>

<div class="{{TOOL_SLUG}}_content">
    <form action="<?php echo get_full_url(); ?>" method="post" class="{{TOOL_SLUG}}_submit_form">
        <div class="form-group">
            <label>Enter Domain</label>
            <div class="{{TOOL_SLUG}}_input_container">
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
            <input type="text" value="{{TOOL_SLUG}}" name="tool" class="d-none">
            <input type="text" value="process_{{TOOL_SLUG}}_checker" name="action" class="d-none">
            <button type="submit" id="{{TOOL_SLUG}}_btn" class="btn btn-primary text-white">Submit</button>
        </div>

        <div class="form-group">
            <label>Result</label>

            <div class="{{TOOL_SLUG}}_report_container">
                <div class="{{TOOL_SLUG}}_report">
                    
                </div>
            </div>
        </div>
    </form>
</div>