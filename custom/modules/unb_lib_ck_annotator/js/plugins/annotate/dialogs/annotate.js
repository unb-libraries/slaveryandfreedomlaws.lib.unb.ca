// Anotator dialog.
CKEDITOR.dialog.add( 'annotate', function(editor) {
  return {
    title: 'Annotation',
    minWidth: 400,
    minHeight: 100,
    contents: [
      {
        id: 'info',
        elements: [
          {
            id: 'group',
            type: 'select',
            label: 'Group',
            items: [
              ['Numbers', 0],
              ['Lowercase', 1],
              ['Uppercase', 2]
            ]
          },
          {
            id: 'body',
            type: 'text',
            label: 'Annotation text',
            width: '380px'
          }
        ]
      }
    ]
  };
});
