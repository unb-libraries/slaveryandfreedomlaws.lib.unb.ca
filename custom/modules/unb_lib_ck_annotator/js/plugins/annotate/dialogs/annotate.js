// Anotator dialog.
CKEDITOR.dialog.add('annotate', function(editor) {
  // Set up 'groups' drop-down by using passed config.
  // Custom config passed in Annotate.getConfig().
  var groups = editor.config.groups;
  var group_items = [];

  if (groups.numbered.enabled) {
    group_items.push([groups.numbered.label, 'num'])
  }
  if (groups.lowercase.enabled) {
    group_items.push([groups.lowercase.label, 'lower'])
  }
  if (groups.uppercase.enabled) {
    group_items.push([groups.uppercase.label, 'upper'])
  }

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
            items: group_items,

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
