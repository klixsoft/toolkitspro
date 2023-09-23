<?php

$activePlugins = (array) get_settings("active_plugins");
$plugins = array();
foreach (new DirectoryIterator(PLUGINS_PATH) as $fileInfo) {
    if($fileInfo->isDot()) continue;

    if( $fileInfo->isDir() ){
        $fileName = $fileInfo->getFilename();
        $pluginFile = PLUGINS_PATH . $fileName . "/plugin.json";
        if( file_exists( $pluginFile ) ){
            $settings = file_get_contents( $pluginFile );
            $settings = json_decode( $settings );
            $settings->isSVG = false;
            if( property_exists( $settings, "icon" ) && !filter_var( $settings->icon, FILTER_VALIDATE_URL ) ){
                $settings->icon = get_site_url() . "plugins/" . $fileName . "/" . $settings->icon;
                $settings->isSVG = trim(strtolower(pathinfo($settings->icon, PATHINFO_EXTENSION))) == 'svg';
            }

            if( isset( $activePlugins[$fileName] ) && isset($activePlugins[$fileName]['status']) ){
                $settings->status = $activePlugins[$fileName]['status'];
            }else{
                $settings->status = "inactive";
            }
            
            $plugins[ $fileName ] = $settings;
        }
    }
}
?>

<div class="col-12">
    <div class="card bg-white p-4">
        <div class="plugin_lists w-100">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Plugin Name</th>
                        <th>Author</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        foreach($plugins as $slug => $plugin){
                            //plugin card
                            $image = $plugin->isSVG ? 
                                file_get_contents($plugin->icon) 
                            : 
                                sprintf('<img src="%s" alt="%s" />', $plugin->icon, $plugin->name);

                            if( !str_contains($image, "<img" ) && !str_contains($image, "<svg" ) ){
                                $image = '';
                            }

                            $pluginName = sprintf('<div class="plugin_name">
                                <div class="icon">%s</div>
                                <div class="info">
                                    <div class="name">%s</div>
                                    <div class="version">Version: <strong>%s</strong></div>
                                </div>
                            </div>', $image, $plugin->name, $plugin->version);

                            //plugin author
                            $authorName = sprintf('<a href="%s" target="_blank">%s</a>', $plugin->author[0]->url, $plugin->author[0]->name);

                            $actions = array();
                            if( $plugin->status == 'active' ){
                                $actions[] = sprintf('<button class="btn btn-warning pluginAction" data-action="deactivate" data-plugin="%s">Deactivate</button>', $slug);
                            }else{
                                $actions[] = sprintf('<button class="btn btn-success pluginAction" data-action="activate" data-plugin="%s">Activate</button>', $slug);
                                $actions[] = sprintf('<button class="btn btn-danger pluginAction" data-action="remove" data-plugin="%s">Remove</button>', $slug);
                            }

                            $actions = apply_filters("tkp/plugins/action", $actions, $plugin);
                            $actions = implode(" ", $actions);
                    ?>
                    <tr>
                        <td><?php echo $pluginName; ?></td>
                        <td><?php echo $authorName; ?></td>
                        <td><?php echo $actions; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>