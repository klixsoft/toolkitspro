<?php
/**
 * Core class used to generate Sitemap functionality.
 *
 * @since 1.0
 * @package AllSmartTools
 * @subpackage Sitemap
 */

namespace AST\Helper;

use AST\Options;

class Sitemap {

    /**
     * The one true Language.
     *
     * @var Language
     * @since 1.0.0
     * @access private
     **/
    private static $instance;
    private $settings;


    public function __construct(){  
        $this->urls = [];    
        $this->code = "";  
        $this->file = ASTROOTPATH . "sitemap.xml";
        $this->settings = get_settings("sitemap", array (
            'cronjob' => 'true',
            'priority_auto' => 'true',
            'priority' => '0.9',
            'frequency' => 'always',
        ));

        self::$instance = $this;
    }

    public function add_main_website(){
        $this->urls[] = array(
            "url" => get_site_url(),
            "time" => date("c")
        );
    }

    private function add_pages(){
        global $db;
        $db->where("type", "page");
        $db->orderBy("id", "asc");
        $pages = $db->get("posts");
        if( !empty( $pages ) ){
            foreach($pages as $k => $page){
                $this->urls[] = array(
                    "url" => get_site_url("/page/" . $page->slug . "/"),
                    "time" => date('c', strtotime($page->modified))
                );
            }
        }
    }

    private function add_posts(){
        global $db;
        $db->where("type", "post");
        $db->orderBy("id", "asc");
        $pages = $db->get("posts");
        if( !empty( $pages ) ){
            foreach($pages as $k => $page){
                $this->urls[] = array(
                    "url" => get_post_url("slug", $page->slug),
                    "time" => date('c', strtotime($page->modified))
                );
            }
        }
    }

    private function add_tools(){
        global $db;
        $db->where("type", "tool");
        $db->orderBy("id", "asc");
        $pages = $db->get("posts");
        if( !empty( $pages ) ){
            foreach($pages as $k => $page){
                $this->urls[] = array(
                    "url" => get_tool_url("slug", $page->slug),
                    "time" => date('c', strtotime($page->modified))
                );
            }
        }
    }

    /**
     * Start Generating Sitemap
     */
    public function start(){
        $this->code = '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL;
        $styleurl = get_site_url("admin_file/assets/css/sitemap.xsl");
        $styleurl = apply_filters("ast/sitemap/style/url", $styleurl);
        $this->code .= sprintf('<?xml-stylesheet type="text/xsl" href="%s"?>', $styleurl) . PHP_EOL;
        $this->code .= '<urlset
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        //start generating urls
        $this->add_main_website();
        $this->add_pages();
        $this->add_posts();
        $this->add_tools();

        $priority = "0.9";
        $frequency = "daily";
        if( filter_var($this->settings->priority_auto, FILTER_VALIDATE_BOOLEAN) ){
            $priority = $this->settings->priority;
            $frequency = $this->settings->frequency;
        }

        //generate xml for urls
        foreach($this->urls as $url){
            $this->code .= sprintf('<url>
                    <loc>%s</loc>
                    <lastmod>%s</lastmod>
                    <priority>%s</priority>
                    <changefreq>%s</changefreq>
                </url>', 
                $url['url'], 
                $url['time'],
                $priority,
                $frequency
            );
        }

        $this->code .= '</urlset>';

        //Update files
        return $this->update();
    }

    /**
     * Update xml code to sitemap file
     * 
     * @since 1.0
     */
    private function update(){
        if(file_put_contents($this->file, $this->code)){
            $loadxml = simplexml_load_file( $this->file );
            $dom = new \DOMDocument('1.0');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($loadxml->asXML());
            $formatxml = new \SimpleXMLElement($dom->saveXML());

            return file_put_contents($this->file, $formatxml->saveXML());
        }
        return false;
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