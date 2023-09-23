<?php
/**
 * Get settings data
 * 
 */
global $fields;
$settings_key = "download";
$settings = get_download_settings();
?>

<div class="col-12">
    <div class="card bg-white">
        <div class="settings_form w-100">
            <div class="settings_title">Options</div>

            <div class="settings_content p-3">
                <div class="row">
                    <div class="col-12">
                        <?php
                            $fields->set(array(
                                "type" => "toggle",
                                "atts" => array(
                                    "type" => "checkbox",
                                    "class" => "onChangeDisable",
                                    "name" => "enable",
                                    "data-tag" => "disableDownloadConfig"
                                ),
                                "value" => @$settings->enable,
                                "title" => "Enable"
                            ))->render();

                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control disableDownloadConfig",
                                    "name" => "slug"
                                ),
                                "value" => @$settings->slug,
                                "title" => "Download Slug",
                                "after_input" => "It will be random string with alphabel and number. Only specify the length of the slug."
                            ))->render();
                            
                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "number",
                                    "class" => "form-control disableDownloadConfig",
                                    "name" => "time"
                                ),
                                "value" => @$settings->time,
                                "title" => "Countdown Timer",
                                "after_input" => "File will be automatically downloaded after this time. (Value in Seconds)"
                            ))->render();

                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "number",
                                    "class" => "form-control disableDownloadConfig",
                                    "name" => "expiry"
                                ),
                                "value" => @$settings->expiry,
                                "title" => "Download Link Expiry Time",
                                "after_input" => "File can't be downloaded after this time. (Value in Minutes)"
                            ))->render();


                            $fields->set(array(
                                "type" => "textarea",
                                "atts" => array(
                                    "class" => "form-control disableDownloadConfig",
                                    "name" => "beforetext",
                                    "rows" => 3
                                ),
                                "value" => @$settings->beforetext ?: 'Your download started in {{COUNTDOWN}} seconds.',
                                "title" => "Coundown Text"
                            ))->render();

                            $fields->set(array(
                                "type" => "textarea",
                                "atts" => array(
                                    "class" => "form-control disableDownloadConfig",
                                    "name" => "aftertext",
                                    "rows" => 3
                                ),
                                "value" => @$settings->aftertext ?: '<strong>Thanks!</strong> Your download will start in few seconds...<br/> If not, <strong>Refresh the page Again</strong>!!!',
                                "title" => "After  Finish Text"
                            ))->render();
                        ?>
                    </div>
                </div>
            </div>

            <div class="settings_footer">
                <button type="button" class="btn btn-primary updateSettings"
                    data-key="<?php echo $settings_key; ?>">Update Settings</button>
            </div>
        </div>
    </div>
</div>