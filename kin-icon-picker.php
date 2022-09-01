<?php

/*
Plugin Name: Kin Icon Picker
Plugin URI: https://github.com/plovinicius/kin-icon-picker
Description: Powerful plugin to add Icons support to a known custom fields plugin
Version: 1.0.0
Author: Paulo Vinicius
Author URI: https://github.com/plovinicius
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

define( 'KIN_ICON_PICKER', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kin-icon-picker-activator.php
 */
function activateKinIconPicker()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-kin-icon-picker-activator.php';
    Kin_Icon_Picker_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kin-icon-picker-deactivator.php
 */
function deactivateKinIconPicker()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-kin-icon-picker-deactivator.php';
    Kin_Icon_Picker_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activateKinIconPicker' );
register_deactivation_hook( __FILE__, 'deactivateKinIconPicker' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-kin-icon-picker.php';

if (! class_exists('kin_icon_picker_plugin')) {
    require_once plugin_dir_path(__FILE__) . 'includes/core/kin-icon-picker.php';
    new kin_icon_picker_plugin();
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
function runKinIconPicker()
{
    $plugin = new Kin_Icon_Picker();
    $plugin->run();
}

runKinIconPicker();