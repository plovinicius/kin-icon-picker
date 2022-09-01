<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Kin_Icon_Picker
 * @subpackage Kin_Icon_Picker/includes
 */
class Kin_Icon_Picker_i18n
{
    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function loadPluginTextdomain()
    {
        load_plugin_textdomain( 'kin-icon-picker', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' );
    }
}