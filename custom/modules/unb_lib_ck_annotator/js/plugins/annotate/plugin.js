// Annotator plugin.
CKEDITOR.plugins.add('annotate', {
  requires: 'widget',

  icons: 'annotate',

  init: function(editor) {
    // Make span tags editable in CKEDITOR dtd.
    CKEDITOR.dtd.$editable['span'] = 1;

    // Add custom CSS to editor.
    editor.addContentsCss(this.path + 'css/annotate.css');

    // Add button.
    editor.ui.addButton( 'annotate', {
      label: 'Annotate',
      title: 'Insert annotation',
      command: 'annotate',
    });

    // Register widget.
    editor.widgets.add( 'annotate', {
      button: 'Insert annotation',

      // Define template.
      template:
        '<span class="unb-lib-anno">&nbsp;[' +
          '<span class="anno-body">Annotation text...</span>' +
        ']&nbsp;</span>',

        // Define editable elements.
        editables: {
          content: {
            selector: '.anno-body'
          }
      },

      // Function needs to return the outermost element for widget persistence.
      upcast: function(element) {
        return element.name == 'span' && element.hasClass('unb-lib-anno');
      },

      // Bind dialog to widget.
      dialog: 'annotate'

      // Initialize data.

    });

    // Add dialog to editor.
    CKEDITOR.dialog.add('annotate', this.path + 'dialogs/annotate.js');
  }
});
