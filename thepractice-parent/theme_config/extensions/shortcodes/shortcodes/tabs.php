<?php

/**
 * Tabs
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * title:
 * class:
 */
class TFUSE_TABS_Shortcode
{
    private static $add_script_for_code;
    static function init ()
    {
        $atts = array(
            'name' => 'Tabs',
            'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
            'category' => 8,
            'options' => array(
                array(
                    'name' => 'Class',
                    'desc' => 'Tabs class (optional)',
                    'id' => 'tf_shc_tabs_class',
                    'value' => '',
                    'divider' => TRUE,
                    'type' => 'text'
                ),
                array(
                    'name' => 'Title',
                    'desc' => '',
                    'id' => 'tf_shc_tabs_title',
                    'value' => '',
                    'properties' => array('class' => 'tf_shc_addable_0 tf_shc_addable'),
                    'type' => 'text'
                ),
                array(
                    'name' => 'Content',
                    'desc' => '',
                    'id' => 'tf_shc_tabs_content',
                    'value' => '',
                    'properties' => array('class' => 'tf_shc_addable_1 tf_shc_addable tf_shc_addable_last'),
                    'divider' => TRUE,
                    'type' => 'textarea'
                )
            )
        );

        tf_add_shortcode('tabs', array(__CLASS__,'tfuse_tabs'), $atts);

        add_action('init', array(__CLASS__, 'register_script'));
        add_action('wp_footer', array(__CLASS__, 'print_script'));
    }

    static function register_script() {
        $template_directory = get_template_directory_uri();

        wp_register_script( 'jquery.tools', $template_directory.'/js/jquery.tools.min.js', array('jquery'), '1.2.5', true );
    }

    static function print_script() {
        if (!self::$add_script_for_code)
            return;

        wp_enqueue_script('jquery.tools');
    }

    static function tfuse_tabs($atts, $content = null)
    {
        self::$add_script_for_code = true;
        global $framedtabsheading;
        $framedtabsheading = '';
        extract(shortcode_atts(array('class' => ''), $atts));

        $get_tabs = do_shortcode($content);
        $k = 0;
        $out = '
        <!-- tab box -->
        <div class="tabs_framed ' . $class . '">
            <ul class="tabs">';

        while (isset($framedtabsheading[$k])) {
            $out .= $framedtabsheading[$k];
            $k++;
        }

        $out .= '
            </ul>'
            . $get_tabs . '
        </div>
        <!--/ tab box -->';

        return $out;
    }
}

function tfuse_tab($atts, $content = null) {
    global $framedtabsheading;
    extract(shortcode_atts(array('title' => ''), $atts));
    $k = 0;

    while (isset($framedtabsheading[$k])) {
        $k++;
    }

    $framedtabsheading[] = '<li><a href="#tabs_1_' . ($k + 1) . '"><span>' . $title . '</span></a></li>';

    return '<div id="tabs_1_' . ($k + 1) . '" class="tabcontent"><div class="inner">' . do_shortcode($content) . '</div><div class="clear"></div></div>';
}

$atts = array(
    'name' => 'Tab',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 8,
    'options' => array(
        array(
            'name' => 'Title',
            'desc' => 'Specifies the title of an shortcode',
            'id' => 'tf_shc_tab_title',
            'value' => '',
            'type' => 'text'
        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter the tabs in this format:<i>[tab]Tab content[/tab]...</i>',
            'id' => 'tf_shc_tab_content',
            'value' => '',
            'type' => 'textarea'
        )
    )
);

add_shortcode('tab', 'tfuse_tab', $atts);

TFUSE_TABS_Shortcode::init();