<?php

// =============================== Popular post widget ======================================

class TFuse_Popular_post extends WP_Widget {

    function TFuse_Popular_post() {
        $widget_ops = array('description' => '' );
        parent::WP_Widget(false, __('TFuse - Popular Posts', 'tfuse'),$widget_ops);
    }

    function widget($args, $instance) {
        extract( $args );
        $template_directory = get_template_directory_uri() . '/';

        $title = apply_filters('widget_title', empty($instance['title']) ? __('POPULAR ARTICLES') : $instance['title'], $instance, $this->id_base);
        $number = esc_attr($instance['number']);
        if ($number>0) { $number = $number>25 ? 25 : $number; } else $number = 8;
    ?>

    <div class="widget-container widget_recent_entries">
        <img src="<?php echo $template_directory; ?>images/icons/widget_icon_02.png" alt="" class="widget_icon">
        <h3 class="widget-title"><?php echo tfuse_qtranslate($title); ?></h3>
        <ul>
            <?php
            $pop_posts =  tfuse_shortcode_posts(array(
                                'sort' => 'popular',
                                'items' => $number,
                                'image_post' => false,
                                'date_post' => false
                            ));

            foreach($pop_posts as $post_val): ?>
                <li>
                    <a href="<?php echo $post_val['post_link']; ?>"><?php echo $post_val['post_title']; ?></a>
                </li>
                <?php endforeach; ?>
        </ul>
    </div>

    <?php
    }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
        $instance = wp_parse_args( (array) $instance, array(  'title' => '', 'number' => '') );
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = esc_attr($instance['number']);
        ?>
       <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
       <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts','tfuse'); ?>:</label>
            <input type="text" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $number; ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>" />
        </p>

    <?php
    }
} 
register_widget('TFuse_Popular_post');
