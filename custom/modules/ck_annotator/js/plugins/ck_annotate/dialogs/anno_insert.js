CKEDITOR.dialog.add('anno_insertDialog', function(editor) {
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
      annoText = ('[an]').concat(annoText).concat('[/an]');

      annoSpan.setAttribute('class', 'anno-span');
      annoSpan.setText(annoText);

      editor.insertHtml(editor.getSelectedHtml(true));
      editor.insertElement(annoSpan);
    }

  };
});
