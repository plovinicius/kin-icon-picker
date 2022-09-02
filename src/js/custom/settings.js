(function($) {
	$('#kin_icon_picker_config_file').on('change', function(e) {
		const $input = $(this);
		const $parent = $input.closest('.acf-icomoon-picker__form__upload');
		const $filename = $parent.find('.filename');
		$filename.html('');
		$parent.removeClass('uploaded');

		if ($input.val()) {
			const filenameSplit = $input.val().split("\\");
			$filename.text(filenameSplit[filenameSplit.length - 1]);

			$parent.addClass('uploaded');
		}
	});
})(jQuery);
