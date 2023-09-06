(function($, navigator, once) {
  'use strict';

  Drupal.behaviors.homepageActiveTabs = {
    attach: function (context, settings) {
      // On document ready.
      once('homepageActiveTabs', 'html').forEach(function (element) {
        // Ensure that tab titles are active when their content is.
        if ($('#title').hasClass('active')) {
          $('#tab-title').addClass('active');
          $('#tab-fulltext').removeClass('active');
        }
        if ($('#fulltext').hasClass('active')) {
          $('#tab-fulltext').addClass('active');
          $('#tab-title').removeClass('active');
        }
        
        // Autofocus the search input of clicked tab.
        $('.nav-tabs a[data-toggle="tab"]').on('shown.bs.tab', function() {
            $('#aaslp-core-homepage input[type="text"]:visible').focus();
        });

        // Simulate context-click when user presses enter key onm homepage.
        $('input[type="text"]').on('keypress', function (e) {
            // If homepage...
            if ($('#aaslp-core-homepage').length) {
              if (e.keyCode == 13) {
                e.preventDefault();
                if ($('#title').hasClass('active')) {
                  $('#edit-submit-title').focus();
                  $('#edit-submit-title').click();
                  return false;
                }
                else {
                  $('#edit-submit-fulltext').focus();
                  $('#edit-submit-fulltext').click();
                  return false;
                }
              }
          }
        });

        // Transcription copy button.
        $('#cite').click(function() {
          navigator.clipboard.writeText($('#citation').html().replace(/<\/?[^>]+>/gi, '')).then(
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
