jQuery(document).ready(function () {

    jQuery("select.tfuse-select").tfuse_chosen();

    jQuery(document).on('click', '.tfuse-selectsearch-enable-delete-btn', function () {

        var li_rows = jQuery(this).find('.chzn-results').children('.active-result');
        if (!li_rows.hasClass('delete-row-btn'))
            li_rows.addClass('delete-row-btn').after('<a href="#" class="tfuse_selectsearch_delete_option_action">X</a>');

    });

    jQuery(document).on({

        click:function (event) {
            var ul =jQuery(this).closest('.tfuse-selectsearch-enable-delete-btn');
            var select = ul.data('record').select;
            var callbackMethod = ul.data('record').callbackDeleteFunction;

            if (typeof window.tfuseNameSpace[ callbackMethod ] === "undefined") {
                alert('Function ' + callbackMethod + " is not defined !");
                return false;
            }

            var close =(window.tfuseNameSpace[ callbackMethod ](jQuery(this),jQuery(this).prev().text() ,select )!== false);

            if (close)
                select.trigger("click");

            return false;
        },
        mouseenter:function (e) {
            jQuery(this).prev().trigger('mouseover');
        }
    }, '.tfuse_selectsearch_delete_option_action');

    jQuery(document).on('change', 'select.tfuse-select', function () {
        var self = jQuery(this);
        self.siblings('input[type=hidden]').val(self.val());
    });

    jQuery(document).on('click', '.tfuse_selectsearch_create_option_action', function (event) {
        if (typeof window.tfuseNameSpace[ jQuery(this).data('record').callback ] === "undefined") {
            alert('Function ' + jQuery(this).data('record').callback + " is not defined !");
            return false;
        }

        var self = jQuery(this);
        var input_text = jQuery('input[type=text]', self.closest('.tf_selectsearch_create_options_content'));

        var close = (window.tfuseNameSpace[ self.data('record').callback ](self, input_text.val()) !== false );

        input_text.val('');

        if (close)
            jQuery(self.data('record').id).trigger("click");

        return false;
    });
});

(function () {
    var methods = {
        addInput:function (callback, id) {
            var main_id = '#' + id + '_chzn';
            var context = jQuery(main_id);
            if (context.hasClass('chzn-container-single'))
                context.find('.chzn-drop').css({'-webkit-border-radius':'0px', 'border-radius':'0px', '-moz-border-radius':'0px'});


            context.find('.chzn-drop').prepend(
                '<div class="tf_selectsearch_create_options_wrapper">\
                    <div class="tf_selectsearch_create_options_content">\
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">\
                            <tr class="tfuse-not-tr">\
                                <td>\
                                    <input type="text"/>\
                                    <div style="clear: both;"></div>\
                                </td>\
                                <td width="1" class="tfuse_selectsearch_create_option_td">\
                                    <a class="add button tfuse_selectsearch_create_option_action">Add</a>\
                                    <div style="clear: both"></div>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
            );

            context.find('.tfuse_selectsearch_create_option_action').data('record', {'callback':callback, 'id':'#' + id});
        },
        addDeleteBtn:function(context, callback){
           var  id= '#'+context.attr('id')+'_chzn';
           var ul = jQuery(id).addClass('tfuse-selectsearch-enable-delete-btn');
            ul.data('record',{'callbackDeleteFunction':callback , 'select':context});
        }
    }

    jQuery.fn.extend({
        tfuse_chosen:function (opts) {
            opts = opts || {};
            jQuery(this).each(function () {
                var self = jQuery(this);

                self.chosen(
                    jQuery.extend({
                        'allow_single_deselect':jQuery(this).attr('single-deselect') === 'true'
                    }, opts)
                );

                if(self.attr('data-callback-delete-btn')!== undefined)
                    methods.addDeleteBtn(self,self.attr('data-callback-delete-btn'));


                if (self.attr('data-callback') !== undefined)
                    methods.addInput(self.attr('data-callback'), self.attr('id'));
            });
        }
    })

})();

//JS FOR GROUP ELEMENTS FROM SELECT SEARCH WHICH HAVE OPTGROUP AS SELECTED
jQuery(document).ready(function () {

    var active_class = 'tf_group_active';

    jQuery(document).on('click', '.tf_selectsearch_control_none', function () {
        var wrapper = jQuery(this).closest('.tf_multicontrol_selectsearch');
        var selectsearch = wrapper.find('select');
        var group_links = wrapper.find('.tf_groups_controls a');
        wrapper.find('option').removeAttr("selected");
        group_links.removeClass(active_class);
        selectsearch.trigger("liszt:updated");
        selectsearch.trigger('change');
        return false;

    });

    jQuery(document).on('click', '.tf_selectsearch_control_all', function () {
        var wrapper = jQuery(this).closest('.tf_multicontrol_selectsearch');
        var selectsearch = wrapper.find('select');
        var group_links = wrapper.find('.tf_groups_controls a');
        wrapper.find('option').attr("selected", "selected");
        group_links.addClass(active_class);
        selectsearch.trigger("liszt:updated");
        selectsearch.trigger('change');
        return false;

    });

    jQuery(document).on('click', '.tf_groups_controls a', function () {
        var self = jQuery(this);
        var wrapper = self.closest('.tf_multicontrol_selectsearch');
        var selectsearch = wrapper.find('select');
        var placeholder = self.attr('data-placeholder');

        if (self.hasClass(active_class)) {
            self.removeClass(active_class);
            wrapper.find('optgroup[data-placeholder=' + placeholder + ']').children().removeAttr("selected");
        } else {
            self.addClass(active_class);
            wrapper.find('optgroup[data-placeholder=' + placeholder + ']').children().attr("selected", "selected");
        }

        selectsearch.trigger("liszt:updated");
        wrapper.find('input[type=hidden]').val(selectsearch.val());
        selectsearch.trigger('change');
        return false;

    });
});