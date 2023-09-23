<?php
include get_site_path() . "admin_file/install/installation.php";

add_action("ajax/req/get_installation_step", "include_get_installation_step");
add_action("ajax/req/nologin/get_installation_step", "include_get_installation_step");
function include_get_installation_step(){
    if( isset( $_POST['page'] ) && !empty($_POST['page']) ){
        $page = trim($_POST['page']);
        $type = trim($_POST['type']);

        $siteurl = @$_POST['siteurl'];
        $sitepath = @$_POST['sitepath'];

        if( $type == 'next' ){
            if( isset( $_POST['host'] ) ){
                if( !Installation::check_database() ){
                    ast_send_json(array(
                        "success" => false,
                        "message" => "Unable to connect database!!!"
                    ));
                }
            }else if( isset( $_POST['user_email'] ) ){
                if( !Installation::create_user() ){
                    ast_send_json(array(
                        "success" => false,
                        "message" => "Unable to create user!!!"
                    ));
                }

                if( !Installation::update_config() ){
                    ast_send_json(array(
                        "success" => false,
                        "message" => "Unable to update configuration file!!!"
                    ));
                }
            }
        }

        $includePage = get_site_path("admin_file/install/parts/$page.php");
        if( file_exists( $includePage ) ){
            ob_start();
            include $includePage;
            ast_send_json(array(
                "success" => true,
                "message" => ob_get_clean(),
                "current" => $page,
                "next" => Installation::next()
            ));
        }else{
            ast_send_json(array(
                "success" => true,
                "message" => "Installation File are missing!!!"
            ));
        }
    }else{
        ast_send_json(array(
            "success" => true,
            "message" => "Invalid Page!!!"
        ));
    }
}