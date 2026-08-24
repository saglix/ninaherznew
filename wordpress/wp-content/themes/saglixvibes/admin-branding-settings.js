(function ($) {
  $(function () {
    var frame;
    var $logoId = $('#site-theme-logo-id');
    var $preview = $('#site-theme-logo-preview');
    var $remove = $('#site-theme-logo-remove');
    var $width = $('#site-theme-logo-width');
    var $widthValue = $('#site-theme-logo-width-value');

    function openLogoFrame(config) {
      var localFrame = wp.media({
        title: config.title,
        button: {
          text: config.button
        },
        library: config.library || {},
        multiple: false
      });

      localFrame.on('select', function () {
        var attachment = localFrame.state().get('selection').first().toJSON();
        var url = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;

        if (config.allowedTypes && config.allowedTypes.indexOf(attachment.mime) === -1) {
          window.alert(siteBrandingSettings.invalidEmailLogo);
          return;
        }

        config.$id.val(attachment.id);
        config.$preview.html('<img src="' + url + '" alt="">');
        config.$remove.prop('disabled', false);
      });

      localFrame.open();
    }

    $('#site-theme-logo-select').on('click', function (event) {
      event.preventDefault();

      if (frame) {
        frame.open();
        return;
      }

      frame = wp.media({
        title: siteBrandingSettings.title,
        button: {
          text: siteBrandingSettings.button
        },
        multiple: false
      });

      frame.on('select', function () {
        var attachment = frame.state().get('selection').first().toJSON();
        var url = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;

        $logoId.val(attachment.id);
        $preview.html('<img src="' + url + '" alt="">');
        $remove.prop('disabled', false);
      });

      frame.open();
    });

    $('#site-theme-email-logo-select').on('click', function (event) {
      event.preventDefault();
      openLogoFrame({
        title: siteBrandingSettings.emailTitle,
        button: siteBrandingSettings.emailButton,
        library: {
          type: ['image/png', 'image/jpeg', 'image/webp']
        },
        allowedTypes: ['image/png', 'image/jpeg', 'image/webp'],
        $id: $('#site-theme-email-logo-id'),
        $preview: $('#site-theme-email-logo-preview'),
        $remove: $('#site-theme-email-logo-remove')
      });
    });

    $remove.on('click', function (event) {
      event.preventDefault();
      $logoId.val('');
      $preview.empty();
      $remove.prop('disabled', true);
    });

    $('#site-theme-email-logo-remove').on('click', function (event) {
      event.preventDefault();
      $('#site-theme-email-logo-id').val('');
      $('#site-theme-email-logo-preview').empty();
      $('#site-theme-email-logo-remove').prop('disabled', true);
    });

    $width.on('input change', function () {
      $widthValue.text($width.val() + 'px');
    });

    $('input[type="color"][name^="site_theme_email_"]').on('input change', function () {
      $(this).next('.site-color-text').val($(this).val());
    });
  });
})(jQuery);
