<?php

/**
 * Minigallery
 *
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 *
 * Optional arguments:
 * id: post/page id
 * order: ASC, DESC
 * orderby:
 * include:
 * exclude:
 * pretty: true/false use or not prettyPhoto
 * icon_plus:
 * class: css class e.g. boxed
 * carousel: jCarousel Configuration. http://sorgalla.com/projects/jcarousel/
 */

function tfuse_minigallery($attr, $content = null)
{
    wp_enqueue_script( 'jcarousel' );
    wp_enqueue_script( 'jquery.easing' );
    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id' => isset($post->ID) ? $post->ID : $attr['id'],
        'include'    => '',
        'exclude'    => '',
        'pretty'     => true,
        'icon_plus'  => '<span></span>',
        'carousel'   => 'easing: "easeInOutQuint",animation: 600',
        'auto'  => 0,
        'class'      => 'boxed'
    ), $attr));

    if ( !empty($include) ) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace('/[^0-9,]+/', '', $exclude);
        $attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    } else {
        $attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    }

    if ( empty($attachments) )
        return '';

    $uniq = rand(1, 200);

    $out = '
    <script type="text/javascript">
        jQuery(document).ready(function($) {
        $("#mycarousel' . $uniq . '").jcarousel({
                ' . $carousel . ',auto:' . $auto .'
            });
        });
    </script>
    <script type="text/javascript">
							jQuery(document).ready(function($) {
								$(\'a[data-rel]\').each(function() {
	  							    $(this).attr(\'rel\', $(this).data(\'rel\'));
	  							});
	  							$("a[rel^=\'prettyPhoto\']").prettyPhoto({social_tools:false});
							});
						</script>
    ';

    $out .= '
    <div class="minigallery-list minigallery ' . $class . '">
        <ul id="mycarousel' . $uniq . '" class="jcarousel-skin-tango">';

    if ($icon_plus)
        $out .= '<span></span>';

    foreach ($attachments as $id => $attachment)
    {


        $link = wp_get_attachment_image_src($id, 'full', true);
        $image_link_attach = $link[0];
        $imgsrc = wp_get_attachment_image_src($id, array(100, 100), false);
        $image_src = $imgsrc[0];

        $image = new TF_GET_IMAGE();
        $img = $image->properties(array('alt' => $attachment->post_title))->src($image_src)->get_img();

        if ( $pretty != 'false')
            $out .= '<li><a href="' . $image_link_attach . '" data-rel="prettyPhoto[gallery' . $uniq . ']" title="">'
                . $img . $icon_plus . '</a></li>';
        else
            $out .= '<li>' . $img . '</li>';
    }

    $out .= '
        </ul>
    </div>
    <div class="clear"></div>
    ';

    return $out;
}

$atts = array(
    'name' => 'Minigallery',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 6,
    'options' => array(
        array(
            'name' => 'ID',
            'desc' => 'Specifies the post or page ID. For more detail about this shortcode follow the <a href="http://codex.wordpress.org/Template_Tags/get_posts" target="_blank">link</a>',
            'id' => 'tf_shc_minigallery_id',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Class',
            'desc' => 'Specifies one or more class names for an shortcode. To specify multiple classes,<br /> separate the class names with a space, e.g. <b>"left important"</b>',
            'id' => 'tf_shc_minigallery_class',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Auto',
            'desc' => 'Autoplay introduced over a period of seconds.',
            'id' => 'tf_shc_minigallery_auto',
            'value' => '0',
            'type' => 'text'
        ),
        array(
            'name' => 'pretty',
            'desc' => 'Open in Box with PrettyPhoto',
            'id' => 'tf_shc_minigallery_pretty',
            'value' => true,
            'type' => 'checkbox'
        )
    )
);

tf_add_shortcode('minigallery', 'tfuse_minigallery', $atts);
