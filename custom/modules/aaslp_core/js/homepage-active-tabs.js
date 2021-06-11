(function($) {
  'use strict';

  // Ensure that tab titles are active when their content is.
  Drupal.behaviors.absentOnClick = {
    attach: function (context, settings) {
      // On documeny ready.
      $(document).ready( function() {
        if ($('#title').hasClass('active')) {
          $('#tab-title').addClass('active');
        }
        if ($('#fulltext').hasClass('active')) {
          $('#tab-fulltext').addClass('active');
        }
      });
    },
  };
})(jQuery);
