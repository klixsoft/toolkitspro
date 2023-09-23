<?php

namespace AST\Helper;

use GuzzleHttp\Client;

class IpApi
{
    protected $IP;
    protected $endpoint = "http://ip-api.com/json/%s";

    public function __construct(){
        $this->IP = $this->userIP();
        $this->setEndpoint();
    }

    public function setEndpoint(){
        $this->endpoint = "http://ip-api.com/json/%s";
    }

    public function userIP(){
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function parse($ip="")
    {
        if( empty( $ip ) ){
            $ip = $this->IP;
        }

        $ip = $this->validateIp($ip);
        $endpoint = sprintf($this->endpoint, $ip);
        
        $response = (new Client())->request('GET', $endpoint, ['query' => []]);
        $body = json_decode($response->getBody(), true);
        $content = $this->results($body);

        return compact('ip', 'content');
    }

    protected function results(array $body)
    {
        return $body['status'] == 'fail' ? false : [
            'country' => $body['country'],
            'country_code' => $body['countryCode'],
            'city' => $body['city'],
            'region' => $body['regionName'],
            'region_code' => $body['region'],
            'zip' => $body['zip'],
            'lat' => $body['lat'],
            'lon' => $body['lon'],
            'timezone' => $body['timezone'],
            'isp' => $body['org'],
            'ip' => $body['query'],
        ];
    }

    protected function validateIp($ip)
    {
        return in_array($ip, ['::1', '127.0.0.1']) ? '' : $ip;
    }
}
