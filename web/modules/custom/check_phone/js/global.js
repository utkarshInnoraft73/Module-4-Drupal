(function ($, Drupal) {
  Drupal.behaviors.globalBehavior = {
    attach: function (context, settings) {
      console.log("This script runs sitewide!");
    }
  };
})(jQuery, Drupal);
