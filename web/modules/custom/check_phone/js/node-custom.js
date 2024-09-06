(function ($, Drupal) {
  Drupal.behaviors.nodeCustomBehavior = {
    attach: function (context, settings) {
      console.log("This script runs only for specific content type or node!");
    }
  };
})(jQuery, Drupal);
