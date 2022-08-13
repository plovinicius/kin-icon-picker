<?php

/*
Plugin Name: Kin Icon Picker
Plugin URI: https://github.com/plovinicius/acf-icomoon-picker
Description: Powerful plugin to add Icons support to a known custom fields plugin
Version: 1.0.0
Author: Paulo Vinicius
Author URI: https://github.com/plovinicius
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

define( 'ACF_ICOMOON_PICKER', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-acf-icomoon-picker-activator.php
 */
function activateAcfIcomoonPicker()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-acf-icomoon-picker-activator.php';
    ACF_Icomoon_Picker_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-acf-icomoon-picker-deactivator.php
 */
function deactivateAcfIcomoonPicker()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-acf-icomoon-picker-deactivator.php';
    ACF_Icomoon_Picker_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activateAcfIcomoonPicker' );
register_deactivation_hook( __FILE__, 'deactivateAcfIcomoonPicker' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-acf-icomoon-picker.php';

if (! class_exists('acf_icomoon_picker_plugin')) {
    require_once plugin_dir_path(__FILE__) . 'includes/core/acf-icomoon-picker.php';
    new acf_icomoon_picker_plugin();
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function runAcfIcomoonPicker()
{
    $plugin = new ACF_Icomoon_Picker();
    $plugin->run();
}

runAcfIcomoonPicker();