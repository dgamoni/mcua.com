<?php

/**
 * Popular Posts
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * items:
 * title:
 * image_width:
 * image_height:
 * image_class:
 */

function tfuse_popular_posts($atts, $content = null)
{
    extract(shortcode_atts(array(
                'items' => 5,
                'title' => 'Popular Posts',
                'image_width' => 75,
                'image_height' => 75,
                'image_class' => 'thumbnail'
                    ), $atts));

    $return_html = !empty($title) ? '<h2>' . $title . '</h2>' : '';
    $latest_posts = tfuse_shortcode_posts(array(
        'sort' => 'popular',
        'items' => $items,
        'image_post' => true,
        'image_width' => $image_width,
        'image_height' => $image_height,
        'image_class' => $image_class,
        'date_post' => false,
            ));
    $return_html .= '
    <div class="widget_popular_posts">
        <ul>';
    foreach ($latest_posts as $post_val):
        $return_html .= '<li>';
        $return_html .= '<a href="' . $post_val['post_link'] . '" class="post-title">' . $post_val['post_title'] . '</a>';
        $return_html .= '
                <div class="post-meta"><em>
                    ' . __('by ', 'tfuse') . '<a href="' . $post_val['post_author_link'] . '" class="author">' . $post_val['post_author_name'] . '</a>
                    <span class="separator">|</span>' . $post_val['post_comnt_numb_link'] . '</em>
                </div>';

        $return_html .= '
                <div class="extras">
                    ' . $post_val['post_img'] . '
                    ' . $post_val['mini_post_excerpt'] . '
                </div>
                <a href="' . $post_val['post_link'] . '" class="link-more">' . __('Read more', 'tfuse') . '</a>';
        $return_html .= '</li>';
    endforeach;
    $return_html .='
        </ul>
    </div> ';

    return $return_html;
}

$atts = array(
    'name' => 'Popular Posts',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 11,
    'options' => array(
        array(
            'name' => 'Items',
            'desc' => 'Specifies the number of the post to show',
            'id' => 'tf_shc_popular_posts_items',
            'value' => '5',
            'type' => 'text'
        ),
        array(
            'name' => 'Title',
            'desc' => 'Specifies the title for an shortcode',
            'id' => 'tf_shc_popular_posts_title',
            'value' => 'Popular Posts',
            'type' => 'text'
        ),
        array(
            'name' => 'Image Width',
            'desc' => 'Specifies the width of an thumbnail',
            'id' => 'tf_shc_popular_posts_image_width',
            'value' => '75',
            'type' => 'text'
        ),
        array(
            'name' => 'Image Height',
            'desc' => 'Specifies the height of an thumbnail',
            'id' => 'tf_shc_popular_posts_image_height',
            'value' => '75',
            'type' => 'text'
        ),
        array(
            'name' => 'Image Class',
            'desc' => 'Specifies one or more class names for an shortcode. To specify multiple classes,<br /> separate the class names with a space, e.g. <b>"left important"</b>.',
            'id' => 'tf_shc_popular_posts_image_class',
            'value' => 'thumbnail',
            'type' => 'text'
        )
    )
);

tf_add_shortcode('popular_posts', 'tfuse_popular_posts', $atts);
