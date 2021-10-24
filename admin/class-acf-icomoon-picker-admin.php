<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    ACF_Icomoon_Picker
 * @subpackage ACF_Icomoon_Picker/admin
 */
class ACF_Icomoon_Picker_Admin {

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

    private $uploaded_config_path;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        // FIXME: refactor this path, remove duplicated code
        $destination = wp_upload_dir();
        $uploadsPath = $destination['basedir'];
        $this->uploaded_config_path = $uploadsPath .'/acf-icomoon-picker/settings';
        // ----------------------------------------------------------------------

        $this->plugin_name = $plugin_name;

        $this->version = $version;

        add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9);
        add_action('admin_init', array( $this, 'registerAndBuildFields' ));
        add_action('admin_notices', array( $this, 'checkIfAcfIsActivated' ));
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
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

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/settings-page-admin.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
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

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/settings-page-admin.js', array( 'jquery' ), $this->version, false );
    }

    public function checkIfAcfIsActivated()
    {
        if (!is_dir($this->uploaded_config_path)) {
            mkdir($this->uploaded_config_path, 0775, true);
        }

        if (!class_exists('acf')) {
            deactivate_plugins('acf-icomoon-picker/acf-icomoon-picker.php'); ?>

            <div class="notice error is-dismissible">
                <p>
                    <?php _e("Can't use <strong>ACF Icomoon Picker</strong> without <strong>Advanced Custom Field</strong> been activated.", "acf-icomoon-picker"); ?>
                </p>
            </div>
        <?php }
    }

    public function addPluginAdminMenu()
    {
        add_menu_page(
            'ACF Icomoon Picker - Settings',
            'ACF Icomoon Picker',
            'administrator',
            $this->plugin_name,
            array( $this, 'displayPluginAdminSettings' ),
            'dashicons-admin-generic',
            82
        );
    }

    public function displayPluginAdminSettings()
    {
        if (isset($_GET['error_message'])) {
//            add_action('admin_notices', array($this,'settingsPageSettingsMessages'));
            do_action( 'admin_notices', $_GET['error_message'] );
        }

        require_once 'partials/'.$this->plugin_name.'-admin-settings-display.php';
    }

    public function registerAndBuildFields()
    {
        register_setting('acf_icomoon_picker_general_settings', 'acf_icomoon_picker_config_file', array($this, 'handle_file_upload'));
    }

    public function handle_file_upload($option)
    {
        if (!empty($_FILES["acf_icomoon_picker_config_file"]["tmp_name"]))
        {
            $urls = wp_handle_upload($_FILES["acf_icomoon_picker_config_file"], array('test_form' => FALSE));
            $this->unzip_icomoon_config($urls);

            wp_delete_file($urls['file']);

            return $this->uploaded_config_path;
        }

        return $option;
    }

    public function unzip_icomoon_config($uploadedFile)
    {
        WP_Filesystem();
        $isUnziped = unzip_file($uploadedFile['file'], $this->uploaded_config_path);

        if ($isUnziped) {
            $this->doDeleteIcomoonUnusedFiles();
        }

        return $isUnziped;
    }

    public function doDeleteIcomoonUnusedFiles()
    {
        WP_Filesystem();
        global $wp_filesystem;

        wp_delete_file($this->uploaded_config_path .'/demo.html');
        wp_delete_file($this->uploaded_config_path .'/Read Me.txt');
        $wp_filesystem->rmdir($this->uploaded_config_path .'/demo-files', true);
    }
}