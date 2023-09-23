<?php
/**
 * Get settings data
 * 
 */
global $fields;
$settings_key = "minification";
$settings = get_settings($settings_key);
?>

<div class="col-sm-12">
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
                                    "name" => "minify",
                                    "data-tag" => "disableCronJobSitemap"
                                ),
                                "value" => @$settings->minify,
                                "title" => "Enable Minification"
                            ))->render();
                            
                            $fields->set(array(
                                "type" => "toggle",
                                "atts" => array(
                                    "type" => "checkbox",
                                    "class" => "disableCronJobSitemap",
                                    "name" => "cron"
                                ),
                                "value" => @$settings->cron,
                                "title" => "Auto Minify using cron"
                            ))->render();
                            
                            $fields->set(array(
                                "type" => "textarea",
                                "atts" => array(
                                    "class" => "form-control disableCronJobSitemap",
                                    "name" => "exclude",
                                    "rows" => 5
                                ),
                                "value" => @$settings->exclude,
                                "title" => "Exclude Scripts",
                                "after_input" => "Exclude css and javascript from minification."
                            ))->render();
                        ?>
                    </div>
                </div>
            </div>

            <div class="settings_footer">
                <button type="button" class="btn btn-primary manualMinification">Manual Minification</button>
                <button type="button" class="btn btn-primary updateSettings" data-key="<?php echo $settings_key; ?>">Update Settings</button>
            </div>
        </div>
    </div>
</div>