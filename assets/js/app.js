"use strict";

(function ($) {
  var control = $('.icomoon-picker__control');
  var $select = $('.icomoon-picker-select2');
  var data = icomoonJSON.full_data;
  var selectedValue = $select.attr('data-selected');
  var options = data === null || data === void 0 ? void 0 : data.icons.map(function (icon) {
    var _icon$properties, _icon$properties2;

    return {
      id: icon === null || icon === void 0 ? void 0 : (_icon$properties = icon.properties) === null || _icon$properties === void 0 ? void 0 : _icon$properties.name,
      text: icon === null || icon === void 0 ? void 0 : (_icon$properties2 = icon.properties) === null || _icon$properties2 === void 0 ? void 0 : _icon$properties2.name
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
  setTimeout(function () {
    control.fadeIn('fast');
  }, 200);

  function formatOption(icon) {
    return $('<span><i class="icon-' + icon.id + '"></i> ' + icon.text + '</span>');
  }
})(jQuery);
"use strict";

(function ($) {
  $('#acf_icomoon_picker_config_file').on('change', function (e) {
    e.preventDefault();
    var $input = $(this);
    var $parent = $input.closest('.acf-icomoon-picker__form__upload');
    var $filename = $parent.find('.filename');
    $filename.html('');

    if (!$input.val()) {
      $parent.removeClass('uploaded');
    }

    var filenameSplit = $input.val().split("\\");
    $filename.html(filenameSplit[filenameSplit.length - 1]);
    $parent.addClass('uploaded');
  });
})(jQuery);