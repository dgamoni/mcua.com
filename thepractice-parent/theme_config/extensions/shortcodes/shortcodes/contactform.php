<?php
function tf_contactform_shortcode($atts){
    global $TFUSE;
    wp_register_script( 'contact_forms_js', get_template_directory_uri().'/js/contact_forms.js', array('jquery'), '1.1.0', true );
    wp_enqueue_script( 'contact_forms_js' );
    wp_enqueue_script('jquery-form');
    wp_enqueue_script('jquery');
    wp_register_style( 'contact_forms_css', get_template_directory_uri().'/theme_config/extensions/contactform/static/css/contact_form.css', true, '1.1.0' );
    wp_enqueue_style( 'contact_forms_css' );
    extract(shortcode_atts(array('tf_cf_formid' => '-1'), $atts));
    $out='';
    $form_exists=false;
	$is_preview=false;
    if($tf_cf_formid!='-1'){
		$is_preview=false;
        $forms = get_option(TF_THEME_PREFIX . '_tfuse_contact_forms');
        if(isset($forms[$tf_cf_formid])){
            $form_exists=true;
            $form = $forms[$tf_cf_formid];
        }
    } elseif(isset($_COOKIE['form_array'])){
        $form_exists=true;
		$is_preview = true;
        $form = unserialize($_COOKIE['form_array']);
        unset($_COOKIE['form_array']);
    }

    if($form_exists){
        $out.='<div id="addcomments" class="add-comment contact-form">';
        $out .='<h3 id="header_message">'.urldecode($form['header_message']).'</h3><div class="comment-form"><div id="form_messages" class="submit_message" ></div>';
        $inputs = $TFUSE->get->ext_config('CONTACTFORM', 'base');
        $input_array = $inputs['input_types'];

        if(isset($_POST['submit'])){
            $TFUSE->ext->contactform->sendSmtp($tf_cf_formid);
        }
        $out.='<form id="contactForm" class="ajax_form contactForm" name="contactForm" method="post" action="">';
        $out.='<input id="this_form_id" type="hidden" value="'. $tf_cf_formid.'" />';
        $fields='';

        $fcount = 1;
        $linewidth = 0;
        $earr=array();
        $linenr = 1;
        $countForm = count($form['input']);
        $dimension=47;
		$lines = array();
		$lines[$linenr] = 0;

        foreach($form['input'] as $form_input_arr){

            $earr[$fcount]['width'] = $form_input_arr['width'];

            $linewidth += $form_input_arr['width'];
            if (isset($form_input_arr['newline'])) {
                $linewidth = $form_input_arr['width'];

                $earr[$fcount]['class'] = ' ';
                if ($fcount>1) {$linenr++;
                    $lines[$linenr] = 0;}
                $earr[$fcount]['line'] = $linenr;
                $lines[$linenr] += $dimension;
            }
            elseif ($linewidth>100) {
                $linewidth = $form_input_arr['width'];
                $linenr++;

                $earr[($fcount-1)]['class'] = ' omega ';
                $earr[$fcount]['class'] = ' ';
                $earr[$fcount]['line'] = $linenr;
                $lines[$linenr] += $dimension;
				$lines[$linenr] = 0;
            }
            elseif($linewidth==100) {
                $linewidth = 0;

                $earr[$fcount]['class'] = ' omega ';
                $earr[$fcount]['line'] = $linenr;
                $lines[$linenr] += $dimension;
                $linenr++;
				$lines[$linenr] = 0;
            }
            else {
                $earr[$fcount]['class'] = ' ';
                $earr[$fcount]['line'] = $linenr;
                $lines[$linenr] += $dimension;
            }

            if ($countForm==$fcount && !isset($form_input_arr['newline'])) {
                $earr[$fcount]['class'] = ' omega ';
            }

            $fcount++;
        }

        $linewidth = 0;
        $fcount = 1;
        $margin=25;
        foreach($form['input'] as $form_input){
            $field='';
            $field_m = '';

            $input=$input_array[$form_input['type']];

            $floating=(isset($form_input['newline']))?'clear:left;':'';
            if (!isset($input['properties']['class']))
                $input['properties']['class'] = '';
            $input['properties']['class'] .=($input['name']=='Email')?' '.TF_THEME_PREFIX.'_email':'';
            $input['properties']['class'] .=(isset($form_input['required']) && $form_input['required'])?' tf_cf_required_input ':'';
            $label_text =(isset($form_input['required']) && $form_input['required'])?trim($form_input['label']).' '.$form['required_text']:trim($form_input['label']);
            $input['id']=str_replace('%%name%%',strtolower(str_ireplace(' ','_',$form_input['shortcode'])),$input['id']);

            $form_input['classes'] = $earr[$fcount]['class'];
            $form_input['floating'] = $floating;
            $form_input['label_text'] = $label_text;

            if($is_preview)
				$sidebar_position = 'full';
            else
				$sidebar_position = tfuse_sidebar_position();

            if (isset($form_input['newline']) ) $field_m .= '<div class="clear"></div>';


            $element_line = $earr[$fcount]['line'];

            if ($sidebar_position == 'full')
            {
                if($is_preview)
                    $ewidth=640-$lines[$element_line]+$margin;
                else
                    $ewidth=828-$lines[$element_line]+$margin;
            }
            else {
                $ewidth=527-$lines[$element_line]+$margin;
            }


            if (isset($form_input['newline'])){
                $linewidth = $form_input['width'];
            }
            else $linewidth += $form_input['width'];


            if ($form_input['width']==100)
            {
                $form_input['ewidthpx'] = $ewidth;
                $linewidth = 0;
            }
            elseif ($linewidth>100 )
            {
                $form_input['ewidthpx'] = (int)($ewidth*$form_input['width']/100);
                $linewidth = 0;
            }
            else
            {
                $form_input['ewidthpx'] = (int)($ewidth*$form_input['width']/100);
            }


            if($lines[$element_line]==$dimension && $form_input['width']>=40 && $form_input['width']<=90){
                $form_input['ewidthpx'] = (int)(($ewidth-$dimension)*$form_input['width']/100);
            }
            elseif($lines[$element_line]==$dimension && $form_input['width']<40 && $form_input['width']>32){
                $form_input['ewidthpx'] = (int)(($ewidth-2*$dimension)*$form_input['width']/100);
            }
            elseif($lines[$element_line]==$dimension && $form_input['width']<33){
                $form_input['ewidthpx'] = (int)(($ewidth-3*$dimension)*$form_input['width']/100);
            }

            if($is_preview && $input['type'] == 'select') $form_input['ewidthpx'] -=23;
            $input_field=$input['type']($input,$form_input);

            if(stripos('[input]',$form['form_template'])!==false){
            } else {
                $field_m .= $input_field;
            }

            if (trim($earr[$fcount]['class'])=='omega' ) $field_m .= '<div class="clear"></div>';

            $field .=$field_m;
            $fields .=$field;

            $fcount++;
        }

        $out.= $fields;
        $surse=get_template_directory_uri().'/images/ajax-loader.gif';
        $out.='<div class="clear"></div><div class="row rowSubmit" style="width:100%">';
        $out.='<a class="link-reset" onclick="resetFields(this,event)" href="#">'.urldecode($form['reset_button']).'</a>';
        $out.='<a href="#" id="sending" class="btn-submit2" style="display: none;"><span>'.__('Sending ...','tfuse').'</span></a>
        <input type="submit" id="send_form" class="btn-submit" name="submit" title="Submit mesage" value="'. $form['submit_mess'].'" />
        <img id="sending_img" src="'.$surse.'" alt="Sending" style="margin-left:10px; margin-bottom:-3px; display: none;" />
        </div></form></div></div>';

    } else {
        $out="<p>This Form is not defined!!</p>";
    }
	global $wp_query;
    if(!isset($wp_query->queried_object->ID))
        return $out;
    return '[raw]' . $out . '[/raw]';
}

$forms_name=array(-1=>'Choose Form');
$forms = get_option(TF_THEME_PREFIX . '_tfuse_contact_forms');
if(!empty($forms)){
    foreach($forms as $key=>$value){
        $forms_name[$key]=$value['form_name'];
    }
}
$atts = array(
    'name' => 'Contact Form',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 9,
    'options' => array(
        array(
            'name' => 'Type',
            'desc' => 'Select the form',
            'id' => 'tf_cf_formid',
            'value' => '',
            'options' => $forms_name,
            'type' => 'select'
        )
    )
);

tf_add_shortcode('tfuse_contactform', 'tf_contactform_shortcode', $atts);
function text($input,$form_input){
    return "<div class='row alignleft infieldlabel ".$form_input['classes']."' style='".$form_input['floating']."'>
                <label for='" .TF_THEME_PREFIX.'_'.trim($form_input['shortcode']). "'>".$form_input['label_text']."</label>
                <input type='text' id='".TF_THEME_PREFIX.'_'. trim($form_input['shortcode'])."' value='' style='width:".$form_input['ewidthpx']."px;' class='".$input['properties']['class']."' name='".TF_THEME_PREFIX.'_'. trim($form_input['shortcode'])."'/>
            </div>";
}

function textarea($input,$form_input){
    return "<div class='row infieldlabel ".$form_input['classes']."' style='".$form_input['floating']."'>
                <label class='textarea' for='" .TF_THEME_PREFIX.'_'.trim($form_input['shortcode']). "'>".$form_input['label_text']."</label>
                <textarea id='".TF_THEME_PREFIX.'_'. trim($form_input['shortcode'])."' style='width:".$form_input['ewidthpx']."px;' class='".$input['properties']['class']."' name='".TF_THEME_PREFIX.'_'.trim($form_input['shortcode'])."' rows='10' ></textarea>
            </div>";
}


function radio($input,$form_input){

    $checked='checked="checked"';
    $output="<div class='row field_text alignleft' style='width:".($form_input['width']-5)."%;".$form_input['floating']."'>
                <label for='" .TF_THEME_PREFIX.'_'.trim($form_input['shortcode']). "'>".$form_input['label_text']."</label>";

    if(is_array($form_input['options'])){
        foreach ($form_input['options'] as $key => $option) {
            $output .= '<div class="multicheckbox"><input '.$checked.' id="' .TF_THEME_PREFIX.'_'. trim($form_input['shortcode']). '_'.$key.'"  type="radio" name="' .TF_THEME_PREFIX.'_'. trim($form_input['shortcode']). '"  value="' .$option. '" /><label class="radiolabel" for="' .TF_THEME_PREFIX.'_'. trim($form_input['shortcode']). '_'.$key.'">' . $option . '</label></div>';
            $checked='';
        }
    }

    $output .= "</div>";
    return $output;
}
function checkbox($input,$form_input){
    $checked = ($input['value'] == 'true') ? 'checked="checked"' : '';
    $output = "<div class='row field_text checkbox alignleft' style='width:".($form_input['width']-5)."%;".$form_input['floating']."'>
                <input class='".$input['properties']['class']."' style='width:15px;' type='checkbox' name='" .TF_THEME_PREFIX."_".trim($form_input['shortcode']). "' id='" .TF_THEME_PREFIX."_".trim($form_input['shortcode']). "' value='".$form_input['label']."'" . $checked . "/>
                <label for='" .TF_THEME_PREFIX."_".trim($form_input['shortcode']). "'>".$form_input['label_text']."</label>
            </div>";
    return $output;
}
function captcha($input,$form_input){
    $input['properties']['class']="tfuse_captcha_input";
    $out="<div class='row field_text alignleft' style='width:".$form_input['width']."%;".$form_input['floating']."'>
            <label for='" .TF_THEME_PREFIX.'_'.trim($form_input['shortcode']). "'>".$form_input['label_text']."</label><br>
            <img  src='".TFUSE_EXT_URI."/contactform/library/".$input['file_name']."?form_id=".TF_THEME_PREFIX.'_'.trim($form_input['shortcode'])."&ver=".rand(0, 15)."' class='tfuse_captcha_img' >
            <input type='button' class='tfuse_captcha_reload' />
            <input style='width:".$form_input['ewidthpx']."px;' id='".trim($input['id'])."' type='text' class='".$input['properties']['class']."' name='".TF_THEME_PREFIX.'_'.trim($form_input['shortcode'])."' />
         </div>";
    return $out;
}

function select($input,$form_input){
    $input['properties']['class'].=' tfuse_option';
    $out = "<div class='row field_text alignleft ".$form_input['classes']."' style='".$form_input['floating']."'>
                <label for='" .TF_THEME_PREFIX."_".trim($form_input['shortcode']). "'>".$form_input['label_text']."</label>
                <select  style='width:".($form_input['ewidthpx']+23)."px;' class='".$input['properties']['class']."' name='" .TF_THEME_PREFIX."_".trim($form_input['shortcode']). "' id='" .trim($input['id']). "'>";
    if(is_array($form_input['options'])){
        foreach ($form_input['options'] as $key => $option) {
            $out .= "<option value='" . $option . "'>";
            $out .= $option;
            $out .= "</option>\r\n";
        }
    }
    $out .= '</select></div>';
    return $out;
}