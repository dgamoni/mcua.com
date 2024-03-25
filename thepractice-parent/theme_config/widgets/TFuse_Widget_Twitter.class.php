<?php
/*---------------------------------------------------------------------------------*/
/* Twitter widget */
/*---------------------------------------------------------------------------------*/
class Tfuse_Twitter extends WP_Widget {

   function Tfuse_Twitter() {
	   $widget_ops = array('description' => 'Add your Twitter feed to your sidebar.' );
       parent::WP_Widget(false, __('Tfuse - Twitter Stream', 'tfuse'),$widget_ops);
   }

   function widget($args, $instance) {
    extract( $args );
    $template_directory = get_template_directory_uri() . '/';
    $title = ( !empty($instance['title']) ) ? $instance['title'] : 'Twitter Activity';
    $limit = ( !empty($instance['limit']) ) ? $instance['limit'] : 3;
    if ( $limit>30 ) $limit = 30;
    $username = ( !empty($instance['username']) ) ? $instance['username'] : 'themefuse';

    $unique_id = $args['widget_id'].rand(0,100);
    $before_widget = '<div class="widget-container widget_twitter">';
    $before_widget .= '<img src="' . $template_directory . 'images/icons/widget_icon_02.png" alt="" class="widget_icon">';
    $after_widget = '</div></div>';
    $before_title = '<h3>';
    $after_title = '</h3>';
    ?>
    <?php echo $before_widget; ?>
    <?php if ($title) echo $before_title . $title . $after_title; ?>
    <div class="tweet_list">
    <div class="back" id="twitter_update_list_<?php echo $unique_id; ?>"></div>
    <?php echo tfuse_twitter_script($unique_id,$username,$limit); //Javascript output function ?>
    <?php echo $after_widget; ?>


    <?php
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {

       (isset($instance['title'])) ? $title = esc_attr($instance['title']) : $title = '';
       (isset($instance['username'])) ? $username = esc_attr($instance['username']) : $username = '';
       (isset($instance['limit'])) ? $limit = esc_attr($instance['limit']) : $limit = '';
       ?>
       <p>
	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):','tfuse'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
       </p>
       <p>
	   	   <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:','tfuse'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('username'); ?>"  value="<?php echo $username; ?>" class="widefat" id="<?php echo $this->get_field_id('username'); ?>" />
       </p>
       <p>
	   	   <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit:','tfuse'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('limit'); ?>"  value="<?php echo $limit; ?>" class="" size="3" id="<?php echo $this->get_field_id('limit'); ?>" />

       </p>
      <?php
   }

}
register_widget('Tfuse_Twitter');



function tfuse_twitter_script($unique_id, $username, $limit) {
    ?>
    <script type="text/javascript">
        <!--//--><![CDATA[//><!--

        function twitterCallback2(twitters) {

            var statusHTML = [];
            for (var i=0; i<twitters.length; i++){
                var username = twitters[i].user.screen_name;
                var username_avatar = twitters[i].user.profile_image_url;
                var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
                    return '<a href="'+url+'">'+url+'</a>';
                }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
                    return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
                });
                statusHTML.push('<div class="tweet_item"><div class="tweet_image"><img src="'+username_avatar+'" width="30" height="30" alt="" /></div><div class="tweet_text"><div class="inner">'+status+'</div></div><div class="clear"></div></div>');
            }
            document.getElementById('twitter_update_list_<?php echo $unique_id; ?>').innerHTML = statusHTML.join('');
        }

        function relative_time(time_value) {
            var values = time_value.split(" ");
            time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
            var parsed_date = Date.parse(time_value);
            var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
            var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
            delta = delta + (relative_to.getTimezoneOffset() * 60);

            if (delta < 60) {
                return 'less than a minute ago';
            } else if(delta < 120) {
                return 'about a minute ago';
            } else if(delta < (60*60)) {
                return (parseInt(delta / 60)).toString() + ' minutes ago';
            } else if(delta < (120*60)) {
                return 'about an hour ago';
            } else if(delta < (24*60*60)) {
                return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
            } else if(delta < (48*60*60)) {
                return '1 day ago';
            } else {
                return (parseInt(delta / 86400)).toString() + ' days ago';
            }
        }
        //-->!]]>
    </script>
    <script type="text/javascript" src="http://api.twitter.com/1/statuses/user_timeline/<?php echo $username; ?>.json?callback=twitterCallback2&amp;count=<?php echo $limit; ?>&amp;include_rts=t"></script>
    <?php
}
