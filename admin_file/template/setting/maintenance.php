<?php
/**
 * Get settings data
 * 
 */
global $fields;
$settings_key = "maintenance";
$settings = get_settings($settings_key);
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
                            "data-tag" => "disableCronJobSitemap"
                        ),
                        "value" => @$settings->enable,
                        "title" => "Enable"
                    ))->render();
                    
                    $fields->set(array(
                        "type" => "input",
                        "atts" => array(
                            "type" => "text",
                            "class" => "form-control disableCronJobSitemap",
                            "name" => "title"
                        ),
                        "value" => @$settings->title,
                        "title" => "Title"
                    ))->render();
                    
                    $fields->set(array(
                        "type" => "textarea",
                        "atts" => array(
                            "class" => "form-control disableCronJobSitemap",
                            "name" => "message",
                            "rows" => 5
                        ),
                        "value" => @$settings->message,
                        "title" => "Message",
                        "after_input" => "Basic HTML Code is Supported such as basic tags, anchor and lists."
                    ))->render();
                    
                    $fields->set(array(
                        "type" => "input",
                        "atts" => array(
                            "type" => "datetime-local",
                            "class" => "form-control disableCronJobSitemap",
                            "name" => "upto"
                        ),
                        "value" => @$settings->upto,
                        "title" => "Counter Timer"
                    ))->render();

                    $fields->set(array(
                        "type" => "input",
                        "atts" => array(
                            "type" => "text",
                            "class" => "form-control disableCronJobSitemap",
                            "name" => "btntext"
                        ),
                        "value" => @$settings->btntext,
                        "title" => "Button Text"
                    ))->render();

                    $fields->set(array(
                        "type" => "input",
                        "atts" => array(
                            "type" => "text",
                            "class" => "form-control disableCronJobSitemap",
                            "name" => "btnlink"
                        ),
                        "value" => @$settings->btnlink,
                        "title" => "Button Link"
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