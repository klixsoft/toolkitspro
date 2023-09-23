<?php

namespace Tool;

use Google\Client;
use Google\Service\YouTube;
use Google\Service\Exception;

class youtubeHashTagExtractor{

    public function __construct( $api, $link ){
        $this->api = $api;
        $this->link = $link;

        $this->client = new Client();
        $this->client->setDeveloperKey( $this->api );
    }


    protected function get_hash_tags( $string ){
        $hashtags= array();  
        preg_match_all("/(#\w+)/u", $string, $matches);  
        if ($matches) {
            $hashtagsArray = array_count_values($matches[0]);
            $hashtags = array_keys($hashtagsArray);
        }
        return $hashtags;
    }
    
    public function get(){
        try {
            $youtube = new YouTube($this->client);
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $this->link, $videoId);

            if( !empty( $videoId ) && count($videoId) > 0 ){
                $value = $youtube->videos->listVideos('snippet', array(
                    'id' => $videoId[1]
                ));

                if( !empty($value['items'][0]['snippet']['description'])) {
                    $hashtags = $this->get_hash_tags( $value['items'][0]['snippet']['description'] );
                    if( ! empty( $hashtags ) ){
                        return array(
                            "success" => true,
                            "message" => $hashtags
                        );
                    }
                }
                
                return array(
                    "success" => false,
                    "message" => "No tags found for this video!!!"
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