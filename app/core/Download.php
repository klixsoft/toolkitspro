<?php

namespace AST;

class Download{

    private static $enable = true;
    private static $keyLength = 0;
    private static $expiry_mins = 86400 / 60;
    private static $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
    private static $chunkSize = 1000000;

    public static function setup(){
        $settings = get_download_settings();
        self::$keyLength = intval(@$settings->slug) > 0 ? intval(@$settings->slug) : 10;
        self::$expiry_mins = intval(@$settings->expiry);
        self::$enable = filter_var(@$settings->enable, FILTER_VALIDATE_BOOLEAN);
    }

    public static function chunks_size($file, $number){
        $size = get_file_size( $file );
        return $size * $number;
    }

    public static function set_chunks( $file, $content ){
        file_put_contents(TEMP_PATH . "chunks/" . $file, $content);
        return get_site_url() . "app/temp/chunks/" . $file;
    }

    private static function get_filename($url){
        if( filter_var( $url, FILTER_VALIDATE_URL ) ){
            return basename($url);
        }

        return "Unknown";
    }

    private static function get_expiry_minutes(){
        return self::$expiry_mins;
    }

    public static function get_data( $key="" ){
        if( empty( $key ) ) return false;
        
        $data = self::get_from_db(intval($key));
        if( $data ){
            if( is_array( $data ) ){
                if( isset( $data['url'] ) ){
                    if( ! isset( $data['atts'] ) ){
                        $data['atts'] = array(
                            "File Name" => self::get_filename( $data['url'] ),
                            "File Size" => get_file_size( $data['url'] ),
                            "Format" => pathinfo($data['url'], PATHINFO_EXTENSION)
                        );
                    }

                    return $data;
                }
            }
        }

        return false;
    }

    public static function get_from_db($id){
        global $db;
        $db->where("id", $id);
        $result = $db->objectBuilder()->getOne("download");
        if( ! empty( $result ) ){
            return maybe_unserialize($result->data);
        }
        return false;
    }

    public static function save_to_db($data){
        global $db;
        return $db->insert("download", array(
            "data" => maybe_serialize($data),
            "date" => date("Y-m-d H:i:s")
        ));
    }

    public static function set_data($data = array()){
        if( is_object( $data ) ){
            $data = (array) $data;
        }

        if( isset( $data['chunked'] ) && empty( $data['chunked'] ) ){
            unset($data['chunked']);
        }

        if( is_array( $data ) ){
            if( isset( $data['url'] ) ){
                if( ! isset( $data['atts'] ) ){
                    $data['atts'] = array(
                        "File Name" => self::get_filename( $data['url'] ),
                        "File Size" => isset($data['size']) ? $data['size'] : get_file_size( $data['url'] ),
                        "Format" => isset($data['extension']) ? $data['extension'] : pathinfo($data['url'], PATHINFO_EXTENSION)
                    );
                }
                
                $uploadID = self::save_to_db($data);
                if( $uploadID ){
                    return get_site_url("download/$uploadID/");
                }
            }
        }

        return false;
    }

    public static function start_download($data){
        if( isset( $data['url'] ) ){
            $url = trim($data['url']);

            if( ! filter_var(self::$enable, FILTER_VALIDATE_BOOLEAN) ){
                redirect($url);
                exit;
            }

            $siteUrl = get_site_url();
            $parsedRemoteUrl = parse_url($url);
            $remoteDomain = str_ireplace('www.', '', $parsedRemoteUrl['host'] ?? '');
            $localDomain = str_ireplace('www.', '', parse_url($siteUrl, PHP_URL_HOST));

            $extension = @$data['extension'];
            $size = @$data['size'];
            $source = @$data['source'];
            $name = @$data['name'];
            $referer = '';
            
            if( isset( $data['chunked'] ) && !empty( $data['chunked'] ) ){
                $chunkFile = trim($data['chunked']);
                $chunks = json_decode(file_get_contents(TEMP_PATH . '/chunks/' . $chunkFile), true);
                self::forceDownloadChunks($chunks, $name, $extension);
            }else{
                self::forceDownload( $url, $name, $extension, $size, $referer );
            }
        }
    }

    public static function forceDownload( $url, $name, $extension, $size=0, $referer = '' ){
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . htmlspecialchars_decode(Str::sanitizeFilename($name, $extension)) . '"');
        header("Content-Transfer-Encoding: binary");
        header("Accept-Ranges: bytes");
        header("Content-Ranges: bytes");
        
        /** SET CONTENT LENGTH */
        header('Content-Length: ' . $size > 0 ? $size : get_file_size($url));

        header('Connection: Close');
        @ini_set('max_execution_time', 0);
        @set_time_limit(0);
        if (ob_get_length() > 0) {
            ob_clean();
        }

        flush();

        /**ACTIVATE FLUSH */
        if (function_exists('apache_setenv')) {
            apache_setenv('no-gzip', 1);
        }
        @ini_set('zlib.output_compression', false);
        ini_set('implicit_flush', true);

        /**CURL PROCESS */
        $ch = curl_init();
        $chunkEnd = $chunkSize = 1000000;  // 1 MB in bytes
        $tries = $count = $chunkStart = 0;
        
        while ($size > $chunkStart) {
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, self::$userAgent);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_REFERER, $referer);
            curl_setopt($ch, CURLOPT_RANGE, $chunkStart . '-' . $chunkEnd);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BUFFERSIZE, $chunkSize);
            $output = curl_exec($ch);
            $curlInfo = curl_getinfo($ch);
            
            if ($curlInfo['http_code'] != "206" && $curlInfo['http_code'] != '403' && $tries < 10) {
                $tries++;
                continue;
            } else {
                if ($tries === 0 && $curlInfo['http_code'] == '403') {
                    self::forceDownloadLegacy($url, $name, $extension, $size);
                    exit;
                }
                $tries = 0;
                echo $output;
                flush();
                ob_implicit_flush(true);

                if (ob_get_length() > 0) 
                    ob_end_flush();
            }
            $chunkStart += self::$chunkSize;
            $chunkStart += ($count == 0) ? 1 : 0;
            $chunkEnd += self::$chunkSize;
            $count++;
        }
        curl_close($ch);
        exit;
    }


    public static function forceDownloadLegacy($url, $name, $extension, $size=0)
    {
        $context_options = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
            )
        );
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . Str::sanitizeFilename($name, $extension) . '"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Pragma: public');
        header('Content-Length: ' . $size > 0 ? $size : get_file_size($url));
        if (isset($_SERVER['HTTP_REQUEST_USER_AGENT']) && strpos($_SERVER['HTTP_REQUEST_USER_AGENT'], 'MSIE') !== FALSE) {
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        }
        header('Connection: Close');
        ob_clean();
        flush();
        readfile($url, "", stream_context_create($context_options));
        exit;
    }

    
    public static function forceDownloadChunks($urls, $name, $extension)
    {
        $context_options = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
            )
        );
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . Str::sanitizeFilename($name, $extension) . '"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Pragma: public');
        if (isset($_SERVER['HTTP_REQUEST_USER_AGENT']) && strpos($_SERVER['HTTP_REQUEST_USER_AGENT'], 'MSIE') !== FALSE) {
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        }
        header('Connection: Close');
        ob_clean();
        flush();
        foreach ($urls as $url) {
            readfile($url, "", stream_context_create($context_options));
        }
        exit;
    }
}