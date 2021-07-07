CKEDITOR.dialog.add('anno_insert_edDialog', function(editor) {
  return {
    title: 'Insert annotation',
    minWidth: 400,
    minHeight: 200,

    contents: [
      {
        id: 'tab-annotate',
        label: '',
        elements: [
          {
          type: 'text',
          id: 'to-annotate',
          label: 'Annotation text'          }
        ]
      }
    ],

    onOk: function() {
      var dialog = this;
      var annoSpan = editor.document.createElement('span');
      var annoText = dialog.getValueOf('tab-annotate', 'to-annotate');
      annoText = (' [ed]').concat(annoText).concat('[/ed] ');

      annoSpan.setAttribute('class', 'anno-ed-span');
      annoSpan.setText(annoText);

      editor.insertHtml(editor.getSelectedHtml(true));
      editor.insertElement(annoSpan);
    }

  };
});
