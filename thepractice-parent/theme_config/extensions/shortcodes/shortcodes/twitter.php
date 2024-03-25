<?php

/**
 * Twitter
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * items: 5
 * username:
 * title:
 * post_date:
 */

function tfuse_twitter($atts, $content = null)
{
    extract(shortcode_atts(array(
            'items' => 5,
            'username' => '',
            'title' => '',
            'post_date' => '',
    ), $atts));

    $return_html = ''; $k = 0;

    if ( !empty($username) )
    {
        require_once ( TFUSE . '/helpers/TWITTER.php' );

        $obj_twitter = new Twitter($username);
        $tweets = $obj_twitter->get($items);
        $return_html .= '<div class="twitter">';

        if (!empty($title))
            $return_html .= '<h2>' . $title . '</h2><ul> ';

        foreach ( $tweets as $tweet )
        {

            $return_html .= '<li>';

            if( isset($tweet[0]) )
            {
                $return_html.= '<p>' . $tweets[$k][2] . '</p>';
                $k++;
            }

            if ( !empty($post_date) )
                $return_html .= '<div class="date">' . $tweet[1] . '</div>';

            $return_html .= '</li>';
        }

        $return_html .= '</ul></div>';
    }

    return $return_html;
}

$atts = array(
    'name' => 'Twitter',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 11,
    'options' => array(
        array(
            'name' => 'Items',
            'desc' => 'Enter the number of tweets',
            'id' => 'tf_shc_twitter_items',
            'value' => '5',
            'type' => 'text'
        ),
        array(
            'name' => 'Title',
            'desc' => 'Specifies the title of an shortcode',
            'id' => 'tf_shc_twitter_title',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Username',
            'desc' => 'Twitter username',
            'id' => 'tf_shc_twitter_username',
            'value' => '',
            'type' => 'text'
        )
    )
);

tf_add_shortcode('twitter', 'tfuse_twitter', $atts);
