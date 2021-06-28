CKEDITOR.plugins.add('anno_insert', {
  icons: 'anno_insert',

  init: function(editor) {
    editor.addCommand('anno_insert',
      new CKEDITOR.dialogCommand('anno_insertDialog'));

    var pluginDirectory = this.path;
    // editor.addContentsCss( pluginDirectory + 'styles/trxn_insert.css' );

    editor.ui.addButton('anno_insert', {
      label: 'Insert Annotation',
      command: 'anno_insert',
      toolbar: 'formatting'
    });

    CKEDITOR.dialog.add('anno_insertDialog', this.path + 'dialogs/anno_insert.js');
  }
});
