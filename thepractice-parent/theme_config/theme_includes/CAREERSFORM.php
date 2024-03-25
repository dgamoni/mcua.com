<?php
/**
 * Contact form
 *
 * To override this function in a child theme, copy this file to your child theme's
 * /theme_config/theme_includes/ folder.
 *
 * /theme_config/theme_includes/CAREERSFORM.php
 *
 * @version 2.0
 */

// don't load from wordpress, load directly with ajax
if ( defined('ABSPATH') )
    return;

// include wordpress functionality
require('../../../../../wp-config.php');
$wp->init();
$wp->parse_request();
$wp->query_posts();
$wp->register_globals();


// -------------- START EDITING FROM HERE --------------

if ( !empty($_POST['email']) )
{
    $errorC = false;

    $the_blogname       = esc_attr(get_bloginfo('name'));
    $the_myemail 	= esc_attr(get_bloginfo('admin_email'));
    $the_email 		= esc_attr($_POST['email']);
    $the_name           = esc_attr($_POST['yourname']);
    $the_message 	= esc_attr($_POST['message']);
    if (isset($_POST['subject']))$the_subject        = esc_attr($_POST['subject']);
    //$the_category       = esc_attr($_POST['contact_select_2']);

    # want to add aditional fields? just add them to the form in content-contact-form.php,
    # you dont have to edit this file

    //added fields that are not set explicit like the once above are combined and added before the actual message
    $already_used = array('email','yourname','message','subject','contact_select_2','ajax');
    $attach = '';

    foreach ($_POST as $key => $field)
    {
        if(!in_array($key,$already_used))
            $attach .= $key . ': ' . $field . '<br />' . PHP_EOL;
    }
    $attach .= '<br />' . PHP_EOL;

    if( !is_email($the_email) )
        $errorC = true;


    if($errorC == false)
    {
        $to      =  $the_myemail;
        $subject = __('New Message from ','tfuse') . $the_blogname;
        $header  = 'MIME-Version: 1.0' . PHP_EOL;
        $header .= 'Content-type: text/html; charset=utf-8' . PHP_EOL;
        $header .= __('From ','tfuse'). $the_email  . PHP_EOL;

        $message1 = nl2br($the_message);

        if(!empty($the_email)) 	$the_email 	= __('Email: ','tfuse').$the_email .'<br />';
        if(!empty($the_name)) 	$the_name 	= __('Name ','tfuse'). $the_name .'<br />';
        if(!empty($the_subject)) $the_subject 	= __('Subject: ','tfuse'). $the_subject .'<br />';
        if(!empty($the_category)) $the_category = __('Category: ','tfuse'). $the_category .'<br />';

        $message = __('You have a new message!','tfuse').' <br />'.
        $the_email.
        $the_name.
        $attach.
        __('Message: ','tfuse').$message1 .'<br />';

        if ( mail($to,$subject,$message,$header) ) $send = true; else $send = false;

        if ( isset($_POST['ajax']) && $send )
            echo 'true';
    }
}
?>