<?php

class acf_icomoon_picker_plugin
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
        add_action('acf/include_field_types', 	array($this, 'include_field')); // v5
        add_action('acf/register_fields', 		array($this, 'include_field')); // v4
    }

    function include_field( $version = false )
    {
        // support empty $version
        if( !$version ) $version = 5;

        // include
        include_once($this->settings['path'] .'../../fields/class-icomoonpicker-acf-field-icomoon-field-v' . $version . '.php');
    }
}
