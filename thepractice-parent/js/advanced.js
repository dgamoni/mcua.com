jQuery(document).ready(function($) {

    $('.tfuse_selectable_code').live('click', function () {
        var r = document.createRange();
        var w = $(this).get(0);
        r.selectNodeContents(w);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(r);
    });
    $(document).bind({reservationform_preview:function(){
        $('select.select_styled').selectmenu({
            style:'dropdown'
        });
    },
        contact_form_preview_open:function(){
            $('select.select_styled').selectmenu({
                style:'dropdown'
            });
        }
    });
    $('#tf_rf_form_name_select').change(function(){
        $_get=getUrlVars();
        if($(this).val()==-1 && 'formid' in $_get){
            delete $_get.formid;
        } else if($(this).val()!=-1){
            $_get.formid=$(this).val();
        }
        $_url_str='?';
        $.each($_get,function(key,val){
            $_url_str +=key+'='+val+'&';
        })
        $_url_str = $_url_str.substring(0,$_url_str.length-1);
        window.location.href=$_url_str;
    });


    function getUrlVars() {
        urlParams = {};
        var e,
            a = /\+/g,
            r = /([^&=]+)=?([^&]*)/g,
            d = function (s) {
                return decodeURIComponent(s.replace(a, " "));
            },
            q = window.location.search.substring(1);
        while (e = r.exec(q))
            urlParams[d(e[1])] = d(e[2]);
        return urlParams;
    }

	
	$("#slider_slideSpeed,#slider_play,#slider_pause,#the-practice_map_zoom").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
            // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||
            // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    });

    jQuery('#the-practice_map_lat,#the-practice_map_long').keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 190 || event.keyCode == 110|| event.keyCode == 189 || event.keyCode == 109 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
            // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||
            // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    });

    $('#the-practice_framework_options_metabox .handlediv, #the-practice_framework_options_metabox .hndle').hide();
    $('#the-practice_framework_options_metabox .handlediv, #the-practice_framework_options_metabox .hndle').hide();

    var options = new Array();

    //hide header options if homepage_category  is different from tfuse_blog_posts or  tfuse_blog_cases

    options['the-practice_homepage_category'] = jQuery('#the-practice_homepage_category').val();
    jQuery('#the-practice_homepage_category').bind('change', function() {
        options['the-practice_homepage_category'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['the-practice_header_element'] = jQuery('#the-practice_header_element').val();
    jQuery('#the-practice_header_element').bind('change', function() {
        options['the-practice_header_element'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['the-practice_page_title'] = jQuery('#the-practice_page_title').val();
    jQuery('#the-practice_page_title').bind('change', function() {
        options['the-practice_page_title'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['slider_hoverPause'] = jQuery('#slider_hoverPause').val();
    jQuery('#slider_hoverPause').bind('change', function() {
       if (jQuery(this).next('.tf_checkbox_switch').hasClass('on'))  options['slider_hoverPause']= true;
        else  options['slider_hoverPause'] = false;
        tfuse_toggle_options(options);
    });

    options['map_type'] = jQuery('#the-practice_map_type').val();
    jQuery(' #the-practice_map_type').bind('change', function() {
        options['map_type'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['the-practice_homepage_category'] = jQuery('#the-practice_homepage_category').val();
    jQuery('#the-practice_homepage_category').bind('change', function() {
        options['the-practice_homepage_category'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['the-practice_blogpage_category'] = jQuery('#the-practice_blogpage_category').val();
    jQuery('#the-practice_blogpage_category').bind('change', function() {
        options['the-practice_blogpage_category'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['the-practice_header_element_blog'] = jQuery('#the-practice_header_element_blog option:selected').val();
    jQuery('#the-practice_header_element_blog').bind('change', function() {
        options['the-practice_header_element_blog'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['the-practice_map_type_blog'] = jQuery('#the-practice_map_type_blog option:selected').val();
    jQuery('#the-practice_map_type_blog').bind('change', function() {
        options['the-practice_map_type_blog'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    tfuse_toggle_options(options);

    function tfuse_erase_divider(list)
    {
        for(i=0;i<$('.tfclear.divider').length;i++)
        {
            if ($.inArray(i,list)!=-1) {$('.tfclear.divider').eq(i).hide(); console.log($('.tfclear.divider').eq(i));}
            else $('.tfclear.divider').eq(i).show();
        }
    }
    function tfuse_toggle_options(options)
    {

        jQuery('#the-practice_quote_before_slider, #the-practice_select_slider, #the-practice_header_image, #the-practice_image_caption, #the-practice_link_text, #the-practice_link_url, #the-practice_link_target, #the-practice_map_address, #the-practice_map_lat, #the-practice_map_long, #the-practice_map_zoom, #the-practice_map_type, #the-practice_quote_after_image, #the-practice_custom_title, .homepage_category_header_element').parents('.option-inner').hide();
        jQuery('#the-practice_quote_before_slider, #the-practice_select_slider, #the-practice_header_image, #the-practice_image_caption, #the-practice_link_text, #the-practice_link_url, #the-practice_link_target, #the-practice_map_address, #the-practice_map_lat, #the-practice_map_long, #the-practice_map_zoom, #the-practice_map_type, #the-practice_quote_after_image, #the-practice_custom_title, .homepage_category_header_element').parents('.form-field').hide();

        var homepage = true;
        if (jQuery('.homepage_category_header_element').length == 1) homepage = false;
        if ( options['the-practice_homepage_category'] == 'tfuse_blog_posts' || options['the-practice_homepage_category'] == 'tfuse_blog_cases')
        {
            homepage = true;
            jQuery('.homepage_category_header_element').parents('.option-inner').show();
            jQuery('.homepage_category_header_element').parents('.form-field').show();
        }
        if(options['the-practice_header_element'] == 'slider' && homepage)
        {
            var list = new Array();
            list=[4,5];
            tfuse_erase_divider(list);
            jQuery('#the-practice_quote_before_slider').parents('.option-inner').show();
            jQuery('#the-practice_quote_before_slider').parents('.form-field').show();

            jQuery('#the-practice_select_slider').parents('.option-inner').show();
            jQuery('#the-practice_select_slider').parents('.form-field').show();
            jQuery('.the-practice_map_zoom,.the-practice_link_target,.the-practice_header_image').next().hide();
        }
        else if(options['the-practice_header_element'] == 'image' && homepage)
            {   var list = new Array();
                list=[1];
                tfuse_erase_divider(list);
                jQuery('#the-practice_header_image').parents('.option-inner').show();
                jQuery('#the-practice_header_image').parents('.form-field').show();

                jQuery('#the-practice_image_caption').parents('.option-inner').show();
                jQuery('#the-practice_image_caption').parents('.form-field').show();

                jQuery('#the-practice_link_text').parents('.option-inner').show();
                jQuery('#the-practice_link_text').parents('.form-field').show();

                jQuery('#the-practice_link_url').parents('.option-inner').show();
                jQuery('#the-practice_link_url').parents('.form-field').show();

                jQuery('#the-practice_link_target').parents('.option-inner').show();
                jQuery('#the-practice_link_target').parents('.form-field').show();

                jQuery('#the-practice_quote_after_image').parents('.option-inner').show();
                jQuery('#the-practice_quote_after_image').parents('.form-field').show();
                jQuery('.the-practice_map_zoom,.the-practice_quote_before_slider').next().hide();
            }
            else if (options['the-practice_header_element'] == 'map' && homepage)
            {
                var list = new Array();
                list=[1,2,3];
                tfuse_erase_divider(list);
                jQuery('#the-practice_map_address').parents('.option-inner').hide();
                jQuery('#the-practice_map_address').parents('.form-field').hide();

                jQuery('#the-practice_map_lat').parents('.option-inner').show();
                jQuery('#the-practice_map_lat').parents('.form-field').show();

                jQuery('#the-practice_map_long').parents('.option-inner').show();
                jQuery('#the-practice_map_long').parents('.form-field').show();

                jQuery('#the-practice_map_zoom').parents('.option-inner').show();
                jQuery('#the-practice_map_zoom').parents('.form-field').show();

                jQuery('#the-practice_map_type').parents('.option-inner').show();
                jQuery('#the-practice_map_type').parents('.form-field').show();
                jQuery('.the-practice_quote_before_slider,.the-practice_header_image,.the-practice_link_target').next().hide();
            } else if (options['the-practice_header_element'] == 'none' && homepage)
            {
                var list = new Array();
                list=[1,2,3,4];
                tfuse_erase_divider(list);
                jQuery('.the-practice_header_element,.the-practice_quote_before_slider,.the-practice_header_image,.the-practice_link_target,.the-practice_map_zoom').next().hide();
            }

        if(options['the-practice_page_title'] == 'custom_title')
        {
            jQuery('#the-practice_custom_title').parents('.option-inner').show();
            jQuery('#the-practice_custom_title').parents('.form-field').show();
        }

        if (options['slider_hoverPause'])
        {
            jQuery('.slider_pause').show();
            jQuery('.slider_pause').next('.tfclear').show();
        }
        else
        {
            jQuery('.slider_pause').hide();
            jQuery('.slider_pause').next('.tfclear').hide();
        }

        if ( (options['map_type'] == 'map3') && (options['the-practice_header_element'] == 'map') && homepage)
        {
            jQuery('#the-practice_map_address').parents('.option-inner').show();
            jQuery('#the-practice_map_address').parents('.form-field').show();
        }

        if(options['the-practice_homepage_category']=='all'){
            jQuery('.the-practice_use_page_options,.the-practice_categories_select_categ,.the-practice_home_page,.the-practice_content_bottom').hide();
            jQuery('#homepage-header,#homepage-shortcodes').show();
        }
        else if(options['the-practice_homepage_category']=='specific'){
            jQuery('.the-practice_use_page_options,.the-practice_categories_select_categ,.the-practice_home_page,.the-practice_content_bottom').hide();
            jQuery('#homepage-header,#homepage-shortcodes,.the-practice_categories_select_categ').show();
        }
        else if(options['the-practice_homepage_category']=='page'){
            jQuery('.the-practice_categories_select_categ,.the-practice_content_bottom').hide();
            jQuery('.the-practice_use_page_options,.the-practice_content_bottom,.the-practice_home_page').show();
            if(jQuery('#the-practice_use_page_options').is(':checked')) jQuery('#homepage-header,#homepage-shortcodes').hide();
            jQuery('#the-practice_use_page_options').live('change',function () {
                if(jQuery(this).is(':checked'))
                    jQuery('#homepage-header,#homepage-shortcodes').hide();
                else
                    jQuery('#homepage-header,#homepage-shortcodes').show();
            });
        }

        if(options['the-practice_blogpage_category']=='all')
            jQuery('.the-practice_categories_select_categ_blog').hide();
        else
            jQuery('.the-practice_categories_select_categ_blog').show();

        if(options['the-practice_header_element_blog']=='none'){
            jQuery('.the-practice_quote_before_slider_blog,.the-practice_select_slider_blog,.the-practice_header_image_blog,.the-practice_image_caption_blog,.the-practice_link_text_blog,.the-practice_link_url_blog,.the-practice_link_target_blog,.the-practice_quote_after_image_blog,.the-practice_map_lat_blog,.the-practice_map_long_blog,.the-practice_map_zoom_blog,.the-practice_map_type_blog,.the-practice_map_address_blog').hide();
            jQuery('.the-practice_header_element_blog,.the-practice_quote_before_slider_blog,.the-practice_header_image_blog,.the-practice_link_target_blog,.the-practice_map_zoom_blog').next().hide();
        }
        else if(options['the-practice_header_element_blog']=='slider'){
            jQuery('.the-practice_header_image_blog,.the-practice_image_caption_blog,.the-practice_link_text_blog,.the-practice_link_url_blog,.the-practice_link_target_blog,.the-practice_quote_after_image_blog,.the-practice_map_lat_blog,.the-practice_map_long_blog,.the-practice_map_zoom_blog,.the-practice_map_type_blog,.the-practice_map_address_blog').hide();
            jQuery('.the-practice_quote_before_slider_blog,.the-practice_select_slider_blog').show();
            jQuery('.the-practice_map_zoom_blog,.the-practice_link_target_blog,.the-practice_header_image_blog').next().hide();
        }
        else if(options['the-practice_header_element_blog']=='image'){
            jQuery('.the-practice_header_image_blog,.the-practice_image_caption_blog,.the-practice_link_text_blog,.the-practice_link_url_blog,.the-practice_link_target_blog,.the-practice_quote_after_image_blog').show();
            jQuery('.the-practice_quote_before_slider_blog,.the-practice_select_slider_blog,.the-practice_map_lat_blog,.the-practice_map_long_blog,.the-practice_map_zoom_blog,.the-practice_map_type_blog,.the-practice_map_address_blog').hide();
            jQuery('.the-practice_map_zoom_blog,.the-practice_quote_before_slider_blog').next().hide();
        }
        else if(options['the-practice_header_element_blog']=='map'){
            jQuery('.the-practice_header_image_blog,.the-practice_image_caption_blog,.the-practice_link_text_blog,.the-practice_link_url_blog,.the-practice_link_target_blog,.the-practice_quote_after_image_blog,.the-practice_quote_before_slider_blog,.the-practice_select_slider_blog').hide();
            jQuery('.the-practice_map_lat_blog,.the-practice_map_long_blog,.the-practice_map_zoom_blog,.the-practice_map_type_blog,.the-practice_map_address_blog').show();
            jQuery('.the-practice_quote_before_slider_blog,.the-practice_header_image_blog,.the-practice_link_target_blog').next().hide();

            if(options['the-practice_map_type_blog']!='map3')
                jQuery('.the-practice_map_address_blog').hide();
            else
                jQuery('.the-practice_map_address_blog').show();
        }

    }
});