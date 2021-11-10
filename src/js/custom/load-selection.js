(function($) {
	const control = $('.icomoon-picker__control');
	const $select = $('.icomoon-picker-select2');
	const data = icomoonJSON.full_data;
	const selectedValue = $select.attr('data-selected');
	const iconPrefix = data.preferences.fontPref.prefix;

	const options = data?.icons.map((icon) => {
		return {
			id: `${iconPrefix}${icon?.properties?.name}`,
			text: icon?.properties?.name
		};
	});

	$select.select2({
		data: options,
		width: "100%",
		templateSelection: formatOption,
		templateResult: formatOption,
		containerCssClass: 'icomoon-picker-dropdown__container',
		dropdownCssClass: 'icomoon-picker-dropdown__results',
		allowHtml: true
	});

	$select.val(selectedValue).trigger('change');

	setTimeout(() => {
		control.fadeIn('fast');
	}, 200);

	function formatOption(icon) {
		return $('<span><i class="'+ icon.id +'"></i> ' + icon.text + '</span>');
	}
})(jQuery);
