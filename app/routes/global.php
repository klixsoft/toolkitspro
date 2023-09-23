<?php

use AST\View;
use Phroute\Phroute\RouteCollector;

$router->filter("alreadylogin", function(){
    if( is_user_loggin() ){
        return View::render("already");
    }
});

function get_maintenance_html( $maintenance ){
    ob_start();
    include ASTROOTPATH . "admin_file/maintenance.php";
    return ob_get_clean();
}

$router->filter("checkMantenance", function(){
    /** CHECK FOR INSTALLATION */
    if( ! has_system_installed() && ! isset($_SESSION['startinstall']) ){
        $_SESSION['startinstall'] = "install";
        redirect(get_site_url("install/"));
        die();
    }
    
    /** CHECK FOR MAINTENANCE */
    if( View::is_front() ){
        $maintenance = (object) get_settings("maintenance", array(
            "enable" => false
        ));
        if( filter_var($maintenance->enable, FILTER_VALIDATE_BOOLEAN) ){
            $user = ast_get_current_user();
            if( $user ){
                if( $user->role != 'administrator' ){
                    return get_maintenance_html($maintenance);
                }
            }else{
                return get_maintenance_html($maintenance);
            }
        }
    }

    /** AFTER CHECKING MAINTENANCE */
    do_action("after/maintenance/check");
});

$router->filter('auth', function(){
    if( ! is_user_loggin() ){
        $redirect_url = get_site_url("auth/login/?redirect_url=") . get_redirect_url();
        header("Location:" . $redirect_url);
        exit;
    }
});

$router->filter('isValidUser', function(){
    if( is_user_loggin() ){
        $user = ast_get_current_user();
        if( $user->role == 'subscriber' ){
            header("Location:" . get_site_url());
            exit;
        }
    }
});

$router->filter("increateViews", function(){
    if( has_system_installed() ){
        $totalViews = get_settings("website_views", 0);
        $totalViews = $totalViews + 1;
        update_settings("website_views", $totalViews);
    }
});