(function($) {
  'use strict';

  Drupal.behaviors.expandActiveFacets = {
    attach: function (context, settings) {
      // On documeny ready.
      $(document).ready( function() {
        if ($("#collapseCategoryFacet .facets-checkbox[checked='checked']").is(':empty')) {
          $("#collapseCategoryFacet").collapse("show");
        }
        if ($("#collapseLocationFacet .facets-checkbox[checked='checked']").is(':empty')) {
          $("#collapseLocationFacet").collapse("show");
        }
        if ($("#collapseCrimeFacet .facets-checkbox[checked='checked']").is(':empty')) {
          $("#collapseCrimeFacet").collapse("show");
        }
        if ($("#collapsePunishmentFacet .facets-checkbox[checked='checked']").is(':empty')) {
          $("#collapsePunishmentFacet").collapse("show");
        }
      });
    },
  };
})(jQuery);
