<?php

namespace AST\Helper;

class ColumnHelper extends \AST\TagParser{

    private $types = array(
        "text" => "Text",
        "populartools" => "Popular Tools",
        "latesttools" => "Latest Tools",
        "popularposts" => "Popular Tools",
        "latestposts" => "Latest Posts",
        "menu" => "Menu"
    );

    public function __construct(){
        parent::__construct();
    }

    public function get_card($type, $label, $settings){
        include APP_PATH . "templates/columns/wrapper.php";
    }

    public function get_card_json(){
        $output = array();
        foreach($this->types as $type => $v){
            ob_start();
            if( $type == 'text' ){
                include APP_PATH . "templates/columns/text.php";
            }else if( $type == 'populartools' || $type == 'latesttools' || $type == 'popularposts' || $type == 'latestposts' ){
                include APP_PATH . "templates/columns/count.php";
            }else if( $type == 'menu' ){
                include APP_PATH . "templates/columns/menu.php";
            }
            $output[$type] = ob_get_contents();
            ob_get_clean();
        }
        return $output;
    }

    public function front($type, $col, $settings){
        echo '<div>';
        echo sprintf('<h6>%s</h6>', $settings['title']);
        
        if( $type == 'text' ){
            $content = $this->parse($settings['text']);
            echo sprintf('<div>%s</div>', $content);
        }else if( $type == 'populartools' ){
            $posts = get_popular_tools(empty($settings['count']) ? 5 : intval($settings['count']));
            include APP_PATH . "templates/columns/front_count.php";
        }else if( $type == 'latesttools' ){
            $posts = get_latest_tools(empty($settings['count']) ? 5 : intval($settings['count']));
            include APP_PATH . "templates/columns/front_count.php";
        }else if( $type == 'popularposts' ){
            $posts = get_popular_posts(empty($settings['count']) ? 5 : intval($settings['count']));
            include APP_PATH . "templates/columns/front_count.php";
        }else if( $type == 'latestposts' ){
            $posts = get_latest_posts(empty($settings['count']) ? 5 : intval($settings['count']));
            include APP_PATH . "templates/columns/front_count.php";
        }else if( $type == 'menu' ){
            if( isset( $settings['menu'] ) && !empty($settings['menu']) ){
                $menus = get_settings($settings['menu']);
                if( !empty($menus) ){
                    $menus = (array) $menus;
                    include APP_PATH . "templates/columns/front_menu.php";
                }
            }
        }

        echo '</div>';
    }

}