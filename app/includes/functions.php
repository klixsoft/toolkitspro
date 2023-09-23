<?php

use AST\View;
use AST\Plan;
use AST\Options;
use AST\Users;
use AST\Cookie;
use AST\PasswordHash;
use AST\FileSystem;
use GuzzleHttp\Client;
use GuzzleHttpException\ClientException;
use GuzzleHttpException\ConnectException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use Phroute\PhrouteException\HttpRouteNotFoundException;

include ASTROOTPATH . "app/includes/Helpers.php";

if( ! function_exists( "has_system_installed" ) ){
    /**
     * Check whether system is proprly installed or not
     */

    function has_system_installed(){
        if( defined("DB_NAME") ){
            if( empty( DB_NAME ) ) return false;
            if( str_contains(DB_NAME, "}}") ) return false;
            return true;
        }
        
        return false;
    }
}

if( ! function_exists( "is_not_install_page" ) ){

    /**
     * Check whether current page installed page
     */
    function is_not_install_page(){
        $url = get_full_url();
        return !str_contains( $url, "/install" );
    }
}

if( ! function_exists( "get_settings" ) ){
    
    /**
     * GET WEBSITE SETTINGS
     * 
     * @param string $key
     * @param any $default
     * 
     * @return any
     */
    function get_settings( $key, $default = false ){
        if( has_system_installed() )
            return Options::get( $key, $default );
        return $default;
    }
}

if( ! function_exists( "get_apikey" ) ){
    /**
     * GET TOOL API KEY
     * 
     * @param string $key
     * 
     * @return any
     */
    function get_apikey( $key, $default = false ){
        $settings = (array) get_settings("toolapikeys");
        if( isset( $settings[$key] ) ){
            $value = $settings[$key];
            if( str_contains($value, " , ") ){
                $value = explode(" , ", $value)[0];
            }

            return $value;
        }

        return $default;
    }
}

if( ! function_exists( "shift_apikey" ) ){
    /**
     * Shift API Key
     */
    function shift_apikey($string, $param, $separator=' , ') {
        $array = explode($separator, $string);
        $rotateCount = $param % count($array);
        
        $rotatedArray = array_slice($array, $rotateCount);
        $rotatedArray = array_merge($rotatedArray, array_slice($array, 0, $rotateCount));
        
        $rotatedString = implode($separator, $rotatedArray);
        return $rotatedString;
    }
}

if( ! function_exists( "shift_apikey_and_update" ) ){
    function shift_apikey_and_update($searchKeys, $updateSettings="toolapikeys"){
        if( is_string( $searchKeys ) ){
            $searchKeys = array($searchKeys);
        }else if( is_object( $searchKeys ) ){
            $searchKeys = (array) $searchKeys;
        }
        
        $settings = (array) get_settings($updateSettings);
        foreach($settings as $key => $v){
            if( in_array( $key, $searchKeys ) ){
                $settings[$key] = shift_apikey($v, 1);
            }
        }

        update_settings($updateSettings, $settings);
    }
}


if( ! function_exists( "update_settings" ) ){
    
    /**
     * GET WEBSITE SETTINGS
     * 
     * @param string $key
     * @param any $default
     * 
     * @return any
     */
    function update_settings( $key, $value ){
        return Options::set( $key, $value );
    }
}


if( ! function_exists( "is_dark_theme" ) ){
    /**
     * Check whether current user choose dark or light theme
     * 
     * @return boolean
     */
    function is_dark_theme(){
        return Cookie::instance()->get("is_dark_theme", "dark");
    }
}

function get_default_color_pallate($dark=0){
    $darkColor = array(
        "primary" => "#002466",
        "background" => "#002247",
        "text-color" => "#fff",
        "card-back" => "#002466",
        "icon-first-color" => "#fff",
        "icon-last-color" => "#ff0000"
    );

    $lightColor = array(
        "primary" => "#009E69",
        "background" => "#f5f5f5",
        "text-color" => "#000",
        "card-back" => "rgba(255, 255, 255, 0.5)",
        "icon-first-color" => "#009E69",
        "icon-last-color" => "#ff0000"
    );

    if( $dark === 0 ){
        return $darkColor;
    }else if( $dark === 1 ){
        return $lightColor;
    }

    return array(
        "light" => $lightColor,
        "dark" => $darkColor
    );
}


if( ! function_exists( "get_color_pallate" ) ){
    function get_color_pallate(){
        $colorSettings = get_settings("colors");

        $light = get_default_color_pallate(1);
        if( ! empty( $colorSettings->light ) )
            $light = (array) $colorSettings->light;
        $light['primaryrgb'] = rgb_implode($light['primary']);

        $dark = get_default_color_pallate(0);
        if( ! empty( $colorSettings->dark ) )
            $dark = (array) $colorSettings->dark;
        $dark['primaryrgb'] = rgb_implode($dark['primary']);
        
        return is_dark_theme() ? $dark : $light;
    }
}


if( ! function_exists( "get_body_class" ) ){
    /**
     * Get body class
     */
    function get_body_class(){
        $classes = array();
        if( is_dark_theme() ){
            $classes[] = "dark";
        }
        $classes = apply_filters("ast/body/class", $classes);
        $classes = implode(" ", $classes);
        return sprintf(' class="%s" ', $classes);
    }
}


if( ! function_exists( "get_full_url" ) ){

    /**
     * GET FULL URL OF CURRENT PAGE
     * 
     * @param boolean $query
     * @return string $url
     */

    function get_full_url( $query = false ){
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if( ! $query ){
            $url = strtok($url, '?');
        }
        return $url;
    }
}


if( ! function_exists( "get_site_url" ) ){

    /**
     * GET MAIN SITE URL
     * 
     * @param string $path
     * @return string
     */
    function get_site_url( $path = "" ){
        $url = get_settings( "siteurl" );
        if ( $path && is_string( $path ) ) {
            $url .= ltrim( $path, '/' );
        }
        return apply_filters( "site_url", $url );
    }

}

if( ! function_exists( "get_temp_path" ) ){

    /**
     * GET TEMP PATH
     * 
     * @param string $path
     * @return string
     */
    function get_temp_path( $path = "" ){
        $url = TEMP_PATH . $path;
        return apply_filters( "temp_path", $url );
    }

}

if( ! function_exists( "get_temp_url" ) ){

    /**
     * GET TEMP URL
     * 
     * @param string $path
     * @return string
     */
    function get_temp_url( $path = "" ){
        $url = get_site_url("app/temp/" . $path);
        return apply_filters( "temp_url", $url );
    }
}

if( ! function_exists( "get_site_path_only" ) ){

    /**
     * Get Website Path Only
     * 
     */
    function get_site_path_only( ){
        return defined("SITEPATH") ? SITEPATH : get_settings( "sitepath" );
    }
}

if( ! function_exists( "get_site_path" ) ){

    /**
     * Get Website Path
     * 
     */
    function get_site_path( $extra = "" ){
        $path = get_site_path_only();
        $path = ltrim( $path, '/' );
        if( ! empty( $path ) ){
            $path = ASTROOTPATH . $path . "/";
        }else{
            $path = ASTROOTPATH;
        }
    
        return apply_filters( "site_path", $path ) . $extra;
    }
}

if( ! function_exists( "get_path_from_url" ) ){

    /**
     * Get File path form url
     */
    function get_path_from_url($url){
        if( str_contains( $url, get_site_url() ) ){
            $hostname = extractHostname($url);
            $urlParts = explode(get_site_url(), $url);
            $urlPath = end($urlParts);
            $path = get_site_path($urlPath);
            $path = str_replace("//", "/", $path);

            if( str_contains($path, "?") ){
                return strtok($path, '?');
            }

            return $path;
        }
        return false;
    }
}


if( ! function_exists( "get_admin_url" ) ){

    /**
     * Get Admin Panel URL
     * 
     * @param string $path
     * @return string
     */
    function get_admin_url_path( $path = "" ){
        $url = get_site_url( "admin_file/" );
    
        if ( $path && is_string( $path ) ) {
            $url .= ltrim( $path, '/' );
        }

        return apply_filters( "admin_url", $url );
    }
}

if( ! function_exists( "get_admin_url" ) ){

    /**
     * Get Admin Panel URL
     * 
     * @param string $path
     * @return string
     */
    function get_admin_url( $path = "" ){
        $url = get_site_url( "admin/" );
    
        if ( $path && is_string( $path ) ) {
            $url .= ltrim( $path, '/' );
        }

        return apply_filters( "admin_url", $url );
    }
}


if( ! function_exists( "get_admin_path" ) ){

    /**
     * Get Admin Panel Path
     * 
     * @param string $path
     * @return string
     */
    function get_admin_path( $path = "" ){
        $url = get_site_path( );
    
        if ( $path && !empty( $path ) ) {
            $path = ltrim($path, "/");
        }


        $url = $url . "admin_file/" . $path;

        return apply_filters( "admin_path", $url );
    }
}


if( ! function_exists( "get_theme_url" ) ){

    /**
     * Get Active ThemeURL
     * 
     * @param null
     * @return string
     */
    function get_theme_url( ){
        $activeTheme = get_settings( "activetheme", "default" );
        $url = get_site_url( "themes/$activeTheme/" );
        return apply_filters("theme_url", $url, $activeTheme);
    }
}


if( ! function_exists( "get_theme_path" ) ){

    /**
     * Get Active Theme Path
     * 
     * @param null
     * @return string
     */
    function get_theme_path( ){
        $activeTheme = get_settings( "activetheme", "default" );
        $path = THEME_PATH . $activeTheme . "/";
        return apply_filters("theme_path", $path, $activeTheme);
    }
}


if( ! function_exists( "get_plugin_url" ) ){

    /**
     * Get Plugin Directory URL
     * 
     * @param null
     * @return string
     */
    function get_plugin_url( ){
        $url = get_site_url( "plugins/" );
        return apply_filters("plugin_path", $url);
    }
}


if( ! function_exists( "get_plugin_path" ) ){

    /**
     * Get Plugin Directory Path
     * 
     * @param null
     * @return string
     */
    function get_plugin_path( ){
        return apply_filters("plugin_path", PLUGINS_PATH);
    }
}


if( ! function_exists( "get_redirect_url" ) ){

    /**
     * Get redirect path
     * IF `redirect_url` query is available then it will return `redirect_url` query value
     * OTHERWISE return relative path of the current url
     * 
     * @return string
     */
    function get_redirect_url(){
        if( isset( $_GET['redirect_url'] ) && !empty($_GET['redirect_url']) ){
            return trim($_GET['redirect_url']);
        }
    
        $actual_link = get_full_url(false);
        return str_replace(get_site_url(), "", $actual_link);
    }
}


if( ! function_exists( "get_redirect_path_from_url" ) ){

    /**
     * Get Full URL from relative path
     */
    function get_redirect_path_from_url(){
        if( isset( $_GET['redirect_url'] ) && !empty( $_GET['redirect_url'] ) ){
            $url = trim($_GET['redirect_url']);
            if( filter_var($url, FILTER_VALIDATE_URL) ){
                return $url;
            }
            return get_site_url( $url );
        }
        return get_site_url();
    }
}


if( ! function_exists( "get_header_file" ) ){

    /**
     * Include Header file of Fronted and Admin Dashboard
     * 
     * @param array $params
     */
    function get_header_file( $params = array() ){

        if( isset( $params ) && !empty( $params ) ){
            extract($params);
        }
    
        if( View::is_auth() || isset($isCallback) ){
            $headerfile = get_admin_path() . "/auth/header.php";
            if( file_exists( $headerfile ) ){
                $active = View::get_active();
                require_once $headerfile;
            }else{
                throw new Exception("Admin Header File is Missing.\nFile: $headerfile");
            }
        }else if( View::is_admin() ){
            $headerfile = get_admin_path() . "header.php";
            if( file_exists( $headerfile ) ){
                require_once $headerfile;
            }else{
                throw new Exception("Admin Header File is Missing.\nFile: $headerfile");
            }
        }else if( View::is_front() ){
            $headerfile = get_theme_path() . "header.php";
            if( file_exists( $headerfile ) ){
                require_once $headerfile;
            }else{
                throw new Exception("Theme Header File is Missing.\nFile: $headerfile");
            }
        }
    }
}


if( ! function_exists( "get_header_file" ) ){

    /**
     * Include Header file of Fronted and Admin Dashboard
     * 
     * @param array $params
     */
    function get_header_file( $params = array() ){

        if( isset( $params ) && !empty( $params ) ){
            extract($params);
        }
    
        if( View::is_auth() || isset($isCallback ) ){
            $headerfile = get_admin_path() . "/auth/header.php";
            if( file_exists( $headerfile ) ){
                $active = View::get_active();
                require_once $headerfile;
            }else{
                throw new Exception("Admin Header File is Missing.\nFile: $headerfile");
            }
        }else if( View::is_admin() ){
            $headerfile = get_admin_path() . "header.php";
            if( file_exists( $headerfile ) ){
                require_once $headerfile;
            }else{
                throw new Exception("Admin Header File is Missing.\nFile: $headerfile");
            }
        }else if( View::is_front() ){
            $headerfile = get_theme_path() . "header.php";
            if( file_exists( $headerfile ) ){
                require_once $headerfile;
            }else{
                throw new Exception("Theme Header File is Missing.\nFile: $headerfile");
            }
        }else if( View::is_install() ){
            // nothing
        }
    }
}


if( ! function_exists( "get_footer_file" ) ){

    /**
     * Include Header file of Fronted and Admin Dashboard
     * 
     * @param array $params
     */
    function get_footer_file( $params = array() ){

        if( isset( $params ) && !empty( $params ) ){
            extract($params);
        }
    
        if( View::is_auth() || isset($isCallback)  ){
            $headerfile = get_admin_path() . "/auth/footer.php";
            if( file_exists( $headerfile ) ){
                require_once $headerfile;
            }else{
                throw new Exception("Admin Header File is Missing.\nFile: $headerfile");
            }
        }else if( View::is_admin() ){
            $footerfile = get_admin_path() . "footer.php";
            if( file_exists( $footerfile ) ){
                require_once $footerfile;
            }else{
                throw new Exception("Admin Footer File is Missing.\nFile: $footerfile");
            }
        }else if( View::is_install() ){
            // nothing
        }else{
            $footerfile = get_theme_path() . "footer.php";
            if( file_exists( $footerfile ) ){
                require_once $footerfile;
            }else{
                throw new Exception("Theme Footer File is Missing.\nFile: $footerfile");
            }
        }
    }
}


if( ! function_exists( "get_current_id" ) ){

    /**
     * Get current user if login
     */
    function get_current_id(){
        return Users::instance()->get_current_id();
    }
}

if( ! function_exists( "current_user_has_role" ) ){

    /**
     * Get current user have current cole or not
     */
    function current_user_has_role($role){
        if( $role == 'admin' ) $role = "administrator";
        
        $user = Users::instance()->get();
        if( @$user->role ){
            return str_contains( $user->role, $role );
        }
        return false;
    }
}


if( ! function_exists( "ast_get_current_user" ) ){

    /**
     * Get current user if login
     */
    function ast_get_current_user(){
        return Users::instance()->get();
    }
}


if( ! function_exists( "set_from_apidata" ) ){

    /**
     * Set current user from API Key
     */
    function set_from_apidata(){
        return Users::instance()->set_from_apidata();
    }
}


if( ! function_exists( "set_user_logedin" ) ){
    /**
     * Set user logged in automatically
     */

    function set_user_logedin( $userID, $rememberme=true ){
        $_SESSION['userlogin'] = $userID;

        if( $rememberme ){
            Cookie::instance()->set(
                "userlogin",
                $userID,
                864000,
                "/"
            );
        }

        return $userID;
    }
}


if( ! function_exists( "is_user_loggin" ) ){

    /**
     * Check user login or not
     */
    function is_user_loggin(){
        return Users::instance()->exists();
    }
}


if( ! function_exists( "get_active_user_plan" ) ){
    /**
     * Get Active user plan
     */
    function get_active_user_plan(){
        return Plan::instance()->get();
    }
}   


if( ! function_exists( "get_user_by" ) ){

    /**
     * Get user by custom field
     * 
     * @param string $key [id, email, username]
     * @param string $value
     * 
     * @return object User
     */
    function get_user_by($key, $value ){
        return Users::instance()->get_user_by($key, $value);
    }
}

if( ! function_exists( "get_user" ) ){

    /**
     * Get user by id or current user
     */
    function get_user($userid = false){
        if( $userid ){
            if( filter_var( $userid, FILTER_VALIDATE_EMAIL ) ){
                return get_user_by("email", $userid);
            }else if( is_numeric( $userid ) ){
                return get_user_by("id", $userid);
            }
        }
        return ast_get_current_user();
    }
}


if( ! function_exists( "get_user_image" ) ){
    /**
     * Get User Image
     * 
     * @return string
     */
    function get_user_image(){
        $profile_image = '';
        
        if( is_user_loggin() ){
            $profile_image = get_user()->profile;
        }
    
        if( empty( $profile_image ) ){
            $profile_image = get_admin_path( "assets/img/user.png" );
        }
    
        return apply_filters( "ast/profile/image", $profile_image );
    }
}


if( !function_exists("get_site_logo") ){
    /**
     * Get website logo
     * 
     * @return string
     */
    function get_site_logo(){
        $isDark = is_dark_theme();

        $defaultLogo = $isDark ? "-dark" : "";
        $url = get_site_url("admin_file/assets/img/logo$defaultLogo.svg");

        $logokey = $isDark ? "website_dark_logo" : "website_logo";
        $url = get_settings( $logokey, $url );

        return apply_filters( "ast/site/logo", $url );
    }
}


if( ! function_exists( "get_site_logo_html" ) ){
    /**
     * Get site HTML logo
     * IF SVG File, return svg code
     * 
     * @return string
     */
    function get_site_logo_html($class="navbar-brand-top-image"){
        $html = get_site_logo();
        if( filter_var($html, FILTER_VALIDATE_URL) ){
            $html = sprintf('<img class="%s" src="%s" alt="Site Logo"/>', $class, $html);
        }
        return apply_filters( "ast/site/logo/html", $html );
    }
}

if( ! function_exists( "get_category_where" ) ){
    /**
     * Get category by custom conditions
     * 
     * @param array $atts
     * 
     * @return object|null|boolean
     */
    function get_category_where($atts = array()){
        global $db;
    
        foreach( $atts as $key => $value ){
            $db->where($key, $value);
        }
        
        $results = $db->arrayBuilder()->get("category", 1);
        if( is_array($results) && count( $results ) > 0 ){
            return $results[0];
        }
        return false;
    }
}

if( ! function_exists( "get_category_by" ) ){
    /**
     * Get category by custom single field
     * 
     * @param string $key
     * @param string $value
     */
    function get_category_by($key, $value){
        global $db;
    
        $db->where("($key = ?)", array($value));
        $results = $db->arrayBuilder()->get("category", 1);
        if( is_array($results) && count( $results ) > 0 ){
            return $results[0];
        }
        return false;
    }
}

if( ! function_exists( "get_category" ) ){
    /**
     * Get category by id
     * 
     * @param number $id
     * @return object|null|boolean
     */
    function get_category($id){
        return get_category_by("id", $id);
    }
}

if( ! function_exists( "parse_route_constants" ) ){
    function parse_route_constants( $const ){
        $constval = "";
        switch( $const ){
            case 'toolcat':
                $constval = ALL_TOOL_CATEGORY_ROUTE;
                break;

            case 'tool':
                $constval = TOOL_ROUTE;
                break;

            case 'blogs':
                $constval = ALL_BLOG_ROUTE;
                break;

            case 'blog':
                $constval = BLOG_ROUTE;
                break;

            case 'blogcat':
                $constval = ALL_BLOG_CATEGORY_ROUTE;
                break;

            case 'page':
                $constval = PAGE_ROUTE;
                break;
                
            case 'contact':
                $constval = CONTACT_ROUTE;
                break;

            case 'account':
                $constval = ACCOUNT_ROUTE;
                break;
        }

        $constval = ltrim($constval, "/");
        $constval = rtrim($constval, "/");
        return apply_filters("ast/front/const/route", $constval, $const);
    }
}

if( ! function_exists( "parse_route" ) ){
    function parse_route($const, $path){
        $constval = parse_route_constants($const);
        return $constval . "/" . $path;
    }
}

if( ! function_exists( "all_routes_params" ) ){
    function all_routes_params(){
        return array(
            "tool_route" => "Single Tool Route Should not be empty!!!",
            "tool_category" => "Tool Category Route Should not be empty!!!",
            "all_blogs_route" => "Blogs page Route should not be empty!!!",
            "blog_category" => "Blog Category Route should not be empty!!!",
            "single_blog" => "Single Blog Route should not be empty",
            "page_route" => "Single Page Route should not be empty!!!",
            "contact_page" => "Contact Page Route should not be empty!!!",
            "account_page" => "Account Route should not be empty!!!"
        );
    }
}

if( ! function_exists( "validate_all_routes" ) ){
    function validate_all_routes($post){
        $routevalues = all_routes_params();

        foreach( $routevalues as $v => $t ){
            if( isset( $post[$v] ) ){
                $value = trim($post[$v]);
                $value = ltrim($value, "/");
                $value = rtrim($value, "/");

                if( empty( $value ) || $value == '/' ){
                    return $t;
                }
            }else{
                return $t;
            }
        }

        return "true";
    }
}

if( ! function_exists( "get_captcha_settings" ) ){
    /**
     * Get captcha settings
     * 
     * @param boolean $includeSecret [Whether to include secret key or not]
     * 
     * @return object 
     */
    function get_captcha_settings( $includeSecret = true ){
        $settings = (array) get_settings("recaptcha", array(
            "site_key" => "",
            "service" => "v2",
            "secret_key" => "",
            "error_message" => "You didn't pass reCAPTCHA validation. Please refresh and try again!!!",
            "score" => "0.5"
        ));

        if( ! filter_var($includeSecret, FILTER_VALIDATE_BOOLEAN) ){
            if( isset( $settings['secret_key'] ) ){
                unset($settings['secret_key']);
            }
        }

        return (object) $settings;
    }
}

if( ! function_exists( "get_download_settings" ) ){
    /**
     * Get Download settings
     * 
     * @return object 
     */
    function get_download_settings( ){
        $settings = (array) get_settings("download", array(
            "enable" => true,
            "slug" => 10,
            "time" => "10",
            "expiry" => "30",
            "beforetext" => "Your download started in {{COUNTDOWN}} seconds.",
            "aftertext" => "<strong>Thanks!</strong> Your download will start in few seconds...<br/> If not, <strong>Refresh the page Again</strong>!!!"
        ));
        return (object) $settings;
    }
}

if( ! function_exists( "get_cookie_data" ) ){
    /**
     * Get Cookie data
     * 
     * @param string $key
     * 
     * @return string|bool
     */
    function get_cookie_data( $key, $file=false ){
        $content = false;
        $filePath = TEMP_PATH . "cookies/$key-cookie.txt";
        if( file_exists( $filePath ) ){
            $content= trim(file_get_contents($filePath));
            if( ! empty( $content ) && $file ){
                return $filePath;
            }
        }
        return $content;
    }
}

if( ! function_exists( "set_cookie_data" ) ){
    /**
     * Set Cookie data
     * 
     * @param string $key
     * 
     * @return boolean
     */
    function set_cookie_data( $key, $content ){
        $filePath = TEMP_PATH . "cookies/$key-cookie.txt";
        if( ! file_exists( $filePath ) ){
            FileSystem::create($filePath);
        }
        return file_put_contents($filePath, $content);
    }
}

function get_report_by( $params = array() ){
    global $db;
    foreach( $params as $k => $v ){
        $db->where($k, $v);
    }

    $results = $db->objectBuilder()->get("report", 1);
    if( ! empty( $results ) && count( $results ) > 0 ){
        return $results[0];
    }

    return false;
}

function get_report( $reportid, $toolslug ){
    global $db;

    $db->where("(`id` = ? and `tool` = ?)", array($reportid, $toolslug));
    $results = $db->objectBuilder()->get("report", 1);
    if( ! empty( $results ) && count( $results ) > 0 ){
        return $results[0];
    }

    return false;
}

function get_post_by($key, $id=false){
    global $db;
    if( is_array( $key ) ){
        foreach( $key as $k => $v ){
            $db->where($k, $v);
        }
    }else{
        $db->where("(`$key` = ?)", array($id));
    }
    
    $results = $db->objectBuilder()->get("posts", 1);
    if( is_array($results) && count( $results ) > 0 ){
        return $results[0];
    }
    return false;    
}

function get_tool_by($key, $value){
    return get_post_by(array(
        "type" => "tool",
        $key => $value
    ));
}

function get_post($id){
    global $db;
    $db->where("(`id` = ?)", array($id));
    $results = $db->objectBuilder()->get("posts", 1);
    if( is_array($results) && count( $results ) > 0 ){
        return $results[0];
    }
    return false;    
}

function get_post_category( $type, $postid ){
    return get_meta($type, $postid, "category");
}

function get_tools_by_category($catid, $length = 10, $orderby="views", $order="desc"){
    global $db;
    $sql = 'SELECT * FROM posts WHERE id in (SELECT meta_id from ast_meta_data WHERE meta_of = ? AND meta_value LIKE ?) AND type = ? AND status = "active" order by '.$orderby.' '.$order;
    if( $length > 0 ){
        $sql .= " LIMIT " . $length;
    }

    $params = array('tool', '%"'.$catid.'"%', 'tool');
    return $db->rawQuery($sql, $params);
}

function get_lastupdate_post_type($type, $length = null){
    global $db;
    $db->where("type", $type);
    $db->orderBy("date", "desc");
    return $db->get("posts", $length);
}

function get_latest_post_type($type, $length = 10){
    global $db;
    $db->where("type=? AND status=?", array($type, "active"));
    $db->orderBy("id", "desc");
    return $db->get("posts", $length);
}

function get_latest_tools($length = 10){
    return get_latest_post_type("tool", $length);
}

function get_latest_posts($length = 10){
    return get_latest_post_type("post", $length);
}

function get_popular_post_type($type, $length = 10){
    global $db;
    $db->where("type=? AND status=?", array($type, "active"));
    $db->orderBy("views", "desc");
    return $db->get("posts", $length);
}

function get_popular_tools($length = 10){
    return get_popular_post_type("tool", $length);
}

function get_popular_posts($length = 10){
    return get_popular_post_type("post", $length);
}

function get_tools_count_by_category($catid){
    global $db;
    $sql = 'SELECT count(*) as total FROM posts WHERE id in (SELECT meta_id from ast_meta_data WHERE meta_of = ? AND meta_value LIKE ?) AND type = ? AND status = ?';
    $params = array('tool', '%"'.$catid.'"%', 'tool', 'active');
    $response = $db->rawQuery($sql, $params);
    if( !empty( $response ) ){
        return $response[0]->total;
    }   
    return 0;
}

function get_posts_by_category($catid){
    global $db;
    $sql = 'SELECT * FROM posts WHERE id in (SELECT meta_id from ast_meta_data WHERE meta_of = ? AND meta_value LIKE ?) AND type = ?';
    $params = array('post', '%"'.$catid.'"%', 'post');
    return $db->rawQuery($sql, $params);
}

function get_posts_count_by_category($catid){
    global $db;
    $sql = 'SELECT count(*) as total FROM posts WHERE id in (SELECT meta_id from ast_meta_data WHERE meta_of = ? AND meta_value LIKE ?) AND type = ?';
    $params = array('post', '%"'.$catid.'"%', 'post');
    $response = $db->rawQuery($sql, $params);
    if( !empty( $response ) ){
        return $response[0]->total;
    }   
    return 0;
}

if( ! function_exists( "tool_exists" ) ){
    /**
     * Check whether tool exists
     * 
     * @param string $tool_slug
     * 
     * @return boolean
     */
    function tool_exists( $tool_slug ){
        return file_exists( TOOLS_PATH . $tool_slug . "/functions.php" );
    }
}

function get_tool_dynamic_url($toolpath){
    $toolIconPath = TOOLS_PATH . $toolpath . "/cicon.svg";
    if( file_exists( $toolIconPath ) ){
        $isDark = is_dark_theme() ? "-dark" : "";
        return get_site_url("tools/$toolpath/cicon$isDark.svg");
    }
    return get_site_url("assets/icon/tool/$toolpath");
}

function get_tool_icon($id, $path, $html=true, $code=false){
    $url = get_tool_url("slug", $path) . "icon.svg";
    $url = str_replace("/tool/", "/tools/", $url);
    $toolIconPath = TOOLS_PATH . $path . "/icon.svg";
    if( file_exists( TOOLS_PATH . $path . "/icon.webp" ) ){
        $url = str_replace(".svg", ".webp", $url);
    }else if( file_exists( $toolIconPath ) ){
        if( $code ){
            return file_get_contents($toolIconPath);
        }
    }else{
        $url = "";
    }

    if( View::is_admin( ) ){
        $url = "";
    }

    $toolFromDb = get_meta( "tool", $id, "featured_image", "");
    if( ! empty( $toolFromDb ) ){
        $url = $toolFromDb;
    }

    if( $html ){
        return sprintf('<img src="%s" class="tool_icon" alt="%s"/>', $url, $path);
    }

    return $url;
}

/**
 * Redirect URL
 */
function redirect( $location, $status = 302, $redirect_by = "All Smart Tools" ) {

	if ( ! $location ) {
		return false;
	}

	if ( $status < 300 || 399 < $status ) {
		die( 'HTTP redirect status code must be a redirection code, 3xx.' );
	}
    
	if ( is_string( $redirect_by ) ) {
		header( "X-Redirect-By: $redirect_by" );
	}

	header( "Location: $location", true, $status );

	return true;
}

function redirect_invalid_post( $data, $type ){
    $postTypes = array_diff(array("post", "page", "tool"), array($type));
    if( is_object( $data ) && property_exists($data, "type") ){
        if( $data->type == $type ){
            return true;
        }else if( $data->type == 'post' ){
            redirect(get_post_url("slug", $data->slug));
            exit;
        }else if( $data->type == 'tool' ){
            redirect(get_tool_url("slug", $data->slug));
            exit;
        }else if( $data->type == 'page' ){
            redirect(get_page_url("slug", $data->slug));
            exit;
        }
    }

    throw new HttpRouteNotFoundException("Invalid Page!!!");
    return false;
}


/**
 * Get File manager url
 */
function get_file_manager_url( $args = array() ){
    $query = http_build_query( $args );
    if( !empty( $query ) ){
        $query = "?$query";
    }
    return get_admin_url_path( "assets/modules/filemanager/filemanager/dialog.php$query" );
}

/**
 * Get Cookie data
 */
function Cookie(){
    return Cookie::instance();
}

function generate_password( $password, $length = 8 ){
    $passwordHash = new PasswordHash($length, true );
	return $passwordHash->HashPassword( trim( $password ) );
}

function verify_password( $password, $stored_hash, $length = 8 ){
    $passwordHash = new PasswordHash( $length, true );
    return $passwordHash->CheckPassword( $password, $stored_hash );
}

function generate_string($n = 20, $number = false, $capital = false){
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    if( $number ){
        $characters .= "0123456789";
    }

    if( $capital ){
        $characters .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }


    $randomString = '';
 
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
 
    return $randomString;
}

function slug_to_title( $text, $divider="-" ){
    return ucwords(str_replace($divider, " ", $text));;
}


function title_to_slug( $text, $divider="-"){
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, $divider);
    $text = preg_replace('~-+~', $divider, $text);
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

function generate_username_from_email($email){
    if( filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
        $prefix = explode("@", $email);
        return str_replace(array(".", "_", "-"), "", $prefix[0]);
    }
    return false;
}

function update_user($update, $where){
    global $db;

    if( isset( $update['password'] ) ){
        if( empty( $update['password'] ) ){
            unset($update['password']);
        }else{
            $password = trim($update['password']);
            $password_hash = generate_password($password);
            $update['password'] = $password_hash;

            do_action("ast/user/password/change", $where);
        }
    }

    if( $db->update("users", $update, $where) ){

        /**
         * Hook after the on insert post success
         * 
         * @param object $insert
         * @param string $type
         */
        do_action("ast/update/user", $update, $where);

        return true;
    }    
    return $db->getLastError();
}

function insert_user( $insert ){
    global $db;

    if( 
        isset( $insert['email'] ) && !empty( $insert['email'] )
        && isset( $insert['password'] ) && !empty( $insert['password'] )
    ){
        $username = generate_username_from_email($insert['email']);
        if( $username ){
            $db->where("(`email` = ?)", array(trim($insert['email'])));
            $results = $db->get("users", 1);
            if( is_array($results) && count( $results ) > 0 ){
                return array(
                    "success" => false,
                    "message" => "User with this EMAIL already exists!!!"
                );
            }

            $password = trim($insert['password']);
            $password_hash = generate_password($password);
            $newInsertArgs = $insert;
            $newInsertArgs['password'] = $password_hash;
            $newInsertArgs['username'] = $username;

            if( ! isset( $insert['role'] ) )
                $newInsertArgs['role'] = "subscriber";
            
            if( ! isset( $insert['status'] ) ){
                $newInsertArgs['status'] = "pending";
            }

            $newInsertArgs['date'] = date("Y-m-d H:i:s");

            /**
             * Hook before inserting post
             * 
             * @param object $insert
             * @param string $type
             */
            do_action("ast/insert/user/before", $newInsertArgs, $insert);
            
            $insertID = $db->insert("users", $newInsertArgs);
            if( is_numeric( $insertID ) ){

                /**
                 * Hook after the on insert post success
                 * 
                 * @param object $insert
                 * @param string $type
                 */
                do_action("ast/insert/user", $insertID, $insert, $newInsertArgs);

                return array(
                    "success" => true,
                    "message" => "User Added Successfully!!!",
                    "userid" => intval($insertID)
                );
            }

            /**
             * Hook after the on insert post error
             * 
             * @param object $insert
             * @param string $type
             * @param string $error
             */
            do_action("ast/insert/user/error", $insert, $db->getLastError());
            return array(
                "success" => false,
                "message" => $db->getLastError()
            );
        }
    }
    return false;
}

function increasePostViews($toolid, $views){
    $views = intval($views) + 1;
    update_post(array(
        "views" => $views
    ), array(
        "id" => $toolid
    ));
}

function update_post( $update, $where ){
    global $db;
    if( $db->update("posts", $update, $where) ){

        /**
         * Hook after the on insert post success
         * 
         * @param object $insert
         * @param string $type
         */
        do_action("ast/update/post", $update, $where);

        return true;
    }    
    return $db->getLastError();
}

function insert_post( $insert, $type = "post" ){
    global $db;

    if( isset( $insert['slug'] ) && !empty( $insert['slug'] ) ){
        $db->where("(`slug` = ? AND `type` = ?)", array(trim($insert['slug']), $type));
        $results = $db->get("posts", 1);
        if( is_array($results) && count( $results ) > 0 ){
            return array(
                "success" => false,
                "code" => 401,
                "message" => "Post with this TITLE already exists!!!"
            );
        }
        
        $insert = $db->insert("posts", $insert);
        if( is_numeric( $insert ) ){

            /**
             * Hook after the on insert post success
             * 
             * @param object $insert
             * @param string $type
             */
            do_action("ast/insert/post", $insert, $type);

            return array(
                "success" => true,
                "message" => "Post Inserted",
                "code" => 200,
                "postid" => intval($insert)
            );
        }

        /**
         * Hook after the on insert post error
         * 
         * @param object $insert
         * @param string $type
         * @param string $error
         */
        do_action("ast/insert/post/error", $insert, $type, $db->getLastError());
        return array(
            "success" => false,            
            "code" => 400,
            "message" => $db->getLastError()
        );
    }
    return false;
}

function delete_meta( $metaof, $metaid, $metakey ){
    global $db;
    if( get_meta( $metaof, $metaid, $metakey ) ){
        return $db->delete("meta_data", array(
            "meta_of" => $metaof,
            "meta_id" => $metaid,
            "meta_key" => $metakey
        ));
    }
    return true;
}

function update_meta( $metaof, $metaid, $metakey, $metavalue ){
    global $db;

    $db->where("(`meta_of` = ? AND `meta_id` = ? AND `meta_key` = ?)", array($metaof, $metaid, $metakey));
    $results = $db->get("meta_data", 1);
    if( is_array($results) && count( $results ) > 0 ){
        return $db->update("meta_data", array(
            "meta_value" => maybe_serialize($metavalue)
        ), array(
            "id" => $results[0]->id
        ));
    }

    $insert = $db->insert("meta_data", array(
        "meta_of" => $metaof,
        "meta_id" => $metaid,
        "meta_key" => $metakey,
        "meta_value" => maybe_serialize($metavalue)
    ));

    if( is_numeric( $insert ) ){

        /**
         * Hook after the on insert post success
         * 
         * @param object $insert
         * @param string $type
         */
        do_action("ast/update/meta", $metaof, $metaid, $metakey, $metavalue);

        return intval($insert);
    }
    return $db->getLastError();
}

function get_all_meta($metaof, $metaid){
    global $db;

    $db->where("(`meta_of` = ? AND `meta_id` = ?)", array($metaof, $metaid));
    $results = $db->objectBuilder()->get("meta_data");
    if( ! empty($results) ){
        $output = array();
        foreach($results as $r){
            $output[$r->meta_key] = $r->meta_value;
        }
        return (object) $output;
    }

    return false;
}

function get_meta( $metaof, $metaid, $metakey, $default = false ){
    global $db;

    $db->where("(`meta_of` = ? AND `meta_id` = ? AND `meta_key` = ?)", array($metaof, $metaid, $metakey));
    $results = $db->objectBuilder()->get("meta_data", 1);
    if( !empty($results) ){
        return maybe_unserialize($results[0]->meta_value);
    }

    return $default;
}

function get_tool_setting( $tool, $key="slug" ){
    global $db;
    $db->where("`type` = ? AND `$key` = ?", array("tool", $tool));
    $results = $db->get("posts", 1);

    $settings = "{}";
    if( $results && !empty( $results ) && count($results) > 0 ){
        $result = $results[0];
        if( is_array( $result ) ){
            $result = (object) $result;
        }

        $settings = get_meta("tool", $result->id, "settings", "{}");
    }

    $defaultsettings = apply_filters( "ast_default_settings-{$result->slug}", array() );
    return (object) array_merge($defaultsettings, json_decode($settings, true));
}

function get_post_status_html( $status ){

    $statuscolor = "secondary";
    switch($status){
        case 'active':
            $statuscolor = "success";
            break;

        case 'pending':
            $statuscolor = "warning";
            break;

        case 'draft':
        default:
            $statuscolor = "secondary";
            break;
    }
    return sprintf('<span class="badge badge-%s">%s</span>', $statuscolor, ucfirst($status));
}


function get_image_picker_container( $image = false, $id = "featured_image", $label = "Featured Image" ){
    
    $pickerID = str_replace(array("[", "]"), "_", $id);
    $imagepickerurl = get_file_manager_url(array(
        "field_id" => $pickerID . "_url"
    ));
    if( empty( $image ) ){
        return sprintf('<div class="from-group %s_container image_picker_container mt-3">
            <label>%s</label>
            <input type="text" id="%s_url" name="%s" style="display:none;">
            <div class="empty_placeholder">
                <a href="%s" class="select_%s_url openImagePicker">Select Image</a>
            </div>
        </div>', $pickerID, $label, $pickerID, $id, $imagepickerurl, $pickerID);
    }

    return sprintf('<div class="from-group %s_container image_picker_container mt-3 added">
        <label>%s</label>
        <input type="text" id="%s_url" name="%s" value="%s" style="display:none;">
        <div class="empty_placeholder">
            <a href="%s" class="select_%s_url openImagePicker">Select Image</a>
        </div>
        <div class="image_fill_placeholder">
            <i class="las la-times"></i>
            <img src="%s" alt="PreView Image">
        </div>
    </div>', $pickerID, $label, $pickerID, $id, $image, $imagepickerurl, $pickerID, $image);
}

function is_error( $error ){
    if( $error instanceof Exception ){
        return true;
    }else if( $error instanceof Throwable ){
        return true;
    }
    return false;
}

function save_tool_report($tool, $input, $output, $extra="", $hashvalue=""){
    global $db;
    $extra = maybe_serialize($extra);

    try {
        $insertID =  $db->insert("report", array(
            "tool" => $tool,
            "input" => $input,
            "output" => $output,
            "extra" => $extra,
            "hashvalue" => $hashvalue,
            "date" => date("Y-m-d h:i:s")
        ));

        return intval($insertID);
    } catch (Throwable $th) {
        return $th->getMessage();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function get_tool_asset_url( $by = "slug", $value ){
    if( $by == 'slug' ){
        return get_site_url("tools/$value/");
    }else if( $by == 'id' ){
        try {
            global $db;
            $result = $db->select("posts", [], array(
                "type" => "tool",
                $by => $value
            ));
            if( !empty( $result ) ){
                $result = $result[0];
                if( is_array( $result ) ){
                    $result = (object) $result;
                }

                return get_site_url("tools/{$result->slug}/");
            }
        } catch (Throwable $th)  {
        } catch (Exception $e) { }
    }
    return false;
}


if( ! function_exists( "get_category_url" ) ){
    /**
     * Get category URL
     * 
     * @param string $by
     * @param string $value
     * @param string $type [tool | blog]
     * 
     * @return string
     */
    function get_category_url( $by="slug", $value, $type="tool" ){
        $toolcaturl = parse_route_constants($type == "tool" ? "toolcat" : "blogcat");
        if( $by == 'slug' ){
            return get_site_url("$toolcaturl/$value/");
        }else if( $by == 'id' ){
            try {
                global $db;
                $result = $db->select("category", [], array(
                    "cat_of" => $type,
                    $by => $value
                ));
                if( !empty( $result ) ){
                    $result = $result[0];
                    if( is_array( $result ) ){
                        $result = (object) $result;
                    }
    
                    return get_site_url("$toolcaturl/{$result->slug}/");
                }
            } catch (Throwable $th)  {
            } catch (Exception $e) { }
        }
        return false;
    }
}

if( ! function_exists( "get_tool_category_url" ) ){
    /**
     * Get tool category url
     * 
     * @param string $by
     * @param string $value
     * 
     * @return string
     */
    function get_tool_category_url($by="slug", $value){
        return get_category_url($by, $value, "tool");
    }
}

if( ! function_exists( "get_blog_category_url" ) ){
    /**
     * Get tool category url
     * 
     * @param string $by
     * @param string $value
     * 
     * @return string
     */
    function get_blog_category_url($by="slug", $value){
        return get_category_url($by, $value, "blog");
    }
}

if( ! function_exists( "get_tool_category" ) ){
    /**
     * Get tool category
     * 
     * @param integer $toolid
     * 
     * @return string
     */
    function get_tool_category($postid){
        return get_meta("tool", $postid, "category");
    }
}

if( ! function_exists( "get_category_url_by_tool" ) ){
    /**
     * Get category url by toolid
     * 
     * @param string $by
     * @param string $value
     * 
     * @return string
     */
    function get_category_url_by_tool($id){
        $cats = get_tool_category($id);
        if( ! empty( $cats ) ){
            return get_tool_category_url("id", $cats[0]);
        }
        return false;
    }
}

function get_unknown_post_url($id){
    global $db;

    $db->where("id", $id);
    $result = $db->getOne("posts");
    if( !empty( $result ) ){
        
        if( $result->type == 'post' ){
            return get_post_url("slug", $result->slug);
        }else if( $result->type == 'tool' ){
            return get_tool_url("slug", $result->slug);
        }
        
    }

    return false;
}

function get_page_url( $by = "slug", $value ){
    return get_post_type_url($by, $value, "page");
}

function get_post_url( $by = "slug", $value ){
    return get_post_type_url($by, $value, "post");
}

function get_tool_url( $by = "slug", $value ){
    return get_post_type_url($by, $value, "tool");
}

function get_post_type_url( $by = "slug", $value, $type = "post" ){
    $routeType = $type == 'post' ? 'blog' : $type;
    $singleurlpart = parse_route_constants($routeType);
    if( $by == 'slug' ){
        return get_site_url("$singleurlpart/$value/");
    }else if(!empty($by)){
        try {
            global $db;
            $result = $db->select("posts", [], array(
                "type" => $type,
                $by => $value
            ));
            if( !empty( $result ) ){
                $result = $result[0];
                if( is_array( $result ) ){
                    $result = (object) $result;
                }

                return get_site_url("$singleurlpart/{$result->slug}/");
            }
        } catch (Throwable $th)  {
        } catch (Exception $e) { }
    }
    return false;
}

function getRequestWithContent($url, $headers=array("Accept: text/plain")){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_AUTOREFERER,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0');
	
    if( ! empty( $headers ) ){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    
	$html = curl_exec($ch);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return array(
        "url" => $url,
        "content" => $html,
        "type" => $contentType,
        "response" => $httpcode
    );
}


function getRequest($url, $header=true){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER,0); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_AUTOREFERER,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0');
	
    if( $header )
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ("Accept: text/plain"));

	$html=curl_exec($ch);
    curl_close($ch);
    return $html;
}

function getSimpleRequest($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_ENCODING, 0);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST , "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $data = curl_exec($ch);
    $info = curl_getinfo($ch);
    if(curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    curl_close($ch);
    if ($data === FALSE) {
        throw new Exception("Content is Empty. Info follows:\n" . print_r($info, TRUE));
    }
    return $data;
}


function getIPAddress() { 
    $ip = false;
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}

function get_domain_from_url($url){
    try {
        $urlparts = parse_url($url);
        return $urlparts['host'];
    } catch (Throwable $th) {
        $regexp = '/.*\/\/([^\/:]+).*/';
        return preg_replace($regexp, '$1', $url);   
    }
}

function getCenterText($str1,$str2,$data){
    $data = explode($str1, $data);
    if( isset( $data[1] ) ){
        $data = explode($str2, $data[1]);
        return trim($data[0]);
    }
    return false;
}

/**
 * Validate URL
 *
 * @param string $url url to encode
 *
 * @return validated url
 */
function validateUrl($url){
    if ($url) {
        $trim = trim($url);
        if (strlen($trim) >= 2) {
            $url = strpos($trim, 'http') !== 0 ? 'http://'.$trim : $trim;
            return urldecode($url);
            }
        }
    return false;
}

if( ! function_exists( "ast_mail" ) ){
    function ast_mail( $to, $subject, $message, $headers = '', $attachments = array() ) {

        /**
         * Filters the ast_mail() arguments.
         *
         * @since 2.2.0
         *
         * @param array $args {
         *     Array of the `ast_mail()` arguments.
         *
         *     @type string|string[] $to          Array or comma-separated list of email addresses to send message.
         *     @type string          $subject     Email subject.
         *     @type string          $message     Message contents.
         *     @type string|string[] $headers     Additional headers.
         *     @type string|string[] $attachments Paths to files to attach.
         * }
         */
        $atts = apply_filters( 'ast_mail', compact( 'to', 'subject', 'message', 'headers', 'attachments' ));
    
        /**
         * Filters whether to preempt sending an email.
         *
         * Returning a non-null value will short-circuit {@see ast_mail()}, returning
         * that value instead. A boolean return value should be used to indicate whether
         * the email was successfully sent.
         *
         * @since 5.7.0
         *
         * @param null|bool $return Short-circuit return value.
         * @param array     $atts {
         *     Array of the `ast_mail()` arguments.
         *
         *     @type string|string[] $to          Array or comma-separated list of email addresses to send message.
         *     @type string          $subject     Email subject.
         *     @type string          $message     Message contents.
         *     @type string|string[] $headers     Additional headers.
         *     @type string|string[] $attachments Paths to files to attach.
         * }
         */
        $pre_ast_mail = apply_filters( 'pre_ast_mail', null, $atts );
    
        if ( null !== $pre_ast_mail ) {
            return $pre_ast_mail;
        }
    
        if ( isset( $atts['to'] ) ) {
            $to = $atts['to'];
        }
    
        if ( ! is_array( $to ) ) {
            $to = explode( ',', $to );
        }
    
        if ( isset( $atts['subject'] ) ) {
            $subject = $atts['subject'];
        }
    
        if ( isset( $atts['message'] ) ) {
            $message = $atts['message'];
        }
    
        if ( isset( $atts['headers'] ) ) {
            $headers = $atts['headers'];
        }
    
        if ( isset( $atts['attachments'] ) ) {
            $attachments = $atts['attachments'];
        }
    
        if ( ! is_array( $attachments ) ) {
            $attachments = explode( "\n", str_replace( "\r\n", "\n", $attachments ) );
        }
    
        global $phpmailer;
    
        // (Re)create it, if it's gone missing.
        if ( ! ( $phpmailer instanceof PHPMailer ) ) {
            $phpmailer = new PHPMailer( true );
            $phpmailer::$validator = static function ( $email ) {
                return (bool) filter_var( $email, FILTER_VALIDATE_BOOLEAN );
            };
        }
    
        // Headers.
        $cc       = array();
        $bcc      = array();
        $reply_to = array();
    
        if ( empty( $headers ) ) {
            $headers = array();
        } else {
            $tempheaders = $headers;
            if ( ! is_array( $headers ) ) {
                // Explode the headers out, so this function can take
                // both string headers and an array of headers.
                $tempheaders = explode( "\n", str_replace( "\r\n", "\n", $headers ) );
            }
            $headers = array();
    
            // If it's actually got contents.
            if ( ! empty( $tempheaders ) ) {
                // Iterate through the raw headers.
                foreach ( (array) $tempheaders as $header ) {
                    if ( strpos( $header, ':' ) === false ) {
                        if ( false !== stripos( $header, 'boundary=' ) ) {
                            $parts    = preg_split( '/boundary=/i', trim( $header ) );
                            $boundary = trim( str_replace( array( "'", '"' ), '', $parts[1] ) );
                        }
                        continue;
                    }
                    // Explode them out.
                    list( $name, $content ) = explode( ':', trim( $header ), 2 );
    
                    // Cleanup crew.
                    $name    = trim( $name );
                    $content = trim( $content );
    
                    switch ( strtolower( $name ) ) {
                        // Mainly for legacy -- process a "From:" header if it's there.
                        case 'from':
                            $bracket_pos = strpos( $content, '<' );
                            if ( false !== $bracket_pos ) {
                                // Text before the bracketed email is the "From" name.
                                if ( $bracket_pos > 0 ) {
                                    $from_name = substr( $content, 0, $bracket_pos );
                                    $from_name = str_replace( '"', '', $from_name );
                                    $from_name = trim( $from_name );
                                }
    
                                $from_email = substr( $content, $bracket_pos + 1 );
                                $from_email = str_replace( '>', '', $from_email );
                                $from_email = trim( $from_email );
    
                                // Avoid setting an empty $from_email.
                            } elseif ( '' !== trim( $content ) ) {
                                $from_email = trim( $content );
                            }
                            break;
                        case 'content-type':
                            if ( strpos( $content, ';' ) !== false ) {
                                list( $type, $charset_content ) = explode( ';', $content );
                                $content_type                   = trim( $type );
                                if ( false !== stripos( $charset_content, 'charset=' ) ) {
                                    $charset = trim( str_replace( array( 'charset=', '"' ), '', $charset_content ) );
                                } elseif ( false !== stripos( $charset_content, 'boundary=' ) ) {
                                    $boundary = trim( str_replace( array( 'BOUNDARY=', 'boundary=', '"' ), '', $charset_content ) );
                                    $charset  = '';
                                }
    
                                // Avoid setting an empty $content_type.
                            } elseif ( '' !== trim( $content ) ) {
                                $content_type = trim( $content );
                            }
                            break;
                        case 'cc':
                            $cc = array_merge( (array) $cc, explode( ',', $content ) );
                            break;
                        case 'bcc':
                            $bcc = array_merge( (array) $bcc, explode( ',', $content ) );
                            break;
                        case 'reply-to':
                            $reply_to = array_merge( (array) $reply_to, explode( ',', $content ) );
                            break;
                        default:
                            // Add it to our grand headers array.
                            $headers[ trim( $name ) ] = trim( $content );
                            break;
                    }
                }
            }
        }
    
        // Empty out the values that may be set.
        $phpmailer->clearAllRecipients();
        $phpmailer->clearAttachments();
        $phpmailer->clearCustomHeaders();
        $phpmailer->clearReplyTos();
        $phpmailer->Body    = '';
        $phpmailer->AltBody = '';
    
        // If we don't have a name from the input headers.
        if ( ! isset( $from_name ) ) {
            $from_name = 'All Smart Tools';
        }
    
        /*
         * If we don't have an email from the input headers, default to ast@$sitename
         * Some hosts will block outgoing mail from this address if it doesn't exist,
         * but there's no easy alternative. Defaulting to admin_email might appear to be
         * another option, but some hosts may refuse to relay mail from an unknown domain.
         */
        if ( ! isset( $from_email ) ) {
            // Get the site domain and get rid of www.
            $sitename   = parse_url( get_site_url(), PHP_URL_HOST );
            $from_email = 'no-reply@';
    
            if ( null !== $sitename ) {
                if ( 'www.' === substr( $sitename, 0, 4 ) ) {
                    $sitename = substr( $sitename, 4 );
                }
    
                $from_email .= $sitename;
            }
        }
    
        /**
         * Filters the email address to send from.
         *
         * @since 2.2.0
         *
         * @param string $from_email Email address to send from.
         */
        $from_email = apply_filters( 'ast_mail_from', $from_email );
    
        /**
         * Filters the name to associate with the "from" email address.
         *
         * @since 2.3.0
         *
         * @param string $from_name Name associated with the "from" email address.
         */
        $from_name = apply_filters( 'ast_mail_from_name', $from_name );
    
        try {
            $phpmailer->setFrom( $from_email, $from_name, false );
        } catch ( PHPMailerException $e ) {
            $mail_error_data = compact( 'to', 'subject', 'message', 'headers', 'attachments' );
            $mail_error_data['phpmailer_exception_code'] = $e->getCode();
    
            /** This filter is documented in wp-includes/pluggable.php */
            do_action( 'ast_mail_failed', array(
                "error" => array(
                    "code" => $e->getCode(),
                    "message" => $e->getMessage()
                ),
                "data" => $mail_error_data
            ));
    
            return false;
        }
    
        // Set mail's subject and body.
        $phpmailer->Subject = $subject;
        $phpmailer->Body    = $message;
    
        // Set destination addresses, using appropriate methods for handling addresses.
        $address_headers = compact( 'to', 'cc', 'bcc', 'reply_to' );
    
        foreach ( $address_headers as $address_header => $addresses ) {
            if ( empty( $addresses ) ) {
                continue;
            }
    
            foreach ( (array) $addresses as $address ) {
                try {
                    // Break $recipient into name and address parts if in the format "Foo <bar@baz.com>".
                    $recipient_name = '';
    
                    if ( preg_match( '/(.*)<(.+)>/', $address, $matches ) ) {
                        if ( count( $matches ) == 3 ) {
                            $recipient_name = $matches[1];
                            $address        = $matches[2];
                        }
                    }
    
                    switch ( $address_header ) {
                        case 'to':
                            $phpmailer->addAddress( $address, $recipient_name );
                            break;
                        case 'cc':
                            $phpmailer->addCc( $address, $recipient_name );
                            break;
                        case 'bcc':
                            $phpmailer->addBcc( $address, $recipient_name );
                            break;
                        case 'reply_to':
                            $phpmailer->addReplyTo( $address, $recipient_name );
                            break;
                    }
                } catch ( PHPMailerException $e ) {
                    continue;
                }
            }
        }
    
        // Set to use PHP's mail().
        $phpmailer->isMail();
    
        // Set Content-Type and charset.
    
        // If we don't have a content-type from the input headers.
        if ( ! isset( $content_type ) ) {
            $content_type = 'text/plain';
        }
    
        /**
         * Filters the ast_mail() content type.
         *
         * @since 2.3.0
         *
         * @param string $content_type Default ast_mail() content type.
         */
        $content_type = apply_filters( 'ast_mail_content_type', $content_type );
        $phpmailer->ContentType = $content_type;
    
        // Set whether it's plaintext, depending on $content_type.
        if ( 'text/html' === $content_type ) {
            $phpmailer->isHTML( true );
        }
    
        // Set custom headers.
        if ( ! empty( $headers ) ) {
            foreach ( (array) $headers as $name => $content ) {
                // Only add custom headers not added automatically by PHPMailer.
                if ( ! in_array( $name, array( 'MIME-Version', 'X-Mailer' ), true ) ) {
                    try {
                        $phpmailer->addCustomHeader( sprintf( '%1$s: %2$s', $name, $content ) );
                    } catch ( PHPMailerException $e ) {
                        continue;
                    }
                }
            }
    
            if ( false !== stripos( $content_type, 'multipart' ) && ! empty( $boundary ) ) {
                $phpmailer->addCustomHeader( sprintf( 'Content-Type: %s; boundary="%s"', $content_type, $boundary ) );
            }
        }
    
        if ( ! empty( $attachments ) ) {
            foreach ( $attachments as $attachment ) {
                try {
                    $phpmailer->addAttachment( $attachment );
                } catch ( PHPMailerException $e ) {
                    continue;
                }
            }
        }
    
        /**
         * Fires after PHPMailer is initialized.
         *
         * @since 2.2.0
         *
         * @param PHPMailer $phpmailer The PHPMailer instance (passed by reference).
         */
        do_action_ref_array( 'phpmailer_init', array( &$phpmailer ) );
    
        $mail_data = compact( 'to', 'subject', 'message', 'headers', 'attachments' );
    
        // Send!
        try {
            $send = $phpmailer->send();
    
            /**
             * Fires after PHPMailer has successfully sent an email.
             *
             * The firing of this action does not necessarily mean that the recipient(s) received the
             * email successfully. It only means that the `send` method above was able to
             * process the request without any errors.
             *
             * @since 5.9.0
             *
             * @param array $mail_data {
             *     An array containing the email recipient(s), subject, message, headers, and attachments.
             *
             *     @type string[] $to          Email addresses to send message.
             *     @type string   $subject     Email subject.
             *     @type string   $message     Message contents.
             *     @type string[] $headers     Additional headers.
             *     @type string[] $attachments Paths to files to attach.
             * }
             */
            do_action( 'ast_mail_succeeded', $mail_data );
    
            return $send;
        } catch ( PHPMailerException $e ) {
            /**
             * Fires after a PHPMailerException is caught.
             *
             * @since 1.0
             */
            do_action( 'ast_mail_failed', array(
                "error" => array(
                    "code" => $e->getCode(),
                    "message" => $e->getMessage()
                ),
                "data" => $mail_data
            ) );
    
            return false;
        }
    
    }
}


function get_mail_template( $args = array() ){

    $defaults = array(
        "buttons" => array(),
        "footer" => "",
        "name" => "",
        "title" => "",
        "message" => "",
        "include_title" => false,
        "after_message" => ""
    );

    $site_title = "";
    $settings =  get_settings("basic");
    if( $settings ){
        $defaults['footer'] = $settings->name . "'s Team";

        if( isset($args['include_title']) && filter_var($args['include_title'], FILTER_VALIDATE_BOOLEAN) && isset($args['title'])){
            $args['title'] = $args['title'] . " - " . $settings->name;
        }

        $site_title = $settings->name;
    }

    $args = array_merge($defaults, $args);
    if( filter_var($args['name'], FILTER_VALIDATE_EMAIL) ){
        $emailpart = @trim(explode("@", $args['name'])[0]);
        if( !empty( $emailpart ) ){
            $args['name'] = $emailpart;
        }
    }else if ($args['name'] == trim($args['name']) && strpos($args['name'], ' ') !== false) {
        $namepart = @trim(explode(" ", $args['name'])[0]);
        if( !empty( $namepart ) ){
            $args['name'] = $namepart;
        }
    }

    extract($args);

    ob_start();
    include ASTROOTPATH . "app/mail/template.php";
    $template = ob_get_clean();

    return apply_filters( "ast/mail/template", $template, $args );

}


function send_user_password_reset_link($userID){
    $user = get_user($userID);
    
    if( $user ){
        $activationCode = generate_string(30);
        $activationlink = get_site_url() . sprintf("/auth/change/reset-password/%s/", $activationCode);

        if( update_meta("user", $user->id, "user_reset_password_key", $activationCode) ){
            $title = "Reset Your Password";
            $messageHTML = '<p>Trouble signing in?</p><p>Resetting your password is easy.</p><p>Just press the button below and follow the instructions. We’ll have you up and running in no time.</p>';
            $afterButtonMessage = sprintf('<p>OR, You can reset your password by clicking the link below:</p><p><a href="%s">%s</a></p><p>If you did not make this request then please ignore this email.</p>', $activationlink, $activationlink);
            
            $template_message = get_mail_template(array(
                "name" => $user->name,
                "buttons" => array(
                    array(
                        "link" => $activationlink,
                        "text" => "Reset Password"
                    )
                ),
                "title" => $title,
                "include_title" => true,
                "message" => $messageHTML,
                "after_message" => $afterButtonMessage
            ));

            if( ast_mail($user->email, $title, $template_message) ){
                return array(
                    "success" => true,
                    "message" => "Reset Password Sent Successfully!!!"
                );
            }else{
                return array(
                    "success" => false,
                    "message" => "Unable to send reset password link!!!"
                );
            }
        }
        
        return array(
            "success" => false,
            "message" => "Unable to update activation code!!!"
        );
    }
    
    return array(
        "success" => false,
        "message" => "User with this email doesn't exists!!!"
    );
}


function send_user_email_activation($userID){
    $user = get_user($userID);
    if( $user ){
        $activationCode = generate_string(30);
        $activationlink = get_site_url() . sprintf("/auth/change/verify-email/%s/", $activationCode);

        if( update_meta("user", $user->id, "user_email_activation_key", $activationCode) ){
            $title = "Verify Your Email Address";
            $messageHTML = '<p>Thanks for signup.Now, there is one step remaining to use our website.</p><p>Just press the button below and follow the instructions. We’ll have you up and running in no time.</p>';
            $afterButtonMessage = sprintf('<p>OR, You can verify your email by clicking the link below:</p><p><a href="%s">%s</a></p><p>If you did not make this request then please ignore this email.</p>', $activationlink, $activationlink);
            
            $template_message = get_mail_template(array(
                "name" => $user->name,
                "buttons" => array(
                    array(
                        "link" => $activationlink,
                        "text" => "Verfy Email Address"
                    )
                ),
                "title" => $title,
                "include_title" => true,
                "message" => $messageHTML,
                "after_message" => $afterButtonMessage
            ));

            if( ast_mail($user->email, $title, $template_message) ){
                return array(
                    "success" => true,
                    "message" => "Email Activation Link Sent Successfully!!!"
                );
            }else{
                return array(
                    "success" => false,
                    "message" => "Unable to send Email Activation Link!!!"
                );
            }
        }
        
        return array(
            "success" => false,
            "message" => "Unable to update activation code!!!"
        );
    }
    
    return array(
        "success" => false,
        "message" => "Unable to get user information!!!"
    );
}

function menu_single_template($data, $count){
    if( is_array($data) && !empty( $data ) ){
        return '<div class="menuDiv">
            <span class="disclose ui-icon ui-icon-minusthick"><span></span></span>
            <span data-id="'.$count.'" class="expandEditor ui-icon ui-icon-triangle-1-s"><span></span></span>
            <span>
                <span data-id="'.$count.'" class="itemTitle">'.$data["title"].'</span>
                <span data-id="'.$count.'" class="deleteMenu ui-icon ui-icon-closethick"><span></span></span>
            </span>
            <div id="menuEdit'.$count.'" class="menuEdit hidden" style="display:none;">
                <div class="p-2">
                    <div class="form-group mb-2">
                        <label>Title</label>
                        <input type="text" value="'.$data["title"].'" class="title form-control">
                    </div>

                    <div class="form-group mb-0">
                        <label>Link</label>
                        <input type="text" value="'.$data["link"].'" class="link form-control">
                    </div>
                </div>
            </div>
        </div>';
    }
}

function render_menu_template( $menu, $count ){
    if( is_array($menu) && !empty($menu) ){
        foreach($menu as $k => $menu){
            if( isset( $menu['child'] ) && is_array($menu['child']) ){
                echo sprintf('<li style="display: list-item;" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded" id="menuItem_%s">', $count);
                echo menu_single_template($menu, $count);
                $count++;
                
                echo '<ol>';
                render_menu_template($menu['child'], $count);
                echo '</ol>';
    
                echo '</li>';
                $count++;
                $count++;
            }else{
                echo sprintf('<li class="mjs-nestedSortable-leaf" id="menuItem_%s">', $count);
                echo menu_single_template($menu, $count);
                echo '</li>';
            }
            $count++;
        }
    }
}

function render_menu_template_front_mobile($menus){
    if( empty( $menus ) ) return false;
    
    foreach($menus as $k => $menu){
        if( isset( $menu['child'] ) && is_array($menu['child']) ){
            echo sprintf('<li class="menu-item-has-children"><a href="%s">%s</a><ul class="sub-menu">', $menu['link'], $menu['title']);

            foreach($menu['child'] as $k => $m){
                echo sprintf('<li><a href="%s">%s</a></li>', $m['link'], $m['title']);
            }
            
            echo '</ul><div class="dropdown-btn"><span class="plus-line"></span></div></li>';
        }else{
            echo sprintf('<li><a href="%s">%s</a></li>', $menu['link'], $menu['title']);
        }
    }
}

function render_menu_template_front($menus){
    if( empty( $menus ) ) return false;

    foreach($menus as $k => $menu){
        if( isset( $menu['child'] ) && is_array($menu['child']) ){
            echo sprintf('<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="%s">%s</a><div class="dropdown-menu">', $menu['link'], $menu['title']);

            foreach($menu['child'] as $k => $m){
                echo sprintf('<a class="dropdown-item" href="%s">%s</a>', $m['link'], $m['title']);
            }
            
            echo '</div></li>';
        }else{
            echo sprintf('<li class="nav-item">
                <a class="nav-link" href="%s">%s</a>
            </li>', $menu['link'], $menu['title']);
        }
    }
}


function get_logout_url( $redirect = false ){
    $url = get_site_url() . "logout.php";
    if( $redirect ){
        $url .= "?redirect_url=" . (is_string($redirect) ? $redirect : get_redirect_url());
    }

    return $url;
}

function get_avatar_url( $id = false ){
    if( empty( $id ) ){
        $id = get_current_id();
    }
    $defaultURL = get_admin_path() . "assets/img/user.png";
    return get_meta("user", $id, "featured_image", $defaultURL);
}

function get_roles(){
    return Users::instance()->roles;
}

function get_user_status(){
    return Users::instance()->status;
}

function get_post_featured_image( $toolid, $type="post", $template=false ){
    $image = get_meta($type, $toolid, "featured_image");
    if( empty( $image ) && $template ){
        global $websiteinfo;
        if( ! empty( @$websiteinfo->featured_image ) ){
            return $websiteinfo->featured_image;
        }
    }
    return $image;
}

function get_post_status(){
    $status = array(
        "active",
        "pending",
        "draft"
    );

    return apply_filters("ast/post/status/", $status);
}

if( ! function_exists( "animate_placeholder" ) ){
    /**
     * Get animate placeholder html
     */
    function animate_placeholder(){
        echo '<div class="animate_placeholder"></div>';
    }
}

if( ! function_exists( "curl_options" ) ){
    function curl_options( $url=false, $header=array() ){

        $userAgent = isset($header["User-Agent"]) ? trim($header["User-Agent"]) : AST_UA;

        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_USERAGENT => $userAgent,
            CURLOPT_REFERER => "",
            CURLOPT_HTTPHEADER => array(
                "User-Agent: $userAgent"
            )
        );

        if( !empty( $url ) )
            $options[CURLOPT_URL] = $url;

        if( ! empty( $header ) ){
            $headers = array(
                "User-Agent: $userAgent"
            );
            foreach( $header as $k => $v ){
                $headers[] = "$k: $v";
            }
            $options[CURLOPT_HTTPHEADER] = $headers;
        }

        return $options;
    }
}

function get_file_size_by_header( $url ){
    $headers = get_headers($url, true);
    if( isset( $headers["Content-Length"] ) ){
        return intval($headers["Content-Length"]);
    }
    return -1;
}

function get_file_size_by_curl( $url ){
    $size = 0;
    $ch = curl_init();

    $curlOptions = curl_options($url);
    $curlOptions[CURLOPT_IPRESOLVE] = CURL_IPRESOLVE_V4;
    $curlOptions[CURLOPT_NOBODY] = TRUE;

    curl_setopt_array($ch, $curlOptions);
    curl_exec($ch);
    
    if (curl_errno($ch) == 0) {
        $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    }
    curl_close($ch);
    return $size;
}

function get_file_size($url, $format=false, $minlen=10) {
    $size = get_file_size_by_curl($url);
    if( $minlen >= $size ){
        $size = get_file_size_by_header($url);
    }
    
    return $format ? format_size($size) : $size;
}


function formatBitsPerseconds($bytes){
    if ($bytes >= 1073741824){
        $bytes = number_format($bytes / 1073741824) . ' GBPS';
    }elseif ($bytes >= 1048576){
        $bytes = number_format($bytes / 1048576) . ' MBPS';
    }elseif ($bytes >= 1024){
        $bytes = number_format($bytes / 1024) . ' KBPS';
    }elseif ($bytes > 1){
        $bytes = $bytes . ' BPS';
    }elseif ($bytes == 1){
        $bytes = $bytes . ' BPS';
    }else{
        $bytes = '0 BPS';
    }

    return $bytes;
}

function format_size_number($bytes){
    if( (float) $bytes > 0 ){
        if ($bytes >= 1073741824){
            $bytes = round($bytes / 1073741824, 2);
        }elseif ($bytes >= 1048576){
            $bytes = round($bytes / 1048576, 2);
        }elseif ($bytes >= 1024){
            $bytes = round($bytes / 1024, 2);
        }elseif ($bytes >= 1){
            $bytes = $bytes;
        }else{
            $bytes = 0;
        }
    
        return $bytes;
    }

    return 0;
}

function format_size($bytes, $round=2){
    if( (float) $bytes > 0 ){
        if ($bytes >= 1073741824){
            $bytes = number_format($bytes / 1073741824, $round) . ' GB';
        }elseif ($bytes >= 1048576){
            $bytes = number_format($bytes / 1048576, $round) . ' MB';
        }elseif ($bytes >= 1024){
            $bytes = number_format($bytes / 1024, $round) . ' KB';
        }elseif ($bytes > 1){
            $bytes = $bytes . ' bytes';
        }elseif ($bytes == 1){
            $bytes = $bytes . ' byte';
        }else{
            $bytes = '0 bytes';
        }
    
        return $bytes;
    }

    return "Unknown";
}

if( ! function_exists( "get_drag_and_drop_field" ) ){
    function get_drag_and_drop_field($params=array()){

        $supports = "ANY";
        if( isset( $params['supports'] ) ){
            $supports = $params['supports'];
        }

        $titles = "Drop your files here";
        if( isset( $params['titles'] ) ){
            $titles = $params['titles'];
        }

        $icon = "las la-image";
        if( isset( $params['icon'] ) ){
            $icon = $params['icon'];
        }

        $accepts = "";
        if( isset( $params['accepts'] ) && !empty( $params['accepts'] ) ){
            $accepts = sprintf('accept="%s"', $params['accepts']);
        }

        $multiplefile = "";
        if( isset( $params['multiple'] ) ){
            $multiplefile = "multiple";
        }

        ob_start();
        include APP_PATH . "templates/drag-drop.php";
        return ob_get_clean();
    }
}


if( ! function_exists( "get_download_modal_html" ) ){
    function get_download_modal_html($params=array()){
        ob_start();
        include APP_PATH . "templates/download-modal.php";
        return ob_get_clean();
    }
}

if( ! function_exists( "get_svg_circle" ) ){
    function get_svg_circle($per=0, $size=140, $textsize="1", $class="success", $perlabel=false){
        $dasharray = round(($per / 100) * 471);
        $pertext = $perlabel ? $per . "%" : $per;

        return sprintf('<style>
            .stroke-success {
                stroke: #28a745 !important;
            }
            .stroke-danger,
            .stroke-error {
                stroke: #dc3545 !important;
            }
            
            .stroke-warning {
                stroke: #ffc107 !important;
            }
            </style><div class="mx-auto mx-lg-0 position-relative d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 160 160" class="stroke-%s" width="%d" height="%d">
                <circle cx="80" cy="80" r="75" stroke="#ddd" stroke-width="5" fill="transparent"></circle>

                <path d="M80,5A75,75,0,1,1,5,80,75,75,0,0,1,80,5" stroke-linecap="round" stroke-width="10" fill="transparent" stroke-dasharray="%s,471"></path>
            </svg>
            <div class="position-absolute">
                <div class="d-flex flex-column align-items-center">
                    <div class="fw-bold h%d mb-0 scoreValue">%s</div>

                    <div class="text-muted border-top pt-1">
                        100
                    </div>
                </div>
            </div>
        </div>', $class, $size, $size, $dasharray, $textsize, $pertext);
    }
}


if( ! function_exists( "generate_pagination" ) ){
    function generate_pagination($total_pages, $current_page){
        $html = '';

        // Create Previous link
        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            $html .= '<li class="page-item"><a class="page-link" href="?page='.$prev_page.'">Previous</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';
        }

        // If there are less than 7 pages, display all pages
        if ($total_pages <= 7) {
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $current_page) {
                    $html .= '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                } else {
                    $html .= '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
                }
            }
        } else {
            // If there are more than 7 pages, display first 3, last 3 and current page
            $html .= sprintf('<li class="page-item %s"><a class="page-link" href="?page=1">1</a></li>', $current_page == 1 ? 'active' : '');
            if ($current_page > 4) {
                $html .= '<li class="page-item disabled"><a class="page-link" href="javascript:void(0);">...</a></li>';
            }

            for ($i = max(2, $current_page - 2); $i <= min($current_page + 2, $total_pages - 1); $i++) {
                if ($i == $current_page) {
                    $html .= '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                } else {
                    $html .= '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
                }
            }

            if ($current_page < $total_pages - 3) {
                $html .= '<li class="page-item disabled"><a class="page-link" href="javascript:void(0);">...</a></li>';
            }
            $html .= '<li class="page-item"><a class="page-link" href="?page='.$total_pages.'">'.$total_pages.'</a></li>';
        }

        // Create Next link
        if ($current_page < $total_pages) {
            $next_page = $current_page + 1;
            $html .= '<li class="page-item"><a class="page-link" href="?page='.$next_page.'">Next</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
        }
        
        return $html;
    }
}

function add_log($output, $file="cron") {
    $log_file = TEMP_PATH . "log/$file.log";
    $date = date('Y-m-d H:i:s');
    $log_entry = "[$date] $output\n";

    if( ! file_exists( $log_file ) ){
        FileSystem::create($log_file);
    }

    file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}


function tkp_format_number($num) {

    if($num>1000) {
  
          $x = round($num);
          $x_number_format = number_format($x);
          $x_array = explode(',', $x_number_format);
          $x_parts = array('K', 'M', 'B', 'T');
          $x_count_parts = count($x_array) - 1;
          $x_display = $x;
          $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
          $x_display .= $x_parts[$x_count_parts - 1];
  
          return $x_display;
  
    }
  
    return $num;
}

function human_time_diff( $from, $to = 0 ) {
	if ( empty( $to ) ) {
		$to = time();
	}

	$diff = (int) abs( $to - $from );

	if ( $diff < 60 ) {
		$secs = $diff;
		if ( $secs <= 1 ) {
			$secs = 1;
		}
		$since = sprintf('%s second', $secs );
	} elseif ( $diff < (60 * 60) && $diff >= 60 ) {
		$mins = round( $diff / 60 );
		if ( $mins <= 1 ) {
			$mins = 1;
		}
		$since = sprintf('%s min', $mins );
	} elseif ( $diff < (24 * 60 * 60) && $diff >= (60 * 60) ) {
		$hours = round( $diff / (60 * 60) );
		if ( $hours <= 1 ) {
			$hours = 1;
		}
		$since = sprintf('%s hour', $hours );
	} elseif ( $diff < (7 * 24 * 60 * 60) && $diff >= (24 * 60 * 60) ) {
		$days = round( $diff / (24 * 60 * 60) );
		if ( $days <= 1 ) {
			$days = 1;
		}
		$since = sprintf('%s day', $days );
	} elseif ( $diff < (30 * 24 * 60 * 60) && $diff >= (7 * 24 * 60 * 60) ) {
		$weeks = round( $diff / (7 * 24 * 60 * 60) );
		if ( $weeks <= 1 ) {
			$weeks = 1;
		}
		$since = sprintf('%s week', $weeks );
	} elseif ( $diff < (365 * 24 * 60 * 60) && $diff >= (30 * 24 * 60 * 60) ) {
		$months = round( $diff / (30 * 24 * 60 * 60) );
		if ( $months <= 1 ) {
			$months = 1;
		}
		$since = sprintf('%s month', $months );
	} elseif ( $diff >= (365 * 24 * 60 * 60) ) {
		$years = round( $diff / (365 * 24 * 60 * 60) );
		if ( $years <= 1 ) {
			$years = 1;
		}
		$since = sprintf('%s year', $years );
	}

	return $since;
}

function bs_alert($message, $class="success"){
    return sprintf('<div class="alert alert-%s">%s</div>', $class, $message);
}

function get_first_filename($folder_path, $ext="jpg") {
    $files = glob($folder_path . "*.$ext");
    if (count($files) > 0) {
        return $files[0];
    }
    
    return false;
}

function check_url_has_query($url){
    $url = htmlspecialchars_decode($url);
    $arr = parse_url($url);
    return !empty($arr['query']);
}

function get_tool_card_html($tool, $lazy=true){
    $toolImage = get_tool_dynamic_url($tool->extra);

    $backgrounImage = $lazy ? 'data-src="%s"' : 'style="background-image:url(%s);"';
    $backgrounImage = sprintf($backgrounImage, $toolImage);

    return sprintf('<a class="tool" href="%s">
        <div class="tool_card">
            <div class="tool_content">
                <div %s class="tool_icon %s"></div>
                <span>%s</span>
            </div>
        </div>
    </a>', get_tool_url("slug", $tool->slug), $backgrounImage, $lazy ? "lozad" : "loaded", $tool->title);
}

function get_submit_button($text, $atts=array()){
    $atts = apply_filters("tool/custom/button/attributes", $atts);

    $attshtml = '';
    foreach($atts as $k => $v){
        if( !empty( $v ) ){
            $attshtml .= sprintf('%s="%s" ', $k, $v);
        }else{
            $attshtml .= sprintf('%s ', $k);
        }
    }
    
    return sprintf('<button %s>%s</button>', $attshtml, $text);
}

function get_tool_submit_button($tool, $text, $atts=array(), $includeCaptcha=true){
    if( empty( $atts ) ){
        $atts = array(
            "type" => "submit",
            "data-modal" => "Getting Download links . . .",
            "id" => $tool->slug . "_btn",
            "disabled" => "",
            "class" => "text-white bg-primary input-group-text download_video_btn"
        );
    }

    if( $includeCaptcha ){
        /** INCLUDE RECAPTCHA DATA */
        do_action("ast/captcha/render", $tool); 
    }

    $atts = apply_filters("tool/button/attributes", $atts, $tool);
    return get_submit_button($text, $atts);
}

function validate_captcha(){
    return (object) apply_filters("ast/before/ajax/req", array(
        "success" => true,
        "message" => ""
    ));
}

function add_js_script( $id, $url, $footer=true, $atts=array() ){
    global $minification;
    $minification->add_script($id, $url, $atts, $footer, "js");
}

function add_css_script( $id, $url, $footer=false, $atts=array() ){
    global $minification;
    $minification->add_script($id, $url, $atts, $footer, "css");
}

function add_code_before_script($id, $code){
    global $minification;
    $minification->add_code_ba_script("before", $id, $code);
}

function add_code_after_script($id, $code){
    global $minification;
    $minification->add_code_ba_script("after", $id, $code);
}

function get_payment_methods(){
    $settings_key = "payment_methods";
    $settings = (array) get_settings($settings_key);
    return apply_filters("tkp/payments/methods", array_keys($settings));
}

function get_payment_methods_front(){
    $settings_key = "payment_methods";
    $settings = get_settings($settings_key);
    $output = array();

    foreach($settings as $payment => $data){
        if( isset( $data['enable'] ) && filter_var($data['enable'], FILTER_VALIDATE_BOOLEAN) ){
            $output[] = $payment;
        }
    }

    return $output;
}

function is_payment_method_active($payment){
    $settings_key = "payment_methods";
    $settings = (array) get_settings($settings_key);
    if( isset( $settings[$payment] ) ){
        return filter_var($settings[$payment]['enable'], FILTER_VALIDATE_BOOLEAN);
    }
    return false;
}

function get_payment_method_setting($payment){
    $settings_key = "payment_methods";
    $settings = (array) get_settings($settings_key);
    if( isset( $settings[$payment] ) ){
        return $settings[$payment];
    }
    return false;
}

function get_account_menus(){
    return apply_filters("tkp/account/menus", array(
        "account" => array(
            "icon" => "las la-home",
            "title" => "Account"
        ),
        "plan" => array(
            "icon" => "las la-dollar-sign",
            "title" => "Plan"
        ),
        "apikeys" => array(
            "icon" => "las la-key",
            "title" => "API Keys"
        ),
        "payments" => array(
            "icon" => "las la-dollar-sign",
            "title" => "Payments"
        ),
        "logout" => array(
            "icon" => "las la-sign-out-alt",
            "title" => "Logout"
        )
    ));
}

function get_word_limit(){
    $plan = get_active_user_plan();
    return intval($plan->plan->meta->wordcount);
}

function get_file_size_limit(){
    $plan = get_active_user_plan();
    return intval($plan->plan->meta->filesize);
}

function get_file_count_limit(){
    $plan = get_active_user_plan();
    return intval($plan->plan->meta->imagenum);
}

function get_url_count_limit(){
    $plan = get_active_user_plan();
    return intval($plan->plan->meta->urlnums);
}

function get_extension_from_mime($mime){
    return Josantonius\MimeType\MimeTypeCollection::getExtension($mime);
}

function get_file_extension($file){
    return FileSystem::extension($file);
}

function check_word_limit($article){
    $wordLimit = get_word_limit();
    return $wordLimit > str_word_count($article);
}

function check_license_already_exists($apikey){
    global $db;
    $db->where("apikey", $apikey);
    $result = $db->getOne("orders");
    return !empty($result);
}

function generateApiKey($length = 36) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $apiKey = 'TKP-';
    
    do {
        for ($i = 0; $i < $length; $i++) {
            $apiKey .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        $existsInDatabase = check_license_already_exists($apiKey);
    } while ($existsInDatabase);

    return $apiKey;
}

function getRemainingRequest($apikey){
    global $db;

    $tablePrefix = TABLE_PREFIX;
    $sql = "SELECT
        ao.apikey,
        ao.id AS orderid,
        ap.id AS planid,
        ao.date AS date,
        amd.meta_value AS usagelimit
    FROM
        ast_orders ao
        INNER JOIN {$tablePrefix}posts ap ON ao.plan = ap.id
        LEFT JOIN {$tablePrefix}meta_data amd ON ap.id = amd.meta_id AND amd.meta_key = 'dailyusage'
    WHERE
        ao.apikey = '$apikey'";
        
    $results = $db->objectBuilder()->rawQuery($sql, null, false);
    if( ! empty( $results ) ){
        $apiData = $results[0];

        $startDate = date("Y-m-") . date("d", strtotime($apiData->date));
        $endDate = date('Y-m-d', strtotime('+1 month', strtotime($startDate)));

        $sql = "SELECT SUM(total_request) AS total_request_sum FROM apikey_request WHERE request_date >= ? AND request_date <= ?";
        $result = $db->objectBuilder()->rawQuery($sql, array($startDate, $endDate));

        if( !empty($result) ){
            $apiData->start = $startDate;
            $apiData->end = $endDate;
            $apiData->total_request = intval($result[0]->total_request_sum);
            $apiData->remaining_request = $apiData->usagelimit - $apiData->total_request;
        }

        return $apiData;
    }

    return false;
}

function is_api(){
    return defined("IS_API");
}

function update_api_limit($apikey=""){
    global $db;

    if( empty( $apiKey ) ){
        if( defined("IS_API") ){
            $apiKey = IS_API;
        }else{
            return false;
        }
    }

    $date = date("Y-m-d");
    $db->where("apikey=? AND request_date=?", array($apiKey, $date));
    $result = $db->objectBuilder()->getOne("apikey_request");
    if( ! empty( $result ) ){
        $db->update("apikey_request", array(
            "total_request" => $result->total_request + 1
        ), array(
            "id" => $result->id
        ));
    }else{
        $db->insert("apikey_request", array(
            "apikey" => $apiKey,
            "request_date" => $date,
            "total_request" => 1
        ));
    }
}

function get_account_url($path=""){
    return get_site_url(parse_route_constants("account") . "/" . $path);
}

function insertIntoArray(&$array, $element, $index) {
    if (!is_array($array)) {
        return $array;
    }

    if (!isset($array[$index])) {
        $array[] = $element;
    } else {
        array_splice($array, $index, 0, [$element]);
    }
}

function addArrayAfterKey($array, $keyToInsertAfter, $newKey, $newValue) {
    $newArray = array();

    foreach ($array as $key => $value) {
        $newArray[$key] = $value;
        if ($key === $keyToInsertAfter) {
            $newArray[$newKey] = $newValue;
        }
    }

    return $newArray;
}