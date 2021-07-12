CKEDITOR.plugins.add( 'annotate', {
  requires: 'widget',

  icons: 'annotate',

  init: function( editor ) {
    editor.widgets.add( 'annotate', {
      button: 'Insert annotation'
    });
  }
});
