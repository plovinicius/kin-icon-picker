<?php

/*
Plugin Name: Advanced Custom Fields: Icomoon Picker
Plugin URI: https://github.com/plovinicius/acf-icomoon-picker
Description: Powerful plugin to add Icomoon support to plugin Advanced Custom Fields (ACF)
Version: 1.0.0
Author: Paulo Vinicius
Author URI: https://github.com/plovinicius
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('icomoonpicker_acf_plugin_icomoon_picker') ) :
    class icomoonpicker_acf_plugin_icomoon_picker {

        var $settings;

        function __construct() {
            $this->settings = array(
                'version'	=> '1.0.0',
                'url'		=> plugin_dir_url( __FILE__ ),
                'path'		=> plugin_dir_path( __FILE__ ),
            );


            // include field
            add_action('acf/include_field_types', 	array($this, 'include_field')); // v5
            add_action('acf/register_fields', 		array($this, 'include_field')); // v4
        }

        function include_field( $version = false ) {

            // support empty $version
            if( !$version ) $version = 4;

            // load textdomain
            load_plugin_textdomain( 'acf-icomoon-picker', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' );

            // include
            include_once('fields/class-icomoonpicker-acf-field-icomoon-field-v' . $version . '.php');
        }
    }

    new icomoonpicker_acf_plugin_icomoon_picker();
endif;