<?php

namespace AST\Helper;

use AST\Download;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class Downloader{

    public $videos = [];
    public $audios = [];
    public $files = [];
    public $others = [];

    public $videoTitle = "Video Files";
    public $audioTitle = "Audio Files";
    public $filesTitle = "Files";
    public $otherTitle = "Other Files";

    public $videoHeader = ["Quality", "Format", "Size"];
    public $audioHeader = ["Quality", "Format", "Size"];
    public $filesHeader = ["Quality", "Format", "Size"];
    public $otherHeader = ["Quality", "Format", "Size"];

    public $title;
    public $image;
    public $link;
    public $domain;
    public $company = "invalid";

    public $resultFile = APP_PATH . "templates/downloader_result.php";
    public $output = [];

    public $source = "AST";
    public $client = false;

    public function __construct( $link, $client=false ){
        $this->link = $link;
        $this->setDomain();

        if( $client ){
            $this->client = new Client([
                'headers' => [
                    'User-Agent' => AST_UA
                ]
            ]);
        }
    }

    public function setDomain(){
        preg_match('/^(?:https?:\/\/)?(?:[^@\/\n]+@)?(?:www\.)?([^:\/\n]+)/', $this->link, $matches);
        if ( ! empty($matches[1]) ) {
            $domain = $this->extractMainDomain($matches[1]);
            if ($matches[1] == 'soundcloud.app.goo.gl') {
                $domain = 'soundcloud.app.goo.gl';
            }   
            $this->domain = $domain;
            $this->company = $this->setCompany();
            $this->source = strtoupper($this->company);
        }

        return $this;
    }

    public function setCompany(){
        switch ($this->domain) {
            case "instagram.com":
                return "instagram";

            case "twitter.com":
                return "twitter";

            case "youtube.com":
            case "youtu.be":
                return "youtube";

            case "web.facebook.com":
            case "facebook.com":
            case "fb.watch":
            case "fb.gg":
                return "facebook";

            case "dailymotion.com":
            case "dai.ly":
                return "dailymotion";

            case "vimeo.com":
            case "player.vimeo.com":
                return "vimeo";

            case "tumblr.com":
                return "tumblr";

            case "pinterest.com":
            case "pin.it":
            case "pinterest.com.br":
            case "pinterest.fr":
            case "pinterest.it":
            case "pinterest.es":
            case "pinterest.jp":
            case "tr.pinterest.com":
            case "pinterest.se":
                return "pinterest";

            case "imgur.com":
                return "imgur";

            case "ted.com":
                return "ted";

            case "mashable.com":
                return "mashable";

            case "vk.com":
            case "m.vk.com":
                return "vk";

            case "9gag.com":
                return "9gag";

            case "soundcloud.app.goo.gl":
            case "soundcloud.com":
                return "soundcloud";

            case "flickr.com":
            case "flic.kr":
                return "flickr";

            case "bandcamp.com":
                return "bandcamp";

            case "espn.com":
            case "espn.com.br":
            case "espn.in":
                return "espn";

            case "imdb.com":
                return "imdb";

            case "izlesene.com":
            case "izl.sn":
                return "izlesene";

            case "buzzfeed.com":
                return "buzzfeed";

            case "tiktok.com":
                return "tiktok";

            case "ok.ru":
                return "okru";

            case "likee.com":
            case "likee.video":
            case "like.video":
                return "likee";
                
            case "twitch.tv":
                return "twitch";

            case "blogspot.com":
                return "blogspot";

            case "reddit.com":
                return "reddit";

            case "douyin.com":
            case "iesdouyin.com":
                return "douyin";

            case "kwai.com":
            case "kw.ai":
            case "kwai-video.com":
                return "kwai";

            case "linkedin.com":
                return "linkedin";

            case "streamable.com":
                return "streamable";

            case "bitchute.com":
                return "bitchute";

            case "akilli.tv":
                return "akilli";

            case "gaana.com":
                return "gaana";

            case "bilibili.com":
            case "bilibili.tv":
                return "bilibili";

            case "febspot.com":
                return "febspot";

            case "rumble.com":
                return "rumble";

            case "periscope.tv":
            case "pscp.tv":
                return "periscope";

            case "puhutv.com":
                return "puhutv";

            case "blutv.com":
                return "blutv";

            case "mxtakatak.com":
                return "mxtakatak";

            case "ifunny.co":
                return "ifunny";

            case "kickstarter.com":
                return "kickstarter";

            case "mixcloud.com":
                return "mixcloud";

            case "sharechat.com":
                return "sharechat";

            case "t.me":
                return "telegram";

            case "snapchat.com":
                return "snapchat";

            case "chingari.io":
                return "chingari";

            case "mojapp.in":
                return "moj-app";
        }

        return "invalid";
    }

    public function setMainTitle( $value ){
        $this->title = $value;
        return $this;
    }

    public function setMainImage( $image ){
        $this->image = $image;
        return $this;
    }

    public function setMainLink( $link ){
        $this->link = $link;
        return $this;
    }

    public function instruction_title(){
        $text = "*** To download the files, Click on the \"Download\" button below in the table ***";
        return apply_filters("ast/downloader/instruction", $text);
    }

    public function setVideo($url, $extension, $quality, $size=-1, $chunk=""){
        if( floatval( $size ) < 0 )
            $size = get_file_size($url);

        $temp = array(
            "url" => $url,
            "quality" => $quality,
            "extension" => $extension,
            "size" => $size,
            "fileType" => "video"
        );

        if( !empty( $chunk ) ){
            $temp['chunked'] = $chunk;
        }

        $this->videos[] = (object) $temp;
        return $this;
    }

    public function setAudio($url, $extension, $quality, $size=-1, $chunk=false){
        if( floatval( $size ) < 0 )
            $size = get_file_size($url);

        $temp = array(
            "url" => $url,
            "quality" => $quality,
            "extension" => $extension,
            "size" => $size,
            "fileType" => "audio"
        );

        if( ! empty( $chunk ) ){
            $temp['chunked'] = $chunk;
        }

        $this->audios[] = (object) $temp;
        return $this;
    }

    public function setFile($url, $extension, $filename="", $size=-1, $chunk=false){
        if( floatval( $size ) < 0 )
            $size = get_file_size($url);

        if( empty( $filename ) )
            $filename = basename($url);

        $temp = array(
            "url" => $url,
            "filename" => $filename,
            "extension" => $extension,
            "size" => $size,
            "fileType" => "file"
        );

        if( ! empty( $chunk ) ){
            $temp['chunked'] = $chunk;
        }

        $this->files[] = (object) $temp;
        return $this;
    }

    public function setOther($url, $format, $filename, $size=-1, $chunk=false){
        if( floatval( $size ) < 0 )
            $size = get_file_size($url);

        $temp = array(
            "url" => $url,
            "filename" => $filename,
            "extension" => $format,
            "size" => $size,
            "fileType" => "other"
        );

        if( ! empty( $chunk ) ){
            $temp['chunked'] = $chunk;
        }

        $this->others[] = (object) $temp;
        return $this;
    }

    public function setTitle( $key, $value ){
        if( $key == 'audio' ){
            $this->audioTitle = $value;
        }else if( $key == 'video' ){
            $this->videoTitle = $value;
        }else if( $key == 'file' ){
            $this->filesTitle = $value;
        }else if( $key == 'other' ){
            $this->otherTitle = $value;
        }
        return $this;
    }

    public function setHeader( $key, $value ){
        
        if( is_array( $value ) ){
            if( $key == 'audio' ){
                $this->audioHeader = $value;
            }else if( $key == 'video' ){
                $this->videoHeader = $value;
            }else if( $key == 'file' ){
                $this->filesHeader = $value;
            }else if( $key == 'other' ){
                $this->otherHeader = $value;
            }
        }
        
        return $this;
    }

    public function getAPIData(){
        return array(
            "data" => array(
                "audios" => $this->audios,
                "videos" => $this->videos,
                "files" => $this->files,
                "others" => $this->others
            ),
            "header" => array(
                "audios" => $this->audioHeader,
                "videos" => $this->videoHeader,
                "files" => $this->filesHeader,
                "others" => $this->otherHeader
            )
        );
    }

    public function getHeader( $key ){
        $output = array();
        if( $key == 'audio' ){
            $output = $this->audioHeader;
        }else if( $key == 'video' ){
            $output = $this->videoHeader;
        }else if( $key == 'file' ){
            $output = $this->filesHeader;
        }else if( $key == 'other' ){
            $output = $this->otherHeader;
        }

        if( ! empty( $output ) ){
            $headerHTML = '';
            foreach( $output as $title ){
                $headerHTML .= sprintf('<th>%s</th>', $title);
            }
            return $headerHTML;
        }

        return false;
    }

    public function download_link( $o ){
        $filename = title_to_slug($this->source);
        $params = array(
            "url" => $o->url,
            "atts" => array(
                "Source" => $this->source,
                "Title" => $this->title,
                "File Size" => format_size(@$o->size)
            ),
            "extension" => @$o->extension,
            "size" => @$o->size,
            "source" => $filename,
            "name" => $filename . "-video"
        );

        if( @$o->fileType == 'file' || @$o->fileType == 'other' ){
            $params['atts']['File Name'] = @$o->filename;
        }else{
            $params['atts']['Quality'] = @$o->quality;
        }
        $params['atts']['Format'] = @$o->extension;

        if( property_exists( $o, "chunked" ) ){
            $params["chunked"] = $o->chunked;
        }

        return Download::set_data($params);
    }

    public function set(){
        if( ! empty( $this->videos ) ){
            $this->output[] = (object) array(
                "key" => "videos",
                "title" => $this->videoTitle,
                "data" => $this->videos
            );
        }
        
        if( ! empty( $this->audios ) ){
            $this->output[] = (object) array(
                "key" => "audios",
                "title" => $this->audioTitle,
                "data" => $this->audios
            );
        }
        
        if( ! empty( $this->files ) ){
            $this->output[] = (object) array(
                "key" => "files",
                "title" => $this->filesTitle,
                "data" => $this->files
            );
        }
        
        if( ! empty( $this->others ) ){
            $this->output[] = (object) array(
                "key" => "others",
                "title" => $this->otherTitle,
                "data" => $this->others
            );
        }

        return $this;
    }

    public function render(){
        if( ! file_exists( $this->resultFile ) ){
            throw \Exception("Downloader result template is missing!!!");
        }
        
        ob_start();
        include $this->resultFile;
        $content = ob_get_contents();
        ob_get_clean();
        return $content;
    }

    private function extractMainDomain($domain)
    {
        $parts = explode('.', $domain);
        $mainDomain = null;
        $length = count($parts);
        if ($length <= 2) {
            return $domain;
        }
        for ($i = $length - 1; $i > 0; $i--) {
            $mainDomain = $parts[$i] . ($mainDomain !== null ? '.' : '') . $mainDomain;
        }
        return $mainDomain;
    }

    public static function template($tool, $report, $placeholder="Enter Video Link", $labels=array()){

        $buttontext = '<i class="las la-download me-1"></i> Download Video';
        if( isset($labels['btnlabel']) ){
            $buttontext = $labels['btnlabel'];
        }

        $resultlabel = 'Download Links';
        if( isset($labels['resultlabel']) ){
            $resultlabel = $labels['resultlabel'];
        }

        $placeholderlabel = 'https:// . . .';
        if( isset($labels['placeholder']) ){
            $placeholderlabel = $labels['placeholder'];
        }

        $copybtn = 'show';
        if( isset($labels['copy']) ){
            $copybtn = "hide";
        }

        $inputname = 'link';
        if( isset($labels['name']) ){
            $inputname = trim($labels['name']);
        }

        $loadingmodal = "Getting Download links . . .";
        if( isset( $labels['loadingmodal'] ) ){
            $loadingmodal = $labels['loadingmodal'];
        }

        $afterinput = '';
        if( isset( $labels['afterinput'] ) ){
            $afterinput = $labels['afterinput'];
        }
        
        $under_slug = str_replace("-", "_", $tool->slug);
        ob_start();
        include APP_PATH . "templates/downloader_field.php";
        return ob_get_clean();
    }

    public function getContent($url, $header=array(), $curlopt=array())
    {
        $ch = curl_init();
        $curlOptions = curl_options($url, $header);
        if( ! empty( $curlopt ) ){
            foreach($curlopt as $k => $v){
                $curlOptions[$k] = $v;
            }
        }

        curl_setopt_array($ch, $curlOptions);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}