<?php

namespace Tool;

use Google\Client;
use Google\Service\YouTube;

class youtubeTitleGenerator{

    public function __construct( $args = array() ){
        $this->api = @$args['api'];
        $this->keyword = @$args['keyword'];
        $this->country = @$args['country'];
    }
    
    public function get(){
        try {
            $client = new Client();
            $client->setDeveloperKey($this->api);
            $youtube = new YouTube($client);
            $value = $youtube->search->listSearch('id,snippet', array(
                'q'          => $this->keyword,
                'maxResults' => 50,
                'regionCode' => $this->country
            ));

            if( count($value['items']) != 0 ) {
                $arr = array_rand($value['items'], 10);
                $data = array();

                foreach ($arr as $k => $v) {
                    $data[] = $value['items'][$v]['snippet']['title'];
                }

                return array(
                    "success" => true,
                    "message" => $data
                );
            }

        } catch (Exception $th) {
            if( isJson($th->getMessage()) ){
                $data = @json_decode($th->getMessage());
                return array(
                    "success" => false,
                    "message" => @$data->error->message
                );
            }else{
                return array(
                    "success" => false,
                    "message" => $th->getMessage()
                );
            }
        }   

        return array(
            "success" => false,
            "message" => "Unable to generate for this keyword!!!"
        );
    }

}