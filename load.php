<?php

use AST\View;
use AST\Fields;
use Whoops\Run;
use AST\Download;
use AST\Database;
use AST\Cache;
use AST\Helper\Minification;
use Phroute\Phroute\Dispatcher;
use PHPMailer\PHPMailer\PHPMailer;
use Phroute\Phroute\RouteCollector;
use Whoops\Handler\PrettyPageHandler;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;

/*=====================================================
 SESSION START                         
*=====================================================*/
session_start();

/*=====================================================
 CONFIGURATION FILE                        
*=====================================================*/
require_once realpath(__DIR__) . '/config.php';
date_default_timezone_set( TIMEZONE );


/*=====================================================
 DIRECTORY CONSTANTS                         
*=====================================================*/
define( "APP_PATH", ASTROOTPATH . "app/");
define( "PLUGINS_PATH", ASTROOTPATH . "plugins/");
define( "THEME_PATH", ASTROOTPATH . "themes/");
define( "UPLOADS_PATH", ASTROOTPATH . "uploads/");
define( "LANG_PATH", ASTROOTPATH . "language/");
define( "TOOLS_PATH", ASTROOTPATH . "tools/");
define( "INCLUDE_PATH", APP_PATH . "includes/");
define( "HELPER_PATH", APP_PATH . "helper/");
define( "TEMP_PATH", APP_PATH . "temp/");
define( "ADMIN_PATH", ASTROOTPATH . "admin_file/");
define( "PACKAGES_PATH", ADMIN_PATH . "packages/");
define( "MODULE_PATH", ADMIN_PATH . "assets/modules/");

/*=====================================================
 OTHERS CONSTANTS                       
*=====================================================*/
define( "AST_UA", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36");
define( "AST_UA_IOS", "Mozilla/5.0 (iPhone; CPU iPhone OS 16_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.3 Mobile/15E148 Safari/604.1");


/*=====================================================
 GLOBAL VARIABLES                          
*=====================================================*/
global $db, $router, $settings, $phpmailer, $post, $colors, $scripts, $minification, $websiteinfo, $extraparams;

/*=====================================================
 INCLUDING LIBRRAIES                          
*=====================================================*/
require_once ASTROOTPATH . '/vendor/autoload.php';


/*=====================================================
 HANDLING ERRORS                         
*=====================================================*/
if( AST_DEBUG ){
    $ASTError = new Run();
    $ASTError->pushHandler(new PrettyPageHandler());
    $ASTError->register();
}else{
    error_reporting(0);
    ini_set('display_errors', 0);
}

/*=====================================================
 ROUTER SETUP                          
*=====================================================*/
$router = new RouteCollector();


/*=====================================================
 PHP MAILER                          
*=====================================================*/
$phpmailer = new PHPMailer( true );


/*=====================================================
 DATABASE CONNECTION                     
*=====================================================*/
$db = Database::getInstance();

/*=====================================================
 INPUT FIELDS GENERATOR                    
*=====================================================*/
$fields = Fields::instance();


/*=====================================================
 INCLUDE FUNCTIONS AND HOOKS                   
*=====================================================*/
require_once INCLUDE_PATH . "Plugin.php";
require_once INCLUDE_PATH . "functions.php";

$minification = new Minification();

$colors = get_color_pallate("colors");
$websiteinfo = get_settings("basic");
require_once INCLUDE_PATH . "ajax.php";
require_once APP_PATH . "helper/ColumnHelper.php";


/*=====================================================
 INCLUDE ALL PLUGIN MAIN FILES                 
*=====================================================*/
foreach (glob(PLUGINS_PATH . "*") as $filename){
    if( is_dir( $filename ) && file_exists( $filename . "/functions.php" ) )
        require_once $filename . "/functions.php";
}

/*=====================================================
 INCLUDE ALL TOOLS IMPORTANT FILES                 
*=====================================================*/
foreach (glob(TOOLS_PATH . "*") as $filename){
    if( is_dir( $filename ) && file_exists( $filename . "/important.php" ) )
        require_once $filename . "/important.php";
}

/*=====================================================
 SETUP VIEW CONTROLLER                
*=====================================================*/
$routerLinks = @include( ASTROOTPATH . "app/routes/config.php" );
$routerLinks = apply_filters("ast/routers/config", $routerLinks);
View::parse_controller();
View::include_admin_functions();
if( has_system_installed() )
    Download::setup();
if( View::is_api() )
    require_once INCLUDE_PATH . "ApiHandlers.php";

/*=====================================================
 INCLUDE ADMIN, FRONT, AUTH, API ROUTES                          
*=====================================================*/
$router->group(["prefix" => get_site_path_only()], function(RouteCollector $router){
    $viewType = View::view_type();
    require_once ASTROOTPATH . "app/routes/global.php";
    require_once ASTROOTPATH . "app/routes/$viewType.php";
});


/*=====================================================
 INCLUDE ACTIVE THEME FUNCTIONS FILE                        
*=====================================================*/
if( View::is_front() || View::is_cron() ){
    View::include_theme_functions();
}

/*=====================================================
 HOOK hANDLER                   
*=====================================================*/
require_once INCLUDE_PATH . "HookHander.php";