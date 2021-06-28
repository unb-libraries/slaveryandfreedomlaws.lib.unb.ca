CKEDITOR.plugins.add('anno_insert_ed', {
  icons: 'anno_insert_ed',

  init: function(editor) {
    editor.addCommand('anno_insert_ed',
      new CKEDITOR.dialogCommand('anno_insert_edDialog'));

    var pluginDirectory = this.path;
    // editor.addContentsCss( pluginDirectory + 'styles/trxn_insert.css' );

    editor.ui.addButton('anno_insert_ed', {
      label: 'Insert Annotation',
      command: 'anno_insert_ed',
      toolbar: 'formatting'
    });

    CKEDITOR.dialog.add('anno_insert_edDialog', this.path + 'dialogs/anno_insert_ed.js');
  }
});
