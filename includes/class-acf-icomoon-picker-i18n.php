<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    ACF_Icomoon_Picker
 * @subpackage ACF_Icomoon_Picker/includes
 */
class ACF_Icomoon_Picker_i18n
{
    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function loadPluginTextdomain()
    {
        load_plugin_textdomain( 'acf-icomoon-picker', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' );
    }
}