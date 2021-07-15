// Anotator dialog.
CKEDITOR.dialog.add('annotate', function(editor) {
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
              ['Numbers', 'num'],
              ['Lowercase', 'lower'],
              ['Uppercase', 'upper']
            ],

            setup: function(widget) {
              this.setValue(widget.data.group);
            },
            commit: function(widget) {
              widget.setData('group', this.getValue());
            }
          },
          {
            id: 'body',
            type: 'text',
            label: 'Annotation text',
            width: '380px',

            setup: function(widget) {
              this.setValue(widget.data.body);
            },
            commit: function(widget) {
              widget.setData('body', this.getValue());
            }
          }
        ]
      }
    ]
  };
});
