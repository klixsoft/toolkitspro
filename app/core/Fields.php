<?php
/**
 * Core class used to implement Fields.
 *
 * @since 1.0
 * @package AllSmartTools
 * @subpackage Fields
 */

namespace AST;

class Fields {

    /**
     * The one true Language.
     *
     * @var Language
     * @since 1.0.0
     * @access private
     **/
    private static $instance;

    /**
     * Set Field Settings
     * 
     * @type - input:type
     * @title - string
     * @attrs - array
     * @value - string
     * @options - incase of select value
     */
    private $settings;
    
    public function __construct(){
        self::$instance = $this;
    }

    public function set($settings = array()){
        $this->settings = (object) array_merge(array(
            "type" => "",
            "atts" => array(),
            "title" => "",
            "value" => "",
            "options" => array(),
            "toggle" => array("Yes", "No"),
            "after_input" => "",
            "wrapper" => "%s",
            "large" => false,
            "width" => 0
        ), $settings);
        return $this;
    }

    public function render( $return = false ){
        $output = '';
        if( @$this->settings->type == 'input' ){
            $output = $this->render_input_type();
        }if( @$this->settings->type == 'textarea' ){
            $output = $this->render_textarea_type();
        }else if( @$this->settings->type == 'toggle' ){
            $output = $this->render_toggle_type();
        }else if( @$this->settings->type == 'select' ){
            $output = $this->render_select_type();
        }

        if( $return ){
            return sprintf($this->settings->wrapper, $output);
        }

        echo sprintf($this->settings->wrapper, $output);
    }

    private function get_attr_name(){
        if( isset($this->settings->atts['name']) ){
            return $this->settings->atts['name'];
        }
        return false;
    }

    private function get_atts(){
        $output = '';
        foreach($this->settings->atts as $key => $val){
            if( @$this->settings->type == 'toggle' && $key == 'class' ){
                $val .= ' ast-switch-input ';
            }else if( @$this->settings->type == 'toggle' && $key == 'name' ){
                $val = '';
            }

            if( empty( $val ) ){
                $output .= sprintf('%s ', $key);
            }else{  
                $output .= sprintf('%s="%s" ', $key, $val);
            }
        }
        return $output;
    }

    private function render_input_type(){
        $html = '<div class="form-group">';

        if( !empty( @$this->settings->title ) )
            $html .= sprintf('<label>%s</label>', @$this->settings->title);

        $html .= sprintf('<input %s value="%s"/>', $this->get_atts(), @$this->settings->value);

        if( !empty( @$this->settings->after_input ) ){
            $html .= sprintf('<small>%s</small>', @$this->settings->after_input);
        }
        
        $html .= '</div>';
        return $html;
    }

    private function render_textarea_type(){
        $html = '<div class="form-group">';

        if( !empty( @$this->settings->title ) )
            $html .= sprintf('<label>%s</label>', @$this->settings->title);

        $html .= sprintf('<textarea %s >%s</textarea>', $this->get_atts(), @$this->settings->value);

        if( !empty( @$this->settings->after_input ) ){
            $html .= sprintf('<small>%s</small>', @$this->settings->after_input);
        }

        $html .= '</div>';
        return $html;
    }

    private function render_select_type(){
        $html = '<div class="form-group">';

        if( !empty( @$this->settings->title ) )
            $html .= sprintf('<label>%s</label>', @$this->settings->title);

        $html .= sprintf('<select %s >', $this->get_atts());

        foreach($this->settings->options as $val => $title){
            $selected = $val == $this->settings->value ? "selected" : "";
            $html .= sprintf('<option value="%s" %s>%s</option>', $val, $selected, $title);
        }

        $html .= '</select>';
        
        if( !empty( @$this->settings->after_input ) ){
            $html .= sprintf('<small>%s</small>', @$this->settings->after_input);
        }

        $html .= '</div>';
        return $html;
    }

    private function render_toggle_type(){
        $html = '<div class="form-group">';

        $width = "";
        if( @$this->settings->width > 0 ){
            $width = sprintf('style="width:%dpx;"', $this->settings->width);
        }

        if( !empty( @$this->settings->title ) )
            $html .= sprintf('<label>%s</label>', @$this->settings->title);

        $checked = filter_var(@$this->settings->value, FILTER_VALIDATE_BOOLEAN) ? "checked" : "";
        $html .= sprintf('<div class="ast-toggle-container">
            <label class="ast-small-switch %s" %s>
                <input type="checkbox" %s %s />
                <span class="ast-switch-label" data-on="%s" data-off="%s"></span>
                <span class="ast-switch-handle"></span>
                <input type="text" name="%s" value="%s" class="d-none"/>
            </label>
        </div>', $this->settings->large ? "w-75" : "", $width, $this->get_atts(), $checked, $this->settings->toggle[0], $this->settings->toggle[1], $this->get_attr_name(), @$this->settings->value);

        if( !empty( @$this->settings->after_input ) ){
            $html .= sprintf('<small>%s</small>', @$this->settings->after_input);
        }

        $html .= '</div>';
        return $html;
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