<?php

namespace AST\Helper;

class paypalSubscription{

    private $requestURL = "https://api-m.paypal.com/";
    private $debug = false;
    private $enable=false;
    private $clientid;
    private $secret;
    private $planID = false;
    private $plan = false;
    private $client;
    private $info = false;
    private $product;

    public function __construct(){
        $this->client = new \GuzzleHttp\Client();

        if( is_payment_method_active("paypal") ){
            $this->enable = true;

            $this->product = get_settings("paypal_product");
            $this->info = get_settings("basic");
            $settings = get_payment_method_setting("paypal");

            if( isset( $settings['clientid'] ) && !empty($settings['clientid']) ){
                $this->clientid = $settings['clientid'];
            }

            if( isset( $settings['secret'] ) && !empty($settings['secret']) ){
                $this->secret = $settings['secret'];
            }

            if( isset( $settings['sandbox'] ) ){
                $this->debug = filter_var($settings['sandbox'], FILTER_VALIDATE_BOOLEAN);
                if( $this->debug ){
                    $this->requestURL = "https://api-m.sandbox.paypal.com/";
                }
            }
        }
    }

    public function updatePlans( $planID ){
        add_log("\n==================== START LOG ====================\n", "paypal");
        $this->planID = $planID;

        $this->checkActive();
        $this->setPlan();

        if( $this->plan->extra == 'plan' ){
            $this->createProduct();
            $this->createPlan();
        }
        add_log("\n==================== END LOG ====================\n", "paypal");
    }

    public function clearPaypalData(){
        try {
            global $db;
            $db->delete("meta_data", array( "meta_key" => "paypal_yearly_plan_id" ));
            $db->delete("meta_data", array( "meta_key" => "paypal_yearly_plan_data" ));
            $db->delete("settings", array( "option_name" => "paypal_product" ));
        } catch (\Throwable $th) {
            
        }
    }

    public function getSubscription($subID){
        $url = $this->getURL("v1/billing/subscriptions/$subID");
        try {
            $response = $this->client->request("GET", $url, array(
                'auth' => [$this->clientid, $this->secret, 'basic'],
                'headers' => array(
                    'Accept' => 'application/json',
                    'Accept-Language' => 'en_US',
                    'Content-Type' => 'application/json',
                )
            ));

            $data = json_decode($response->getBody());
            return (object) array(
                "success" => true,
                "data" => $data
            );
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            add_log(print_r($e->getMessage(), true), "paypal");
            return array(
                "success" => false,
                "message" => $e->getMessage()
            );
        }
    }

    private function getURL($path){
        return $this->requestURL . $path;
    }

    private function updateSubPlan($plan, $price, $id){
        $args = array(
            array(
                "op" => "replace", 
                "path" => "/name", 
                "value" => $this->plan->title
            ),
            array(
                "op" => "replace", 
                "path" => "/description", 
                "value" => $this->plan->description
            )
        );

        $url = $this->getURL("v1/billing/plans/$id");
        try {
            $response = $this->client->request("PATCH", $url, array(
                'headers' => array(
                    'Accept' => 'application/json',
                    'Accept-Language' => 'en_US',
                    'Content-Type' => 'application/json',
                ),
                "json" => $args,
                'auth' => [$this->clientid, $this->secret, 'basic']
            ));

            $url .= "/update-pricing-schemes";
            $response = $this->client->request("POST", $url, array(
                'headers' => array(
                    'Accept' => 'application/json',
                    'Accept-Language' => 'en_US',
                    'Content-Type' => 'application/json',
                ),
                "json" => array(
                    "pricing_schemes" => array(
                        array(
                            "billing_cycle_sequence" => 1,
                            "pricing_scheme" => array(
                                "fixed_price" => array(
                                    "value" => $price, 
                                    "currency_code" => "USD"
                                ),
                            ),
                        )
                    ),
                ),
                'auth' => [$this->clientid, $this->secret, 'basic']
            ));

            add_log("{$plan}ly Plan Updated Successfully!!!", "paypal");
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            add_log(print_r($e->getMessage(), true), "paypal");
        }
    }

    private function manageSubPlan($plan, $price, $id=""){
        if( ! empty( $id ) ){
            $this->updateSubPlan($plan, $price, $id);
            return false;
        }

        $url = $this->getURL("v1/billing/plans");
        $request = "POST";
        $args = array(
            "product_id" => $this->product,
            "name" => $this->plan->title,
            "description" => $this->plan->description,
            "status" => "ACTIVE",
            "billing_cycles" => array(
                array(
                    "frequency" => array(
                        "interval_unit" => strtoupper($plan),
                        "interval_count" => 1
                    ),
                    "tenure_type" => "REGULAR",
                    "sequence" => 1,
                    "total_cycles" => 0,
                    "pricing_scheme" => array(
                        "fixed_price" => array(
                            "value" => $price,
                            "currency_code" => "USD"
                        )
                    )
                )
            ),
            "payment_preferences" => array(
                "auto_bill_outstanding" => true,
                "setup_fee_failure_action" => "CONTINUE",
                "payment_failure_threshold" => 1
            )            
        );

        try {
            $response = $this->client->request("POST", $url, array(
                'headers' => array(
                    'Accept' => 'application/json',
                    'Accept-Language' => 'en_US',
                    'Content-Type' => 'application/json',
                ),
                "json" => $args,
                'auth' => [$this->clientid, $this->secret, 'basic']
            ));
    
            $data = json_decode($response->getBody(), true);
            if( isset( $data['id'] ) ){
                update_meta("plan", $this->planID, "paypal_{$plan}ly_plan_id", $data['id']);
                update_meta("plan", $this->planID, "paypal_{$plan}ly_plan_data", $data);
    
                $this->$plan = $data;

                add_log("{$plan}ly Plan Created Successfully!!!", "paypal");
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            add_log(print_r($e->getMessage(), true), "paypal");
        }
    }

    private function createPlan(){
        $montlyPlan = get_meta("plan", $this->planID, "paypal_monthly_plan_id");
        $this->manageSubPlan("month", $this->plan->meta->monthlyprice, $montlyPlan);
        $this->manageSubPlan("year", $this->plan->meta->yearlyprice, $montlyPlan);
    }

    private function createProduct(){
        if( ! empty( $this->product ) ){
            add_log("Product Already Created!!!", "paypal");
            return false;
        }

        $url = $this->getURL("v1/catalogs/products");
        try {
            $response = $this->client->request('POST', $url, array(
                'headers' => array(
                    'Accept' => 'application/json',
                    'Accept-Language' => 'en_US',
                    'Content-Type' => 'application/json',
                ),
                'json' => array(
                    "name" => $this->info->name,
                    "description" => $this->info->description,
                    "type" => "SERVICE",
                    "category" => "SOFTWARE",
                    "home_url" => get_site_url("pricing/"),
                    "image_url" => $this->info->branding_logo
                ),
                'auth' => [$this->clientid, $this->secret, 'basic']
            ));
    
            $data = json_decode($response->getBody(), true);
            if( isset( $data['id'] ) ){
                $this->product = $data['id'];
                update_settings("paypal_product", $data['id']);
                add_log("Product Created Successfuly!!!", "paypal");
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            add_log(print_r($e->getMessage(), true), "paypal");
        }
    }

    private function checkActive(){
        if( empty($this->clientid) || empty($this->secret) ){
            $this->enable = false;
        }
    }

    private function setPlan(){
        global $db;
        $db->where("id", $this->planID);
        $plan = $db->objectBuilder()->getOne("posts");
        if( ! empty( $plan ) ){
            $plan->meta = get_all_meta("plan", $this->planID);
            $this->plan = $plan;
            add_log("Plan Seup Successfully!!!", "paypal");
        }
    }
}