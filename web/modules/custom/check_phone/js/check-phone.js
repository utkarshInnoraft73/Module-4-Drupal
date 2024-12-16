(function ($, Drupal) {
  Drupal.behaviors.phoneValidation = {
    attach: function (context, settings) {
      $(once('phoneValidation', '#edit-phone-format', context)).on('change', function () {
        var phoneNumber = $(this).val();

        phoneNumber = phoneNumber.replace(/\D/g, '');

        if (phoneNumber.length === 10) {
          var formattedPhoneNumber = '(' + phoneNumber.substring(0, 3) + ') ' +
            phoneNumber.substring(3, 6) + ' ' +
            phoneNumber.substring(6, 10);

          $(this).val(formattedPhoneNumber);
        }
        else {
          alert('Please enter a valid 10-digit phone number.');
        }
      });
    }
  };
})(jQuery, Drupal);
