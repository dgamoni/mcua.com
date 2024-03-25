function custom_generator_faq(type,options) {
    shortcode='[faq title="'+options.title+'"]';
    for(i in options.array) {
        shortcode+='[faq_question]'+options.array[i]['question']+'[/faq_question]';
        shortcode+='[faq_answer]'+options.array[i]['answer']+'[/faq_answer]';
    }
    shortcode+='[/faq]';
    return shortcode;
}

function custom_obtainer_faq(data) {
    var $ = jQuery;
    cont=$('.tf_shortcode_option:visible');
    sh_options={};
    sh_options['array']=[];
    sh_options['title']=opt_get('tf_shc_faq_title',cont);
    cont.find('[name="tf_shc_faq_question"]').each(function(i) {
        question=$(this).val();
        answer=$(this).parents('.option').nextAll('.option').find('[name="tf_shc_faq_answer"]:first').val();
        tmp={};
        tmp['question']=question;
        tmp['answer']=answer;
        sh_options['array'].push(tmp);
    })
    return sh_options;
}

function custom_generator_tabs(type,options) {
    shortcode='[tabs class="'+options['class']+'"]';
    for(i in options.array) {
        shortcode+='[tab title="'+options.array[i]['title']+'"]'+options.array[i]['content']+'[/tab]';
    }
    shortcode+='[/tabs]';
    return shortcode;
}

function custom_obtainer_tabs(data) {
    var $ = jQuery;
    cont=$('.tf_shortcode_option:visible');
    sh_options={};
    sh_options['array']=[];
    sh_options['class']= opt_get('tf_shc_tabs_class',cont);
    cont.find('[name="tf_shc_tabs_title"]').each(function(i) {
        div=$(this).parents('.option');
        title=opt_get($(this).attr('name'),div);
        div=$(this).parents('.option').nextAll('.option').find('[name="tf_shc_tabs_content"]').first().parents('.option');
        content=opt_get($(this).parents('.option').nextAll('.option').find('[name="tf_shc_tabs_content"]').first().attr('name'),div);
        tmp={};
        tmp['title']=title;
        tmp['content']=content;
        sh_options['array'].push(tmp);
    })
    console.log(sh_options)
    return sh_options;
}

function custom_generator_slider(type,options) {
    shortcode='[slider fadespeed="'+options['fadespeed']+'" play="' + options['play'] + '" pause="' + options['pause'] + '" hoverpause="' + options['hoverpause'] + '" autoheight="' + options['autoheight'] + '"]';
    for(i in options.array) {
        shortcode+='[slide title="'+options.array[i]['title']+'" text="' + options.array[i]['text'] + '" url="' + options.array[i]['url'] + '"]'+options.array[i]['content']+'[/slide]';
    }
    shortcode+='[/slider]';
    return shortcode;
}

function custom_obtainer_slider(data) {
    var $ = jQuery;
    cont=$('.tf_shortcode_option:visible');
    sh_options={};
    sh_options['array']=[];
    sh_options['fadespeed']= opt_get('tf_shc_slider_fadespeed',cont);
    sh_options['play']= opt_get('tf_shc_slider_play',cont);
    sh_options['pause']= opt_get('tf_shc_slider_pause',cont);
    sh_options['hoverpause']= opt_get('tf_shc_slider_hoverpause',cont);
    sh_options['autoheight']= opt_get('tf_shc_slider_autoheight',cont);

    cont.find('[name="tf_shc_slider_title"]').each(function(i)
    {
        div=$(this).parents('.option');
        title=opt_get($(this).attr('name'),div);

        div=$(this).parents('.option').nextAll('.option').find('[name="tf_shc_slider_content"]').first().parents('.option');
        content=opt_get($(this).parents('.option').nextAll('.option').find('[name="tf_shc_slider_content"]').first().attr('name'),div);

        div=$(this).parents('.option').nextAll('.option').find('[name="tf_shc_slider_text"]').first().parents('.option');
        text=opt_get($(this).parents('.option').nextAll('.option').find('[name="tf_shc_slider_text"]').first().attr('name'),div);

        div=$(this).parents('.option').nextAll('.option').find('[name="tf_shc_slider_url"]').first().parents('.option');
        url=opt_get($(this).parents('.option').nextAll('.option').find('[name="tf_shc_slider_url"]').first().attr('name'),div);
        tmp={};
        tmp['title'] = title;
        tmp['content'] = content;
        tmp['text']=text;
        tmp['url']=url;

        sh_options['array'].push(tmp);
    });
    console.log(sh_options)
    return sh_options;
}
