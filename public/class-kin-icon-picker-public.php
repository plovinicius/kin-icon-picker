<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    Kin_Icon_Picker
 * @subpackage Kin_Icon_Picker/public
 */
class Kin_Icon_Picker_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * @since    1.0.0
     * @var      string
     */
    private $uploaded_config;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        // FIXME: refactor this path, remove duplicated code
        $destination = wp_upload_dir();
        $this->uploaded_config = [
            'path' => $destination['basedir'] .'/kin-icon-picker/settings',
            'url' => $destination['baseurl'] .'/kin-icon-picker/settings'
        ];
        // ----------------------------------------------------------------------

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueueStyles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Kin_Icon_Picker_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Kin_Icon_Picker_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( 'kin-icon-picker-style', "{$this->uploaded_config['url']}/style.css", array(), $this->version, 'all' );
    }
}