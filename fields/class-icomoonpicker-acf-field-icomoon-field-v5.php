<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

// check if class already exists
if( !class_exists('icomoonpicker_acf_field_icomoon_picker') ) :

class icomoonpicker_acf_field_icomoon_picker extends acf_field
{
	
	function __construct( $settings ) {
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		$this->name = 'icomoon_picker';

		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		$this->label = __('Icomoon Picker', 'acf-icomoon-picker');

		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		$this->category = 'content';

		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		$this->defaults = array();
        // ----------------------------------------------------------------------

		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('icomoon_picker', 'error');
		*/
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'acf-icomoon-picker'),
		);

		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/
		
		$this->settings = $settings;
		
		// do not delete!
    	parent::__construct();
	}

	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/

	function render_field_settings( $field )
    {
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/
//		acf_render_field_setting( $field, array(
//			'label'			=> __('Font Size','acf-icomoon-picker'),
//			'instructions'	=> __('Customise the input font size','acf-icomoon-picker'),
//			'type'			=> 'number',
//			'name'			=> 'font_size',
//		));
	}

	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	function render_field( $field )
    { ?>
        <div class="icomoon-picker__control">
            <label class="icomoon-picker__label">
                <select class="icomoon-picker-select2" name="<?php echo esc_attr($field['name']); ?>"
                    data-selected="<?php echo esc_attr($field['value']); ?>">
                    <option value="" selected>
                        <?php _e('Select', 'acf-icomoon-picker'); ?>
                    </option>
                </select>
            </label>
        </div>

    <?php }
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
	function format_value( $value, $post_id, $field )
	{
		if ( empty($value) ) {
			return null;
		}

		return "<i class='{$value}'></i>";
	}
}

// initialize
new icomoonpicker_acf_field_icomoon_picker( $this->settings );

// class_exists check
endif;