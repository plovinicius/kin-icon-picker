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

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

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
        add_menu_page( $this->plugin_name, 'ACF Icomoon Picker', 'administrator', $this->plugin_name, array( $this, 'displayPluginAdminSettings' ), 'dashicons-chart-area', 26 );
    }

    public function displayPluginAdminSettings()
    {
        if (isset($_GET['error_message'])) {
            add_action('admin_notices', array($this,'settingsPageSettingsMessages'));
            do_action( 'admin_notices', $_GET['error_message'] );
        }

        require_once 'partials/'.$this->plugin_name.'-admin-settings-display.php';
    }

    public function settingsPageSettingsMessages($error_message)
    {
        switch ($error_message) {
            case '1':
                $message = __( 'There was an error adding this setting. Please try again.  If this persists, shoot us an email.', 'my-text-domain' );
                $err_code = esc_attr( 'acf_icomoon_picker_example_setting' );
                $setting_field = 'acf_icomoon_picker_example_setting';
                break;
        }

        $type = 'error';

        add_settings_error(
            $setting_field,
            $err_code,
            $message,
            $type
        );
    }

    public function registerAndBuildFields()
    {
        /**
         * First, we add_settings_section. This is necessary since all future settings must belong to one.
         * Second, add_settings_field
         * Third, register_setting
         */
        add_settings_section(
        // ID used to identify this section and with which to register options
            'acf_icomoon_picker_general_section',
            // Title to be displayed on the administration page
            'Example',
            // Callback used to render the description of the section
            array( $this, 'acf_icomoon_picker_display_general_account' ),
            // Page on which to add this section of options
            'acf_icomoon_picker_general_settings'
        );

        unset($args);

        $args = array (
            'type'      => 'input',
            'subtype'   => 'text',
            'id'    => 'acf_icomoon_picker_example_setting',
            'name'      => 'acf_icomoon_picker_example_setting',
            'required' => 'true',
            'get_options_list' => '',
            'value_type'=>'normal',
            'wp_data' => 'option'
        );

        add_settings_field(
            'acf_icomoon_picker_example_setting',
            'Example Setting',
            array( $this, 'acf_icomoon_picker_render_settings_field' ),
            'acf_icomoon_picker_general_settings',
            'acf_icomoon_picker_general_section',
            $args
        );

        register_setting(
            'acf_icomoon_picker_general_settings',
            'acf_icomoon_picker_example_setting'
        );

    }

    public function acf_icomoon_picker_display_general_account()
    {
        echo '<p>These settings apply to all Plugin Name functionality.</p>';
    }

    public function acf_icomoon_picker_render_settings_field($args)
    {
        /* EXAMPLE INPUT
                            'type'      => 'input',
                            'subtype'   => '',
                            'id'    => $this->plugin_name.'_example_setting',
                            'name'      => $this->plugin_name.'_example_setting',
                            'required' => 'required="required"',
                            'get_option_list' => "",
                                'value_type' = serialized OR normal,
        'wp_data'=>(option or post_meta),
        'post_id' =>
        */
        if($args['wp_data'] == 'option'){
            $wp_data_value = get_option($args['name']);
        } elseif($args['wp_data'] == 'post_meta'){
            $wp_data_value = get_post_meta($args['post_id'], $args['name'], true );
        }

        switch ($args['type']) {

            case 'input':
                $value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
                if($args['subtype'] != 'checkbox'){
                    $prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">'.$args['prepend_value'].'</span>' : '';
                    $prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
                    $step = (isset($args['step'])) ? 'step="'.$args['step'].'"' : '';
                    $min = (isset($args['min'])) ? 'min="'.$args['min'].'"' : '';
                    $max = (isset($args['max'])) ? 'max="'.$args['max'].'"' : '';
                    if(isset($args['disabled'])){
                        // hide the actual input bc if it was just a disabled input the info saved in the database would be wrong - bc it would pass empty values and wipe the actual information
                        echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'_disabled" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="'.$args['id'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
                    } else {
                        echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
                    }
                    /*<input required="required" '.$disabled.' type="number" step="any" id="'.$this->plugin_name.'_cost2" name="'.$this->plugin_name.'_cost2" value="' . esc_attr( $cost ) . '" size="25" /><input type="hidden" id="'.$this->plugin_name.'_cost" step="any" name="'.$this->plugin_name.'_cost" value="' . esc_attr( $cost ) . '" />*/

                } else {
                    $checked = ($value) ? 'checked' : '';
                    echo '<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" name="'.$args['name'].'" size="40" value="1" '.$checked.' />';
                }
                break;
            default:
                # code...
                break;
        }
    }
}