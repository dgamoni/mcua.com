<?php

// =============================== Flickr widget ======================================

class TFuse_flickr extends WP_Widget {

	function TFuse_flickr() {
            $widget_ops = array('description' => '' );
            parent::WP_Widget(false, __('TFuse - Flickr', 'tfuse'),$widget_ops);
	}

	function widget($args, $instance) {
            extract( $args );
            $template_directory = get_template_directory_uri() . '/';
            $flickr_id = esc_attr($instance['flickr_id']);
            $number = esc_attr($instance['number']);
            $before_widget = '<div class="clear"></div><div class="widget-container widget_flickr">';
            $before_widget .= '<img src="' . $template_directory . 'images/icons/widget_icon_05.png" alt="" class="widget_icon">';
            $after_widget = '</div>';

        echo $before_widget; ?>
        <h3 class="widget_title"><?php _e('IMAGE GALLERY','tfuse'); ?></h3>
		<div class="flickr">
			<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=random&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $flickr_id; ?>"></script>
			<div class="clear"></div>
		</div>

	   <?php
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(  'flickr_id' => '', 'number' => '') );
		$title = esc_attr($instance['flickr_id']);
		$number = esc_attr($instance['number']);
		?>
        <p>
            <label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e('Flickr ID:','tfuse'); ?> (<a href="http://www.idgettr.com" target="_blank">idGettr</a>):</label>
            <input type="text" name="<?php echo $this->get_field_name('flickr_id'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of photos','tfuse'); ?>:</label>
            <input type="text" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $number; ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>" />
        </p>
		<?php
	}
}
register_widget('TFuse_flickr');
