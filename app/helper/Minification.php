<?php

namespace AST\Helper;

use AST\FileSystem;
use WyriHaximus\JsCompress\Factory;

class Minification{

    private $settings;
    public $scripts;
    private $before_script;
    private $after_script;

    public function __construct(){
        require_once PACKAGES_PATH . "matthiasmullie/vendor/autoload.php";
        $this->settings = get_settings("minification", (object) array(
            "minify" => false
        ));
        
        $this->scripts = array(
            "footer" => array(
                "css" => array(),
                "js" => array()
            ),
            "header" => array(
                "css" => array(),
                "js" => array()
            )
        );

        $this->before_script = array();
        $this->after_script = array();
    }

    private function getOutput($file, $ext="js"){
        $filename = basename($file);
        $newFilename = str_replace(".$ext", ".min.$ext", $filename);
        return str_replace($filename, $newFilename, $file);
    }
    
    private function minify_css($input) {
        if(trim($input) === "") return $input;
        return preg_replace(
            array(
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
                '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
                '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
                '#(background-position):0(?=[;\}])#si',
                '#(?<=[\s:,\-])0+\.(\d+)#s',
                '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
                '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
                '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
                '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
                '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
            ),
            array(
                '$1',
                '$1$2$3$4$5$6$7',
                '$1',
                ':0',
                '$1:0 0',
                '.$1',
                '$1$3',
                '$1$2$4$5',
                '$1$2$3',
                '$1:0',
                '$1$2'
            ),
        $input);
    }

    public function minifyCSS($file){
        if( $this->alreadyMinified( $file ) ){
            return false;
        }
        
        $code = file_get_contents($file);
        if( class_exists( "JavaScriptPacker" ) ){
            $packed = $this->minify_css($code);
            $outputFile = $this->getOutput($file, "css");

            $directory = dirname($outputFile);
            if( ! is_writable( $directory ) ){
                exec("chmod 777 $directory");
                if( ! is_writable($directory) ){
                    return false;
                }
            }

            return FileSystem::write($outputFile, $packed);
        }
        return false;
    }

    public function minifyJS($file){
        if( $this->alreadyMinified( $file ) ){
            return false;
        }
        
        $code = file_get_contents($file);
        $packed = Factory::construct()->compress($code);
        if( !empty( $packed ) ){
            $outputFile = $this->getOutput($file, "js");

            $directory = dirname($outputFile) . "/";
            if( ! is_writable( $directory ) ){
                return false;
            }

            return FileSystem::write($outputFile, $packed);
        }

        return false;
    }

    public function alreadyMinified($file){
        return str_contains($file, ".min");
    }

    public function minify(){

        /** MINIFY JS TOOLS */
        foreach(glob(TOOLS_PATH . "*") as $tool){
            if( is_dir( $tool ) ){
                if( file_exists( $tool . "/main.js" ) ){
                    // self::minifyJS( $tool . "/main.js" );
                }else if( file_exists( $tool . "/assets/js/" ) ){
                    foreach(glob($tool . "/assets/js/*") as $assetsFile){
                        if ( is_file($assetsFile) ){
                            self::minifyJS( $assetsFile ); 
                        }  
                    }
                }
            }
        }

        return true;

        /** MINIFY THEME JS FILES */
        foreach(glob(get_theme_path() . "assets/js/*") as $jsFile){
            if( file_exists( $jsFile ) ){
                self::minifyJS( $jsFile );
            }
        }

        /** MINIFY PLUGIN JS FILES */
        foreach(glob(PLUGINS_PATH . "*") as $plugin){
            if( is_dir( $plugin ) ){
                if( file_exists( $plugin . "/main.js" ) ){
                    self::minifyJS( $plugin . "/main.js" );
                }else if( file_exists( $plugin . "/assets/js/main.js" ) ){
                    self::minifyJS( $plugin . "/assets/js/main.js" );
                }
            }
        }

        /** MINIFY THEME CSS FILES */
        foreach(glob(get_theme_path() . "assets/css/*") as $cssFile){
            if( file_exists( $cssFile ) ){
                self::minifyCSS( $cssFile );
            }
        }

    }

    private function render_css_code($stylesheetInfo){
        $id = $stylesheetInfo['id'];
        $url = $stylesheetInfo['url'];
        $atts = $stylesheetInfo['atts'];
        if( ! isset( $atts['rel'] ) ){
            $atts['rel'] = "stylesheet";
        }

        $attsStr = '';
        if (!empty($atts)) {
            foreach ($atts as $key => $value) {
                $attsStr .= ' ' . $key . '="' . $value . '"';
            }
        }
        
        return '<link id="' . $id . '-css" href="' . $this->filterURL($url) . '"' . $attsStr . '>' . PHP_EOL;
    }

    private function include_ba_scripts($on, $id){
        if( $on == 'before' ){
            if( isset( $this->before_script[$id] ) ){
                return sprintf('<script>%s</script>', $this->before_script[$id]) . PHP_EOL;
            }
        }else{
            if( isset( $this->after_script[$id] ) ){
                return sprintf('<script>%s</script>', $this->after_script[$id]) . PHP_EOL;
            }
        }
    }

    private function render_js_code($scriptInfo){
        $id = $scriptInfo['id'];
        $url = $scriptInfo['url'];
        $atts = $scriptInfo['atts'];

        $attsStr = '';
        if (!empty($atts)) {
            foreach ($atts as $key => $value) {
                $attsStr .= ' ' . $key . '="' . $value . '"';
            }
        }
        
        return '<script id="' . $id . '-js" src="' . $this->filterURL($url) . '"' . $attsStr . '></script>' . PHP_EOL;
    }

    private function filterURL( $url ){
        
        if( filter_var( $this->settings->minify, FILTER_VALIDATE_BOOLEAN ) ){
            if( str_contains($url, "ver=") ){
                $parsedUrl = parse_url($url);
                if (isset($parsedUrl['query'])) {
                    parse_str($parsedUrl['query'], $query);
                    unset($query['ver']);
                    $queryString = http_build_query($query);
                    $modifiedUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];
                
                    if (!empty($queryString)) {
                        $modifiedUrl .= '?' . $queryString;
                    }

                    return $modifiedUrl;
                }
            }
        }

        return $url;
    }

    public function include_front_scripts( $type="footer" ){
        if( 
            isset( $this->scripts[$type]['css'] ) 
            && isset( $this->scripts[$type]['js'] ) 
        ){
            /** INCLUDE CSS CODE */
            if( ! empty( $this->scripts[$type]['css'] ) ){
                foreach($this->scripts[$type]['css'] as $script){
                    echo $this->render_css_code($script);
                }
            }

            /** INCLUDE JS CODE */
            if( ! empty( $this->scripts[$type]['js'] ) ){
                foreach($this->scripts[$type]['js'] as $script){
                    echo $this->include_ba_scripts("before", $script['id']);
                    echo $this->render_js_code($script);
                    echo $this->include_ba_scripts("after", $script['id']);
                }
            }
        }
    }

    public function add_script($id, $url, $atts=array(), $footer=false, $type="js"){
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
        $footerKey = $footer ? "footer" : "header";

        if( isset( $this->scripts[$footerKey][$type] ) ){
            if( isset( $this->scripts[$footerKey][$type][$id] ) ) return false;

            if( ! $this->alreadyMinified($url) && filter_var( $this->settings->minify, FILTER_VALIDATE_BOOLEAN ) ){
                $path = get_path_from_url($url);
                if( $path ){
                    $minFile = $this->getOutput($path, $type);
                    if( file_exists( $minFile ) ){
                        $fileName = pathinfo($path, PATHINFO_FILENAME);
                        $url = str_replace($fileName, $fileName . ".min", $url);
                    }
                }
            }

            $temp = array(
                "id" => $id,
                "url" => $url,
                "atts" => $atts
            );
            $this->scripts[$footerKey][$type][] = $temp;
        }

        return true;
    }

    public function add_code_ba_script($on, $id, $code){
        if( $on == 'before' ){
            $this->before_script[$id] = $code;
        }else{
            $this->after_script[$id] = $code;
        }
    }

}