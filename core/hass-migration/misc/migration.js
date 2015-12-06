jQuery(function () {
	
	   jQuery('#migrationutility-databasetables').bind('change',
               function () {
                   var val = jQuery(this).find('option:selected').text();
                   if (val) {
                       var $elm = jQuery('#migrationutility-tables');
                       var val2 = $elm.val().replace(val + ',', '');
                       val = val2 + ',' + val;
                       val = val.replace(/,+/gi, ',').replace(/\s+/gi, '').replace(/^,/, '');
                       $elm.val(val);
                   }
               });
	

        jQuery.fn.selectText = function () {
            this.find('input').each(function () {
                if ($(this).prev().length == 0 || !$(this).prev().hasClass('p_copy')) {
                    $('<p class="p_copy" style="position: absolute; z-index: -1;"></p>').insertBefore($(this));
                }
                $(this).prev().html($(this).val());
            });
            var doc = document;
            var element = this[0];
            console.log(this, element);
            if (doc.body.createTextRange) {
                var range = document.body.createTextRange();
                range.moveToElementText(element);
                range.select();
            } else if (window.getSelection) {
                var selection = window.getSelection();
                var range = document.createRange();
                range.selectNodeContents(element);
                selection.removeAllRanges();
                selection.addRange(range);
            }
        };

        jQuery('#button-add-all')
            .click(function () {
                var $tables = jQuery('#migrationutility-tables');
                $tables.val("");
                jQuery("#migrationutility-databasetables > option")
                    .each(function () {
                        if (this.text != 'migration') {
                            $tables.val($tables.val() + ',' + this.text);
                        }
                    });
                $tables.val($tables.val().replace(/^,+/, ''));
            });
        jQuery('#button-select-all')
            .click(function () {
                jQuery('#code-output').selectText();
            });
        jQuery('#button-select-all-drop')
            .click(function () {
                jQuery('#code-output-drop').selectText();
            });
        jQuery('#button-tables-convert')
            .click(function () {
                var $this = jQuery('#migrationutility-tables');
                var $parent = $this.parent();
                if ($this.attr('type') == "text") {
                    var $textarea = jQuery(document.createElement('textarea'));
                    $textarea.attr('id', $this.attr('id'));
                    $textarea.attr('type', 'textarea');
                    $textarea.attr('class', $this.attr('class'));
                    $textarea.attr('name', $this.attr('name'));
                    $textarea.html($this.val().replace(/\s+/g, '').replace(/,/g, "\n"));
                    $this.remove();
                    jQuery($textarea).insertAfter($parent.find('> label'));
                } else {
                    var $input = jQuery(document.createElement('input'));
                    $input.attr('id', $this.attr('id'));
                    $input.attr('type', 'text');
                    $input.attr('class', $this.attr('class'));
                    $input.attr('name', $this.attr('name'));
                    $input.val($this.html().replace(/[\r\n]/g, ", "));
                    $this.remove();
                    jQuery($input).insertAfter($parent.find('> label'));
                }
                jQuery('#migrationutility-tables').blur();
            });
    });