<?php

/**
 * Styled Boxes
 *
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 *
 * Optional arguments:
 * title: Shortcode title
 * class: custom class
 */

function tfuse_styled_box($atts, $content = null)
{
    extract( shortcode_atts(array('title' => '','type' => 'sb', 'class' => ''), $atts) );

    if ($type == 'box')
    {
        $html = '<div class="box '.$class.'">'
            . do_shortcode($content) .
                    ' <div class="clear"></div>
                </div>';
    }
    else
    {
        $html = '<div class="sb '.$class.'">
                <div class="box_title">' . $title . '</div>
                <div class="box_content">'
            . do_shortcode($content) .
            '<div class="clear"></div>
                </div>
            </div>';
    }


    return $html;
}
$atts = array(
    'name' => 'Boxes',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 7,
    'options' => array(
        array(
            'name' => 'Title',
            'desc' => 'Text to display above the box',
            'id' => 'tf_shc_styled_box_title',
            'value' => 'Styled box Title',
            'type' => 'text'
        ),
        array(
            'name' => 'Type',
            'desc' => 'Type of boxes',
            'id' => 'tf_shc_styled_box_type',
            'value' => 'sb',
            'options' => array(
                'sb' => 'Styled Box',
                'box' => 'Box',
            ),
            'type' => 'select'
        ),
        array(
            'name' => 'Class',
            'desc' => 'Specifies one or more class names for an shortcode, separated by space.
                <br /><b>predefined classes:</b> sb_pink, sb_yellow, sb_blue, sb_green, sb_dark_gray, sb_purple, sb_orange',
            'id' => 'tf_shc_styled_box_class',
            'value' => '',
            'type' => 'text'
        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter shortcode content',
            'id' => 'tf_shc_styled_box_content',
            'value' => 'Insert the content here',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('styled_box', 'tfuse_styled_box', $atts);
