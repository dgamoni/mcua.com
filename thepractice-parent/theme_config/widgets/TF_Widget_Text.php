<?php
class TF_Widget_Text extends WP_Widget {

	function TF_Widget_Text() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __('Arbitrary text or HTML'));
		$control_ops = array('width' => 400, 'height' => 350);
		$this->WP_Widget('text', __('TFuse Text'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$class = empty($instance['class']) ? '' : $instance['class'];
		if (isset($instance['apply_filters']) && $instance['apply_filters'])
        {
            $text = empty($instance['text']) ? '' : $instance['text'];
        }
        else
        {
            $text = apply_filters( 'widget_text', $instance['text'], $instance );
        }

		$tf_class = ( @$instance['nopadding'] ) ? '' : 'class="widget-container widget_text ' . $class . '"';
		$before_widget = '<div id="text-'.$args['widget_id'].'" '.$tf_class.'>';
		$after_widget = '</div>';
		$before_title = '<h3 class="widget-title">';
		$after_title = '</h3>';


		echo $before_widget;
		$title = tfuse_qtranslate($title);
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
			<div class="textwidget"><?php echo $instance['filter'] ? wpautop($text) : $text; ?></div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['class'] = $new_instance['class'];
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		$instance['nopadding'] = isset($new_instance['nopadding']);
		$instance['apply_filters'] = isset($new_instance['apply_filters']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'class' => '', 'text' => '', 'nopadding' => '' ) );
		$title = $instance['title'];
		$class = $instance['class'];
		$text = format_to_edit($instance['text']);
?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Class:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($class); ?>" /></p>


		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
		<p><input id="<?php echo $this->get_field_id('nopadding'); ?>" name="<?php echo $this->get_field_name('nopadding'); ?>" type="checkbox" <?php checked(isset($instance['nopadding']) ? $instance['nopadding'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('nopadding'); ?>"><?php _e('No Margin and padding'); ?></label></p>
		<p><input id="<?php echo $this->get_field_id('apply_filters'); ?>" name="<?php echo $this->get_field_name('apply_filters'); ?>" type="checkbox" <?php checked(isset($instance['apply_filters']) ? $instance['apply_filters'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('apply_filters'); ?>"><?php _e('Disable filters'); ?></label></p>

<?php
	}
}


function TFuse_Unregister_WP_Widget_Text() {
	unregister_widget('WP_Widget_Text');
}
add_action('widgets_init','TFuse_Unregister_WP_Widget_Text');

register_widget('TF_Widget_Text');
