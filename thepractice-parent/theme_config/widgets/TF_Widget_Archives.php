<?php
class TF_Widget_Archives extends WP_Widget {

	function TF_Widget_Archives() {
		$widget_ops = array('classname' => 'widget_archive', 'description' => __( 'A monthly archive of your site&#8217;s posts') );
		$this->WP_Widget('archives', __('TFuse Archives'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
        $template_directory = get_template_directory_uri() . '/';
		$c = $instance['count'] ? '1' : '0';
		$d = $instance['dropdown'] ? '1' : '0';

        $tfuse_widget_col_before = $tfuse_widget_col_after = '';

        		$title = apply_filters('widget_title', empty($instance['title']) ? __('Archives') : $instance['title'], $instance, $this->id_base);

		$before_widget = '<div id="archives-'.$args['widget_id'].'" class="widget-container widget_archive">';
		$before_widget .= '<img src="' . $template_directory . 'images/icons/widget_icon_04.png" alt="" class="widget_icon">';
		$after_widget = '</div>';
		$before_title = '<h3 class="widget-title">';
		$after_title = '</h3>';

		echo $tfuse_widget_col_before .$before_widget;
		$title = tfuse_qtranslate($title);
		if ( $title )
			echo $before_title . $title . $after_title;

		if ( $d ) {
?>
		<select class="postform" name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'> <option value=""><?php echo esc_attr(__('Select Month')); ?></option> <?php wp_get_archives(apply_filters('widget_archives_dropdown_args', array('type' => 'monthly', 'format' => 'option', 'show_post_count' => $c))); ?> </select>
<?php
		} else {
?>
		<ul>
		<?php wp_get_archives(apply_filters('widget_archives_args', array('type' => 'monthly', 'show_post_count' => $c))); ?>
		</ul>
<?php
		}

		echo $after_widget . $tfuse_widget_col_after;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '', 'col_1_2' => '') );
		$instance['title'] = $new_instance['title'];
		$instance['count'] = $new_instance['count'] ? 1 : 0;
		$instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;
		if ( in_array( $new_instance['template'], array( 'box_white', 'box_white box_border' ) ) ) {
			$instance['template'] = $new_instance['template'];
		} else {
			$instance['template'] = 'box_white';
		}

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '', 'template' => 'box_black') );
		$title = $instance['title'];
		$count = $instance['count'] ? 'checked="checked"' : '';
		$dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
		$template = esc_attr( $instance['template'] );
?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p>
			<input class="checkbox" type="checkbox" <?php echo $dropdown; ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" /> <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e('Display as a drop down'); ?></label>
        </p>

<?php
	}
}

function TFuse_Unregister_WP_Widget_Archives() {
	unregister_widget('WP_Widget_Archives');
}
add_action('widgets_init','TFuse_Unregister_WP_Widget_Archives');

register_widget('TF_Widget_Archives');
