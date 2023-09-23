<?php
use AST\View;
use GuzzleHttp\Client;
use GuzzleHttpException\ClientException;
use GuzzleHttpException\ConnectException;


if( ! function_exists( "isJson" ) ){
    /**
     * Check whether the string is json or not
     * 
     * @since 1.0
     * @param string
     * @return string
     */
    function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}


if( ! function_exists( "is_" ) ){

    /**
     * Check whether string is searilized or not
     * 
     * @param string $data
     * @param boolean $strict
     * 
     * @return boolean
     */
    function is_serialized( $data, $strict = true ) {
        // If it isn't a string, it isn't serialized.
        if ( ! is_string( $data ) ) {
            return false;
        }

        $data = trim( $data );
        if ( 'N;' === $data ) {
            return true;
        }
        if ( strlen( $data ) < 4 ) {
            return false;
        }
        if ( ':' !== $data[1] ) {
            return false;
        }
        if ( $strict ) {
            $lastc = substr( $data, -1 );
            if ( ';' !== $lastc && '}' !== $lastc ) {
                return false;
            }
        } else {
            $semicolon = strpos( $data, ';' );
            $brace     = strpos( $data, '}' );
            // Either ; or } must exist.
            if ( false === $semicolon && false === $brace ) {
                return false;
            }
            // But neither must be in the first X characters.
            if ( false !== $semicolon && $semicolon < 3 ) {
                return false;
            }
            if ( false !== $brace && $brace < 4 ) {
                return false;
            }
        }
        $token = $data[0];
        switch ( $token ) {
            case 's':
                if ( $strict ) {
                    if ( '"' !== substr( $data, -2, 1 ) ) {
                        return false;
                    }
                } elseif ( false === strpos( $data, '"' ) ) {
                    return false;
                }
                // Or else fall through.
            case 'a':
            case 'O':
            case 'E':
                return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
            case 'b':
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';
                return (bool) preg_match( "/^{$token}:[0-9.E+-]+;$end/", $data );
        }
        return false;
    }
}


if( ! function_exists( "maybe_unserialize" ) ){
    
    /**
     * Unsearilized the string if is in the form of serialized data
     * 
     * @see is_serialized()
     * 
     * @param string $data
     * @return any $data
     */
    function maybe_unserialize( $data ) {
        if ( is_serialized( $data ) ) {
            return @unserialize( trim($data) );
        }
    
        return $data;
    }
}


if( ! function_exists( "maybe_serialize" ) ){
    
    /**
     * Searilized the data if is in the form of array or object
     * 
     * @param array|object $data
     * @return string $data
     */
    function maybe_serialize( $data ) {
        if ( is_array( $data ) || is_object( $data ) ) {
            return @serialize( $data );
        }
    
        return $data;
    }
}

if ( !function_exists('parseMetaFromString') ) {
    /**
     * Retrieve metadata from a file.
     *
     * Searches for metadata in the first 8kiB of a file, such as a plugin or theme.
     * Each piece of metadata must be on its own line. Fields can not span multiple
     * lines, the value will get cut at the end of the first line.
     *
     * If the file data is not within that first 8kiB, then the author should correct
     * their plugin file and move the data headers to the top.
     *
     * @param string $url of html|css
     * @param array $meta_list List of headers, in the format array('HeaderKey' => 'Header Name')
     */
    function parseMetaFromString($contents, $meta_list)
    {
        $file_data = str_replace("\r", "\n", $contents);
        $all_headers = $meta_list;

        $comment_regex = '/\/\*(.*?)\*\//s';
        preg_match_all($comment_regex, $contents, $matches);

        $comment_info = array();
        foreach ($matches[1] as $match) {
            $lines = explode("\n", $match);
            foreach ($lines as $line) {
                $key_value = explode(':', $line, 2);
                if( count($key_value) == 2 ){
                    $key = trim($key_value[0]);
                    $value = trim($key_value[1]);

                    $comment_info[$key] = $value;
                }
            }
        }
        
        foreach ($all_headers as $field => $regex) {
            if (empty($regex)) continue;
            
            if( isset( $comment_info[$regex] ) ){
                $all_headers[$field] = $comment_info[$regex];
            }else{
                $all_headers[$field] = "";
            }
        }
        return $all_headers;
    }
}

if ( !function_exists('parseMetaFromUrl') ) {
    /**
     * Retrieve metadata from a file.
     *
     * Searches for metadata in the first 8kiB of a file, such as a plugin or theme.
     * Each piece of metadata must be on its own line. Fields can not span multiple
     * lines, the value will get cut at the end of the first line.
     *
     * If the file data is not within that first 8kiB, then the author should correct
     * their plugin file and move the data headers to the top.
     *
     * @param string $url of html|css
     * @param array $meta_list List of headers, in the format array('HeaderKey' => 'Header Name')
     */
    function parseMetaFromUrl($url, $meta_list)
    {
        $contents = url_get_contents($url, true);
        $output = parseMetaFromString($contents, $meta_list);

        // if( empty( $output['name'] ) ){
        //     $parts = parse_url($url);
        //     $url .= isset($parts['query']) ? "&" : "?";
        //     $url .= "version=" . rand(50, 1000000000);
        //     $contents = url_get_contents($url, true);
        //     $output = parseMetaFromString($contents, $meta_list);
        // }
        return $output;
    }
}


if ( !function_exists('fetchAsGoogle') ) {

    /**
     * Get URL response as google bot sent
     * 
     * @param string $url
     * @return string
     */
    function fetchAsGoogle($url)
    {
        $header = array();
        $header[] = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
        $header[] = 'Cache-Control: max-age=0';
        $header[] = 'Content-Type: text/html; charset=utf-8';
        $header[] = 'Transfer-Encoding: chunked';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Keep-Alive: 300';
        $header[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
        $header[] = 'Accept-Language: en-us,en;q=0.5';
        $header[] = 'Pragma:';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        $body = curl_exec($curl);
        curl_close($curl);

        return $body;
    }
}


if ( !function_exists('getHttpResponseCode') ) {

    /**
     * Get HTTP Response Code
     * 
     * @param string $url
     * @return int
     */
    function getHttpResponseCode(string $url, bool $followRedirect=true): int
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $followRedirect);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36');
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpCode;
    }
}


if ( !function_exists('isHttpStatusCode200') ) {

    /**
     * Check url is giving success response
     * 
     * 
     * @param string $url
     * @return bool
     */
    function isHttpStatusCode200(string $url): bool
    {
        return getHttpResponseCode($url) === 200;
    }
}


if( ! function_exists( "getBearerToken" ) ){

    /**
     * Get bearer token from request header
     */
    function getBearerToken() {
        $headers = get_authorization_header();
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}


if( ! function_exists( "get_authorization_header" ) ){
    function get_authorization_header(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
}


if( !function_exists( "ast_send_json" ) ){
    /**
     * Print json output with status code
     * 
     * @param array|object $response
     * @param null|number $status_code
     * @param any $options
     */
    function ast_send_json($response, $status_code = null, $options = JSON_UNESCAPED_UNICODE){
        if ( ! headers_sent() ) {
            header( 'Content-Type: application/json; charset=utf-8' );
            if ( null !== $status_code ) {
                status_header( $status_code );
            }
        }

        if( is_api() ){
            if( is_object($response) ){
                $response = (array) $response;
            }

            if( isset($response['success']) ){
                update_api_limit();
            }
        }
    
        echo json_encode( $response, $options);
        die();
    }
}


if( ! function_exists( "get_status_header_desc" ) ){
    /**
     * Get header description
     * 
     * @param number $code
     * @return string
     */
    function get_status_header_desc( $code ) {
        $code = absint( $code );
        $header_to_desc = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            103 => 'Early Hints',
    
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            226 => 'IM Used',
    
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Reserved',
            307 => 'Temporary Redirect',
            308 => 'Permanent Redirect',
    
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',
            421 => 'Misdirected Request',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            451 => 'Unavailable For Legal Reasons',
    
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            510 => 'Not Extended',
            511 => 'Network Authentication Required',
        );
    
        if ( isset( $header_to_desc[ $code ] ) ) {
            return $header_to_desc[ $code ];
        } else {
            return '';
        }
    }
}


if( ! function_exists( "ast_get_server_protocol" ) ){
    /**
     * Get server protocol
     * 
     * @return string HTTP|HTTPS
     */
    function ast_get_server_protocol() {
        $protocol = isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : '';
        if ( ! in_array( $protocol, array( 'HTTP/1.1', 'HTTP/2', 'HTTP/2.0', 'HTTP/3' ), true ) ) {
            $protocol = 'HTTP/1.0';
        }
        return $protocol;
    }
}


if( ! function_exists( "absint" ) ){
    /**
     * Convert number to absolute number
     * 
     * @param number $maybeint
     * @return absolute $maybeint
     */
    function absint( $maybeint ) {
        return abs( (int) $maybeint );
    }
}


if( ! function_exists( "status_header" ) ){
    /**
     * Set status header
     * 
     * @param number $code
     * @param string $description
     */
    function status_header( $code, $description = '' ) {
        if ( ! $description ) {
            $description = get_status_header_desc( $code );
        }
    
        if ( empty( $description ) ) {
            return;
        }
    
        $protocol      = ast_get_server_protocol();
        $status_header = "$protocol $code $description";
    
        if ( ! headers_sent() ) {
            header( $status_header, true, $code );
        }
    }
}


if( ! function_exists( "ast_strip_all_tags" ) ){

    /**
     * Strip all HTML tags
     * 
     * @param string $string
     * @param boolean $remove_breaks
     * 
     * @return string
     */
    function ast_strip_all_tags( $string, $remove_breaks = false ) {
        $string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
        $string = strip_tags( $string );
    
        if ( $remove_breaks ) {
            $string = preg_replace( '/[\r\n\t ]+/', ' ', $string );
        }
    
        return trim( $string );
    }
}


if( ! function_exists( "ast_trim_words" ) ){
    /**
     * Get string by word count
     * 
     * @param string $text
     * @param number $num_words
     * @param string $more
     * 
     * @return string $text
     */
    function ast_trim_words( $text, $num_words = 55, $more = "" ) {
        $text          = ast_strip_all_tags( $text );
        $num_words     = (int) $num_words;
    
        $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
        $sep         = ' ';
    
        if ( count( $words_array ) > $num_words ) {
            array_pop( $words_array );
            $text = implode( $sep, $words_array );
            $text = $text . $more;
        } else {
            $text = implode( $sep, $words_array );
        }
    
        return $text;
    }
}


if( ! function_exists( "ast_trim_characters" ) ){
    /**
     * Get string by character count
     * 
     * @param string $text
     * @param number $num_character
     * @param string $more
     * 
     * @return string $text
     */
    function ast_trim_characters( $text, $num_character = 55, $more = "" ) {
        $text          = ast_strip_all_tags( $text );
        $text = substr($text, 0, intval($num_character));
        return $text . $more;
    }
}

if (!function_exists('extractHostname')) {
    /**
     * Get domain or hostname from string
     *
     * @param string $url
     * @param boolean $domainName
     *
     * @return string
     */
    function extractHostname(string $url, $domainName = false)
    {
        if (!preg_match('#^http(s)?://#', $url)) {
            $url = 'http://' . $url;
        }

        $url = parse_url($url, PHP_URL_HOST);

        if ($domainName && preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $url, $matches)) {
            $url = $matches['domain'];
        }

        return $domainName ? preg_replace('/^www\./', '', $url) : $url;
    }
}

if (!function_exists('extractDomainurl')) {
    /**
     * Get domain url from string
     *
     * @param string $url
     * @param boolean $domainName
     *
     * @return string
     */
    function extractDomainurl(string $url)
    {
        if (!preg_match('#^http(s)?://#', $url)) {
            $url = 'http://' . $url;
        }

        $parsedUrl = parse_url($url);
        return $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
    }
}

if( ! function_exists( "get_long_url" ) ){
    /**
     * Get redirect full url from short url
     * 
     * @param string $url
     * 
     * @return string $url
     */
    function get_long_url($url, $maxRedirect=3){
        $ch = curl_init();

        $curlOptions = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
            CURLOPT_REFERER => "",
            CURLOPT_HTTPHEADER => array(
                "User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
            ),
            CURLOPT_MAXREDIRS => $maxRedirect
        );
        curl_setopt_array($ch, $curlOptions);
        curl_exec($ch);
        $longUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        
        return $longUrl;
    }
}


if( ! function_exists( "hex_to_rgba" ) ){
    /**
     * Convert hex code to rgba
     */
    function hex_to_rgba($hex, $alpha = false) {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);

        $colorcode = $alpha ? 'rgba(' : 'rgb(';
        $colorcode .= hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0)) . ", ";
        $colorcode .= hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0)) . ", ";
        $colorcode .= hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        
        if ( $alpha ) {
            $colorcode .= ", " . $alpha;
        }
        $colorcode .= ")";
        return $colorcode;
    }
}

if( ! function_exists( "rgb_implode" ) ){
    /**
     * Convert hex code to rgba
     */
    function rgb_implode( $hex ) {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);

        $colorcode = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0)) . ", ";
        $colorcode .= hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0)) . ", ";
        $colorcode .= hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        
        return $colorcode;
    }
}

function url_get_contents($url, $referer=false){
    $process = curl_init($url); 
    curl_setopt($process, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36'); 
    curl_setopt($process, CURLOPT_TIMEOUT, 60); 
    curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($process, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($process, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 2);        
    curl_setopt($process, CURLOPT_FRESH_CONNECT, TRUE);
    curl_setopt($process, CURLOPT_FORBID_REUSE, TRUE);

    if( $referer ){
        curl_setopt($process, CURLOPT_REFERER, $url);
    }

    $return = curl_exec($process);
    curl_close($process);
    return $return;
}

if( ! function_exists( "get_all_links_from_url" ) ){
    /**
     * GET LINKS BY CRAWLING URL
     * 
     * @param string $my_url
     * 
     * @return array
     */
    function get_all_links_from_url( $my_url ){
        require_once INCLUDE_PATH . "simple_html_dom.php";
        $ex_data_arr = $int_data = [];

        $html = url_get_contents($my_url);
        if (empty($html)) {
            return false;
        }

        $data = str_get_html($html);
        if (empty($data)) {
            return false;
        }
        
        //Parse Host
        $my_url_parse = parse_url($my_url);
        $inputHost = $my_url_parse["scheme"] . "://" . $my_url_parse["host"];
        $my_url_host = str_replace("www.", "", $my_url_parse["host"]);
        $my_url_path = isset($my_url_parse["path"]) ? $my_url_parse["path"] : "";
        $my_url_query = isset($my_url_parse["query"]) ? $my_url_parse["query"] : "";
        $find_out = $data->find("a");
        
        foreach ($find_out as $href) {
            if (!in_array($href->href, $ex_data_arr)) {
                if (substr($href->href, 0, 1) != "" && $href->href != "#") {
                    $ex_data_arr[] = $href->href;
                    $ex_data[] = [
                        "href" => $href->href,
                        "rel" => $href->rel,
                    ];
                }
            }
        }
        
        foreach ($ex_data as $count => $link) {
            $parse_urls = parse_url($link["href"]);
            $urlhost = isset( $parse_urls["host"] ) ? $parse_urls["host"] : "";
    
            if (
                isset( $parse_urls["host"] )
                && ($parse_urls["host"] == $my_url_host
                || $parse_urls["host"] == "www." . $my_url_host)
            ) {
                if (substr($link["href"], 0, 7) == "http://") {
                    //Link Okay
                } elseif (substr($link["href"], 0, 8) == "https://") {
                    //Link Okay
                } elseif (substr($link["href"], 0, 2) == "//") {
                    $link["href"] = "http:" . $link["href"];
                } elseif (substr($link["href"], 0, 1) == "/") {
                    $link["href"] = $inputHost . $link["href"];
                } else {
                    $link["href"] = $inputHost . "/" . $link["href"];
                }
        
                if (!in_array($link["href"], $int_data)) {
                    if (!in_array($link["href"] . "/", $int_data)) {
                        if (
                            !empty( $link["href"] )
                            && !(strpos($link["href"], "cdn-cgi") !== false)
                            && !(strpos($link["href"], ".xml") !== false)
                            && !empty( $urlhost )
                            && substr_count($link["href"], $urlhost) == 1
                        ) {
                            $int_data[] = $link["href"];
                        }
                    }
                }
            } elseif (
                substr($link["href"], 0, 2) != "//" &&
                substr($link["href"], 0, 1) == "/"
            ) {
                if (substr($link["href"], 0, 7) == "http://") {
                    //Link Okay
                } elseif (substr($link["href"], 0, 8) == "https://") {
                    //Link Okay
                } elseif (substr($link["href"], 0, 2) == "//") {
                    $link["href"] = "http:" . $link["href"];
                } elseif (substr($link["href"], 0, 1) == "/") {
                    $link["href"] = $inputHost . $link["href"];
                } else {
                    $link["href"] = $inputHost . "/" . $link["href"];
                }
        
                if (!in_array($link["href"], $int_data)) {
                    if (!in_array($link["href"] . "/", $int_data)) {
                        if (
                            !empty( $link["href"] )
                            && !(strpos($link["href"], "cdn-cgi") !== false)
                            && !(strpos($link["href"], ".xml") !== false)
                            && !empty( $urlhost )
                            && substr_count($link["href"], $urlhost) == 1
                        ) {
                            $int_data[] = $link["href"];
                        }
                    }
                }
            } else {
                if (
                    substr($link["href"], 0, 7) != "http://" &&
                    substr($link["href"], 0, 8) != "https://" &&
                    substr($link["href"], 0, 2) != "//" &&
                    substr($link["href"], 0, 1) != "/" &&
                    substr($link["href"], 0, 1) != "#" &&
                    substr($link["href"], 0, 2) != "//" &&
                    substr($link["href"], 0, 4) != "tel:" &&
                    substr($link["href"], 0, 6) != "mailto" &&
                    substr($link["href"], 0, 10) != "javascript"
                ) {
                    //Link Okay
                    $link["href"] = $inputHost . "/" . $link["href"];
        
                    if (!in_array($link["href"], $int_data)) {
                        if (!in_array($link["href"] . "/", $int_data)) {
                            if (
                                !empty( $link["href"] )
                                && !(strpos($link["href"], "cdn-cgi") !== false)
                                && !(strpos($link["href"], ".xml") !== false)
                                && !empty( $urlhost )
                                && substr_count($link["href"], $urlhost) == 1
                            ) {
                                $int_data[] = $link["href"];
                            }
                        }
                    }
                }
            }
        }
        
        return $int_data;    
    }
}