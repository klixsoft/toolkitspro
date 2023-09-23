<?php

namespace Tool;

use Google\Client;
use Google\Service\YouTube;
use Google\Service\Exception;

class youtubeTrend{

    public function __construct( $args = array() ){
        $this->api = $args['api'];
        $this->result = isset($args['result']) ? intval($args['result']) : 10;
        $this->country = isset($args['country']) ? $args['country'] : "US";
        $this->lang = isset($args['lang']) ? $args['lang'] : "EN";
    }

    public function get(){
        try {
            $client = new Client();
            $client->setDeveloperKey( $this->api );

            $youtube = new YouTube($client);

            $value = $youtube->videos->listVideos('snippet', array(
                'chart'      => 'mostPopular',
                'maxResults' => $this->result,
                'regionCode' => $this->country,
                'hl'         => $this->lang
            ));
            

            if( count( $value['items'] ) > 0 ){
                $data = array();
                foreach($value['items'] as $video){
                    $data[] = (object) array(
                        "thumbnail" => @$video['snippet']['thumbnails']['default']['url'],
                        "title" => @$video['snippet']['title'],
                        "description" => @$video['snippet']['description'],
                        "id" => @$video['id'],
                        "link" => 'https://youtu.be/' . @$video['id'],
                        "tags" => @$video['snippet']['tags']
                    );
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
            "message" => "No Result Found!!!"
        );
    }

}