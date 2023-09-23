<?php

namespace AST;

class Plan{

    private static $instance;
    private $user;
    private $plan;

    public function __construct(){
        if( ! has_system_installed() ) return false;

        if( is_user_loggin() ){
            $this->user = ast_get_current_user();

            $this->setActivePlan();
        }else{
            $this->setFreePlan();
        }
    }

    private function setFreePlan(){
        global $db;
        $db->where("extra=? AND type=?", array("nodelete", "plan"));
        $planDetails = $db->objectBuilder()->getOne("posts");
        if( ! empty( $planDetails ) ){
            $this->plan = (object) array(
                "price" => 0,
                "plan" => $planDetails,
                "user" => 0,
                "type" => "lifetime",
                "orderid" => "",
                "source" => "Unknown",
                "response" => "",
                "expiry" => "Never",
                "status" => "active",
                "date" => date("Y-m-d H:i:s"),
                "subscribed" => false
            );

            $this->plan->plan->meta = get_all_meta("plan", $planDetails->id);
        }
    }

    private function setActivePlan(){
        global $db;
        $db->where("user=? AND status=?", array($this->user->id, "active"));
        $this->plan = $db->objectBuilder()->getOne("orders");

        if( ! empty( $this->plan ) ){
            $this->plan->subscribed = true;
            $this->setplanData($this->plan->plan);
        }else{
            $this->setFreePlan();
        }
    }

    private function setplanData($planID){
        global $db;
        
        $db->where("id", $planID);
        $this->plan->plan = $db->objectBuilder()->getOne("posts");
        if( ! empty( $this->plan->plan ) ){
            $this->plan->plan->meta = get_all_meta("plan", $planID);
        }

        $this->plan->apidata = getRemainingRequest($this->plan->apikey);
    }

    public function get(){
        return $this->plan;
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