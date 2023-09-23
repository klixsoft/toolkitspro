<?php
/**
 * Get settings data
 * 
 */
global $fields;
$settings_key = "pricing_plan";
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
                                    "name" => "priority_auto",
                                    "data-tag" => "disableSitemapAuto"
                                ),
                                "value" => @$settings->priority_auto,
                                "title" => "Auto calculate priority level and change frequency"
                            ))->render();
                            
                            $fields->set(array(
                                "type" => "select",
                                "atts" => array(
                                    "class" => "form-control disableSitemapAuto",
                                    "name" => "frequency"
                                ),
                                "options" => array(
                                    "always" => "Always",
                                    "hourly" => "Hourly",
                                    "daily" => "Daily",
                                    "weekly" => "Weekly",
                                    "monthly" => "Monthly",
                                    "yearly" => "Yearly",
                                    "never" => "Never",
                                ),
                                "value" => @$settings->frequency,
                                "title" => "Default Change Frequency"
                            ))->render();
                            
                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control disableSitemapAuto",
                                    "name" => "priority",
                                    "required" => "",
                                    "data-alert" => "Priority Level is Required!!!"
                                ),
                                "value" => @$settings->priority,
                                "title" => "Default Priority Level"
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