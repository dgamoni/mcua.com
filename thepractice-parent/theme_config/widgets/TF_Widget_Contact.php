<?php
class TF_Widget_Contact extends WP_Widget
{

    function TF_Widget_Contact()
    {
        $widget_ops = array('classname' => 'widget_contact', 'description' => __( 'Add Contact in Sidebar') );
        $this->WP_Widget('contact', __('TFuse Contact Widgets'), $widget_ops);
    }

    function widget( $args, $instance )
    {
        extract($args);
        $template_directory = get_template_directory_uri() . '/';

        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        $before_widget = '<div class="widget-container widget_contact">';
        $after_widget = '</div>';
        $before_title = '<h3 class="widget-title">';
        $after_title = '</h3>';
        $tfuse_title = (!empty($title)) ? $before_title .tfuse_qtranslate($title) .$after_title : '';

        echo $before_widget;

        // echo widgets title
        echo $tfuse_title;
        echo '<div class="inner">';
        if (( !empty($instance['name'])) ||( !empty($instance['address'])) ||( !empty($instance['phone'])) ||( !empty($instance['fax'])) ||( !empty($instance['email'])) )
        {
            echo '<div class="contact-address">';
            if ( $instance['name'] != '')
            {
                echo '<div class="name"><strong>' . $instance['name'] .'</strong></div>';
            }

            if ( $instance['address'] != '')
            {
                echo '<div class="address">' . $instance['address'] .'</div>';
            }
            if ( !isset($instance['one_row']))
            {
                if ( $instance['phone'] != '')
                {
                    echo '<div class="phone"><em>' . __('Phone','tfuse') . ':</em> <span>' . $instance['phone'] .'</span></div>';
                }

                if ( $instance['fax'] != '')
                {
                    echo '<div class="fax"><em>' . __('Fax','tfuse') . ':</em> <span>' . $instance['fax'] .'</span></div>';
                }
            }
            else
            {
                if ( $instance['phone'] != '' || $instance['fax'])
                {
                    echo '<div class="phone">';
                    if ( $instance['phone'] != '') echo '<em>' . __('Phone','tfuse') . ':</em> <span>' . $instance['phone'] .'</span>';
                    if ( $instance['fax'] != '') echo ' '. __('Fax', 'tfuse') .': <span>' . $instance['fax'] .'</span>';
                    echo '</div>';
                }
            }

            if ( $instance['email'] != '')
            {
                echo '<div class="mail"><em>' . __('Email','tfuse') . ':</em> <a href="mailto:' . $instance['email'] .'">' . $instance['email'] .'</a></div>';
            }
            echo '</div>';
        }

        if (( !empty($instance['skype'])) || ( !empty($instance['twitter'])) ||( !empty($instance['facebook'])))
        {
            echo '<div class="contact-social">';
            if ( $instance['skype'] != '')
            {
                echo '<div><strong>' . __('Call us','tfuse'). ':</strong> <br> <a href="skype:' . $instance['skype'] . '?call"><img src="' . $template_directory . 'images/icons/btn_skype.png" alt=""></a></div>';
            }

            if ( $instance['twitter'] != '')
            {
                echo '<div><strong>' . __('Follow us','tfuse'). ':</strong> <br> <a href="' . $instance['twitter'] . '" target="_blank"><img src="' . $template_directory . 'images/icons/btn_twitter.png" alt=""></a></div>';
            }

            if ( $instance['facebook'] != '')
            {
                echo '<div><strong>' . __('Join us','tfuse'). ':</strong> <br> <a href="' . $instance['facebook'] . '" target="_blank"><img src="' . $template_directory . 'images/icons/btn_facebook.png" alt=""></a></div>';
            }
            echo '<div class="clear"></div>';
            echo '</div>';
        }

        echo '</div>';
        echo $after_widget;
    }

    function update( $new_instance, $old_instance )
    {
        /* $instance = $old_instance;
       $new_instance = wp_parse_args( (array) $new_instance, array( 'title'=>'','name' => '', 'address' => '', 'phone' => '', 'fax' => '', 'email' => '', 'skype' => '', 'twitter' => '', 'facebook' => '', 'one_row' => 'one_row') );

       $instance['title']      = $new_instance['title'];
       $instance['name']      = $new_instance['name'];
       $instance['address']      = $new_instance['address'];
       $instance['phone']      = $new_instance['phone'];
       $instance['fax']      = $new_instance['fax'];
       $instance['email']      = $new_instance['email'];

       $instance['skype']      = $new_instance['skype'];
       $instance['twitter']      = $new_instance['twitter'];
       $instance['facebook']      = $new_instance['facebook'];
       $instance['one_row'] = isset($new_instance['one_row']);
       return $instance;*/
        return $new_instance;
    }

    function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, array( 'title'=>'','name' => '', 'address' => '', 'phone' => '', 'fax' => '', 'email' => '', 'skype' => '', 'twitter' => '', 'facebook' => '', 'one_row' => '') );
        $title = $instance['title'];
        $one_row = esc_attr($instance['one_row']);
        ?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Name:'); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" type="text" value="<?php echo $instance['name']; ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:'); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo esc_attr($instance['address']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone:'); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo esc_attr($instance['phone']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('fax'); ?>"><?php _e('Fax:'); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" type="text" value="<?php echo esc_attr($instance['fax']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:'); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo  esc_attr($instance['email']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('skype'); ?>"><?php _e('Skype:'); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id('skype'); ?>" name="<?php echo $this->get_field_name('skype'); ?>" type="text" value="<?php echo  esc_attr($instance['skype']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:'); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo  esc_attr($instance['twitter']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URL:'); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo  esc_attr($instance['facebook']); ?>"  />
    </p>
    <p>
        <?php if (isset($one_row) && $one_row!= '') $checked = ' checked="checked" '; else $checked = ''; ?>
        <input <?php echo $checked; ?> id="<?php echo $this->get_field_id('one_row'); ?>" name="<?php echo $this->get_field_name('one_row'); ?>" type="checkbox"/>&nbsp;<label for="<?php echo $this->get_field_id('one_row'); ?>"><?php _e('One row for phone and fax'); ?></label>
    </p>
    <?php
    }
}
register_widget('TF_Widget_Contact');
