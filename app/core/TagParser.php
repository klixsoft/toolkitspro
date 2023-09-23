<?php
/**
 * Core class used to replace website tags
 *
 * @since 1.0
 * @package ToolKitsPRO
 * @subpackage Sitemap
 */

namespace AST;

use AST\Options;

class TagParser {

    protected $wrapper = "%";
    protected $settings;
    protected $default_tags = array(
        "%sitename%",
        "%sitedes%",
        "%sep%",
        "%currentdate%",
        "%currentyear%",
        "%currentmonth%",
        "%currenttime%",
        "%adminemail%",
        "%sitelogo%"
    );
    protected $type = "page";
    protected $data = false;

    public function __construct(){
        $this->settings = get_settings("basic");
    }

    public function setWrapper($wrapper){
        $this->wrapper = $wrapper;
    }

    protected function parse_sitelogo(){
        return get_site_logo();
    }

    protected function parse_sitelogodark(){
        if( @$this->settings && property_exists( @$this->settings, "website_dark_logo" ) ){
            return @$this->settings->website_dark_logo;
        }
        return false;
    }

    protected function parse_sitetitle( ){
        if( @$this->settings && property_exists( @$this->settings, "name" ) ){
            return @$this->settings->name;
        }
        return false;
    }

    protected function parse_sitename( ){
        if( @$this->settings && property_exists( $this->settings, "name" ) ){
            return @$this->settings->name;
        }
        return false;
    }

    protected function parse_sitedes( ){
        if( @$this->settings && property_exists( @$this->settings, "description" ) ){
            return @$this->settings->description;
        }
        return false;
    }

    protected function parse_sep( ){
        if( @$this->settings && property_exists( @$this->settings, "separator" ) ){
            return @$this->settings->separator;
        }
        return "-";
    }

    protected function parse_adminemail(){
        return Options::get("adminemail");
    }

    protected function parse_currenttime( ){
        return date("h:i A");
    }

    protected function parse_currentmonth( ){
        return date("F");
    }

    protected function parse_currentyear( ){
        return date("Y");
    }

    protected function parse_currentdate( ){
        return date("d");
    }

    protected function parse( $parse_text ){
        $regex = "/($this->wrapper)((?!$this->wrapper|$this->wrapper).)*($this->wrapper)/";
        return preg_replace_callback($regex, function($match){
            $matchquote = str_replace($this->wrapper, "", $match[0]);

            if( in_array( $match[0], $this->default_tags ) ){
                $callback_func = "parse_$matchquote";
                $matchquote = $this->$callback_func($this->type, $this->data);
            }

            return $matchquote;
        }, $parse_text);
    }

}