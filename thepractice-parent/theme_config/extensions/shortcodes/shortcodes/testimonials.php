<?php

/**
 * Testimonials
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * title:
 * order: RAND, ASC, DESC
 */
class TFUSE_Testimonials_Shortcode {

    static $add_script_for_code;

    static function init ()
    {

        $atts = array(
            'name' => 'Testimonials',
            'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
            'category' => 11,
            'options' => array(
                array(
                    'name' => 'Title',
                    'desc' => 'Specifies the title of an shortcode',
                    'id' => 'tf_shc_testimonials_title',
                    'value' => 'Testimonials',
                    'type' => 'text'
                ),
                array(
                    'name' => 'Order',
                    'desc' => 'Select display order',
                    'id' => 'tf_shc_testimonials_order',
                    'value' => 'DESC',
                    'options' => array(
                        'RAND' => 'Random',
                        'ASC' => 'Ascending',
                        'DESC' => 'Descending'
                    ),
                    'type' => 'select'
                )
            )
        );

        tf_add_shortcode('testimonials', array(__CLASS__, 'tfuse_testimonials'), $atts);

        add_action('init', array(__CLASS__, 'register_script'));
        add_action('wp_footer', array(__CLASS__, 'print_script'));
    }

    function register_script()
    {
        $template_directory = get_template_directory_uri();
        wp_register_script( 'slides', $template_directory.'/js/slides.min.jquery.js', array('jquery'), '1.3', false );
    }

    function print_script()
    {
        if (!self::$add_script_for_code)
            return;

        wp_print_scripts('slides');
    }

    function tfuse_testimonials($atts, $content = null)
    {
        global $testimonials_uniq;
        self::$add_script_for_code = true;

        extract(shortcode_atts(array('title' => '', 'order ' => 'RAND'), $atts));
        wp_enqueue_script( 'slides' );
        wp_enqueue_script( 'jquery.easing' );

        $slide = $nav = $single = '';

        $testimonials_uniq = rand(1, 300);

        if (!empty($title))
            $title = '<h2>' . $title . '</h2>';

        if (!empty($order) && ($order == 'ASC' || $order == 'DESC'))
            $order = '&order=' . $order;
        else
            $order = '&orderby=rand';

        query_posts('post_type=testimonials&posts_per_page=-1' . $order);
        $k = 0;
        if (have_posts()) {
            while (have_posts()) {
                $k++;
                the_post();
                global $more; $more = 0;
                $content = get_the_content();
                $position = strpos($content,'...&nbsp;<a href="');
                $positions = '';
                $terms = get_the_terms(get_the_ID(), 'positions');

                if (!is_wp_error($terms) && !empty($terms))
                    foreach ($terms as $term)
                        $positions .= ', ' . $term->name;

                $slide .= '
                <div class="slide">
                    <div class="quote-text">
                    ' . $content . '
                    </div>
                    <div class="quote-author">
                        <span>' . get_the_title() . '</span>
                        ' . $positions . '
                    </div>
                </div>
        ';
            } // End WHILE Loop
        } // End IF Statement
        wp_reset_query();

        if ($k > 1) {
            $nav = '<a href="#" class="prev"></a> <a href="#" class="next"></a>';
        }
        else
            $single = ' style="display: block"';

        $output = '
    <div id="testimonials' . $testimonials_uniq . '" class="slideshow slideQuotes">
        ' . $title . '
        <div class="slides_container"' . $single . '>
        ' . $slide . '
        </div><!--/ .slides_container -->
        ' . $nav . '
    </div><!--/ .slideshow slideQuotes -->
    <script language="javascript" type="text/javascript">
       jQuery(document).ready(function($){
            $("#testimonials' . $testimonials_uniq . '").slides({
                hoverPause: true,
                play: 9000,
                autoHeight: true,
                pagination: false,
                generatePagination: false,
                effect: "fade",
                fadeSpeed: 150});
        });
    </script>';

        return $output;
    }
}

TFUSE_Testimonials_Shortcode::init();


