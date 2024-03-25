<?php

/**
 * Buttons
 *
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 *
 * Optional arguments:
 * style: custom css style
 * link: the destination of a link e.g. http://themefuse.com/
 * class: css class
 * target: _blank, _self, _parent, _top
 */

function tfuse_button($atts, $content = null)
{
    extract( shortcode_atts(array('style' => '', 'link' => '#', 'class' => '', 'target' => '_self', 'size' => 'normal'), $atts) );

    if ( !empty($style) )
    {
        $class = 'button_styled';
        $style = ' style="' . $style . '"';
    }
    elseif ($size == 'big')
    {
        $class = 'btn ' . $class;
    }
    else
        $class = 'button_link ' . $class;


    return '<a href="' . $link . '" class="' . $class . '"  target="' . $target . '"' . $style . '><span>' . $content . '</span></a>';
}

$atts = array(
    'name' => 'Buttons',
    'desc' => 'Here comes some lorem ipsum description for the button shortcode.',
    'category' => 2,
    'options' => array(
        array(
            'name' => 'Target',
            'desc' => 'Specifies where to open the linked shortcode',
            'id' => 'tf_shc_button_target',
            'value' => '_self',
            'options' => array(
                '_blank' => 'Opens the link in a new window or tab',
                '_parent' => 'Opens the link in the parent frame',
                '_self' => 'Opens the link in the same frame as it was clicked (this is default)',
                '_top' => 'Opens the link in the full body of the window',
            ),
            'type' => 'select'
        ),
        array(
            'name' => 'Size',
            'desc' => 'Choose the button size.',
            'id' => 'tf_shc_button_size',
            'value' => 'normal',
            'options' => array(
                'normal' => 'Normal',
                'big' => 'Big'
            ),
            'type' => 'select'
        ),
        array(
            'name' => 'Style',
            'desc' => 'Specify an inline style for an shortcode',
            'id' => 'tf_shc_button_style',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Class',
            'desc' => 'Specifies one or more class names for an shortcode, separated by space.
                <br /><b>predefined classes:</b> btn_pink, btn_black, btn_blue, btn_yellow, btn_green',
            'id' => 'tf_shc_button_class',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Link',
            'desc' => 'Specifies the URL of the page the link goes to',
            'id' => 'tf_shc_button_link',
            'value' => '#',
            'type' => 'text'
        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter shortcode content',
            'id' => 'tf_shc_button_content',
            'value' => 'button',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('button', 'tfuse_button', $atts);
