<?php

/**
 * Latest Cases
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

function tfuse_latest_cases($atts, $content = null)
{
    extract(shortcode_atts(array(
                                'items' => 4,
                           ), $atts));

    $return_html ='<!--  postlist / 1 article --><div class="postlist">';

    $latest_cases = tfuse_shortcode_posts(array(
                                               'sort' => 'recent',
                                               'items' => $items,
                                               'post_type' => 'cases'
                                          ));

    foreach ($latest_cases as $post_val):

        $excerpt = $post_val['excerpt'] ? apply_filters('themefuse_shortcodes', $post_val['excerpt']) : apply_filters('themefuse_shortcodes', $post_val['content']);
        $return_html .= '<article>
	                	<figure class="image_frame" style="padding: 0 0;">
	                        <a href="' . $post_val['post_link'] . '"><img src="' . $post_val['photo_src'] . '" alt=""></a>
	                        <figcaption>' . $post_val['photo_title'] . '</figcaption>
						</figure>

	                    <section class="summary">
		                    <h1><a href="' . $post_val['post_link'] . '">' . $post_val['post_title'] . '</a></h1>' . $excerpt . '
	                        <div class="post-meta"><a style="font-family: \'Lato\', Arial, Helvetica, sans-serif;"; href="' . $post_val['post_link'] . '" class="link-more alignleft">' . __('Read more', 'tfuse') . '</a></div>
	                  </section>

	                    <section class="aside">
		                    <h2 style="font-weight:normal; line-height: normal;">' . __('The Charges', 'tfuse') . ':</h2>
		                    <p>' . $post_val['charges'] . '</p>

	                        <h2 style="font-weight:normal; line-height: normal;">' . __('The Verdict','tfuse') . ':</h2>
		                    <p>' . $post_val['verdict'] . '</p>
		                </section>
	                    <div class="clear"></div>
	                </article>';
    endforeach;
    $return_html .='</div><!--/  postlist / 1 article -->';

    return $return_html;
}

$atts = array(
    'name' => 'Latest Cases',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 11,
    'options' => array(
        array(
            'name' => 'Items',
            'desc' => 'Specifies the number of the cases to show',
            'id' => 'tf_shc_latest_cases_items',
            'value' => '4',
            'type' => 'text'
        )
    )
);

tf_add_shortcode('latest_cases', 'tfuse_latest_cases', $atts);
