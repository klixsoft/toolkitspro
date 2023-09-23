<?php

/*=====================================================
 SCRIPT CONFIGURATION FILE                        
*=====================================================*/
define("DOING_AJAX", true);

$origin = $_SERVER['HTTP_ORIGIN'];
$mainDomain = preg_replace('/^https?:\/\/([^\/]+).*$/', '$1', $origin);
header("Access-Control-Allow-Origin: $mainDomain");

require_once realpath(__DIR__) . '/load.php';


/*=====================================================
 HANDLING VALID AJAX                    
*=====================================================*/
if ( 
    ! isset(  $_REQUEST['action'] )
    || empty( $_REQUEST['action'] ) 
    || ! is_scalar( $_REQUEST['action'] ) 
) {
    header('HTTP/1.1 500 Internal Server Error');
    die('0');
}


/*=====================================================
 INCLUDE TOOL FUNCTIONS.PHP FILE                       
*=====================================================*/
if ( 
    isset(  $_REQUEST['tool'] )
    && ! empty( $_REQUEST['tool'] )
) {
    $toolfunc = TOOLS_PATH . $_REQUEST['tool'] . "/functions.php";
    if( file_exists( $toolfunc ) ){
        require_once $toolfunc;
    }
}else if ( 
    isset(  $_REQUEST['install'] )
    && ! empty( $_REQUEST['install'] )
) {
    $ajaxFile = get_site_path() . "admin_file/install/ajax.php";
    if( file_exists( $ajaxFile ) ){
        include $ajaxFile;
    }else{
        ast_send_json(array(
            "success" => false,
            "message" => "Installation File is mising!!!"
        ));
    }
}


/*=====================================================
 HANDLING AJAX FOR LOGIN AND NON LOGIN USERS                 
*=====================================================*/
$action = $_REQUEST['action'];
if ( is_user_loggin() ) {
    if ( ! has_action( "ajax/req/{$action}" ) ) {
        header('HTTP/1.1 500 Internal Server Error');
        die('Incorrect Ajax Setup');
    }

    do_action( "ajax/req/{$action}" );
} else {
    if ( ! has_action( "ajax/req/nologin/{$action}" ) ) {
        header('HTTP/1.1 500 Internal Server Error');
        die('Incorrect Ajax Setup');
    }


    /*=====================================================
    CSRF VALIDATION FOR NON LOGIN USERS                   
    *=====================================================*/
    // if( ! csrf_validate() ){
    //     header('HTTP/1.1 500 Internal Server Error');
    //     die('csrf Error!!!');
    // }
    
    do_action( "ajax/req/nologin/{$action}" );
}

die('0');
