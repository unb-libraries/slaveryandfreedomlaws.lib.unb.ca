(function($) {
  'use strict';

  Drupal.behaviors.facetLimitDecor = {
    attach: function (context, settings) {
      // On documeny ready.
      $(document).ready( function() {
        // Prepend fontawesome icon to facet soft-limit link and mark as decorated to prevent repeats.
        $(".facets-soft-limit-link").prepend('<i class="fa fa-plus"></i>');
      });
      // On clicking the facet soft-limit link.
      $(".facets-soft-limit-link").click( function() {
        if ($(this).hasClass("open")) {
          // Prepend fontawesome minus icon to facet soft-limit link.
          $(this).prepend('<i class="fa fa-minus"></i>');
        }
        else {
          // Prepend fontawesome minus icon to facet soft-limit link.
          $(this).prepend('<i class="fa fa-plus"></i>');
        }
      });
    },
  };
})(jQuery);
