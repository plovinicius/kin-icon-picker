(function($) {
	$('#acf_icomoon_picker_config_file').on('change', function(e) {
		e.preventDefault();

		const $input = $(this);
		const $parent = $input.closest('.acf-icomoon-picker__form__upload');
		const $filename = $parent.find('.filename');
		$filename.html('');

		if (!$input.val()) {
			$parent.removeClass('uploaded');
		}

		const filenameSplit = $input.val().split("\\");
		$filename.html(filenameSplit[filenameSplit.length - 1]);

		$parent.addClass('uploaded');
	});
})(jQuery);
