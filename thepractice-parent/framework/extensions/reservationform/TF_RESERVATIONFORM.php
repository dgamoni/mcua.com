<?php
if (!defined('TFUSE')) exit('Direct access forbidden.');

class TF_RESERVATIONFORM extends TF_TFUSE
{
    public $generalSettingsRow = 'TFUSE_GENOPTIONS_ROW';
    public $_the_class_name = 'RESERVATIONFORM';

    function __construct()
    {
        parent::__construct();
    }

    function __init()
    {
        // Load or not this extension
        if( !$this->load->ext_file_exists($this->_the_class_name, '') )  return;

        require_once(TFUSE_THEME_DIR . '/framework/extensions/' . strtolower($this->_the_class_name) . '/config/constants.php');
        require_once(TFUSE_THEME_DIR . '/framework/extensions/' . strtolower($this->_the_class_name) . '/config/utils.php');
        if (isset($_GET['page']) && $_GET['page'] == 'tf_reservation_form' && isset($_GET['id'])) {
            $this->redirect_if_id_invalid($_GET['id']);
        }
        add_action('admin_menu', array($this, 'add_menu'), 20);
        $this->get->ext_config('RESERVATIONFORM', 'base');
        if (is_admin() && isset($_GET['page']) && stripos($_GET['page'], 'tf_reservation') === 0) {
            $this->add_static();
            $this->include->js_enq('tf_reservationform_save', wp_create_nonce('tf_reservationform_save'));
        }
        $this->add_ajax();
        add_action('tf_rf_form_content', array($this, 'tf_rf_forms_setup'));
        add_action('resform_gen_options', array($this, 'resform_general_settings'));
        add_action('tf_reservation', array($this, 'resform_general_settings'));

    }

    function add_ajax()
    {
        $this->ajax->_add_action('tfuse_ajax_reservationform', $this);
    }

    function add_static()
    {
        $this->include->register_type('framework_css', TFUSE . '/static/css');
        $this->include->register_type('selectmenu', TEMPLATEPATH . '/css');
        $this->include->register_type('framework_js', TFUSE . '/static/javascript');
        $this->include->js('popbox.min', 'framework_js');
        $this->include->css('datepicker', 'framework_css', 'tf_head');
        $this->include->register_type('ext_reservationform_css', TFUSE_EXT_DIR . '/' . strtolower($this->_the_class_name) . '/static/css');
        $this->include->register_type('ext_reservationform_js', TFUSE_EXT_DIR . '/' . strtolower($this->_the_class_name) . '/static/js');
        $this->include->css('reservation_form', 'ext_reservationform_css');
        $this->include->js('reservation_form', 'ext_reservationform_js', 'tf_footer', 10, '1.1');
        if(file_exists(TEMPLATEPATH.'/theme_config/extensions/reservationform/options/preview_options.php')){

            $options = $this->get->ext_options($this->_the_class_name, 'preview');
            if(@is_array($options))
                foreach($options as $key=>$option){
                    $this->include->register_type($option['type'].$key,$option['dir'] );
                    $this->include->$option['type']( $option['filename'],$option['type'].$key,'tf_footer',($option['type'] == 'js') ? '20' : '' );
                }


        }
    }

    function add_menu()
    {
        if (function_exists('add_object_page'))
        add_object_page('Reservation Forms Settings', apply_filters('res_form_top_menu','Reservations'), 'publish_pages', 'tf_reservations_list', array($this, 'list_reservations'));
       else
        add_menu_page('Reservation Forms Settings', apply_filters('res_form_top_menu','Reservations'), 'publish_pages', 'tf_reservations_list', array($this, 'list_reservations'));
        add_submenu_page('tf_reservations_list', apply_filters('res_form_res_list','User Reservations'), apply_filters('res_form_res_list','User Reservations'), 'publish_pages', 'tf_reservations_list', array($this, 'list_reservations'));
        add_submenu_page('tf_reservations_list', apply_filters('res_form_all_forms','All Reservation Forms'), apply_filters('res_form_all_forms','All Reservation Forms'), 'publish_pages', 'tf_reservation_forms_list', array($this, 'list_forms'));
        add_submenu_page('tf_reservations_list', apply_filters('res_form_add_new','Add New Form'), apply_filters('res_form_add_new','Add New Form'), 'publish_pages', 'tf_reservation_form', array($this, 'show_add_form'));
        add_submenu_page('tf_reservations_list', apply_filters('res_form_gen_set','General Settings'), apply_filters('res_form_gen_set','General Settings'), 'publish_pages', 'tf_reservation_forms_gensett', array($this, 'list_gen_options'));

    }

    function list_reservations()
    {
        if(isset($_GET['id'])) {
            $this->reservation_details();
            return;
        }
        $status = (isset($_GET['filter']))?$_GET['filter']:1;
        $post_statuses = array(1=>'any',2=>'private',3=>'publish',4=>'draft');
        $this->common_html();
        $filter = $post_statuses[$status];
        $posts = array();
        $paged = (isset($_GET['paged'])) ? $_GET['paged'] :1;
        if(isset($_GET['s'])){
            $post_id = decode_res_id($_GET['s']);
            $posts[] = get_post($post_id);
        }
        else
            $posts = get_posts(array('numberposts' => -1,'posts_per_page'=>20,'paged'=>$paged, 'post_type' => 'reservations', 'post_status' => $post_statuses[$status]));
        $count_posts = wp_count_posts('reservations');
        $all_posts = $count_posts->private+$count_posts->publish+$count_posts->draft;
        $array_statistic = array('all'=> $all_posts,'pending'=>$count_posts->private,'approved'=>$count_posts->publish,'rejected'=>$count_posts->draft);
        foreach ($posts as $key => $post) {
            $cur_post_term = wp_get_post_terms($post->ID, $post->post_type);
            if(empty($cur_post_term)){
                $form = unserialize($post->post_content);
                $form =serialize($form['form']);
                $terms = array($form);
            } else $terms = $cur_post_term;
            $posts[$key]->term = $terms;

        }
        if($this->module_tc_view_exists('list_reservations'))
            $this->get_tc_view('list_reservations',array('posts' => $posts,'statistic'=>$array_statistic, 'ext_name' => $this->_the_class_name));
        else
            $this->load->ext_view($this->_the_class_name, 'list_reservations', array('posts' => $posts,'statistic'=>$array_statistic, 'ext_name' => $this->_the_class_name));

    }
    public function module_tc_view_exists($name_file)
    {
        $child_path =  TFUSE_CHILD_CONFIG.'/extensions/' . strtolower($this->_the_class_name) .  '/views/' .$name_file . '.php';
        $theme_path = TFUSE_CONFIG.'/extensions/' . strtolower($this->_the_class_name) .  '/views/' .$name_file . '.php';
        if(file_exists($child_path))
            return $child_path;
        if (file_exists($theme_path))
            return $theme_path;
        else return FALSE;
    }
    function get_tc_view($__name_file, $__data = NULL, $__return = FALSE){
        $__name_file = strtolower($__name_file);
        $view_path = $this->module_tc_view_exists($__name_file);
        if (!$view_path)
            exit('View not found View -> Theme Config: ' . strtolower($this->_the_class_name) . '/views/' . $__name_file . '.php');
        if ($__data !== NULL && count($__data) > 0)
            foreach ($__data as $__name_var => $_value)
                ${$__name_var} = $_value;
        ob_start();
        require($view_path);
        $buffer = ob_get_clean();
        if ($__return === TRUE)
            return $buffer;
        else
            echo $buffer;
    }
    function add_email_content(){
        $this->common_html();
        $resId = $_GET['id'];
        $status = $_GET['status'];
        $the_post = get_post($resId);
        $the_post = unserialize($the_post->post_content);
        $the_form = wp_get_post_terms($resId, 'reservations');
        if(count($the_form) == 0){
            $the_form = $the_post['form'];
        } else
            $the_form = unserialize($the_form[0]->description);
        $message = ($status == 1) ? $the_form['confirm_email_template'] : $the_form['reject_email_template'];
        if(trim($message) != ''){
            foreach($the_form['input'] as $input){
                $message = str_replace('['.$input["shortcode"].']',$the_post[TF_THEME_PREFIX.'_'.$input["shortcode"]],$message);
            }
        } else {
            foreach($the_form['input'] as $input){
                $value = (in_array($input['type'],array(7,8)))?date_i18n(get_option('date_format') ,strtotime($the_post[TF_THEME_PREFIX . '_' . $input['shortcode']])):$the_post[TF_THEME_PREFIX . '_' . $input['shortcode']];
                $message .= '<strong>'. urldecode($input['label']) . ':</strong> '.$value. '<br />';
            }
            $not = ($status == -1)?'rejected':'approved';
            $message .= '<br />Your reservation has been '.$not.'.';
        }
        $options = array(
            'tabs' => array(
                array(
                    'name' => 'Edit email',
                    'id' => TF_THEME_PREFIX . 'edit_email',
                    'headings' => array(
                        array(
                            'name' => 'Email Content',
                            'id' => 'email_details',
                            'options' => array(
                                array(
                                    'name' => 'Email',
                                    'type'=>'textarea',
                                    'desc' => '',
                                    'id' => 'tfuse_rf_email',
                                    'value' => $message,
                                    'properties' =>array(
                                        'rel' => $resId
                                    )
                                )
                            )
                        )
                    )
                )
            )
        );
        foreach($options['tabs'] as $tab){
            $headings = $tab['headings'];
            unset($tab['headings']);
            foreach ($headings as $heading) {
                $options[$tab['id']][$heading['name']] = '';
                foreach($heading['options'] as $option){
                    $options[$tab['id']][$heading['name']] .= $this->interface->meta_box_row_template($option);
                }
            }
        }
        $this->create_form_meta_box($options);
        echo '<a id="tfuse_rf_send_email" class="approve_selected_reservations button">Send Email</a>
        <a href="'.get_admin_url().'admin.php?page=tf_reservations_list" class="reject_selected_reservations button reset-button">Cancel</a>';

    }

    function reservation_details()
    {
        $resId = $_GET['id'];
        $this->redirect_if_reservation_id_invalid($resId);
        $this->common_html();
        $inputs = $this->get->ext_config('RESERVATIONFORM', 'base');
        $inputs = $inputs['input_types'];
        $post = get_post($resId);
        $the_post = unserialize($post->post_content);
        $the_form = wp_get_post_terms($resId, 'reservations');
        if(count($the_form) == 0){
            $the_form = $the_post['form'];
        } else
            $the_form = unserialize($the_form[0]->description);
        $post_statuses = array('publish'=>'Approved','draft'=>'Rejected','private'=>'Pending');
        $options = array(
            'tabs' => array(
                array(
                    'name' => apply_filters('res_details_name','Reservation Details'),
                    'id' => TF_THEME_PREFIX . 'res_details',
                    'headings' => array(
                        array(
                            'name' => 'Details',
                            'id' => 'res_details',
                            'options' => array(
                                array(
                                    'name' => 'Status',
                                    'type' => 'raw',
                                    'id' =>'',
                                    'html'=>'<div class="rf_post_status_'.$post->post_status.'">'.$post_statuses[$post->post_status].'</div>',
                                    'value'=> '',
                                    'divider'=>true
                                )
                            )
                        )
                    )
                )
            )
        );
        foreach ($the_form['input'] as $key=>$input) {
            if(!isset($the_post[TF_THEME_PREFIX . '_' . $input['shortcode']])) $the_post[TF_THEME_PREFIX . '_' . $input['shortcode']] = '-';
            if($input['type'] == 9)
                $html = '<a  class="res_mailto" href="mailto:'.urldecode($the_post[TF_THEME_PREFIX . '_' . $input['shortcode']]).'">'.urldecode($the_post[TF_THEME_PREFIX . '_' . $input['shortcode']]).'</a>';
            else
                $html = (!in_array($input['type'],array(7,8)) && $inputs[$input['type']]['name'] == 'Email') ? '<a  class="res_mailto" href="mailto:'.urldecode($the_post[TF_THEME_PREFIX . '_' . $input['shortcode']]).'">'.urldecode($the_post[TF_THEME_PREFIX . '_' . $input['shortcode']]).'</a>':urldecode($the_post[TF_THEME_PREFIX . '_' . $input['shortcode']]);
            $option = array();
            $option['name'] = apply_filters('res_input_name_'.TF_THEME_PREFIX .'_'.$input['shortcode'],__(urldecode($input['label']),'tfuse'));
            $option['desc'] = '';
            $option['id'] = TF_THEME_PREFIX .'_'.$input['shortcode'];
            $option['type'] = 'raw';
            $option['html'] ='<div class="res_det_messages">'.((in_array($input['type'],array(7,8)))?date_i18n(get_option('date_format') ,strtotime($the_post[TF_THEME_PREFIX . '_' . $input['shortcode']])):$html ).'</div>';
            $option['value'] = '';
            end($the_form['input']);
            $k = key($the_form['input']);
            if($k == $key)
                $option['divider'] = true;
            $options['tabs'][0]['headings'][0]['options'][] = $option;
        }
        if(isset($the_post['sent_messages']))
            foreach($the_post['sent_messages'] as $sent_message){
                $option = array();
                $option['name'] = date_i18n(get_option('date_format') ,strtotime($sent_message['date']));
                $option['desc'] = 'Message sent by you to the user that made the reservation';
                $option['id'] = '';
                $option['type'] = 'raw';
                $option['html'] = '<div class="res_det_messages">'.urldecode($sent_message['message']).'</div>';
                $option['value'] = '';
                $options['tabs'][0]['headings'][0]['options'][] = $option;
            }
        $mess_option = array(
            'name' => 'Message',
            'desc' => 'This message will overwrite the message template from form settings',
            'id'   => TF_THEME_PREFIX .'_email_message',
            'type' => 'textarea',
            'value' => '',
        );
        $options['tabs'][0]['headings'][0]['options'][] = $mess_option;
        foreach($options['tabs'] as $tab){
            $headings = $tab['headings'];
            unset($tab['headings']);
            foreach ($headings as $heading) {
                $options[$tab['id']][$heading['name']] = '';
                foreach($heading['options'] as $option){
                    $options[$tab['id']][$heading['name']] .= $this->interface->meta_box_row_template($option);
                }
            }
        }
        echo '<div style="clear:both;height:20px;"> </div>';
        $this->create_form_meta_box($options);
        $approve_button = '<a href="#" id="tf_rf_confirm_reservation" class="button">Approve</a>';
        $reject_button = ' <a id="tf_rf_reject_reservation" href="#" class="button reset-button">Reject</a>';
        $message_button = ' <a id="tf_rf_send_message_reservation" href="#" class="button">Send message</a>';
        if(in_array($post->post_status,array('private','draft')))
            echo $approve_button;
        else echo $message_button;
        if(in_array($post->post_status,array('private','publish')))
            echo $reject_button;
        else echo $message_button;

    }
    function ajax_send_multiple_emails(){
        $post_ids = $_POST['resid'];
        foreach($post_ids as $post_id)
            $this->ajax_send_email($post_id);die;
    }
    function ajax_send_email($ph_id = -1){
        $this->ajax->_verify_nonce('tf_reservationform_save');
        $inputs = $this->get->ext_config($this->_the_class_name, 'base');
        $gen_sett = $this->model->get_forms_gen_options();
        $post_id = isset($_POST['post_id'])?$_POST['post_id']:$ph_id;
        $message = (isset($_POST['message']) && trim($_POST['message']) != '')?$_POST['message']:'';
        $status = $_POST['status'];
        $the_form = wp_get_post_terms($post_id, 'reservations');
        $the_form = unserialize($the_form[0]->description);
        $the_post = get_post($post_id);
        if(($the_post == 'draft' && $status == -1) || ($the_post == 'publish' && $status == 1 )) return;
        $date_format=get_option('date_format');
        $post = unserialize($the_post->post_content);
        $nr=encode_id($post_id);
        if(trim($message) == '' && $status !=0)
            $message = ($status == 1) ? __(urldecode($the_form['confirm_email_template'] ),'tfuse')
                :__(urldecode($the_form['reject_email_template']),'tfuse');
        if(trim($message) != ''){
            foreach($the_form['input'] as $input){
                $value = (in_array($input['type'],array(7,8)))?date_i18n($date_format ,strtotime($post[TF_THEME_PREFIX . '_' . $input['shortcode']])):$post[TF_THEME_PREFIX . '_' . $input['shortcode']];
                $message = str_replace('['.$input["shortcode"].']',$value,$message);
            }
            $message = str_replace('[resnumber]',$nr,$message);
        } else {
            foreach($the_form['input'] as $input){
                $value = (in_array($input['type'],array(7,8)))?date_i18n($date_format ,strtotime($post[TF_THEME_PREFIX . '_' . $input['shortcode']])):$post[TF_THEME_PREFIX . '_' . $input['shortcode']];
                $message .= '<strong>'. urldecode($input['label']) . ':</strong> '.$value. '<br />';
            }
            $not = ($status == -1)?'rejected':'approved';
            $message .= '<br />Your reservation has been '.$not.'.';
        }

        $email = '';
        foreach($the_form['input'] as $input){
            if($input['type']==9){
                $email =urldecode($post[TF_THEME_PREFIX.'_'.$input['shortcode']]);
                break;
            }
        }
        $mail_type=(isset($gen_sett['mail_type']))?'send'.ucwords($gen_sett['mail_type']):'sendWpmail';
        $the_form['email_subject'] = urlencode(str_replace('[resnumber]',$nr,urldecode($the_form['email_subject'])));
        $response = $this->$mail_type($gen_sett,$message,$email,$the_form);
        $now = date($date_format);
        $m = array(
            'message' => $message,
            'date' => $now
        );
        $post['sent_messages'][] = $m;
        $the_post->post_content = serialize($post);
        if($response['error'] == false){
            if($status == 1)
                $the_post->post_status = 'publish';
            elseif($status == -1)
                $the_post->post_status = 'draft';
            wp_update_post($the_post);
        }
        echo json_encode($response);if(isset($_POST['post_id']))die;
    }
    function delete_reservations()
    {
        if (is_array($_POST['resid']))
            foreach ($_POST['resid'] as $id)
                wp_delete_post($id, true);
        else wp_delete_post($_POST['resid'], true);
    }

    function get_excluded_dates()
    {
        $post_term = get_term_by('id', $_POST['tf_form_id'], 'reservations');
        $form = unserialize($post_term->description);
        $exclude_dates = $form['exclude_dates'];
        foreach ($exclude_dates as $key => $val)
            $exclude_dates[$key] = urldecode($val);
        echo json_encode($exclude_dates);
        die;
    }

    function resform_general_settings()
    {
        $this->common_html();
        if (isset($_POST['save_gen_options'])) {
            $this->save_general_options();
        }
        echo '<div style="clear:both;height:20px;">&nbsp;</div>';
        $options = $this->get_form_gen_options();
        $this->create_form_meta_box($options);
    }

    function list_gen_options()
    {
        $this->load->ext_view($this->_the_class_name, 'general_settings', array('ext_name' => $this->_the_class_name));
    }

    function list_forms()
    {
        $this->common_html();
        $forms = get_terms('reservations', array('hide_empty' => 0));
        foreach ($forms as $key => $form) {
            $forms[$key]->description = unserialize($form->description);
        }
        $this->load->ext_view($this->_the_class_name, 'list_forms', array('forms' => $forms, 'ext_name' => $this->_the_class_name));

    }

    function common_html()
    {
        echo '<div id="tfuse_fields" class="wrap metabox-holder">';
        $this->interface->page_header_info();
    }

    function show_add_form()
    {
        $this->common_html();
        $this->load->ext_view($this->_the_class_name, 'form_setup', array('ext_name' => $this->_the_class_name));
    }

    function tf_rf_forms_setup()
    {
        if (isset($_POST['save_form']) || isset($_POST['save_messages']) || isset($_POST['save_dates'])) {
            $this->save_form();
        }
        echo '<div style="clear:both;height:20px;">&nbsp;</div>';
        $options = $this->get_form_options();
        $this->create_form_meta_box($options);
    }
    function ajax_datepicker_row(){
        $values = array('label'=>'Check Out','width'=>'50','newline'=>false);
        echo json_encode(array( 'html'=>$this->interface->cf_row_template($this->date_in_out(8,$values,$_POST['number']))));die;
    }
    function submitFrontendForm()
    {
        $exclude_from_post = array('submit', 'action', 'tf_action', 'form_id');
        $form_id = $_POST['form_id'];
        $inputs = $this->get->ext_config($this->_the_class_name, 'base');
        $gen_sett = $this->model->get_forms_gen_options();
        $form = get_term_by('id', $form_id, 'reservations');
        $form = unserialize($form->description);
        $message = '';
        $title = (trim(urldecode($form['reservation_title'])) != '') ? __(urldecode($form['reservation_title']),'tfuse') : 'New Reservation';
        $post_content = array();
        foreach ($_POST as $key => $value) {
            $title = str_replace('[' . str_replace(TF_THEME_PREFIX . '_', '', $key) . ']', $value, $title);
            if (!in_array($key, $exclude_from_post)) {
                $post_content[$key] = urlencode($value);
            }
        }
        $post = array('post_type' => 'reservations', 'post_title' => $title, 'post_status' => 'private', 'post_content' => serialize($post_content));
        $status = wp_insert_post($post, true);
        if($status){
            $nr=encode_id($status);
            if(isset($form['new_res_email_template']) && trim($form['new_res_email_template']) != '')
            {
                $message = __(urldecode($form['new_res_email_template']),'tfuse');
                $message = str_replace('[resnumber]',$nr,$message);
                foreach($form['input'] as $input){
                    if(isset($_POST[TF_THEME_PREFIX.'_'.$input["shortcode"]]))
                        $message = str_replace('['.$input["shortcode"].']',$_POST[TF_THEME_PREFIX.'_'.$input["shortcode"]],$message);
                    else
                        $message = str_replace('['.$input["shortcode"].']','-',$message);
                }

            }
            else {
                foreach($form['input'] as $input){
                    $value = (in_array($input['type'],array(7,8)))?date_i18n(get_option('date_format') ,strtotime($_POST[TF_THEME_PREFIX . '_' . $input['shortcode']])):$_POST[TF_THEME_PREFIX . '_' . $input['shortcode']];
                    $message .= '<strong>'. urldecode($input['label']) . ':</strong> '.$value. '<br />';
                }

                $message .= '<strong>Registration number:</strong> '.$nr. '<br />';
            }
            $email = '';
            foreach($form['input'] as $input){
                if($input['type'] == 9){
                    $email = $_POST[TF_THEME_PREFIX.'_'.$input['shortcode']];
                    break;
                }
            }
            $form['email_subject'] = urlencode(str_replace('[resnumber]',$nr,urldecode($form['email_subject'])));
            $mail_type=($gen_sett['mail_type'])?'send'.ucwords($gen_sett['mail_type']):'sendWpmail';
            $this->$mail_type($gen_sett,$message,$email,$form);
            $form['email_subject'] = 'New Reservation';
            $email = urldecode($form['email_from']);
            $this->$mail_type($gen_sett,$this->new_reservation_admin_email_content($form,$post_content),$email,$form);
            wp_set_post_terms($status,$form_id, 'reservations', false);
            echo json_encode(array('mess'=>__(urldecode($form['succes_mess']),'tfuse'),'error' => false));
        } else echo json_encode(array('mess'=>__(urldecode($form['fail_mess']),'tfuse'),'error' => true));
        die;
    }
    function new_reservation_admin_email_content($form,$post_content){
        $content ='There is a new reservation on '.get_bloginfo('name');
        if(isset($form['admin_email_template']) && $form['admin_email_template'] != '')
        {
            $content = urldecode($form['admin_email_template']);
            foreach($post_content as $key=>$value){
                $content = str_replace('['.str_replace(TF_THEME_PREFIX.'_','',$key).']',$value,$content);
                   }
        }
        else
        foreach($form['input'] as $input){
                        if(isset($post_content[TF_THEME_PREFIX.'_'.$input["shortcode"]]))
                        $content .= '<strong>' . __($input['label'],'tfuse') . ':</strong> '. $post_content[TF_THEME_PREFIX.'_'.$input["shortcode"]] . '<br />';
    }
        return urldecode($content);
    }
    function delete_form()
    {
        $formId = $_POST['formid'];
        if (is_array($formId)) {
            foreach ($formId as $id) $this->delete_form_term($id);
        } else {
            $this->delete_form_term($formId);
        }
    }
    function delete_form_term($term_id){
        global $wpdb;
        global $table_prefix;
        $tax = 'reservations';
        $term = get_term_by('id',$term_id,$tax);
        $query = "Select * From ".$table_prefix.'posts'." AS p LEFT JOIN ".$table_prefix.'term_relationships'." AS tr ON p.ID = tr.object_id WHERE tr.term_taxonomy_id = %d";
        $term_posts = $wpdb->get_results(
            $wpdb->prepare(
                $query,$term->term_id
            )
        );
        $form = unserialize($term->description);
        foreach($term_posts as $post){
            $content = unserialize($post->post_content);
            $content['form'] = $form;
            $post->post_content = serialize($content);
            wp_update_post($post);
        }
        wp_delete_term($term_id, 'reservations');
    }
    function save_form()
    {
        if (!wp_verify_nonce($_POST['resform_setup_nonce'], 'resform_setup_nonce_action')) {
            echo "Your nonce did not pass verification";
            return;
        }
        $form_to_save = array();
        $form_to_save['form_name'] = urlencode($_POST['tf_rf_formname_input']);
        foreach ($_POST['tf_rf_input'] as $key => $value) {
            $form_to_save['input'][$key]['label'] = urlencode($value);
        }
        foreach ($_POST['tf_rf_input_options_label'] as $key => $value) {
            if ($_POST['tf_rf_select'][$key] == 2 || $_POST['tf_rf_select'][$key] == 4) {
                $form_to_save['input'][$key]['options'] = $value;
            }
        }
        foreach ($_POST['tf_rf_input_shortcode'] as $key => $value) {
            $form_to_save['input'][$key]['shortcode'] = urlencode($value);
        }
        foreach ($_POST['tf_rf_select'] as $key => $value) {
            $form_to_save['input'][$key]['type'] = $value;
            if (@tfuse_parse_boolean($_POST['tf_rf_input_newline_' . $key]) && tfuse_parse_boolean($_POST['tf_rf_input_newline_' . $key])) {
                $form_to_save['input'][$key]['newline'] = 1;
            }
            if (@tfuse_parse_boolean($_POST['tf_rf_input_required_' . $key])  && tfuse_parse_boolean($_POST['tf_rf_input_required_' . $key])) {
                $form_to_save['input'][$key]['required'] = 1;
            }
        }
        if(isset($_POST['tf_rf_exclude_date']))
        foreach ($_POST['tf_rf_exclude_date'] as $value) {
            $form_to_save['exclude_dates'][] = urlencode($value);
        }
        foreach ($_POST['tf_rf_input_width'] as $key => $value) {
            $form_to_save['input'][$key]['width'] = urlencode($value);
        }
        $form_to_save['submit_mess'] = (trim($_POST['tf_rf_mess_submit']) == '') ? 'Submit' : urlencode($_POST['tf_rf_mess_submit']);
        $form_to_save['succes_mess'] = urlencode($_POST['tf_rf_succ_mess']);
        $form_to_save['fail_mess'] = urlencode($_POST['tf_rf_failure_mess']);
        $form_to_save['tf_rf_form_notice'] = urlencode($_POST['tf_rf_form_notice']);
        $form_to_save['confirm_email_template'] = urlencode($_POST['tf_rf_confirm_email_template']);
        $form_to_save['reject_email_template'] = urlencode($_POST['tf_rf_reject_email_template']);
        $form_to_save['header_message'] = urlencode($_POST['tf_rf_heading_text']);
        $form_to_save['email_from'] = urlencode($_POST['tf_rf_email_from']);
        if(isset($_POST['tf_rf_mess_reset']))
            $form_to_save['reset_button'] = urlencode($_POST['tf_rf_mess_reset']);
        if(isset($_POST['tf_rf_new_res_admin_email_template']))
            $form_to_save['admin_email_template'] = urlencode($_POST['tf_rf_new_res_admin_email_template']);
        $form_to_save['new_res_email_template'] = urlencode($_POST['tf_rf_new_res_email_template']);
        $form_to_save['reservation_title'] = urlencode($_POST['tf_rf_res_title']);
        $form_to_save['datepickers_count'] = urlencode($_POST['tf_rf_datepickers_count']);
        $form_to_save['form_template'] = urlencode($_POST['tf_rf_form_template']);
        $form_to_save['email_subject'] = urlencode($_POST['tf_rf_email_subject']);
        $form_to_save['required_text'] = urlencode($_POST['tf_rf_required_text']);

        if (isset($_GET['id'])) {
            wp_update_term($_GET['id'], 'reservations', array('description' => serialize($form_to_save)));
        } else {
            $new_term = wp_insert_term($_POST['tf_rf_formname_input'], 'reservations', array('description' => serialize($form_to_save)));
            $pageURL = 'http';
            if (!empty($_SERVER['HTTPS'])) {
                if ($_SERVER['HTTPS'] == 'on')
                    $pageURL .= "s";
            }
            $pageURL .= "://";
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] . "&id=" . $new_term['term_id'];
            header('Location:' . $pageURL);
        }

    }

    function prepare_ajax_data($form_data)
    {
        $form_to_save = array();
        foreach ($form_data['types'] as $key => $type) {
            $form_to_save['input'][$key]['type'] = $type;
        }
        unset($form_data['types']);
        foreach ($form_data['shortcode'] as $key => $shortcode) {
            $form_to_save['input'][$key]['shortcode'] = $shortcode;
        }
        unset($form_data['shortcode']);
        foreach ($form_data['labels'] as $key => $label) {
            $form_to_save['input'][$key]['label'] = $label;
        }
        unset($form_data['labels']);
        foreach ($form_data['width'] as $key => $width) {
            $form_to_save['input'][$key]['width'] = $width;
        }
        unset($form_data['width']);
        foreach ($form_data['required'] as $key => $req) {
            if ($req == 1) {
                $form_to_save['input'][$key]['required'] = 1;
            }
        }
        unset($form_data['required']);
        foreach ($form_data['newline'] as $key => $newl) {
            if ($newl == 1) {
                $form_to_save['input'][$key]['newline'] = 1;
            }
        }
        unset($form_data['newline']);
        if(isset($form_data['excludeDate'] )){
        foreach ($form_data['excludeDate'] as $key => $exclude_date) {
            $form_to_save['exclude_dates'][$key] = $exclude_date;
        }
        unset($form_data['excludeDate']);
        }
        if (isset($form_data['options'])) {
            foreach ($form_data['options'] as $key => $options) {
                $form_to_save['input'][$key]['options'] = $options;
            }
            unset($form_data['options']);
        }
        $form_to_save = array_merge($form_to_save, $form_data);
        return $form_to_save;
    }

    function ajax_save_form()
    {
        $form_data = $_POST['post_data'];
        foreach ($form_data as $form_key => $form) {
            if (is_array($form)) {
                foreach ($form as $input_key => $input) {
                    if (is_array($input)) {
                        foreach ($input as $k => $v) {
                            $form_data[$form_key][$input_key][$k] = urlencode($v);
                        }
                    } else {
                        $form_data[$form_key][$input_key] = urlencode($input);
                    }
                }
            } else {
                $form_data[$form_key] = urlencode($form);
            }
        }
        $this->ajax->_verify_nonce('tf_reservationform_save');
        $form_id = $_POST['get_id'];
        $form_to_save = $this->prepare_ajax_data($form_data);
        wp_update_term($form_id, 'reservations', array('description' => serialize($form_to_save), 'name' => $form_to_save['form_name']));
        echo json_encode(array('saved' => 1));
        die();
    }

    function form_preview()
    {
        require_once(TFUSE_CONFIG_SHORTCODES . '/shortcodes/reservationform.php');
        $_formArray = $this->prepare_ajax_data($_POST['tf_form_']);
        $_COOKIE['res_form_array'] = serialize($_formArray);
        echo do_shortcode('[tfuse_reservationform]');
        die();
    }

    function save_general_options()
    {
        if (wp_verify_nonce($_POST['res_form_gensett_nonce'], 'res_form_gensett_nonce_action')) {
            $gen_options = array('mail_type' => $_POST['tf_rf_mail_type'], 'smtp_host' => $_POST['tf_rf_smtp_host'], 'smtp_user' => $_POST['tf_rf_smtp_user'], 'smtp_pwd' => $_POST['tf_rf_smtp_pwd'], 'smtp_port' => $_POST['tf_rf_smtp_port'], 'secure_conn' => $_POST['tf_rf_secure_conn']);
            $this->model->save_form_gen_options($gen_options);
        } else {
            echo "Your nonce did not pass verification";
        }
    }

    function sendSmtp($general_options,$message,$email,$form)
    {
        require_once ABSPATH.WPINC . '/class-phpmailer.php';
        $from = str_replace(array('[',']'),'',urldecode($form['email_from']));
        if(isset($_POST[TF_THEME_PREFIX.'_'.$from]) && filter_var($_POST[TF_THEME_PREFIX.'_'.$from],FILTER_VALIDATE_EMAIL))
            $form['email_from'] = $_POST[TF_THEME_PREFIX.'_'.$from];
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->IsHTML(true);
        $mail->Port = $general_options['smtp_port'];
        $mail->Host = $general_options['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 2;
        $mail->SMTPSecure = ($general_options['secure_conn'] != 'no') ? $general_options['secure_conn'] : null;
        $mail->Username = $general_options['smtp_user'];
        $mail->Password = $general_options['smtp_pwd'];
        $mail->From = $form['email_from'];
        $mail->FromName = $form['email_from'];
        $mail->Subject = $form['email_subject'];
        $mail->AddAddress($email);
        $mail->CharSet="UTF-8";
        $mail->Body = $message;
        if (!$mail->send()) {
            return array('mail'=>$email,'error' => true);
        } else {
            return array('mail'=>$email,'error' => false);
        }
        $mail->ClearAddresses();
        $mail->ClearAllRecipients();

    }

    function sendWpmail($general_options,$message,$email,$form)
    {
        $from = str_replace(array('[',']'),'',urldecode($form['email_from']));
        if(isset($_POST[TF_THEME_PREFIX.'_'.$from]) && filter_var($_POST[TF_THEME_PREFIX.'_'.$from],FILTER_VALIDATE_EMAIL))
            $form['email_from'] = $_POST[TF_THEME_PREFIX.'_'.$from];
        $headers = "From:" .urldecode($form['email_from']) . "><" . urldecode($form['email_from']) . ">";
        add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
        if (wp_mail($email, urldecode($form['email_subject']), $message, $headers))
            return array('mail'=>$email, 'error' => false);
        else
            return array('mail'=>$email, 'error' => true);
    }

    function custom_admin_box_content($post, $args)
    {
        echo apply_filters("{$args['id']}_custom_admin_box_content", $args['args'], $post, $args);

    }

    function create_form_meta_box($options, $accepted_tab_ids = array())
    {
        $admin_meta_boxes = &$options;
        $tabs_header = '<ul>';
        foreach ($admin_meta_boxes['tabs'] as $tab) {
            if (count($accepted_tab_ids) > 0 && !in_array($tab['id'], $accepted_tab_ids)) continue;
            $tabs_header .= '<li id="tfusetabheader-' . $tab['id'] . '"><a href="#tfusetab-' . $tab['id'] . '">' . $tab['name'] . '</a></li>';
        }
        $tabs_header .= '</ul>';

        foreach ($admin_meta_boxes as $tab => $box) {
            if ($tab == 'tabs') continue;
            foreach ($box as $heading => $rows) {
                if ($heading == "buttons") continue;
                $boxid = sanitize_title($heading);
                add_meta_box($boxid, $heading, array(&$this, 'custom_admin_box_content'), $tab, 'normal', 'core', $rows);
            }
        }
        echo '<div class="tf_meta_tabs">';
        echo $tabs_header;
        foreach ($admin_meta_boxes['tabs'] as $tab) {
            if (count($accepted_tab_ids) > 0 && !in_array($tab['id'], $accepted_tab_ids)) continue;
            echo '<div id="tfusetab-' . $tab['id'] . '">';
            do_meta_boxes($tab['id'], 'normal', null);
            if (isset($admin_meta_boxes[$tab['id']]['buttons']))
                echo $admin_meta_boxes[$tab['id']]['buttons'];
            echo '</div>';
        }
        echo'</div>';
    }
    function urldecode_array(&$value,$key){
        $value = urldecode($value);
    }
    function get_form_options()
    {
        $id = (isset($_GET['id'])) ? $_GET['id'] : false;
        $form = get_term_by('id', $id, 'reservations');
        if ($id) {
            $form->description = unserialize($form->description);
        }
        $admin_meta_boxes = array();
        $add_button = array('name' => '', 'desc' => '', 'id' => 'tf_rf_add_new', 'value' => 'Add new field', 'type' => 'button', 'subtype' => 'button', 'properties' => array('class' => 'button rf_add_new'));
        $prev_button = array('name' => '', 'desc' => '', 'id' => 'tf_rf_prev_button', 'value' => 'Preview', 'type' => 'button', 'subtype' => 'button', 'properties' => array('class' => 'reset-button rf_form_preview button'));
        $options = $this->get->ext_options($this->_the_class_name, strtolower($this->_the_class_name));
        $options = apply_filters('res_form_options_array',$options);
        foreach ($options['tabs'] as $tab) {
            if ($tab['id'] == 'tf_rf_general_settings') continue;
            $admin_meta_boxes['tabs'][] = $tab;
            $headings = $tab['headings'];
            unset($tab['headings']);
            foreach ($headings as $heading) {
                $admin_meta_boxes[$tab['id']][$heading['name']] = '';
                if ($heading['id'] == 'form_settings') {
                    $form_labels = $this->getFormLabels();
                }
                if ($id !== false) {
                    if ($heading['id'] != 'message_settings' && $heading['id'] != 'form_name' && $tab['id'] != 'tf_rf_dates_settings') {
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->cf_row_template($form_labels) . '<div class="tfclear divider" style="margin-bottom:0 !important;"></div>';
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= '<ul class="ui-sortable" id="rf_form_elements">';
                    }
                    if ($heading['id'] == 'tf_rf_dates_toexclude') {
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= '<ul class="ui-sortable" id="rf_excludedates_elements">';
                    }
                    if (!empty($form->description['exclude_dates']))
                        foreach ($form->description['exclude_dates'] as $exclude_date) {
                            if ($tab['id'] == 'tf_rf_messages_settings' || $tab['id'] == 'add_edit_forms') continue;
                            foreach ($heading['options'] as $key => $option) {
                                if(!is_array($option)) continue;
                                if ($option['id'] == 'tf_rf_exclude_date[]') {
                                    $heading['options'][$key]['value'] = urldecode($exclude_date);
                                }
                            }
                            $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->cf_row_template($heading['options']);
                        }
                    foreach ($form->description['input'] as $key => $input) {
                        if ($tab['id'] == 'tf_rf_messages_settings' || $heading['id'] == 'form_name' || $tab['id'] == 'tf_rf_dates_settings') continue;
                        if(in_array($input['type'],array(7,8))){
                            $values = array('label'=>urldecode($input['label']),'width'=>urldecode($input['width']),'newline'=>(isset($input['newline']) && $input['newline']) ? 'true' : 'false');
                            $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->cf_row_template($this->date_in_out($input['type'],$values,$key));
                            continue;
                        }
                        if($input['type'] == 9){
                            $values = array('label'=>urldecode($input['label']),'width'=>urldecode($input['width']),'newline'=>(isset($input['newline']) && $input['newline']) ? 'true' : 'false');
                            $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->cf_row_template($this->default_email($values,$key));
                            continue;
                        }
                        $row = array();
                        $row['type'] = $heading['options']['type'];
                        foreach ($heading['options'] as $option) {
                            if(!is_array($option)) continue;
                            if ($option['id'] == 'tf_rf_input[]') {
                                $option['value'] = str_replace('_', ' ', urldecode($input['label']));
                            } elseif ($option['id'] == 'tf_rf_select[]') {

                                $option['value'] = urldecode($input['type']);
                            } elseif ($option['id'] == 'tf_rf_input_width[]') {
                                $option['value'] = urldecode($input['width']);
                            } elseif ($option['id'] == 'tf_rf_input_required') {
                                if ($input['type'] == 2 || $input['type'] == 3 || $input['type'] == 4) {
                                    $option['properties']['class'] .= ' invisible';
                                }
                                $option['id'] .= '_' . $key;
                                $option['value'] = (isset($input['required']) && $input['required']) ? 'true' : 'false';
                            } elseif ($option['id'] == 'tf_rf_input_newline') {
                                $option['id'] .= '_' . $key;
                                $option['value'] = (isset($input['newline']) && $input['newline']) ? 'true' : 'false';
                            } elseif ($option['id'] == 'tf_rf_toggle_show') {
                                if ($input['type'] != 2 && $input['type'] != 4) {
                                    $option['id'] .= ' hidden';
                                }
                            } elseif ($option['id'] == 'tf_rf_shortcode_row') {
                                $option['value'] = str_replace('%%code%%', '[' . $input['shortcode'] . ']', $option['value']);
                            }

                            if (sizeof($form->description['input']) == 1) {
                                if ($option['type'] == 'delete_row') $option['class'] = 'tf_rf_delete_row_last';
                            }
                            $row[] = $option;
                        }
                        if (isset($input['options']) && $input['options']) {
                            $opt = array();
                            $i = 0;
                            foreach ($input['options'] as $value) {
                                foreach ($heading['options_row'] as $opt_row) {

                                    if ($opt_row['id'] == 'tf_rf_input_options_label') {
                                        $opt_row['value'] = str_replace('%%value%%', urldecode($value), $opt_row['value']);
                                    }
                                    $opt_row['id'] .= '[' . $key . "][]";
                                    $opt[$i][] = $opt_row;
                                }
                                $i++;
                            }
                        } else {
                            foreach ($heading['options_row'] as $opt_row) {
                                $opt_row['id'] .= '[' . $key . '][]';
                                $opt_row['value'] = str_replace('%%value%%', '', $opt_row['value']);
                                $opt[0][] = $opt_row;
                            }
                        }
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->cf_row_template($row, $opt);
                        unset($row);
                        unset($opt);
                    }
                    if ($heading['id'] == 'form_settings') {
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= '</ul>';
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->optigen->$add_button['type']($add_button);
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->optigen->$prev_button['type']($prev_button);
                    }
                    elseif ($heading['id'] == 'tf_rf_dates_toexclude') {
                        $dates_button = $add_button;
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= '</ul>';
                        $dates_button['id'] = 'rf_exclude_new_interval';
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->optigen->$add_button['type']($dates_button);
                    }
                    foreach ($heading['options'] as $option) {
                        if ($heading['id'] == 'form_settings' || $tab['id'] == 'tf_rf_dates_settings' || !is_array($option)) continue;
                        if ($option['id'] == 'tf_rf_mess_submit') {
                            $option['value'] = urldecode($form->description['submit_mess']);
                        }
                        if ($option['id'] == 'tf_rf_shortcode') {
                            $option['value'] = str_replace('%%form_id%%', $id, $option['value']);
                        }
                        if ($option['id'] == 'tf_rf_formname_input') {
                            $option['value'] = urldecode($form->name);
                        }
                        if ($option['id'] == 'tf_rf_heading_text' && isset($form->description['header_message'])) {
                            $option['value'] = urldecode($form->description['header_message']);
                        }
                        if ($option['id'] == 'tf_rf_res_title') {
                            $option['value'] = urldecode($form->description['reservation_title']);
                        }
                        if ($option['id'] == 'tf_rf_datepickers_count') {
                            $option['value'] = urldecode($form->description['datepickers_count']);
                        }
                        if ($option['id'] == 'tf_rf_new_res_email_template' && isset($form->description['new_res_email_template'])) {
                            $option['value'] = urldecode($form->description['new_res_email_template']);
                        }
                        if($option['id'] == 'tf_rf_mess_reset' && isset($form->description['reset_button'])) {
                            $option['value'] = urldecode($form->description['reset_button']);
                        }
                        if($option['id'] == 'tf_rf_form_notice' && isset($form->description['tf_rf_form_notice'])) {
                            $option['value'] = urldecode($form->description['tf_rf_form_notice']);
                        }
                        if($option['id'] == 'tf_rf_new_res_admin_email_template' && isset($form->description['admin_email_template'])) {
                            $option['value'] = urldecode($form->description['admin_email_template']);
                        }
                        if ($option['id'] == 'tf_rf_form_template') {
                            $option['value'] = urldecode($form->description['form_template']);
                        }
                        if ($option['id'] == 'tf_rf_email_template') {
                            $option['value'] = urldecode($form->description['email_template']);
                        }
                        if ($option['id'] == 'tf_rf_succ_mess') {
                            $option['value'] = urldecode($form->description['succes_mess']);
                        }
                        if ($option['id'] == 'tf_rf_reject_email_template') {
                            $option['value'] = urldecode($form->description['reject_email_template']);
                        }
                        if ($option['id'] == 'tf_rf_confirm_email_template') {
                            $option['value'] = urldecode($form->description['confirm_email_template']);
                        }
                        if ($option['id'] == 'tf_rf_succ_mess') {
                            $option['value'] = urldecode($form->description['succes_mess']);
                        }
                        if ($option['id'] == 'tf_rf_required_text') {
                            $option['value'] = urldecode($form->description['required_text']);
                        }
                        if ($option['id'] == 'tf_rf_failure_mess') {
                            $option['value'] = urldecode($form->description['fail_mess']);
                        }
                        if ($option['id'] == 'tf_rf_email_from') {
                            $option['value'] = urldecode($form->description['email_from']);
                        }
                        if ($option['id'] == 'tf_rf_email_to') {
                            $option['value'] = urldecode($form->description['email_to']);
                        }
                        if ($option['id'] == 'tf_rf_email_subject') {
                            $option['value'] = urldecode($form->description['email_subject']);
                        }
                        if ($option['id'] == 'tf_rf_email_subject') {
                            $option['value'] = urldecode($form->description['email_subject']);
                        }
                        if ($option['id'] == 'tf_rf_exclude_date[]') {
                            $option['value'] = urldecode($form->description['dates_to_exclude']);
                        }
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->meta_box_row_template($option);

                    }
                } else {
                    if ($heading['id'] == 'form_settings') {
                        foreach ($heading['options'] as $key => $option) {
                            if(!is_array($option)) continue;
                            if ($option['id'] == 'tf_rf_input_required') {
                                $heading['options'][$key]['id'] .= '_0';
                            }
                            if ($option['id'] == 'tf_rf_input_newline') {
                                $heading['options'][$key]['id'] .= '_0';
                            }
                            if ($option['id'] == 'tf_rf_input_options[]') {
                                $heading['options'][$key]['value'] = '';
                                $heading['options'][$key]['properties']['class'] = str_replace('%%visible%%', 'hidden', $heading['options'][$key]['properties']['class']);
                            }
                            if ($option['id'] == 'tf_rf_toggle_show') {
                                $heading['options'][$key]['id'] .= ' hidden';
                            }
                            if ($option['id'] == 'tf_rf_shortcode_row') {
                                $heading['options'][$key]['value'] = str_replace('%%code%%', '[]', $option['value']);
                            }
                        }
                        foreach ($heading['options_row'] as $opt_row) {
                            $opt_row['id'] .= '[0][]';
                            $opt_row['value'] = str_replace('%%value%%', '', $opt_row['value']);
                            $opt[0][] = $opt_row;
                        }
                        $values = array('label'=>'Check In','width'=>'50','newline'=>false);
                        $email_values = array('label'=>'Your Email','width'=>'50','newline'=>false);
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->cf_row_template($form_labels) . '<div class="tfclear divider" style="margin-bottom:0 !important;"></div>';
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= '<ul class="ui-sortable" id="rf_form_elements">';
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->cf_row_template($heading['options'], $opt);
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->cf_row_template($this->date_in_out(7,$values,1));
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->cf_row_template($this->default_email($email_values,2));
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= '</ul>';
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->optigen->$add_button['type']($add_button);
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->optigen->$add_button['type']($prev_button);
                    }
                    elseif ($heading['id'] == 'tf_rf_dates_toexclude') {
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= '<ul class="ui-sortable" id="rf_excludedates_elements">';
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->cf_row_template($heading['options']);
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= '</ul>';
                        $add_button['id'] = 'rf_exclude_new_interval';
                        $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->optigen->$add_button['type']($add_button);
                    }
                    else {
                        foreach ($heading['options'] as $option) {
                            if(!is_array($option)) continue;
                            if ($option['id'] == 'tf_rf_shortcode') {

                                $option['value'] = str_replace('%%form_id%%', 0, $option['value']);
                            }
                            $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->meta_box_row_template($option);
                        }
                    }
                }
            }
            $admin_meta_boxes[$tab['id']]['buttons'] = '';
            if (!empty($tab['buttons'])) {
                foreach ($tab['buttons'] as $button) {
                    if ($button['id'] == 'rf_save_form_button') {
                        if (!isset($_GET['id'])) {
                            $button['value'] = 'Create form';
                        }
                    }
                    $admin_meta_boxes[$tab['id']]['buttons'] .= $this->optigen->$button['type']($button);
                }
            }
        }
        return $admin_meta_boxes;
    }

    function get_form_gen_options()
    {
        $admin_meta_boxes = array();
        $gen_options = $this->model->get_forms_gen_options();
        $options = $this->get->ext_options($this->_the_class_name, strtolower($this->_the_class_name));
        $is_smtp = ($gen_options['mail_type'] == 'smtp') ? true : false;
        foreach ($options['tabs'] as $tab) {
            if ($tab['id'] == 'add_edit_forms' || $tab['id'] == 'tf_rf_messages_settings' || $tab['id'] == 'tf_rf_dates_settings') continue;
            foreach ($tab['headings'] as $heading) {
                $admin_meta_boxes[$tab['id']][$heading['name']] = '';
                foreach ($heading['options'] as $option) {
                    if ($gen_options) {
                        if ($option['id'] == 'tf_rf_mail_type') {
                            $option['value'] = $gen_options['mail_type'];
                        }
                        if ($option['id'] == 'tf_rf_secure_conn') {
                            $option['value'] = $gen_options['secure_conn'];
                        }
                        if ($option['id'] == 'tf_rf_smtp_host') {
                            $option['value'] = $gen_options['smtp_host'];
                        }
                        if ($option['id'] == 'tf_rf_smtp_port') {
                            $option['value'] = $gen_options['smtp_port'];
                        }
                        if ($option['id'] == 'tf_rf_smtp_user') {
                            $option['value'] = $gen_options['smtp_user'];
                        }
                        if ($option['id'] == 'tf_rf_smtp_pwd') {
                            $option['value'] = $gen_options['smtp_pwd'];
                        }
                    }
                    if (!$is_smtp && $option['id'] != 'tf_rf_mail_type') {
                        if (isset($option['properties']['class'])) {
                            $option['properties']['class'] .= ' hidden';
                        } else {
                            $option['properties']['class'] = ' hidden';
                        }
                    }
                    $admin_meta_boxes[$tab['id']][$heading['name']] .= $this->interface->meta_box_row_template($option);
                }
            }
            $admin_meta_boxes['tabs'][] = $tab;
            $admin_meta_boxes[$tab['id']]['buttons'] = '';
            foreach ($tab['buttons'] as $button) {
                $admin_meta_boxes[$tab['id']]['buttons'] .= $this->optigen->$button['type']($button);
            }
        }
        return $admin_meta_boxes;
    }

    function getFormLabels()
    {
        $inputs = $this->get->ext_config($this->_the_class_name, 'base');
        return $inputs['labels'];

    }
    function date_in_out($field,$values,$nr_in_form){
        $datepickers_ids = array(7 => 'in', 8 => 'out');
        $datepickers_types = array(7 => 'Check In', 8 => 'Check Out');
        $datepickers =  array(
            array('name' => 'Input type',
                  'desc' => '',
                  'id' => 'tf_rf_select[]',
                  'value' => '',
                  'type' => 'select',
                  'value' => '',
                  'properties' => array(
                      'class'=>TF_THEME_PREFIX.'_inp_select medica_inp_select'
                  ),
                  'options' => array(
                      $field => $datepickers_types[$field]
                  )
            ),
            array('name' => 'Label',
                  'desc' => 'Input label',
                  'id' => 'tf_rf_input[]',
                  'value' => $values['label'],
                  'properties' => array(
                      'class' => 'rf_input_label'
                  ),
                  'type' => 'text'),
            array('name' => 'Width',
                  'desc' => 'fields width',
                  'type' => 'text',
                  'id' => 'tf_rf_input_width[]',
                  'value' => $values['width'],
                  'properties' => array(
                      'class' => 'rf_input_width'
                  ),
                  'divider' => true),
            array('name' => 'Required',
                  'desc' => 'is this field required?',
                  'type' => 'raw',
                  'id' => 'tf_rf_input_required_'.$nr_in_form,
                  'html' => '<div id="datepicker_inputs_required" class="rf_input_required">Yes</div>',
                  'properties' => array(
                      'class' => 'rf_input_required',
                  ),
                  'divider' => true
            ),
            array(
                'name' => 'New Line',
                'desc' => '',
                'type' => 'checkbox',
                'id' => 'tf_rf_input_newline_'.$nr_in_form,
                'value' => $values['newline'],
                'properties' => array(
                    'class' => 'rf_input_newline'
                ),
                'divider' => true
            ),
            array('name'=>'',
                  'desc'=>'',
                  'id'=>'tf_cf_shortcode_row',
                  'type'=>'selectable_code',
                  'value'=>'%%code%%',
                  'properties'=>array(
                      'class'=> 'shortcode_code',
                  ),
                  'divider'=>true,
            ),
            array('name' => '',
                  'desc' => '',
                  'id' => 'tf_rf_is_datepicker[]',
                  'type' => 'text',
                  'value' => $datepickers_ids[$field],
                  'divider' => true,
                  'properties' => array(
                      'class'=> 'tfuse_is_datepicker_flag'
                  )
            ),
            'type'=>'custom_reservationform_row'
        );
        return apply_filters('datepickers_res_form',$datepickers);
    }
    function default_email($values,$key){
        return array(
            array('name' => 'Input type',
                  'desc' => '',
                  'id' => 'tf_rf_select[]',
                  'value' => '',
                  'type' => 'select',
                  'value' => '',
                  'properties' => array(
                      'class'=>TF_THEME_PREFIX.'_inp_select medica_inp_select'
                  ),
                  'options' => array(
                      9 => 'Email'
                  )
            ),
            array('name' => 'Label',
                  'desc' => 'Input label',
                  'id' => 'tf_rf_input[]',
                  'value' => $values['label'],
                  'properties' => array(
                      'class' => 'rf_input_label'
                  ),
                  'type' => 'text'),
            array('name' => 'Width',
                  'desc' => 'fields width',
                  'type' => 'text',
                  'id' => 'tf_rf_input_width[]',
                  'value' => $values['width'],
                  'properties' => array(
                      'class' => 'rf_input_width'
                  ),
                  'divider' => true),
            array('name' => 'Required',
                  'desc' => 'is this field required?',
                  'type' => 'raw',
                  'id' => 'tf_rf_input_required_'.$key,
                  'html' => '<div id="datepicker_inputs_required" class="rf_input_required">Yes</div>',
                  'properties' => array(
                      'class' => 'rf_input_required',
                  ),
                  'divider' => true
            ),
            array(
                'name' => 'New Line',
                'desc' => '',
                'type' => 'checkbox',
                'id' => 'tf_rf_input_newline_'.$key,
                'value' => $values['newline'],
                'properties' => array(
                    'class' => 'rf_input_newline'
                ),
                'divider' => true
            ),
            array('name'=>'',
                  'desc'=>'',
                  'id'=>'tf_cf_shortcode_row',
                  'type'=>'selectable_code',
                  'value'=>'%%code%%',
                  'properties'=>array(
                      'class'=> 'shortcode_code',
                  ),
                  'divider'=>true,
            ),
            array('name' => '',
                  'desc' => '',
                  'id' => 'tf_rf_is_datepicker[]',
                  'type' => 'text',
                  'value' => 'email',
                  'divider' => true,
                  'properties' => array(
                      'class'=> 'tfuse_is_datepicker_flag'
                  )
            ),
            'type'=>'custom_reservationform_row'
        );
    }
    function redirect_if_id_invalid($_id)
    {
        if (is_null(get_term($_id, 'reservations')))
            wp_redirect(get_admin_url() . 'admin.php?page=tf_reservation_forms_list');
    }
    function redirect_if_reservation_id_invalid($_id)
    {
        if (is_null(get_post($_id)))
            wp_redirect(get_admin_url() . 'admin.php?page=tf_reservations_list');
    }
}
