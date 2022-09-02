"use strict";

(function ($) {
  // Return if it's inside Settings page
  if ($('.acf-icomoon-picker__form').length) {
    return false;
  } // otherwise (it's on some edit page), loads everything


  acf.addAction('load', function ($el) {
    initSelect2();
  });

  function initSelect2() {
    var control = $('.icomoon-picker__control');
    var $allSelects = $('.icomoon-picker-select2');
    var data = icomoonJSON.full_data;
    $allSelects.each(function (index, item) {
      var $select = $allSelects.eq(index);
      var selectedValue = $select.attr('data-selected');
      var iconPrefix = data.preferences.fontPref.prefix;
      var options = data === null || data === void 0 ? void 0 : data.icons.map(function (icon) {
        var _icon$properties, _icon$properties2;

        return {
          id: "".concat(iconPrefix).concat(icon === null || icon === void 0 ? void 0 : (_icon$properties = icon.properties) === null || _icon$properties === void 0 ? void 0 : _icon$properties.name),
          text: icon === null || icon === void 0 ? void 0 : (_icon$properties2 = icon.properties) === null || _icon$properties2 === void 0 ? void 0 : _icon$properties2.name
        };
      });
      var $currentSelect2 = $select.select2({
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
    setTimeout(function () {
      control.fadeIn('fast');
    }, 200);
  }

  function formatOption(icon) {
    return $("<span><i class=\"".concat(icon.id, "\"></i> ").concat(icon.text, "</span>"));
  }
})(jQuery);
"use strict";

(function ($) {
  $('#kin_icon_picker_config_file').on('change', function (e) {
    var $input = $(this);
    var $parent = $input.closest('.acf-icomoon-picker__form__upload');
    var $filename = $parent.find('.filename');
    $filename.html('');
    $parent.removeClass('uploaded');

    if ($input.val()) {
      var filenameSplit = $input.val().split("\\");
      $filename.text(filenameSplit[filenameSplit.length - 1]);
      $parent.addClass('uploaded');
    }
  });
})(jQuery);