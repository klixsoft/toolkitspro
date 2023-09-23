<div class="<?php echo $tool->slug; ?>_content video_downloader">
    <form action="<?php echo get_full_url(); ?>" method="post" class="video_downloader_form <?php echo $tool->slug; ?>_submit_form">
        <div class="form-group form-group-nopad">
            <label id="videoDownloadInputLabel" for="videoDownloadInput"><?php echo $placeholder; ?></label>
            <div class="input-group mb-<?php echo empty($afterinput) ? 3 : 1; ?>">
                <input type="text" aria-labelledby="videoDownloadInputLabel" disabled name="<?php echo $inputname; ?>" id="videoDownloadInput" class="pastedContent form-control" placeholder="<?php echo $placeholderlabel; ?>">

                <div class="input-group-append">
                    <?php if( $copybtn == "show" ): ?>
                    <i class="las la-copy pasteText" 
                    <?php echo isset($labels['iconleft']) ? sprintf('style="left:%s;"', $labels['iconleft']) : ""; ?>
                    data-field="pastedContent" data-validate="url"></i>
                    <?php endif; ?>

                    <?php
                        if( isset( $labels['before_btn'] ) ){
                            echo $labels['before_btn'];
                        }
                    ?>

                    <?php echo get_tool_submit_button($tool, $buttontext, array(
                        "type" => "submit",
                        "data-modal" => $loadingmodal,
                        "id" => $tool->slug . "_btn",
                        "disabled" => "",
                        "class" => "text-white bg-primary input-group-text download_video_btn"
                    ), false); ?>
                </div>
            </div>

            <?php echo $afterinput; ?>

            <input type="text" aria-labelledby="videoDownloadInputLabel" value="<?php echo $tool->slug; ?>" name="tool" class="d-none">
            <input type="text" aria-labelledby="videoDownloadInputLabel" value="<?php echo $tool->id; ?>" name="toolid" class="d-none">
            <input type="text" aria-labelledby="videoDownloadInputLabel" value="process_<?php echo $tool->slug; ?>_checker" name="action" class="d-none">
        </div>

        <?php
            /**
             * Render Captcha Settings
             */
            do_action("ast/captcha/render", $tool, $report);
        ?>

        <?php
            do_action("downloader/fields/$tool->slug");
        ?>

        <div class="form-group d-none mt-4">
            <label class="fw-bold d-block" style="font-size:1.3rem;"><?php echo $resultlabel; ?>:</label>

            <div class="<?php echo $tool->slug; ?>_report_container">
                <div class="<?php echo $tool->slug; ?>_report video_downloader_report">
                    <?php
                        do_action("downloader/field/output/$tool->slug");
                    ?>
                </div>
            </div>
        </div>
    </form>
</div>