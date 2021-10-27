<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    ACF_Icomoon_Picker
 * @subpackage ACF_Icomoon_Picker/public
 */
class ACF_Icomoon_Picker_Public
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
            'path' => $destination['basedir'] .'/acf-icomoon-picker/settings',
            'url' => $destination['baseurl'] .'/acf-icomoon-picker/settings'
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
         * defined in ACF_Icomoon_Picker_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The ACF_Icomoon_Picker_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( 'acf-icomoon-picker-style', "{$this->uploaded_config['url']}/style.css", array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueueScripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in ACF_Icomoon_Picker_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The ACF_Icomoon_Picker_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

//        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/file.js', array( 'jquery' ), $this->version, false );
    }
}