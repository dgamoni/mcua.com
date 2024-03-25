<?php

// =============================== Tabs widget ======================================

class TFuse_tabs extends WP_Widget {

	function TFuse_tabs() {
		$widget_ops = array('description' => '' );
		parent::WP_Widget(false, __('TFuse - Tabs', 'tfuse'),$widget_ops);
	}



	function widget($args, $instance) {
        $template_directory = get_template_directory_uri() . '/';

        /*shortcode: Tabs*/
        wp_register_script( 'jquery.tools', $template_directory.'js/jquery.tools.min.js', array('jquery'), '1.2.5', true );
        wp_enqueue_script( 'jquery.tools' );

		extract( $args );
		if (isset($instance['number']))
        {
            $number =  esc_attr($instance['number']);
        }
        else
        {
            $number = 5;
        }
	?>

	<div class="tf_sidebar_tabs tabs_framed">
                <ul class="tabs">
                    <li><a href="#tf_tabs_1"><?php _e('Recent Posts','tfuse'); ?></a></li>
                    <li><a href="#tf_tabs_2"><?php _e('Most Commented','tfuse'); ?></a></li>
                </ul>
                <div id="tf_tabs_1" class="tabcontent">
                    <ul class="post_list recent_posts">
                    <?php   $rec_posts =  tfuse_shortcode_posts(array('sort' => 'recent','date_format' => 'F j, Y', 'items' => $number));
                    foreach($rec_posts as $recpost_val ): ?>
                        <li>
                            <a href="<?php echo $recpost_val['post_link']; ?>"><?php echo $recpost_val['post_img']; ?></a>
                            <a href="<?php echo $recpost_val['post_link']; ?>"><?php echo $recpost_val['post_title']; ?></a>
                            <div class="date"><?php echo $recpost_val['post_date_post']; ?></div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div id="tf_tabs_2" class="tabcontent">
                    <ul class="post_list popular_posts">
                        <?php $pop_posts =  tfuse_shortcode_posts(array('sort' => 'commented', 'items' => $number));
                        foreach($pop_posts as $post_val ): ?>
                            <li>
                                <a href="<?php echo $post_val['post_link']; ?>"><?php echo $post_val['post_img']; ?></a>
                                <a href="<?php echo $post_val['post_link']; ?>"><?php echo $post_val['post_title']; ?></a>
                                <div class="date"><?php echo $post_val['post_date_post']; ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

	   <?php
        }

        function update($new_instance, $old_instance) {
            return $new_instance;
        }

        function form($instance) {
            $instance = wp_parse_args( (array) $instance, array(  'number' => '') );
            $number = esc_attr($instance['number']);
            ?>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts','tfuse'); ?>:</label>
            <input type="text" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $number; ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>" />
        </p>
        <?php
	}
}
register_widget('TFuse_tabs');
