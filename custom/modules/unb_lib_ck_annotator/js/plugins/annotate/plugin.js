CKEDITOR.plugins.add( 'annotate', {
  requires: 'widget',

  icons: 'annotate',

  init: function( editor ) {
    editor.ui.addButton( 'annotate', {
      label: 'Annotate',
      title: 'Insert annotation',
      command: 'annotate',
    });

    editor.widgets.add( 'annotate', {
      button: 'Insert annotation',

      template:
        '<div class="unb-lib-anno">' +
            '<h2 class="anno-title">Title</h2>' +
            '<div class="anno-content"><p>Content...</p></div>' +
        '</div>'
    });
  }
});
