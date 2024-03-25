<?php
/**
 * The template for displaying content in the template-contact.php template.
 * To override this template in a child theme, copy this file 
 * to your child theme's folder.
 *
 * @since The Practice 1.0
 */
?>

<?php
    wp_enqueue_script( 'contactform', tfuse_get_file_uri('js/contactform.js'), array('jquery'), '2.0', true );

    $params = array( 'contactform_uri' => tfuse_get_file_uri('theme_config/theme_includes/CONTACTFORM.php') );

    wp_localize_script( 'contactform', 'ContactFormParams', $params );

    add_action( 'wp_footer', create_function( '', 'wp_print_scripts( "contactform" );' ) );
?>

<!-- contact form -->
 <div class="add-comment" id="addcomments">

     <div class="comment-form">
         <form action= "" method="post" id="contactForm" class="ajax_form" name="contactForm">

         <div class="row alignleft infieldlabel">
             <label for="yourname"><?php _e('Enter your name and surname','tfuse'); ?>*</label>
             <input type="text" name="yourname" id="yourname" value="" class="inputtext input_middle required " />
         </div>

         <div class="space"></div>

         <div class="row alignleft infieldlabel">
             <label for="email"><?php _e('Enter your email address','tfuse'); ?>*</label>
             <input type="text" name="email" id="email" value="" class="inputtext input_middle required" />
         </div>

         <div class="clear"></div>

             <div class="row infieldlabel">
                 <label for="message"><?php _e('Enter your message'); ?>*</label>
                 <textarea cols="30" rows="10" name="message" id="message" class="textarea textarea_middle required"><?php  if (isset($the_message)) echo $the_message ?></textarea>
             </div>

             <div class="row rowSubmit">
                 <input type="submit" value="<?php _e('SEND YOUR MESSAGE','tfuse'); ?>"  id="send" class="btn-submit" />
                 <a onclick="document.getElementById('contactForm').reset();return false" href="#" class="link-reset"><?php _e('reset all fields', 'tfuse') ?></a>
             </div>
         </form>
     </div>
 </div>

        <div style="display: none;" id="reservation_send_ok">
            <div class="notice">
                <h3><?php _e('Your message has been sent!', 'tfuse') ?></h3>
                <?php _e('Thank you for contacting us,', 'tfuse') ?><br /><?php _e('We will get back to you within 2 business days.', 'tfuse') ?>
            </div>
        </div>
        <div style="display: none;" id="reservation_send_failure">
            <div class="notice">
                <h3><?php _e('Oops!', 'tfuse') ?></h3>
                <?php _e('Due to an unknown error, your form was not submitted, please resubmit it or try later.', 'tfuse') ?>
            </div>
        </div>

<!--/ contact form -->

