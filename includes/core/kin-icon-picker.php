<?php

class kin_icon_picker_plugin
{
    var $settings;

    function __construct()
    {
        $this->settings = array(
            'version'	=> '1.0.0',
            'url'		=> plugin_dir_url( __FILE__ ),
            'path'		=> plugin_dir_path( __FILE__ ),
        );

        // include field
        add_action('acf/include_field_types', 	array($this, 'includeField')); // v5
        add_action('acf/register_fields', 		array($this, 'includeField')); // v4
    }

    function includeField( $version = false )
    {
        if( !$version ) $version = 5;

        // include
        include_once($this->settings['path'] .'../../fields/class-kin-icon-picker-v' . $version . '.php');
    }
}
