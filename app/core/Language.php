<?php
/**
 * Core class used to implement language functionality.
 *
 * @since 1.0
 * @package ToolkitsPRO
 * @subpackage Language
 */

namespace AST;

class Language {

    /**
     * The one true Language.
     *
     * @var Language
     * @since 1.0.0
     * @access public
     **/
    public static $instance;

    private $active = "en";
    private $languages = [];
    private $lndata = [];

    public function __construct() {
        $configlang = get_setting( "languages" );
        if( ! empty( $configlang ) ){
            $this->active = isset($configlang['active']) ? $configlang['active'] : "en";
            $this->languages = isset($configlang['available']) ? $configlang['available'] : array();
            
            /** Get Language Data */
            $this->getLangData();
        }else{
            throw new \Exception("Language Configuration file is mising. Please contact support team.");
        }
        self::$instance = $this;
    }

    public function getLangData(){
        $path = LANG_PATH . $this->active . ".json";
        if( file_exists( $path ) ){
            $langData = file_get_contents( $path );
            if( isJson( $langData ) ){
                $this->lndata = apply_filters( "ToolkitsPRO\Language\data", $langData, $this->active );
            }else{
                throw new \Exception("Active Language ({$this->active}) contain invalid language data. Please contact support team.");
            }
        }else{
            throw new \Exception("Active Language ({$this->active}) file is missing. Please contact support team.");
        }
        return $this->lndata;
    }

    public function get($name, $default) {
        if( empty( $lndata ) ){
            $this->getLangData();
        }
        
        $key = is_admin() ? "admin" : "front";
        if( isset( $language[$key][$name] ) ){
            return $language[$key][$name];
        }
        return $default;
    }

    public function set($name) {

        if(in_array($name, $this->get_languages())) {
            $this->active = apply_filters( "ToolkitsPRO\Language", $name );
            $this->getLangData();
        }else{
            return new \Exception("Provide Language ($name) is invalid language format.");
        }
    }

    public function get_active(){
        if( empty( $this->active ) ){
            return "en";
        }
        return trim($this->active);
    }

    public function get_languages(){
        if( empty( $this->languages ) ){
            return array();
        }

        return array_keys( $this->languages );
    }

    /**
	 * Main Language Instance.
	 * Insures that only one instance of Language exists in memory at any one time.
	 *
	 * @static
     * @since 1.0.0
	 * @return Language
	 **/
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}