<?php
    $uploadedPath = get_option('kin_icon_picker_config_file');
    $files = [];
    $loadStyle = 0;

    if (get_option('kin_icon_picker_load_style') ) {
        $loadStyle = !!get_option('kin_icon_picker_load_style');
    }

    if (is_dir($uploadedPath)) {
        $files = list_files($uploadedPath);
    }
?>

<div class="acf-icomoon-picker">
    <div class="acf-icomoon-picker__header">
        <h2>
            <i class="acf-tab-icon dashicons dashicons-welcome-widgets-menus"></i>
            <?php _e('Kin Icon Picker - Settings', 'kin-icon-picker'); ?>
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
                <?php _e('For the plugin to work correctly, it is necessary to upload the .zip file exported from Icomoon.', 'kin-icon-picker'); ?>
            </div>

            <form method="POST" action="options.php" enctype="multipart/form-data">
                <?php
                    settings_fields( 'kin_icon_picker_general_settings' );
                    do_settings_sections( 'kin_icon_picker_general_settings' );
                    wp_nonce_field('kin_icon_picker_settings_nonce', 'settings_nonce');
                ?>

                <div class="acf-icomoon-picker__form-control">
                    <div class="acf-icomoon-picker__form-col">
                        <label for="kin_icon_picker_load_style" class="acf-icomoon-picker__form__checkbox">
                            <span class="acf-icomoon-picker__form__checkbox-switch">
                                <input id="kin_icon_picker_load_style" type="checkbox" name="kin_icon_picker_load_style"
                                   value="1" <?php if ($loadStyle) echo esc_attr('checked'); ?> />

                                <span class="slider"></span>
                            </span>

                            <span class="acf-icomoon-picker__form__checkbox-label">
                                <?php _e('Load Icomoon fonts and styles (css) on the front-end.', 'kin-icon-picker'); ?>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="acf-icomoon-picker__form-control">
                    <div class="acf-icomoon-picker__form-col">
                        <div class="acf-icomoon-picker__form__upload">
                            <label for="kin_icon_picker_config_file">
                                <input id="kin_icon_picker_config_file" type="file" accept=".zip"
                                   name="kin_icon_picker_config_file" value="<?php echo esc_attr($uploadedPath); ?>" />

                                <input type="hidden" name="kin_icon_picker_old_config_file"
                                       value="<?php echo esc_attr($uploadedPath); ?>" />

                                <span class="acf-icomoon-picker__form__upload-text text">
                                    <?php _e('Update Icomoon files (.zip)', 'kin-icon-picker'); ?>
                                </span>

                                <span class="acf-icomoon-picker__form__upload-filename filename"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="acf-icomoon-picker__files">
                    <h3>
                        <?php _e('Files uploaded from .zip', 'kin-icon-picker'); ?>
                    </h3>

                    <?php if (!empty($files)): ?>
                        <ul>
                            <?php foreach($files as $file): ?>
                                <li>
                                    <?php echo esc_html(str_replace($uploadedPath, "", $file)); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>
                            <?php _e('Please, upload Icomoon files clicking on above button!', 'kin-icon-picker'); ?>
                        </p>
                    <?php endif; ?>
                </div>

              <?php submit_button(); ?>
            </form>
        </div>
    </div>
</div>