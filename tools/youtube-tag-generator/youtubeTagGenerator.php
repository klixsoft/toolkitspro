<?php

namespace Tool;

use GuzzleHttp\Client;

class youtubeTagGenerator{

    public function __construct( $lang, $keyword ){
        $this->language = $lang;
        $this->keyword = $keyword;
    }
    
    public function get(){
        
        $client = new Client();
        $reqURL = ('http://suggestqueries.google.com/complete/search?callback=?&hl='.strtolower($this->language).'&ds=yt&jsonp=suggestCallBack&client=youtube&q=' . urlencode($this->keyword));
        $response = $client->request('GET', $reqURL);

        if( $response->getStatusCode() == 200 ){
            $contents = $response->getBody()->getContents();
            preg_match('/suggestCallBack\((.*)\)/', $contents, $match);
            
            if( !empty( $match ) ){
                $deJson = json_decode($match[1], true);
                if( isset( $deJson[1] ) ){

                    $tags = array();
                    foreach($deJson[1] as $tag){
                        $tags[] = $tag[0];
                    }

                    return array(
                        "success" => true,
                        "message" => $tags
                    );
                }
            }
        }

        return array(
            "success" => true,
            "message" => bs_alert("Unable to generate for this keyword!!!", "danger mt-2")
        );
    }

}