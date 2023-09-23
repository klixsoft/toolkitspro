<?php

$plugins = array();
foreach (new DirectoryIterator(PLUGINS_PATH) as $fileInfo) {
    if($fileInfo->isDot()) continue;

    if( $fileInfo->isDir() ){
        $pluginFile = PLUGINS_PATH . $fileInfo->getFilename() . "/plugin.json";
        if( file_exists( $pluginFile ) ){
            $settings = file_get_contents( $pluginFile );
            $settings = json_decode( $settings );
            $settings->isSVG = false;
            if( property_exists( $settings, "icon" ) && !filter_var( $settings->icon, FILTER_VALIDATE_URL ) ){
                $settings->icon = get_site_url() . "plugins/" . $fileInfo->getFilename() . "/" . $settings->icon;
                $settings->isSVG = trim(strtolower(pathinfo($settings->icon, PATHINFO_EXTENSION))) == 'svg';
            }
            $plugins[ $fileInfo->getFilename() ] = $settings;
        }
    }
}

// update_admin_settings( "available_plugins", $plugins );

?>

<style>
.plugin_lists .profile-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    background: #fff;
    border-radius: 24px;
    padding: 25px;
    position: relative;
    border: 1px solid #ccc;
}

.plugin_lists .profile-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    height: 36%;
    width: 100%;
    border-radius: 24px 24px 0 0;
    background-color: var(--primary);
}

.plugin_lists .image {
    position: relative;
    height: 100px;
    width: 100px;
    border-radius: 50%;
    padding: 3px;
    margin-bottom: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 4px solid #20cb91;
    background: #fff;
}

.plugin_lists .image svg{
    width:50px;
    height:50px;
}

.plugin_lists .image .profile-img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #fff;
}

.plugin_lists .profile-card .text-data {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #333;
}

.plugin_lists .text-data .name {
    font-size: 22px;
    font-weight: 500;
}

.plugin_lists .text-data .job {
    font-size: 15px;
    font-weight: 400;
}
</style>

<div class="col-12">
    <div class="card bg-white p-4">
        <div class="plugin_lists w-100">
            <div class="row">
                <?php foreach($plugins as $pluginName => $plugin): ?>
                <div class="col-md-3">
                    <div class="profile-card">
                        <div class="image">
                            <?php
                                if( $settings->isSVG ){
                                    echo file_get_contents($plugin->icon);
                                }else{
                                    echo sprintf('<img src="%s" alt="%s" class="profile-img" />', $plugin->icon, $plugin->name);
                                }
                            ?>
                        </div>

                        <div class="text-data mb-3">
                            <span class="name"><?php echo $plugin->name; ?></span>

                            <?php if( !empty( $plugin->author ) ): ?>
                            <span class="job">By: <a href="<?php echo @$plugin->author[0]->url; ?>" target="_blank" rel="noopener noreferrer"><?php echo @$plugin->author[0]->name; ?></a></span>
                            <?php endif; ?>

                            <span class="job">Version: <strong><?php echo @$plugin->version; ?></strong></span>
                        </div>

                        <div class="button-row d-flex align-items-center justify-content-between w-100">
                            <button class="btn btn-warning rounded-0">Update</button>
                            <button data-plugin="<?php echo $pluginName; ?>" class="btn btn-danger rounded-0 removePluginBtn">Remove</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>