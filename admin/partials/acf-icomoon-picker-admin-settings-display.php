<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 * @package    ACF_Icomoon_Picker
 * @subpackage ACF_Icomoon_Picker/admin/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2>
        <?php _e('ACF Icomoon Picker - Settings', 'acf-icomoon-picker'); ?>
    </h2>

    <!-- NEED THE settings_errors below so that the errors/success messages are shown after submission - wasn't working
        once we started using add_menu_page and stopped using add_options_page so needed this
        -->
    <?php settings_errors(); ?>

    <form method="POST" action="options.php">
        <?php
            settings_fields( 'acf_icomoon_picker_general_settings' );
            do_settings_sections( 'acf_icomoon_picker_general_settings' );

            submit_button();
        ?>
    </form>
</div>