<?php

namespace Tool;

class domainNameSearch{

    private $counts = 20;
    private $buynowlink = "";

    public function __construct($keyword, $ext){
        $this->keyword = $keyword;
        $this->keyword_dash = title_to_slug($keyword);
        $this->keyword_withoutdash = str_replace("-", "", $this->keyword_dash);
        $this->ext = $ext;

        if( isset( $_POST['toolid'] ) ){
            $this->counts = get_meta("tool", $_POST['toolid'], "suggestion_count", $this->counts);
            $this->buynowlink = get_meta("tool", $_POST['toolid'], "buy_now_link");
        }
    }

    public function get(){
        $suggestions = $this->getSugesstionWords();
        $output = array();
        foreach($suggestions as $key => $suggestion){
            $domain = $suggestion . "." . $this->ext;
            $buynowlink = str_replace(array("{{domain}}", "{{url}}"), array($domain, "http://$domain"), $this->buynowlink);
            $output[] = array(
                "domain" => $domain,
                "already" => gethostbyname($domain) != $domain,
                "buy" => $buynowlink
            );

            if( $this->counts <= $key ) break;
        }
        return $output;
    }

    public function getSugesstionWords()
    {
        $amazon = $this->amazonSuggetions($this->keyword);
        $google = $this->googleSuggetions($this->keyword);
        $bing = $this->bingSuggetions($this->keyword);
        $list = array_merge($amazon, $google, $bing);
        $list = array_filter($list, function($item){
            return str_word_count($item) > 1 && str_word_count($item) < 4;
        });

        $suggestions = array();
        $suggestions[] = $this->keyword_dash;
        $suggestions[] = $this->keyword_withoutdash;
        foreach($list as $k => $v){
            $slug = title_to_slug($v);
            $suggestions[] = $slug;
            $suggestions[] = str_replace("-", "", $slug);
        }
        return array_unique($suggestions);
    }

    protected function googleSuggetions($keyword)
    {
        $endpoint = "http://suggestqueries.google.com/complete/search?output=chrome&&hl=en&q=" . $keyword;
        $json = getRequest($endpoint);
        $list = @json_decode($json, TRUE);
        return @$list[1] ?? [];
    }

    protected function bingSuggetions($keyword)
    {
        $endpoint = "https://api.bing.com/osjson.aspx?JsonType=callback&JsonCallback&Query={$keyword}&Market=en-us";
        $json = getRequest($endpoint);
        $list = @json_decode($json, TRUE);
        return @$list[1] ?? [];
    }

    protected function amazonSuggetions($keyword)
    {
        $endpoint = "https://completion.amazon.com/search/complete?q={$keyword}&method=completion&search-alias=aps&mkt=1";
        $json = getRequest($endpoint);
        $list = @json_decode($json, TRUE);
        return @$list['gossip']['results'] ?? [];
    }

}