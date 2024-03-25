<?php

if ( ! function_exists( 'tfuse_get_header_content' ) ):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * To override tfuse_slider_type() in a child theme, add your own tfuse_slider_type to your child theme's
     * functions.php file.
     */

    function tfuse_get_header_content()
    {
        global $TFUSE, $post, $header_image,$header_map,$quote_before_slider,$header_element,$is_tf_blog_page;
        $posts = $header_element = $header_image = $header_map = $slider = $quote_before_slider = null;

        if ( $is_tf_blog_page)
        {
            $header_element = tfuse_options('header_element_blog');
            if ( 'slider' == $header_element )
            {
                $slider = tfuse_options('select_slider_blog');
                $quote_before_slider = tfuse_options('quote_before_slider_blog');
            }

            elseif ( 'image' == $header_element )
            {
                $header_image['image'] = tfuse_options('header_image_blog');
                $header_image['caption'] = tfuse_options('image_caption_blog');
                $header_image['link_text'] = tfuse_options('link_text_blog');
                $header_image['link_url'] = tfuse_options('link_url_blog');
                $header_image['link_target'] = tfuse_options('link_target_blog');
                $header_image['quote_after_image'] = tfuse_options('quote_after_image_blog');
            }
            elseif ( 'map' == $header_element)
            {
                $header_map['address'] = tfuse_options('map_address_blog');
                $header_map['lat'] = tfuse_options('map_lat_blog');
                $header_map['long'] = tfuse_options('map_long_blog');
                $header_map['zoom'] = tfuse_options('map_zoom_blog');
                $header_map['type'] = tfuse_options('map_type_blog');
            }
        }
        elseif ( is_front_page())
        {
            if(tfuse_options('use_page_options') && tfuse_options('homepage_category')=='page'){
                $page_id = tfuse_options('home_page');
                $header_element = tfuse_page_options('header_element','',$page_id);
                if ( 'slider' == $header_element )
                {
                    $slider = tfuse_page_options('select_slider','',$page_id);
                    $quote_before_slider = tfuse_page_options('quote_before_slider','',$page_id);
                }

                elseif ( 'image' == $header_element )
                {
                    $header_image['image'] = tfuse_page_options('header_image','',$page_id);
                    $header_image['caption'] = tfuse_page_options('image_caption','',$page_id);
                    $header_image['link_text'] = tfuse_page_options('link_text','',$page_id);
                    $header_image['link_url'] = tfuse_page_options('link_url','',$page_id);
                    $header_image['link_target'] = tfuse_page_options('link_target','',$page_id);
                    $header_image['quote_after_image'] = tfuse_page_options('quote_after_image','',$page_id);
                }
                elseif ( 'map' == $header_element)
                {
                    $header_map['address'] = tfuse_page_options('map_address','',$page_id);
                    $header_map['lat'] = tfuse_page_options('map_lat','',$page_id);
                    $header_map['long'] = tfuse_page_options('map_long','',$page_id);
                    $header_map['zoom'] = tfuse_page_options('map_zoom','',$page_id);
                    $header_map['type'] = tfuse_page_options('map_type','',$page_id);
                }
            }
            else{
                $header_element = tfuse_options('header_element');
                if ( 'slider' == $header_element )
                {
                    $slider = tfuse_options('select_slider');
                    $quote_before_slider = tfuse_options('quote_before_slider');
                }

                elseif ( 'image' == $header_element )
                {
                    $header_image['image'] = tfuse_options('header_image');
                    $header_image['caption'] = tfuse_options('image_caption');
                    $header_image['link_text'] = tfuse_options('link_text');
                    $header_image['link_url'] = tfuse_options('link_url');
                    $header_image['link_target'] = tfuse_options('link_target');
                    $header_image['quote_after_image'] = tfuse_options('quote_after_image');
                }
                elseif ( 'map' == $header_element)
                {
                    $header_map['address'] = tfuse_options('map_address');
                    $header_map['lat'] = tfuse_options('map_lat');
                    $header_map['long'] = tfuse_options('map_long');
                    $header_map['zoom'] = tfuse_options('map_zoom');
                    $header_map['type'] = tfuse_options('map_type');
                }
            }
        }
		elseif ( is_singular() )
        {
            $ID = $post->ID;
            $header_element = tfuse_page_options('header_element');
            if ( 'slider' == $header_element )
            {
                $slider = tfuse_page_options('select_slider');
                $quote_before_slider = tfuse_page_options('quote_before_slider');
            }

            elseif ( 'image' == $header_element )
            {
                $header_image['image'] = tfuse_page_options('header_image');
                $header_image['caption'] = tfuse_page_options('image_caption');
                $header_image['link_text'] = tfuse_page_options('link_text');
                $header_image['link_url'] = tfuse_page_options('link_url');
                $header_image['link_target'] = tfuse_page_options('link_target');
                $header_image['quote_after_image'] = tfuse_page_options('quote_after_image');
            }
            elseif ( 'map' == $header_element)
            {
                $header_map['address'] = tfuse_page_options('map_address');
                $header_map['lat'] = tfuse_page_options('map_lat');
                $header_map['long'] = tfuse_page_options('map_long');
                $header_map['zoom'] = tfuse_page_options('map_zoom');
                $header_map['type'] = tfuse_page_options('map_type');
            }

        }
        elseif ( is_category() )
        {
            $ID = get_query_var('cat');
            $header_element = tfuse_options('header_element', null, $ID);
            if ( 'slider' == $header_element )
            {
                $slider = tfuse_options('select_slider', null, $ID);
                $quote_before_slider = tfuse_page_options('quote_before_slider', null, $ID);
            }

            elseif ( 'image' == $header_element )
            {
                $header_image['image'] = tfuse_options('header_image', null, $ID);
                $header_image['caption'] = tfuse_options('image_caption', null, $ID);
                $header_image['link_text'] = tfuse_options('link_text', null, $ID);
                $header_image['link_url'] = tfuse_options('link_url', null, $ID);
                $header_image['link_target'] = tfuse_options('link_target', null, $ID);
                $header_image['quote_after_image'] = tfuse_options('quote_after_image', null, $ID);
            }
            elseif( 'map' == $header_element)
            {
                $header_map['address'] = tfuse_options('map_address', null, $ID);
                $header_map['lat'] = tfuse_options('map_lat', null, $ID);
                $header_map['long'] = tfuse_options('map_long', null, $ID);
                $header_map['zoom'] = tfuse_options('map_zoom', null, $ID);
                $header_map['type'] = tfuse_options('map_type', null, $ID);
            }
        }
        elseif ( is_tax() )
        {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $ID = $term->term_id;
            $header_element = tfuse_options('header_element', null, $ID);
            if ( 'slider' == $header_element )
            {
                $slider = tfuse_options('select_slider', null, $ID);
                $quote_before_slider = tfuse_options('quote_before_slider', null, $ID);
            }

            elseif ( 'image' == $header_element )
            {
                $header_image['image'] = tfuse_options('header_image', null, $ID);
                $header_image['caption'] = tfuse_options('image_caption', null, $ID);
                $header_image['link_text'] = tfuse_options('link_text', null, $ID);
                $header_image['link_url'] = tfuse_options('link_url', null, $ID);
                $header_image['link_target'] = tfuse_options('link_target', null, $ID);
                $header_image['quote_after_image'] = tfuse_options('quote_after_image', null, $ID);
            }
            elseif( 'map' == $header_element)
            {
                $header_map['address'] = tfuse_options('map_address', null, $ID);
                $header_map['lat'] = tfuse_options('map_lat', null, $ID);
                $header_map['long'] = tfuse_options('map_long', null, $ID);
                $header_map['zoom'] = tfuse_options('map_zoom', null, $ID);
                $header_map['type'] = tfuse_options('map_type', null, $ID);
            }
        }

        if ( $header_element == 'image' )
        {
            get_template_part( 'header', 'image' );
            return;
        }
        elseif( $header_element == 'map')
        {
            get_template_part( 'header', 'map');
            return;
        }
        elseif ( !$slider )
            return;

        $slider = $TFUSE->ext->slider->model->get_slider($slider);

        switch ($slider['type']):

            case 'custom':

                if ( is_array($slider['slides']) ) :
                    $slider_image_resize = ( isset($slider['general']['slider_image_resize']) && $slider['general']['slider_image_resize'] == 'true' ) ? true : false;
                    foreach ($slider['slides'] as $k => $slide) :
                        $image = new TF_GET_IMAGE();
                        $slider['slides'][$k]['slide_src'] = $image->width(960)->height(444)->src($slide['slide_src'])->resize($slider_image_resize)->get_src();
                    endforeach;
                endif;

                break;

            case 'posts':
                $args = array( 'post__in' => explode(',',$slider['general']['posts_select']) );

                $args = apply_filters('tfuse_slider_posts_args', $args, $slider);
                $args = apply_filters('tfuse_slider_posts_args_'.$ID, $args, $slider);
                $posts = get_posts($args);
                break;

            case 'tags':
                $args = array( 'tag__in' => explode(',',$slider['general']['tags_select']) );

                $args = apply_filters('tfuse_slider_tags_args', $args, $slider);
                $args = apply_filters('tfuse_slider_tags_args_'.$ID, $args, $slider);
                $posts = get_posts($args);
                break;

            case 'categories':
                $args = 'cat='.$slider['general']['categories_select'].
                    '&posts_per_page='.$slider['general']['sliders_posts_number'];

                $args = apply_filters('tfuse_slider_categories_args', $args, $slider);
                $args = apply_filters('tfuse_slider_categories_args_'.$ID, $args, $slider);
                $posts = get_posts($args);
                break;

        endswitch;

        if ( is_array($posts) ) :
            $slider['slides'] = tfuse_get_slides_from_posts($posts,$slider);
        endif;

        if ( !is_array($slider['slides']) ) return;

        include_once(locate_template( '/theme_config/extensions/slider/designs/'.$slider['design'].'/template.php' ));
    }

endif;
add_action('tfuse_header_content', 'tfuse_get_header_content');


if ( ! function_exists( 'tfuse_get_slides_from_posts' ) ):
    /**
     * aici se schimba pentru fiecare tema spefica de unde ia imaginea, titlul, linkl siderului etc.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * To override tfuse_slider_type() in a child theme, add your own tfuse_slider_type to your child theme's
     * functions.php file.
     */
    function tfuse_get_slides_from_posts( $posts=array(), $slider = array() )
    {
        global $post;

        $slides = array();
        $slider_image_resize = ( isset($slider['general']['slider_image_resize']) && $slider['general']['slider_image_resize'] == 'true' ) ? $slider['general']['slider_image_resize'] : false;

        foreach ($posts as $k => $post) : setup_postdata( $post );

            $tfuse_image = $image = null;

            if ( !$single_image = tfuse_page_options('single_image') ) continue;

            $image = new TF_GET_IMAGE();
            $tfuse_image = $image->width(960)->height(444)->src($single_image)->resize($slider_image_resize)->get_src();

            $slides[$k]['slide_src'] = $tfuse_image;
            $slides[$k]['slide_url'] = get_permalink();
            $slides[$k]['slide_title'] = get_the_title();

            if ( $subtitle = tfuse_page_options('slide_subtitle') )
                $slides[$k]['slide_subtitle'] = $subtitle;
            else
                $slides[$k]['slide_subtitle'] = tfuse_substr( get_the_excerpt(), 50 );

            if ( $slider['design'] == 'play' )
                $slides[$k]['slide_tab_title'] =tfuse_page_options('slide_tab_subtitle');

        endforeach;

        return $slides;
    }
endif;
