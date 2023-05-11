(function($) {
  'use strict';

  Drupal.behaviors.homepageActiveTabs = {
    attach: function (context, settings) {
      // On documeny ready.
      $(document).ready( function() {
        // Ensure that tab titles are active when their content is.
        if ($('#title').hasClass('active')) {
          $('#tab-title').addClass('active');
        }
        if ($('#fulltext').hasClass('active')) {
          $('#tab-fulltext').addClass('active');
        }
      });

      // Autofocus the search input of clicked tab.
      $('.nav-tabs a[data-toggle="tab"]').on('shown.bs.tab', function() {
          $('#aaslp-core-homepage input[type="text"]:visible').focus();
      });

      // Simulate click function when user presses enter key.
      $('input[type="text"]').on('keypress', function (e) {
          if (e.keyCode == 13) {
              $('#aaslp-core-homepage input[type=submit]:visible').focus();
              $('#aaslp-core-homepage input[type=submit]:visible').click();
              return false;
          }
      });

      // Transcription copy button.
      $('#copy-trans', context).once('copyTrans').on('click', function() {
        navigator.clipboard.writeText($('.field--name-dynamic-citation > .field__item').toString()).then(
          function() {
            // Clipboard successfully set.
            window.alert('Transcription copied to clipboard') 
          }, 
          function() {
            // Clipboard write failed.
            window.alert('ERROR: Clipboard API unsupported by browser')
          }
        );
      });
    },
  };
})(jQuery);
