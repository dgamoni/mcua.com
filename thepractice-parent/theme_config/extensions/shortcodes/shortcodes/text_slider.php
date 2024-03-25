<?php

/**
 * Text Slider
 *
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 *
 * Optional arguments:
 * fadeSpeed: 100
 * play: 10000
 * pause: 10000
 * hoverPause: true
 * autoHeight: true
 */
function tfuse_slider($atts, $content = null) {
    global $uniqTextSlideID, $text_slide;
    extract(shortcode_atts(array('fadeSpeed' => 100, 'play ' => 10000, 'pause'=> 10000, 'hoverpause' => true, 'autoheight' => true), $atts));
    $get_slides = do_shortcode($content);
    wp_enqueue_script( 'slides' );
    wp_enqueue_script( 'jquery.easing' );

    $title = $content = $text = $url = $slides = '';

    $i = 0;

    $uniqID = rand(400, 600);

    while (isset($text_slide['content'][$i])) {

        $slides .= '<div class="slide">';
            if (!empty($text_slide['title'][$i])) $slides .= '<h3>' . $text_slide['title'][$i] . '</h3>';
            $slides .= '<p>' . $text_slide['content'][$i] . '</p>';
            if (!empty($text_slide['text'][$i]) && !empty($text_slide['url'][$i])) $slides .= '<a href="' . $text_slide['url'][$i] . '" class="link-more">' . $text_slide['text'][$i] .'</a>';
        $slides .= '</div>';
        $i++;
    }

    $output = '
    <!-- text slider -->
    <div id="text_slider' . $uniqID . '" class="slideshow slideText">
        <div class="slides_container">
        ' . $slides . '
        </div>
    </div>
    <script language="javascript" type="text/javascript">
       jQuery(document).ready(function($){
            jQuery("#text_slider' . $uniqID . '").slides({
                effect: "fade",
                fadeSpeed: ' . $fadeSpeed . ',
                play: ' . '10000' . ',
                pause: ' . $pause . ',
                hoverPause: true,
                autoHeight: true
                });
        });
    </script>
    <!--/ text slider -->';

    return $output;
}

$atts = array(
    'name' => 'Text Slider',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 11,
    'options' => array(
        array(
            'name' => 'Fade Speed',
            'desc' => 'Set the speed of the fading animation in milliseconds.',
            'id' => 'tf_shc_slider_fadespeed',
            'value' => '100',
            'type' => 'text'
        ),
        array(
            'name' => 'Play',
            'desc' => 'Autoplay slideshow, a positive number will set to true and be the time between slide animation in milliseconds.',
            'id' => 'tf_shc_slider_play',
            'value' => '10000',
            'type' => 'text'
        ),
        array(
            'name' => 'Pause',
            'desc' => 'Pause slideshow on click of next/prev or pagination. A positive number will set to true and be the time of pause in milliseconds.',
            'id' => 'tf_shc_slider_pause',
            'value' => '10000',
            'type' => 'text'
        ),
        array(
            'name' => 'Hover Pause',
            'desc' => 'Set to true and hovering over slideshow will pause it.',
            'id' => 'tf_shc_slider_hoverpause',
            'value' => true,
            'type' => 'checkbox'
        ),
        array(
            'name' => 'Auto Height',
            'desc' => 'Set to true to auto adjust height.',
            'id' => 'tf_shc_slider_autoheight',
            'value' => true,
            'type' => 'checkbox'
        ),
        array(
            'name' => 'Title',
            'desc' => '',
            'id' => 'tf_shc_slider_title',
            'value' => '',
            'properties' => array('class' => 'tf_shc_addable_0 tf_shc_addable'),
            'type' => 'text'
        ),
        array(
            'name' => 'Content',
            'desc' => '',
            'id' => 'tf_shc_slider_content',
            'value' => '',
            'properties' => array('class' => 'tf_shc_addable_1 tf_shc_addable'),
            'type' => 'textarea'
        ),
        array(
            'name' => 'Link Text',
            'desc' => '',
            'id' => 'tf_shc_slider_text',
            'value' => '',
            'properties' => array('class' => 'tf_shc_addable_2 tf_shc_addable'),
            'type' => 'text'
        ),
        array(
            'name' => 'Link URL',
            'desc' => '',
            'id' => 'tf_shc_slider_url',
            'value' => '',
            'properties' => array('class' => 'tf_shc_addable_3 tf_shc_addable tf_shc_addable_last'),
            'type' => 'text'
        )

    )
);

tf_add_shortcode('slider', 'tfuse_slider', $atts);


function tfuse_slide($atts, $content = null)
{
    global $text_slide;
    extract(shortcode_atts(array('title' => '','text' => '', 'url' => ''), $atts));

    $text_slide['title'][] = $title;
    $text_slide['text'][] = $text;
    $text_slide['url'][] = $url;
    $text_slide['content'][] = do_shortcode($content);
}

$atts = array(
    'name' => 'Slide',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 11,
    'options' => array(
        array(
            'name' => 'Title',
            'desc' => 'Specifies the title of an shortcode',
            'id' => 'tf_shc_slide_title',
            'value' => '',
            'type' => 'text'
        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => '',
            'id' => 'tf_shc_slide_content',
            'value' => '',
            'type' => 'textarea'
        ),
        array(
            'name' => 'Link Text',
            'desc' => '',
            'id' => 'tf_shc_slide_text',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Link URL',
            'desc' => '',
            'id' => 'tf_shc_slide_url',
            'value' => '',
            'type' => 'text'
        )
    )
);

add_shortcode('slide', 'tfuse_slide', $atts);
