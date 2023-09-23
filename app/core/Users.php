<?php
/**
 * Core class used to implement Users functionality.
 *
 * @since 1.0
 * @package AllSmartTools
 * @subpackage Users
 */

namespace AST;

use AST\Cookie;

class Users {

    /**
     * The one true Users.
     *
     * @var Users
     * @since 1.0.0
     * @access private
     **/
    public static $instance;

    private $userID = 0;
    private $userData = [];
    private $role = "subscriber";
    public $profile = "";

    public $roles = array(
        "administrator",
        "editor",
        "subscriber"
    );

    public $status = array(
        "active",
        "pending",
        "rejected"
    );

    public function __construct( $userID = false ){
        if( $userID ){
            $this->userID = intval($userID);
        }else if( isset( $_SESSION['userlogin'] ) && !empty( $_SESSION['userlogin'] ) ){
            $this->userID = intval($_SESSION['userlogin']);
        }else{
            $this->userID = 0;
            $loginID = Cookie::instance()->get("userlogin");
            if( ! empty( $loginID ) ){
                $_SESSION['userlogin'] = $loginID;
                $this->userID = intval($loginID);
            }
        }

        /** Get user details */
        $this->get_user_details();
    }

    public function roles(){
        return apply_filters("allsmarttools/roles", $this->roles);
    }

    private function get_meta_details(){
        global $db;
        if( $this->userID ){
            $this->userData['meta'] = get_all_meta("user", $this->userID);
            /** Setup for profile image */
            $this->setup_profile_image();
        }
    }

    public function setup_profile_image(){
        $profile = '';
        if( isset( $this->userData['meta']->profile ) ){
            $profile = $this->userData['meta']->profile;
        }
        $this->userData['profile'] = $profile;
    }

    public function set_from_apidata(){
        if( is_api() ){
            global $db;
            $db->where("apikey", IS_API);
            $apiRequest = $db->objectBuilder()->getOne("orders");
            if( ! empty( $apiRequest ) ){
                $this->userID = $apiRequest->user;
                $this->get_user_details();
            }
        }
    }

    private function get_user_details(){
        global $db;
        if( $this->userID ){
            $db->where("id", $this->userID);
            $result = $db->get("users", 1);
            if( is_array($result) && count( $result ) > 0 ){
                $this->userData = (array) $result[0];
                $this->role = $this->userData['role'];
                $this->userData["meta"] = array();
                $this->get_meta_details();
            }
        }
    }

    public function get_user_by( $key, $value ){
        global $db;
        $db->where($key, $value);
        $result = $db->objectBuilder()->get("users", 1);
        if( is_array($result) && count( $result ) > 0 ){
            return $result[0];
        }
        return false;
    }

    public function get(){
        if( $this->exists() ){
            return (object) $this->userData;
        }
        return false;
    }

    public function get_current_id(){
        return intval( $this->userID );
    }

    public function exists(){
        return intval( $this->userID ) > 0;
    }

    public function add_default_roles( $role ){
        $this->roles[] = trim(strtolower($role));
    }

    public function add_role( $role ){
        global $db;
        if( $this->userID ){
            if( $db->update("users", array(
                "role" => $role
            ), array(
                'id' => $this->userID
            )) ){
                $this->role = $role;
                return true;
            }
        }
        return false;
    }

    /**
	 * Main Users Instance.
	 * Insures that only one instance of Users exists in memory at any one time.
	 *
	 * @static
     * @since 1.0.0
	 * @return Users
	 **/
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}