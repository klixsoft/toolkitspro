<?php

namespace AST;

class Options
{

    public static function get( $key, $default=false )
    {
        $settings = $default;
        if( isset( $_GLOBALS["settings_$key"] ) ){
            $settings = $_GLOBALS["settings_$key"];
        }else{
            global $db;
            $db->where("option_name", $key);
            $result = $db->arrayBuilder()->get("settings", 1);
            if( !empty( $result ) && count( $result ) > 0 ){
                $value = maybe_unserialize( $result[0]['option_value'] );
                
                if( is_array( $value ) ){
                    if( is_array( $default ) ){
                        $value = array_merge($default, $value);
                    }

                    $value = (object) $value;
                }
                $settings = $value;
            }
        }

        return apply_filters("ast/settings", $settings, $key);
    }

    public static function has( $key )
    {

        global $db;
        $db->where("option_name", $key);
        $result = $db->objectBuilder()->get("settings", 1);
        if( !empty( $result ) && count( $result ) > 0 ){
            return true;
        }

        return false;

    }

    public static function set( $key, $value )
    {
        global $db;

        if( Options::has( $key ) )
        {
            $db->where("option_name", $key);
            return $db->update("settings", array(
                "option_value" => maybe_serialize($value)
            ));

        }else{
            return $db->insert("settings", array(
                "option_name" => $key,
                "option_value" => maybe_serialize($value)
            ));
        }

    }
}