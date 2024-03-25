<?php

/**
 * Toggle Content
 *
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 */

function tfuse_toggle_content($atts, $content = null)
{
    extract(shortcode_atts(array('title' => '', 'class' => 'box'), $atts));

    if (empty($title))
        $title = __('Toggle Content (click to open)', 'tfuse');

    return '<h3 class="toggle ' . $class . '">' . $title . '<span class="ico"></span></h3>
        <div class="toggle_content boxed"><p>' . do_shortcode($content) . '</p></div>';
}

$atts = array(
    'name' => 'Toggle Content',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 8,
    'options' => array(
        array(
            'name' => 'Title',
            'desc' => 'Specifies the title of an shortcode',
            'id' => 'tf_shc_toggle_content_title',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Class',
            'desc' => 'Specifies one or more class names for an shortcode. To specify multiple classes,<br /> separate the class names with a space, e.g. <b>"left important"</b>',
            'id' => 'tf_shc_toggle_content_class',
            'value' => '',
            'type' => 'text'
        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter shortcode content',
            'id' => 'tf_shc_toggle_content_content',
            'value' => '',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('toggle_content', 'tfuse_toggle_content', $atts);

class TFUSE_Code_Shortcode {

    static $add_script_for_code;

    static function init() {
        $atts = array(
            'name' => 'Toggle Code',
            'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
            'category' => 8,
            'options' => array(
                array(
                    'name' => 'Title',
                    'desc' => 'Specifies the title of an shortcode',
                    'id' => 'tf_shc_toggle_code_title',
                    'value' => '',
                    'type' => 'text'
                ),
                /* add the fllowing option in case shortcode has content */
                array(
                    'name' => 'Content',
                    'desc' => 'Enter shortcode content',
                    'id' => 'tf_shc_toggle_code_content',
                    'value' => '',
                    'type' => 'textarea'
                )
            )
        );

        tf_add_shortcode('toggle_code', array(__CLASS__, 'tfuse_toggle_code'), $atts);

        $atts = array(
            'name' => 'Code',
            'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
            'category' => 8,
            'options' => array(
                /* add the fllowing option in case shortcode has content */
                array(
                    'name' => 'Content',
                    'desc' => 'Enter shortcode content',
                    'id' => 'tf_shc_code_content',
                    'value' => '',
                    'type' => 'textarea'
                )
            )
        );

        tf_add_shortcode('code', array(__CLASS__, 'tfuse_code'), $atts);

        add_action('init', array(__CLASS__, 'register_script'));
        add_action('wp_footer', array(__CLASS__, 'print_script'));
        add_action('wp_print_styles', array(__CLASS__, 'print_styles'));
    }

    function register_script() {
        $template_directory = get_template_directory_uri();

        wp_register_script('shCore', $template_directory . '/js/shCore.js', array('jquery'), '2.1.382', true);
        wp_register_script('shBrushPlain', $template_directory . '/js/shBrushPlain.js', array('jquery'), '2.1.382', true);
    }

    function print_styles() {
        $template_directory = get_template_directory_uri();

        wp_register_style('shCore', $template_directory . '/css/shCore.css', false, '2.1.382');
        wp_enqueue_style('shCore');

        wp_register_style('shThemeDefault', $template_directory . '/css/shThemeDefault.css', false, '2.1.382');
        wp_enqueue_style('shThemeDefault');
    }

    function print_script() {
        if (!self::$add_script_for_code)
            return;

        wp_print_scripts('shCore');
        wp_print_scripts('shBrushPlain');
        echo '<script type="text/javascript">SyntaxHighlighter.defaults[\'gutter\'] = false;SyntaxHighlighter.defaults[\'toolbar\'] = true;SyntaxHighlighter.all();</script>';
    }

    function tfuse_toggle_code($atts, $content = null) {
        self::$add_script_for_code = true;

        extract(shortcode_atts(array('title' => __('Toggle Content (click to open)', 'tfuse'), 'brush' => 'plain'), $atts));

        $out = '<h3 class="toggle box">' . $title . '<span class="ico"></span></h3>';
        $out .= '<div class="toggle_content">';
        $out .= '<pre class="brush: ' . $brush . '">';
        $out .= $content;
        $out .= '</pre>';
        $out .= '</div>';

        return $out;
    }

    function tfuse_code($atts, $content = null) {
        self::$add_script_for_code = true;

        extract(shortcode_atts(array('brush' => 'plain'), $atts));

        return '<pre class="brush: ' . $brush . '">' . $content . '</pre>';
    }

}

TFUSE_Code_Shortcode::init();
