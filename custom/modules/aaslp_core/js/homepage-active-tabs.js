(function($, navigator, once) {
  'use strict';

  Drupal.behaviors.homepageActiveTabs = {
    attach: function (context, settings) {
      // On document ready.
      once('homepageActiveTabs', 'html').forEach(function (element) {
        // Ensure that tab titles are active when their content is.
        if ($('#title').hasClass('active')) {
          $('#tab-title').addClass('active');
        }
        if ($('#fulltext').hasClass('active')) {
          $('#tab-fulltext').addClass('active');
        }
        
        // Autofocus the search input of clicked tab.
        $('.nav-tabs a[data-toggle="tab"]').on('shown.bs.tab', function() {
            $('#aaslp-core-homepage input[type="text"]:visible').focus();
        });

        // Simulate click function when user presses enter key.
        $('input[type="text"]').on('keypress', function (element) {
            if (e.keyCode == 13) {
                $('#aaslp-core-homepage input[type=submit]:visible').focus();
                $('#aaslp-core-homepage input[type=submit]:visible').click();
                return false;
            }
        });

        // Transcription copy button.
        $('#cite').click(function() {
          navigator.clipboard.writeText($('#citation').html()).then(
            function() {
              // Clipboard successfully set.
              window.alert('Citation copied to clipboard') 
            }, 
            function() {
              // Clipboard write failed.
              window.alert('ERROR: Clipboard API unsupported by browser')
            }
          );
        });
      });
    },
  };
}(jQuery, navigator, once));
