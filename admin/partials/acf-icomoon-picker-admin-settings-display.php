<?php
    $uploadedPath = get_option('acf_icomoon_picker_config_file');
    $files = [];

    if (is_dir($uploadedPath)) {
        $files = list_files($uploadedPath);
    }
?>

<div class="acf-icomoon-picker">
    <div class="acf-icomoon-picker__header">
        <h2>
            <i class="acf-tab-icon dashicons dashicons-welcome-widgets-menus"></i>
            <?php _e('ACF Icomoon Picker - Settings', 'acf-icomoon-picker'); ?>
        </h2>
    </div>

    <div class="acf-icomoon-picker__container">
        <!-- NEED THE settings_errors below so that the errors/success messages are shown after submission - wasn't working
            once we started using add_menu_page and stopped using add_options_page so needed this -->
        <div class="acf-icomoon-picker__notices">
            <?php settings_errors(); ?>
        </div>

        <div class="acf-icomoon-picker__form">
            <div class="acf-icomoon-picker__form__description">
                <?php _e('For the plugin to work correctly, it is necessary to upload the .zip file exported from Icomoon.', 'acf-icomoon-picker'); ?>
            </div>

            <form method="POST" action="options.php" enctype="multipart/form-data">
                <?php
                    settings_fields( 'acf_icomoon_picker_general_settings' );
                    do_settings_sections( 'acf_icomoon_picker_general_settings' );
                ?>

                <div class="acf-icomoon-picker__form-control">
                    <div class="acf-icomoon-picker__form-col">
                        <div class="acf-icomoon-picker__form__upload">
                            <label for="acf_icomoon_picker_config_file">
                                <input id="acf_icomoon_picker_config_file" type="file" accept=".zip"
                                   name="acf_icomoon_picker_config_file"
                                   value="<?php echo esc_attr( get_option('new_option_name') ); ?>" />

                                <span class="acf-icomoon-picker__form__upload-text text">
                                    <?php _e('Update Icomoon files (.zip)', 'acf-icomoon-picker'); ?>
                                </span>

                                <span class="acf-icomoon-picker__form__upload-filename filename"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="acf-icomoon-picker__files">
                    <h3>
                        <?php _e('Files uploaded from .zip', 'acf-icomoon-picker'); ?>
                    </h3>

                    <?php if (!empty($files)): ?>
                        <ul>
                            <?php foreach($files as $file): ?>
                                <li>
                                    <?php echo str_replace($uploadedPath, "", $file); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>
                            <?php _e('Please, upload Icomoon files clicking on above button!', 'acf-icomoon-picker'); ?>
                        </p>
                    <?php endif; ?>
                </div>

              <?php submit_button(); ?>
            </form>
        </div>
    </div>
</div>