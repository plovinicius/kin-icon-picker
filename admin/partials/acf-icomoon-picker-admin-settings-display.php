<?php
    $uploadedPath = get_option('acf_icomoon_picker_config_file');
    $files = [];

    if (is_dir($uploadedPath)) {
        $files = list_files($uploadedPath);
    }
?>

<div class="wrap">
    <h1>
        <?php _e('ACF Icomoon Picker - Settings', 'acf-icomoon-picker'); ?>
    </h1>

    <!-- NEED THE settings_errors below so that the errors/success messages are shown after submission - wasn't working
        once we started using add_menu_page and stopped using add_options_page so needed this -->
    <?php settings_errors(); ?>

    <form method="POST" action="options.php" enctype="multipart/form-data">
        <?php
            settings_fields( 'acf_icomoon_picker_general_settings' );
            do_settings_sections( 'acf_icomoon_picker_general_settings' );
        ?>

        <div>
            <div>
                <label for="acf_icomoon_picker_config_file">
                    <?php _e('Icomoon files (.zip)', 'acf-icomoon-picker'); ?>
                </label>

                <input id="acf_icomoon_picker_config_file" type="file" name="acf_icomoon_picker_config_file"
                       value="<?php echo esc_attr( get_option('new_option_name') ); ?>" />
            </div>

            <div>
                <ul>
                    <?php foreach($files as $file): ?>
                        <li>
                            <?php echo str_replace($uploadedPath, "", $file); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

      <?php submit_button(); ?>
    </form>
</div>