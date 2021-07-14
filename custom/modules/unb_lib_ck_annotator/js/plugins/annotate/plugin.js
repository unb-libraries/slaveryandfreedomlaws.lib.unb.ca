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
            '<div class="anno-body">Annotation text...</div>' +
        '</div>',

        editables: {
          content: {
              selector: '.anno-body'
          }
      },

      upcast: function( element ) {
          return element.name == 'div' && element.hasClass( 'unb-lib-anno' );
      }
    });
  }
});
