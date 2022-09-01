<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

// check if class already exists
if( !class_exists('kin_icon_picker_field') ) :

class kin_icon_picker_field extends acf_field
{
	
	function __construct( $settings ) {
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		$this->name = 'kin_icon_picker';

		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		$this->label = __('Kin Icon Picker', 'kin-icon-picker');

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
		*  var message = acf._e('kin_icon_picker', 'error');
		*/
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'kin-icon-picker'),
		);

		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/
		
		$this->settings = $settings;
		
		// do not delete!
    	parent::__construct();
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
                        <?php _e('Select', 'kin-icon-picker'); ?>
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

		$value = esc_attr($value);

		return "<i class='{$value}'></i>";
	}
}

// initialize
new kin_icon_picker_field( $this->settings );

// class_exists check
endif;