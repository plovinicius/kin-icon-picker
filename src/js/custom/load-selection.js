(function($) {
	// Return if it's inside Settings page
	if ($('.acf-icomoon-picker__form').length) {
		return false;
	}
	
	// otherwise (it's on some edit page), loads everything
	acf.addAction('load', function( $el ) {
		initSelect2();
	});

	function initSelect2() {
		const control = $('.icomoon-picker__control');
		const $allSelects = $('.icomoon-picker-select2');
		const data = icomoonJSON.full_data;

		$allSelects.each((index, item) => {
			const $select = $allSelects.eq(index);
			const selectedValue = $select.attr('data-selected');
			const iconPrefix = data.preferences.fontPref.prefix;

			const options = data?.icons.map((icon) => {
				return {
					id: `${iconPrefix}${icon?.properties?.name}`,
					text: icon?.properties?.name
				};
			});

			const $currentSelect2 = $select.select2({
				data: options,
				width: "100%",
				templateSelection: formatOption,
				templateResult: formatOption,
				containerCssClass: 'icomoon-picker-dropdown__container',
				dropdownCssClass: 'icomoon-picker-dropdown__results',
				allowHtml: true
			});

			$currentSelect2.val(selectedValue).trigger('change');
		});

		setTimeout(() => {
			control.fadeIn('fast');
		}, 200);
	}

	function formatOption(icon) {
		return $(`<span><i class="${icon.id}"></i> ${icon.text}</span>`);
	}
})(jQuery);
