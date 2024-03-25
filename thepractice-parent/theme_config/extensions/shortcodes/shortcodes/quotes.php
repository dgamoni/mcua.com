<?php

/**
 * Quotes
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 *
 */


function tfuse_quote_right($atts, $content = null) {
    return '<div class="quote_right"><div class="inner1"><p>' . do_shortcode($content) . '</p></div></div>';
}

$atts = array(
    'name' => 'Quote Right',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 9,
    'options' => array(
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter Quotes Content',
            'id' => 'tf_shc_quote_right_content',
            'value' => '',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('quote_right', 'tfuse_quote_right', $atts);

function tfuse_quote_left($atts, $content = null) {
    return '<div class="quote_left"><div class="inner"><p>' . do_shortcode($content) . '</p></div></div>';
}

$atts = array(
    'name' => 'Quote Left',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 9,
    'options' => array(
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter Quotes Content',
            'id' => 'tf_shc_quote_left_content',
            'value' => '',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('quote_left', 'tfuse_quote_left', $atts);

function tfuse_blockquote($atts, $content = null)
{
    return '<blockquote><div class="inner">' . do_shortcode($content) . '</div></blockquote>';
}

$atts = array(
    'name' => 'BlockQuote',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 9,
    'options' => array(
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter Quotes Content',
            'id' => 'tf_shc_blockquote_content',
            'value' => '',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('blockquote', 'tfuse_blockquote', $atts);

function tfuse_quote_simple($atts, $content = null)
{
    extract(shortcode_atts(array('author' => ''), $atts));
    if ( $author != '')
        return '<div class="quoteBox"><div class="inner"><div class="quote-text">' . do_shortcode($content) . '</div><div class="quote-author">' . $author . '</div></div></div>';
    return '<div class="quoteBox"><div class="quote-text">' . do_shortcode($content) . '</div></div>';
}

$atts = array(
    'name' => 'Quote Simple',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 9,
    'options' => array(
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Author',
            'desc' => 'Enter Quotes Author',
            'id' => 'tf_shc_quote_simple_author',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Content',
            'desc' => 'Enter Quotes Content',
            'id' => 'tf_shc_quote_simple_content',
            'value' => '',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('quote_simple', 'tfuse_quote_simple', $atts);
