<?php
/**
 * Get settings data
 * 
 */
global $fields;
$settings_key = "colors";
$settings = get_settings($settings_key);

$colorOptions = array(
    "primary" => "Primary Color",
    "background" => "Background Color",
    "text-color" => "Text Color",
    "card-back" => "Card Background Color",
    "icon-first-color" => "Icon First Color",
    "icon-last-color" => "Icon Last Color"
);

$colors = get_default_color_pallate(2);
?>

<form method="post" class="settings_form w-100">
    <div class="row">
        <div class="col-sm-6">
            <div class="card bg-white">
                <div class="settings_form_row w-100">
                    <div class="settings_title">Light Theme</div>

                    <div class="settings_content p-3">
                        <div class="row">
                            <div class="col-12">
                                <?php
                                    foreach($colorOptions as $name => $title){
                                        $value = @$settings->light[$name] ?? $colors['light'][$name];
                                        $format = str_contains($value, "rgb") ? "rgb" : "hex";
                                        $opacity = $format == "rgb" ? "true" : "false";
                                        echo sprintf('<div class="form-group mb-3 primarycolor_field">
                                            <label>%s</label>
                                            <input type="text" data-format="%s" data-opacity="%s" value="%s" class="primary_color form-control colorpicker" name="light[%s]" required>
                                        </div>', $title, $format, $opacity, $value, $name);
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="settings_footer">
                        <button type="submit" class="btn btn-primary updateSettings"
                            data-key="<?php echo $settings_key; ?>">Update Settings</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card bg-white">
                <div class="settings_form_row w-100">
                    <div class="settings_title">Dark Theme</div>

                    <div class="settings_content p-3">
                        <div class="row">
                            <div class="col-12">
                                <?php
                                    foreach($colorOptions as $name => $title){
                                        $value = @$settings->dark[$name] ?? $colors['dark'][$name];
                                        $format = str_contains($value, "rgb") ? "rgb" : "hex";
                                        $opacity = $format == "rgb" ? "true" : "false";
                                        echo sprintf('<div class="form-group mb-3 primarycolor_field">
                                            <label>%s</label>
                                            <input type="text" data-format="%s" data-opacity="%s" value="%s" class="primary_color form-control colorpicker" name="dark[%s]" required>
                                        </div>', $title, $format, $opacity, $value, $name);
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>