<?php
class TF_Nav_Menu_Widget extends WP_Widget {

	function TF_Nav_Menu_Widget() {
		$widget_ops = array( 'description' => __('Add a custom menus as a widget.') );
		parent::WP_Widget( 'nav_menu', __('TFuse Custom Menu'), $widget_ops );
	}

	function widget($args, $instance) {
		// Get menu
		$nav_menu = wp_get_nav_menu_object( $instance['nav_menu'] );
		if ( !$nav_menu )
			return;
        $template_directory = get_template_directory_uri() . '/';

		$instance['title'] = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        $class = empty($instance['class']) ? '' : ' ' . $instance['class'];


		$args['before_widget'] = '<div id="categories-'.$args['widget_id'].'" class="widget-container widget_nav_menu' . $class . '">';
		$args['before_widget'] .= '<img src="' . $template_directory . 'images/icons/widget_icon_03.png" alt="" class="widget_icon">  ';
		$args['after_widget'] = '</div>';
		$args['before_title'] = '<h3 class="widget-title">';
		$args['after_title'] = '</h3>';

		echo $args['before_widget'];
		$instance['title'] = tfuse_qtranslate($instance['title']);
		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];

			wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'link_before'=> '<span>', 'link_after' => '</span>') );

			echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] =  $new_instance['title'] ;
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
        $instance['class'] = $new_instance['class'];

		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
        $class = isset( $instance['class'] ) ? $instance['class'] : '';
		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>


		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>

        <p>
            <label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Class:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" value="<?php echo $class; ?>" />
        </p>

		<p>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
		<?php
			foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
			}
		?>
			</select>
		</p>
		<?php
	}
}


function TFuse_Unregister_WP_Nav_Menu_Widget() {
	unregister_widget('WP_Nav_Menu_Widget');
}
add_action('widgets_init','TFuse_Unregister_WP_Nav_Menu_Widget');

register_widget('TF_Nav_Menu_Widget');
