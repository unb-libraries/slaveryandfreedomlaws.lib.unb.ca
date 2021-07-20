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
        '<span class="unb-lib-anno">' +
          '<span class="anno-marker" title="Double-click to edit annotation">' +
          'MARKER_PLACEHOLDER</span><span class="anno-open">[an]</span>' +
          '<span class="anno-body">BODY_PLACEHOLDER</span>' +
          '<span class="anno-close">[/an]</span>' +
        '</span>',

        // Define editable elements.
        editables: {
          content: {
            selector: '.anno-body'
          }
      },

      allowedContent:
        'span(!unb-lib-anno); ' +
        'span(!anno-marker); span(!anno-open); ' +
        'span(!anno-close); span(!anno-body){body, group};',

      // This variable makes parts of template available for updating.
      parts: {
        markerSpan: 'span.anno-marker',
        openSpan: 'span.anno-open',
        annoSpan: 'span.anno-body',
        closeSpan: 'span.anno-close'
      },

      // Function needs to return the outermost element for widget persistence.
      upcast: function(element) {
        return element.name == 'span' && element.hasClass('unb-lib-anno');
      },

      // Bind dialog to widget.
      dialog: 'annotate',

      // Initialize data.
      init: function() {

        // Initialize group.
        if (this.parts.annoSpan.hasClass('group-lower')) {
          this.setData('group', 'lower');
        }
        else if (this.parts.annoSpan.hasClass('group-upper')) {
          this.setData('group', 'upper');
        }
        else {
          this.setData('group', 'num');
        }

        // Initialize body.
        var body = this.parts.annoSpan.getHtml();

        if (body && body != 'BODY_PLACEHOLDER') {
          this.setData('body', body);
        }
      },

      // Update data.
      data: function() {
        var group = this.data.group;
        var body = this.data.body;

        // Add group class.
        this.parts.annoSpan.addClass('group-' + group);
        // Add annotation marker.
        switch (group) {
          case 'lower':
            var marker = '[a]';
            this.parts.openSpan.setHtml('[ed]');
            this.parts.closeSpan.setHtml('[/ed]');
            break;
          case 'upper':
            var marker = '[A]';
            break;
          default:
            var marker = '[#]';
            this.parts.openSpan.setHtml('[an]');
            this.parts.closeSpan.setHtml('[/an]');
            break;
        }
        this.parts.openSpan.hide();
        this.parts.closeSpan.hide();

        this.parts.markerSpan.setHtml(marker);

        if (body) {
          this.parts.annoSpan.setHtml(body);
          this.parts.annoSpan.hide();
        }
      }
    });

    // Add dialog to editor.
    CKEDITOR.dialog.add('annotate', this.path + 'dialogs/annotate.js');
  }
});
