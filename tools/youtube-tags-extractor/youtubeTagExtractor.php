<?php

namespace Tool;

use Google\Client;
use Google\Service\YouTube;
use Google\Service\Exception;

class youtubeTagExtractor{

    public function __construct( $api, $link ){
        $this->api = $api;
        $this->link = $link;

        $this->client = new Client();
        $this->client->setDeveloperKey( $this->api );
    }


    public function get(){
        try {
            $youtube = new YouTube($this->client);

            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $this->link, $videoId);

            if( !empty( $videoId ) && count($videoId) > 0 ){
                $value = $youtube->videos->listVideos('snippet', array(
                    'id' => $videoId[1]
                ));

                if( count($value['items'][0]['snippet']['tags']) != 0 ) {
                    return array(
                        "success" => true,
                        "message" => $value['items'][0]['snippet']['tags']
                    );
                }else{
                    return array(
                        "success" => false,
                        "message" => "No tags found for this video!!!"
                    );
                }
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