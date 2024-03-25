<?php
/**
 * Twitter Newsline
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * items: 5
 * username:
 * title:
 */

function tfuse_twitter_newsline($atts, $content = null)
{
    global $twitter_uniq;
    wp_enqueue_script( 'jcarousel' );

    $twitter_uniq = rand(1, 300);

    extract(shortcode_atts(array(
            'items' => 5,
            'username' => '',
            'title' => '',
    ), $atts));

    $return_html = ''; $k = 0;

    if ( !empty($username) )
    {
        require_once ( TFUSE . '/helpers/TWITTER.php' );

        $obj_twitter = new Twitter($username);
        $tweets = $obj_twitter->get($items);

        $tweets_content = '';

        foreach ( $tweets as $tweet )
        {

            $tweets_content .= '<li>';

            if( isset($tweet[0]) )
            {
                $tweets_content.= $tweets[$k][2];
                $k++;
            }

            $tweets_content .= '</li>';
        }
    }

    $return_html = '<!-- latest news line --><div class="newsline">';
    $return_html .= '<h2><a href="http://twitter.com/#!/' . $username . '" onmouseover="this.style.color = \'#fff\'">' . $title . '</a></h2>';
    $return_html .= '<ul id="twitterlist' . $twitter_uniq . '" class="jcarousel-skin-newsline">';
    $return_html .= $tweets_content;
    $return_html .= '</ul></div>';
    $return_html .= '<script type="text/javascript">
    jQuery(document).ready(function($) {
        jQuery("#twitterlist' . $twitter_uniq . '").jcarousel({
            vertical: true,
            scroll: 1,
            animation: 300,
            auto: 5, // Time interval in sec.
            wrap: "circular",
            initCallback: mycarousel_initCallback
        });
    });
    </script>
<!--/ latest news line -->';

    return $return_html;
}

$atts = array(
    'name' => 'Twitter Newsline',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 11,
    'options' => array(
        array(
            'name' => 'Items',
            'desc' => 'Enter the number of tweets',
            'id' => 'tf_shc_twitter_newsline_items',
            'value' => '5',
            'type' => 'text'
        ),
        array(
            'name' => 'Title',
            'desc' => 'Specifies the title of an shortcode',
            'id' => 'tf_shc_twitter_newsline_title',
            'value' => 'Latest News',
            'type' => 'text'
        ),
        array(
            'name' => 'Username',
            'desc' => 'Twitter username',
            'id' => 'tf_shc_twitter_newsline_username',
            'value' => '',
            'type' => 'text'
        )
    )
);

tf_add_shortcode('twitter_newsline', 'tfuse_twitter_newsline', $atts);
