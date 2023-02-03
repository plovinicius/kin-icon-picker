<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    Kin_Icon_Picker
 * @subpackage Kin_Icon_Picker/admin
 */
class Kin_Icon_Picker_Admin
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
            'path' => $destination['basedir'] .'/kin-icon-picker/settings',
            'url' => $destination['baseurl'] .'/kin-icon-picker/settings'
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
         * defined in Kin_Icon_Picker_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Kin_Icon_Picker_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->plugin_name, "{$this->assetsUrl}css/admin.css", array(), $this->version, 'all' );
        wp_enqueue_style( 'kin-icon-picker-css', "{$this->uploaded_config['url']}/style.css", array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the settings page in admin area.
     *
     * @since    1.0.0
     */
    public function enqueueSettingsScripts()
    {
        wp_register_script('app-js', "{$this->assetsUrl}js/app.min.js", array('jquery'), $this->version, true);
        wp_enqueue_script( 'app-js' );
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
         * defined in Kin_Icon_Picker_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Kin_Icon_Picker_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_register_script('vendor-js', "{$this->assetsUrl}js/vendor.min.js", array('jquery'), $this->version, true);
        wp_enqueue_script( 'vendor-js' );

        // Register main js file to be enqueued
        wp_register_script('app-js', "{$this->assetsUrl}js/app.min.js", array('jquery'), $this->version, true);
        
        $file_path = $this->uploaded_config['path'] .'/selection.json';

        if (file_exists($file_path)) {
            ob_start();
            include $file_path;
            $contents = ob_get_clean();

            $data = json_decode( $contents );

            // Localize script exposing $data contents
            wp_localize_script( 'app-js', 'icomoonJSON', [
                'full_data' => $data
            ]);
        }

        // Enqueues main js file
        wp_enqueue_script( 'app-js' );
    }


    public function checkIfAcfIsActivated()
    {
        $file_path = $this->uploaded_config['path'];

        if (!is_dir($file_path)) {
            wp_mkdir_p($file_path);
        }

        if (!class_exists('acf')) {
            deactivate_plugins('kin-icon-picker/kin-icon-picker.php'); ?>

            <div class="notice error is-dismissible">
                <p>
                    <?php _e("Can't use <strong>Kin Icon Picker</strong> without <strong>Advanced Custom Field</strong> been activated.", "kin-icon-picker"); ?>
                </p>
            </div>
        <?php }
    }

    public function addPluginAdminMenu()
    {
        add_menu_page(
            'Kin Icon Picker - Settings',
            'Kin Icon Picker',
            'administrator',
            $this->plugin_name,
            array( $this, 'displayPluginAdminSettings' ),
            'dashicons-welcome-widgets-menus',
            82
        );
    }

    public function displayPluginAdminSettings()
    {
        $error_message = isset($_GET['error_message']) ? sanitize_text_field($_GET['error_message']) : null;

        if ($error_message) {
            do_action( 'admin_notices', esc_html($error_message) );
        }

        require_once 'partials/'.$this->plugin_name.'-admin-settings-display.php';
    }

    public function registerAndBuildFields()
    {
        register_setting('kin_icon_picker_general_settings', 'kin_icon_picker_config_file', array($this, 'handleFileUpload'));
        register_setting('kin_icon_picker_general_settings', 'kin_icon_picker_load_style', array($this, 'handleLoadStyle'));
    }

    public function handleLoadStyle($data) {
        return sanitize_text_field($data);
    }

    public function handleFileUpload($option)
    {
        $nonce = isset($_POST['settings_nonce']) ? sanitize_text_field($_POST['settings_nonce']) : null;

        if (!$nonce || !wp_verify_nonce($nonce, 'kin_icon_picker_settings_nonce')) {
            add_settings_error(
                'kin_icon_picker_general_settings',
                'kin_icon_picker_config_file',
                __('Nonce is invalid, please, try to reload the page and upload again.', 'kin-icon-picker')
            );
        };

        if (!current_user_can('upload_files')) {
            add_settings_error(
                'kin_icon_picker_general_settings',
                'kin_icon_picker_config_file',
                __('Sorry, you don\'t have permission.', 'kin-icon-picker')
            );
        }

        if (!isset($_FILES["kin_icon_picker_config_file"]["name"]) || empty($_FILES["kin_icon_picker_config_file"]["name"])) {
            add_settings_error(
                'kin_icon_picker_general_settings',
                'kin_icon_picker_config_file',
                __('File not found, please, try to upload a .zip file again.', 'kin-icon-picker')
            );
        }

        $file_name = sanitize_file_name($_FILES["kin_icon_picker_config_file"]["name"]);

        if (!empty($file_name)) {
            if (!$this->validateUploadedFileFormat($file_name)) {
                add_settings_error(
                    'kin_icon_picker_general_settings',
                    'kin_icon_picker_config_file',
                    __('Uploaded file is invalid, please, provide a .zip file.', 'kin-icon-picker')
                );
            }

            $urls = wp_handle_upload($_FILES["kin_icon_picker_config_file"], array('test_form' => false));

            if (empty($urls) || !isset($urls['file'])) {
                add_settings_error(
                    'kin_icon_picker_general_settings',
                    'kin_icon_picker_config_file',
                    __('File is invalid, please, try to upload a .zip file again.', 'kin-icon-picker')
                );
            }

            $response = $this->unzipIcomoonConfig($urls);

            if (!$response) {
                add_settings_error(
                    'kin_icon_picker_general_settings',
                    'kin_icon_picker_config_file',
                    __('An unexpected error occurred, please, verify the directory permissions.', 'kin-icon-picker')
                );
            }

            wp_delete_file($urls['file']);

            return sanitize_text_field($this->uploaded_config['path']);
        }

        $oldConfigFile = isset($_POST['kin_icon_picker_old_config_file']) 
            ? sanitize_text_field($_POST['kin_icon_picker_old_config_file']) 
            : null;

        if (!empty($oldConfigFile)) {
            return $oldConfigFile;
        }

        return sanitize_text_field($option);
    }

    public function unzipIcomoonConfig($uploadedFile)
    {
        WP_Filesystem();
        $this->doCleanFiles();
        
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

    public function doCleanFiles()
    {
        WP_Filesystem();
        global $wp_filesystem;

        $wp_filesystem->rmdir($this->uploaded_config['path'] .'/', true);
    }

    private function validateUploadedFileFormat($file_name)
    {
        $file_info = wp_check_filetype(basename($file_name));

        if (!isset($file_info['type']) || $file_info['type'] !== 'application/zip') {
            return false;
        }

        return true;
    }
}