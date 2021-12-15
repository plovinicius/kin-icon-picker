<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 *
 * @package    ACF_Icomoon_Picker
 * @subpackage ACF_Icomoon_Picker/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    ACF_Icomoon_Picker
 * @subpackage ACF_Icomoon_Picker/includes
 */
class ACF_Icomoon_Picker
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      ACF_Icomoon_Picker_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if ( defined( 'ACF_ICOMOON_PICKER_VERSION' ) ) {
            $this->version = ACF_ICOMOON_PICKER_VERSION;
        } else {
            $this->version = '1.0.0';
        }

        $this->plugin_name = 'acf-icomoon-picker';

        $this->loadDependencies();
        $this->setLocale();
        $this->defineAdminHooks();

        if (esc_attr( get_option('acf_icomoon_picker_load_style') )) {
            $this->definePublicHooks();
        }
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - ACF_Icomoon_Picker_Loader. Orchestrates the hooks of the plugin.
     * - ACF_Icomoon_Picker_i18n. Defines internationalization functionality.
     * - ACF_Icomoon_Picker_Admin. Defines all hooks for the admin area.
     * - ACF_Icomoon_Picker_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function loadDependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-acf-icomoon-picker-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-acf-icomoon-picker-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-acf-icomoon-picker-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-acf-icomoon-picker-public.php';

        $this->loader = new ACF_Icomoon_Picker_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the ACF_Icomoon_Picker_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function setLocale()
    {
        $plugin_i18n = new ACF_Icomoon_Picker_i18n();

        $this->loader->addAction( 'plugins_loaded', $plugin_i18n, 'loadPluginTextdomain' );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function defineAdminHooks()
    {

        $plugin_admin = new ACF_Icomoon_Picker_Admin( $this->getPluginName(), $this->getVersion() );

        $this->loader->addAction( 'admin_enqueue_scripts', $plugin_admin, 'enqueueStyles' );
//        $this->loader->addAction( 'admin_enqueue_scripts', $plugin_admin, 'enqueueScripts' );
        $this->loader->addAction( 'acf/input/admin_enqueue_scripts', $plugin_admin, 'enqueueScripts' );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function definePublicHooks()
    {
        $plugin_public = new ACF_Icomoon_Picker_Public( $this->getPluginName(), $this->getVersion() );

        $this->loader->addAction( 'wp_enqueue_scripts', $plugin_public, 'enqueueStyles' );
        $this->loader->addAction( 'wp_enqueue_scripts', $plugin_public, 'enqueueScripts' );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function getPluginName()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    ACF_Icomoon_Picker_Loader    Orchestrates the hooks of the plugin.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function getVersion()
    {
        return $this->version;
    }

}