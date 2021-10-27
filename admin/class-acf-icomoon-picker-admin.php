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
class ACF_Icomoon_Picker_Admin
{
    /**
     * @since    1.0.0
     * @var      string
     */
    private $plugin_name;

    /**
     * @since    1.0.0
     * @var      string
     */
    private $version;

    /**
     * @since    1.0.0
     * @var      string
     */
    private $uploaded_config;

    /**
     * @since    1.0.0
     * @var      string
     */
    private $assetsUrl;

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
        $this->uploaded_config = [
            'path' => $destination['basedir'] .'/acf-icomoon-picker/settings',
            'url' => $destination['baseurl'] .'/acf-icomoon-picker/settings'
        ];

        $this->assetsUrl = plugin_dir_url( __FILE__ ) .'../assets/';
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

        wp_enqueue_style( $this->plugin_name, "{$this->assetsUrl}css/admin.css", array(), $this->version, 'all' );
        wp_enqueue_style( 'acf-icomoon-css', "{$this->uploaded_config['url']}/style.css", array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the admin area.
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

        wp_register_script('vendor-js', "{$this->assetsUrl}js/vendor.min.js", array('jquery'), $this->version, true);
        wp_enqueue_script( 'vendor-js' );

        // Register main js file to be enqueued
        wp_register_script('app-js', "{$this->assetsUrl}js/app.min.js", array('jquery'), $this->version, true);

        ob_start();
        include "{$this->uploaded_config['path']}/selection.json";
        $contents = ob_get_clean();
        $data = json_decode( $contents );

        // Localize script exposing $data contents
        wp_localize_script( 'app-js', 'icomoonJSON', [
            'full_data' => $data
        ]);

        // Enqueues main js file
        wp_enqueue_script( 'app-js' );
    }

    public function checkIfAcfIsActivated()
    {
        if (!is_dir($this->uploaded_config['path'])) {
            mkdir($this->uploaded_config['path'], 0775, true);
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
            'dashicons-welcome-widgets-menus',
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
        register_setting('acf_icomoon_picker_general_settings', 'acf_icomoon_picker_config_file', array($this, 'handleFileUpload'));
        register_setting('acf_icomoon_picker_general_settings', 'acf_icomoon_picker_load_style');
    }

    public function handleFileUpload($option)
    {
        if (!empty($_FILES["acf_icomoon_picker_config_file"]["tmp_name"]))
        {
            $urls = wp_handle_upload($_FILES["acf_icomoon_picker_config_file"], array('test_form' => FALSE));
            $this->unzipIcomoonConfig($urls);

            wp_delete_file($urls['file']);

            return $this->uploaded_config['path'];
        }

        $oldConfigFile = isset($_POST['acf_icomoon_picker_old_config_file']) ? $_POST['acf_icomoon_picker_old_config_file'] : null;

        if (!empty($oldConfigFile)) {
            return $oldConfigFile;
        }

        return $option;
    }

    public function unzipIcomoonConfig($uploadedFile)
    {
        WP_Filesystem();
        $isUnziped = unzip_file($uploadedFile['file'], $this->uploaded_config['path']);

        if ($isUnziped) {
            $this->doDeleteIcomoonUnusedFiles();
        }

        return $isUnziped;
    }

    public function doDeleteIcomoonUnusedFiles()
    {
        WP_Filesystem();
        global $wp_filesystem;

        wp_delete_file($this->uploaded_config['path'] .'/demo.html');
        wp_delete_file($this->uploaded_config['path'] .'/Read Me.txt');
        $wp_filesystem->rmdir($this->uploaded_config['path'] .'/demo-files', true);
    }
}