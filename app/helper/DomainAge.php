<?php

namespace AST\Helper;

use Carbon\Carbon;
use Iodev\Whois\Factory;
use DateTime;

class DomainAge
{
    public function parse($domain)
    {
        $host = extractHostname($domain, true);
        $whois = Factory::get()->createWhois();
        $info = $whois->loadDomainInfo($host);
        $content = $this->results($info);
        return compact('domain', 'content');
    }

    public function nameAvaiability($domain)
    {
        $msg  = "<span class='text-danger'>Registered</span>";
        $whois = Factory::get()->createWhois();
        if ($whois->isDomainAvailable($domain)) {
            $msg = "<span class='text-success'>Available</span>";
        }

        $content = $this->resultsName($msg, $domain);
        return compact('domain', 'content');
    }

    public function whois($domain){
        $host = extractHostname($domain, true);
        $whois = Factory::get()->createWhois();
        $response = $whois->lookupDomain($domain);
        $content = $response->text;
        return compact('domain', 'content');
    }

    protected function diff($date1){
        $first_date = new DateTime($date1);
        $second_date = new DateTime();

        $interval = $first_date->diff($second_date);

        $result = "";
        if ($interval->y) { $result .= $interval->format("%y years "); }
        if ($interval->m) { $result .= $interval->format("%m months "); }
        if ($interval->d) { $result .= $interval->format("%d days "); }

        return $result;
    }

    public function extractData( $whois )
    {
        $roles = array(
            "registrant" => "Registrant", 
            "administrative" => "Admin", 
            "technical" => "Tech"
        );

        $keys = array(
            "Name",
            "Organization",
            "Street",
            "City",
            "State\/Province",
            "Postal Code",
            "Country",
            "Phone",
            "Phone Ext",
            "Fax",
            "Fax Ext",
            "Email"
        );

        $output = array();
        foreach($roles as $role => $role_title){
            $output[$role] = array();
            foreach($keys as $key){
                $pattern = "/$role_title $key:(.*)/im";
                preg_match_all($pattern, $whois, $matches);
                if( ! empty( $matches[1] ) ){
                    $key = str_replace(array("\/", "Ext"), array("/", "Extra"), $key);
                    $output[$role][$key] = trim($matches[1][0]);
                }
            }
        }
        return $output;
    }

    protected function results($info)
    {
        if( ! empty( $info ) ){
            $expire_date = Carbon::parse($info->expirationDate);
            $registered_date = Carbon::parse($info->creationDate);
            $updated_date = Carbon::parse($info->updatedDate);
            
            $currentDate = Carbon::now();
            $domain_age = $expire_date->diffInDays($currentDate);
            $domainExpire = $currentDate->diffInDays($expire_date, false);
            
            $date1 = $registered_date->format('Y-m-d h:i:s');
            return  [
                'expiry' => $expire_date->format('d M, Y H:i A'),
                "expiryage" => $this->diff($expire_date->format('Y-m-d h:i:s')),
                'created' => $registered_date->format('d M, Y H:i A'),
                'updated' => $updated_date->format('d M, Y H:i A'),
                'age' => $this->diff($date1),
                'domain' => $info->domainName,
                'expireafter' => $domainExpire
            ];
        }else{
            return  [
                'expiry' => false,
                'expiryage' => false,
                'created' => false,
                'updated' => false,
                'age' => false,
                'domain' => false,
                'expireafter' => false
            ];
        }
    }

    protected function resultsName($msg, $domain)
    {
        return  [
            'status' => $msg,
            'domain' => $domain,
        ];
    }
}
