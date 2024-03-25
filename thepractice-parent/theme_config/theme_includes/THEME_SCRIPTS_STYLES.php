<?php

add_action( 'wp_print_styles', 'tfuse_add_css' );
add_action( 'wp_print_scripts', 'tfuse_add_js' );

if ( ! function_exists( 'tfuse_add_css' ) ) :
    /**
     * This function include files of css.
     */
    function tfuse_add_css()
    {
        $template_directory = get_template_directory_uri();

        wp_register_style( 'prettyPhoto', TFUSE_ADMIN_CSS . '/prettyPhoto.css', false, '3.1.4' );
        wp_enqueue_style( 'prettyPhoto' );

        wp_register_style( 'jquery-ui-custom', $template_directory.'/css/md-theme/jquery-ui-1.8.16.custom.css', false, '1.8.16' );
        wp_enqueue_style( 'jquery-ui-custom' );

        wp_register_style( 'screen_css', $template_directory.'/screen.css');
        wp_enqueue_style( 'screen_css' );

        wp_register_style( 'custom_css', $template_directory.'/custom.css');
        wp_enqueue_style( 'custom_css' );

        wp_register_style( 'selectmenu', $template_directory.'/css/ui.selectmenu.css', false, '1.1.0' );
        wp_enqueue_style( 'selectmenu' );
        $tfuse_browser_detect = tfuse_browser_body_class();

        if ( $tfuse_browser_detect[0] == 'ie7' )
            wp_enqueue_style('ie7-style', $template_directory.'/css/ie.css');

    }
endif;


if ( ! function_exists( 'tfuse_add_js' ) ) :
    /**
     * This function include files of javascript.
     */
    function tfuse_add_js()
    {
        $template_directory = get_template_directory_uri();

        wp_register_script( 'prettyPhoto', TFUSE_ADMIN_JS . '/jquery.prettyPhoto.js', array('jquery'), '3.1.4', true );
        wp_enqueue_script( 'prettyPhoto' );

        wp_register_script( 'modernizr', $template_directory . '/js/libs/modernizr-2.5.3.min.js',array(), '3.1.4', false );
        wp_enqueue_script( 'modernizr' );

        wp_register_script( 'respond', $template_directory . '/js/libs/respond.min.js',array(), '3.1.4', false );
        wp_enqueue_script( 'respond' );

        wp_enqueue_script( 'jquery' );


        wp_register_script( 'jquery.easing', $template_directory.'/js/jquery.easing.1.3.js', array('jquery'), '1.3', false );
        //wp_enqueue_script( 'jquery.easing' );

        // general.js can be overridden in a child theme by copying it in child theme's js folder
        wp_register_script( 'general', tfuse_get_file_uri('/js/general.js'));
        wp_enqueue_script( 'general' );

        wp_register_script('maps.google.com', 'http://maps.google.com/maps/api/js?sensor=false', array('jquery'), '1.0', true);
        wp_register_script('jquery.gmap', $template_directory . '/js/jquery.gmap.min.js', array('jquery', 'maps.google.com'), '3.3.0', true);

        /*Carousel*/
        wp_register_script( 'jcarousel', $template_directory.'/js/jquery.jcarousel.min.js', array('jquery'), '1.3', false );
        //wp_enqueue_script( 'jcarousel' );

        /*Slides*/
        wp_register_script( 'slides', $template_directory.'/js/slides.min.jquery.js', array('jquery'), '1.3', false );
        //wp_enqueue_script( 'slides' );

        /*infield labels*/
        wp_register_script( 'infieldlabel', $template_directory.'/js/jquery.infieldlabel.min.js', array('jquery'), '1.0.0', false );
        wp_enqueue_script( 'infieldlabel' );

        wp_enqueue_script('jquery-ui-widget');

        wp_register_script( 'ui.selectmenu', $template_directory.'/js/ui.selectmenu.js', array('jquery'), '1.1.0', true );
        wp_enqueue_script( 'ui.selectmenu' );

        wp_register_script( 'styled.selectmenu', $template_directory.'/js/styled.selectmenu.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'styled.selectmenu' );


    }
endif;