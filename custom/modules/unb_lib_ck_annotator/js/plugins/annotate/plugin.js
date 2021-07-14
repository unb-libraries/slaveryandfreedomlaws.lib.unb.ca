CKEDITOR.plugins.add( 'annotate', {
  requires: 'widget',

  icons: 'annotate',

  init: function( editor ) {
    CKEDITOR.dtd.$editable['span'] = 1;

    editor.ui.addButton( 'annotate', {
      label: 'Annotate',
      title: 'Insert annotation',
      command: 'annotate',
    });

    editor.widgets.add( 'annotate', {
      button: 'Insert annotation',

      template:
        '<span class="unb-lib-anno">&nbsp;' +
            '<span class="anno-body">Annotation text...</span>' +
        '&nbsp;</span>',

        editables: {
          content: {
              selector: '.anno-body'
          }
      },

      upcast: function( element ) {
          return element.name == 'span' && element.hasClass( 'unb-lib-anno' );
      }
    });
  }
});
