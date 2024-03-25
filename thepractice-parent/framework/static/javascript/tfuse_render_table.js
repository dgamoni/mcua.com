(function () {
    var methods = {
        changeCheckboxId:function (self) {
            var uniqueID = Math.floor(Math.random() * 99999);
            self.find('td[data-type=checkbox]').each(function () {
                var td = jQuery(this);
                var id = td.attr('data-id');

                td.find('[id^="' + id + '"],label[for^="' + id + '"]').each(function () {
                    var self = jQuery(this);
                    if (self.attr('for'))
                        self.attr('for', id + '_' + (uniqueID));
                    else
                        self.attr('id', id + '_' + uniqueID);
                });
                uniqueID = Math.floor(Math.random() * 99999);
            });
        },
        setInputValue:function (event) {
            var  self = event.data.self;
            var tableId = self.attr('id');
            self.find('input[name="' + tableId + '"]').val(JSON.stringify(self.find('.tfbtq_first_body input, .tfbtq_first_body textarea, .tfbtq_first_body select').serializeObject()));
        },
        checkAllRows:function (event) {
           var self = event.data.self;
            if (jQuery(this).is(':checked'))
                self.find('.tfbtq_checkbox_column').attr('checked', 'checked');
            else
                self.find('.tfbtq_checkbox_column').removeAttr('checked');
        },
        addCheckboxToRow:function (self) {
            self.find('tr').not(".tfuse-not-tr").each(function () {
                var tr = jQuery(this);
                if (tr.parent().is('thead') || tr.parent().is('tfoot'))
                    tr.prepend('<td class="tf-table-checkox-control"><input class="tfbtq_checkbox_column_all" type="checkbox"/></td>');
                else
                    tr.prepend('<td class="tf-table-checkox-control"><input class="tfbtq_checkbox_column" type="checkbox"/></td>');
            });
        },
        deleteRows:function (event) {
           var self = event.data.self;

            var checkboxes = self.find('.tfbtq_checkbox_column');
            
            jQuery.each(checkboxes, function () {
                if (jQuery(this).is(':checked'))
                    jQuery(this).parents('tr').remove();
            });
            self.find('.tfbtq_checkbox_column_all').removeAttr('checked');
            self.find('input').trigger('change');
            return false;
        },
        addButtons:function (self) {
            var thLength = self.find('thead tr').children().size();
            self.find('.tfbtq_last_body').append('<tr><td colspan=' + thLength + '><a class="add button tfbtq_shopping_add_row" href="#">Add Row</a><a class="add button tfbtq_shopping_delete_rows" href="#">Delete Row</a></td></tr>');
        },
        addInput:function (callback, id) {
            var id = '#' + id + '_chzn';

            jQuery(id).find('.chzn-drop').prepend(
                '<div class="tf_selectsearch_create_options_wrapper">' +
                    '<div class="tf_selectsearch_create_options_content">' +
                    '<input   type="text"/><a class="add button tfuse_selectsearch_create_option_action">Add</a>' +
                    '<div style="clear: both"></div> ' +
                    '</div>' +
                    '</div>'
            );

            jQuery('.tfuse_selectsearch_create_option_action').data('record', {'callback':callback, 'id':'#' + id});
        },
        addRow:function (event) {
            var self = event.data.self;
            var firstTr = event.data.firstTr

            var row = firstTr.clone().removeClass();
            var selectsearch = row.find('.tfuse-select');

            self.find('.tfbtq_first_body').append(row.show());
            if(selectsearch.length > 0){
            selectsearch.removeClass('chzn-done').removeAttr('id').next('div').remove();
            selectsearch.tfuse_chosen();
            }
            methods.changeCheckboxId(self);
            self.find('input').trigger('change');

            return false;
        }

    };

    jQuery.fn.extend({
        tfuseMakeTable:function () {

            jQuery(this).each(function () {
                var self = jQuery(this);
                self.parent().siblings('.desc').remove();

                methods.changeCheckboxId(self);
                methods.addCheckboxToRow(self);
                methods.addButtons(self);

                var firstTr = self.find('.tfbtq_last_body .tfbtq-default-value-row');
                jQuery(document).on('click', '#' + self.attr('id') + ' .tfbtq_shopping_delete_rows', {self:self}, methods.deleteRows);
                jQuery(document).on('change', '#' + self.attr('id') + ' .tfbtq_checkbox_column_all', {self:self}, methods.checkAllRows);
                jQuery(document).on('change', '#' + self.attr('id') + ' input, #' + self.attr('id') + ' textarea, #' + self.attr('id') + ' select', {self:self}, methods.setInputValue);
                jQuery(document).on('click', '#' + self.attr('id') + ' .tfbtq_shopping_add_row', {self:self, firstTr:firstTr}, methods.addRow);

                self.find('input').trigger('change');
            });
        }
    });
})();

jQuery(document).ready(function () {

    jQuery('.tfuse-tip-twitter').poshytip({
        className:'tip-twitter',
        showTimeout:1,
        alignTo:'target',
        alignX:'center',
        alignY:'bottom',
        allowTipHover:false,
        fade:false,
        slide:false
    });

})
