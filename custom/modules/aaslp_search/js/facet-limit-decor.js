(function () {
  'use strict';

  Drupal.behaviors.facetLimitDecor = {
    attach: function (context, settings) {
      // Find all elements with the class "facets-soft-limit-link" and process them using the "once" utility.
      const links = once('facetLimitDecor', '.facets-soft-limit-link', context);

      // Prepend the fontawesome "plus" icon to each link.
      links.forEach(function (link) {
        link.insertAdjacentHTML('afterbegin', '<i class="fa fa-plus"></i>');

        // Add a click event listener to toggle the icons.
        link.addEventListener('click', function () {
          // Remove any existing icons inside the link to prevent duplicates.
          this.querySelectorAll('i').forEach(icon => icon.remove());

          // If the link has the "open" class, prepend the "minus" icon, otherwise prepend the "plus" icon.
          if (this.classList.contains('open')) {
            this.insertAdjacentHTML('afterbegin', '<i class="fa fa-minus"></i>');
          } else {
            this.insertAdjacentHTML('afterbegin', '<i class="fa fa-plus"></i>');
          }
        });
      });
    },
  };
})();