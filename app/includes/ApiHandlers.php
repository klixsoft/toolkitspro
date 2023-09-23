<?php

add_filter("ast/api/plugins", function($plugins){
    $plugins = get_settings("available_plugins", array());
    return $plugins;
}, 1, 1);