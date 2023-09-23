<?php

namespace AST;

class View{

    private static $is_admin = false;
    private static $is_front = false;
    private static $is_api = false;
    private static $is_auth = false;
    private static $is_install = false;
    private static $active = array();
    private static $viewType = "front";
    private static $pathParts = [];
    public static $customPage = "";

    public static function render( $path="index", $params = array() )
    {
        global $db;

        if( !empty( $params ) ){
            extract($params);
        }

        ob_start();
        
        /** INCLUDE FRONT SCRIPTS */
        if( self::is_front() )
            do_action("add_scripts");
        
        get_header_file( $params );
        $requirepath = self::real_path($path);
        
        if( self::is_admin() ){
            $active = View::get_active();
            require_once get_site_path("admin_file/main.php");
        }else{
            require_once $requirepath;
        }
        get_footer_file( $params );

        return ob_get_clean();
    }

    public static function isCustomPage($page){
        return self::$customPage == $page;
    }

    public static function real_path( $path ){

        $path = str_replace(".", "/", $path);
        
        if( self::is_admin() ){
            $adminpath = "admin_file/template/" . $path;
            if( file_exists( get_site_path( $adminpath ) ) ){
                $path = $adminpath;
            }
        }else if( self::is_auth() ){
            $path = "admin_file/auth/" . $path;
        }else if( self::is_front() ){
            $path = "themes/default/" . $path;
        }else if( self::is_install() ){
            $path = "admin_file/install/" . $path;
        }

        return ASTROOTPATH . $path . ".php";
    }

    
    public static function is_admin()
    {
        return self::$is_admin;
    }


    public static function is_front()
    {
        return self::$is_front;
    }


    public static function is_api()
    {
        return self::$is_api;
    }

    public static function is_cron(){
        return defined("AST_CRON_JOB");
    }


    public static function is_auth()
    {
        return self::$is_auth;
    }

    public static function is_install(){
        return self::$is_install;
    }

    public static function view_type()
    {
        return self::$viewType;
    }

    protected static function set_admin()
    {
        self::$is_admin = true;
        self::$is_front = false;
        self::$is_install = false;
        self::$is_auth = false;
        self::$is_api = false;
        self::$viewType = "admin";
    }

    protected static function set_auth()
    {
        self::$is_admin = false;
        self::$is_front = false;
        self::$is_install = false;
        self::$is_auth = true;
        self::$is_api = false;
        self::$viewType = "auth";
    }

    protected static function set_api()
    {
        self::$is_admin = false;
        self::$is_front = false;
        self::$is_install = false;
        self::$is_auth = false;
        self::$is_api = true;
        self::$viewType = "api";
    }

    protected static function set_front()
    {
        self::$is_admin = false;
        self::$is_front = true;
        self::$is_auth = false;
        self::$is_api = false;
        self::$is_install = false;
        self::$viewType = "front";
    }

    protected static function set_install()
    {
        self::$is_admin = false;
        self::$is_front = false;
        self::$is_auth = false;
        self::$is_api = false;
        self::$is_install = true;
        self::$viewType = "install";
    }

    public static function is_tool(){
        if( !empty( self::$pathParts ) ){
            if( self::$pathParts[0] == TOOL_ROUTE ){
                return true;
            }
        }
        return false;
    }

    public static function is_account(){
        if( !empty( self::$pathParts ) ){
            if( self::$pathParts[0] == ACCOUNT_ROUTE ){
                return true;
            }
        }
        return false;
    }

    public static function is_post(){
        if( !empty( self::$pathParts ) ){
            if( self::$pathParts[0] == BLOG_ROUTE ){
                return true;
            }
        }
        return false;
    }
    
    public static function parse_controller()
    {
        $path = ltrim(rtrim($_SERVER['REQUEST_URI'], "/"), "/");
        $rootPath = get_site_path_only();
        if( ! empty($rootPath) && str_contains( $path, $rootPath ) ){
            $path = str_replace($rootPath, "", $path);
            $path = ltrim($path, "/");
        }

        if( !empty( $path ) ){
            self::$pathParts = explode("/", $path);
            if( trim(self::$pathParts[0]) == 'admin' ){
                self::set_admin();
            }else if( trim(self::$pathParts[0]) == 'auth' ){
                self::set_auth();
            }else if( trim(self::$pathParts[0]) == 'api' ){
                self::set_api();
            }else if( trim(self::$pathParts[0]) == 'install' ){
                self::set_install();
            }else{
                self::set_front();
            }
        }else{
            self::set_front();
        }
        
        self::set_active();
    }

    private static function get_path_only(){
        $path = $_SERVER['REQUEST_URI'];
        $path = explode("?", $path)[0];
        return "/" . ltrim(rtrim($path, "/"), "/") . "/";
    }

    private static function set_active()
    {
        global $routerLinks;
        $path  = self::get_path_only();
        $newRouteLinks = "front";
        
        if( self::is_admin() ){
            $newRouteLinks = "admin";
        }else if( self::is_auth() ){
            $newRouteLinks = "auth";
        }else if( self::is_front() ){
            $newRouteLinks = "front";
        }

        if( isset($routerLinks[$newRouteLinks]) ){
            foreach($routerLinks[$newRouteLinks] as $k => $d){
                if( ! isset( $d['header'] ) ){
                    if( isset( $d['child'] ) && !empty($d['child']) ){
                        foreach( $d['child'] as $kk => $dd ){
                            if( self::is_match( $dd['link'], $path, $dd ) ){
                                break;
                            }
                        }
                    }else{
                        if( self::is_match( $d['link'], $path, $d ) ){
                            break;
                        }
                    }
                }
            } 
        }
    }

    private static function is_match( $link, $match, $data ){
        if( self::is_admin() ){
            $link = "admin/$link";
        }
        
        $createurlregex = rtrim($link, "/");
        $createurlregex = str_replace("/", "\/", $createurlregex);
        $regex = '/\/?' . $createurlregex . '\/?$/';

        preg_match($regex, $match, $matches);

        if( !empty( $matches ) ){
            self::$active = $data;
            return true;
        }

        return false;
    }

    public static function get_active()
    {        
        return self::$active;
    }

    public static function include_admin_functions(){
        $adminFunctions = get_site_path("admin_file/functions.php");

        if( file_exists( $adminFunctions ) ){
            require_once $adminFunctions;
        }
    }

    public static function include_install_functions(){
        $ajaxFile = get_site_path("admin_file/install/ajax.php");
        if( file_exists( $ajaxFile ) ){
            include $ajaxFile;
        }else{
            die("Installation File is mising!!!");
        }
    }

    public static function include_theme_functions(){
        $activeTheme = get_settings( "activetheme", "default" );
        $themePath = get_site_path("themes/$activeTheme/functions.php");

        if( file_exists( $themePath ) ){
            require_once $themePath;
        }
    }

    public static function include_tool_functions( $tool ){
        if( is_numeric( $tool ) ){
            $tooldata = get_post($tool);
            if( empty( $tooldata ) ){
                return false;
            }

            $tool = $tooldata->extra;
        }

        $toolPath = get_site_path("tools/$tool/functions.php");
        if( file_exists( $toolPath ) ){
            require_once $toolPath;
        }
    }

}