<?php
/**
 * The template for displaying SlidesJS Slider.
 * To override this template in a child theme, copy this file to your 
 * child theme's folder /theme_config/extensions/slider/designs/slidesjs/
 * 
 * If you want to change style or javascript of this slider, copy files to your 
 * child theme's folder /theme_config/extensions/slider/designs/slidesjs/static/
 * and change get_template_directory() with get_stylesheet_directory()
 */
wp_enqueue_script( 'slides' );
wp_enqueue_script( 'jquery.easing' );

$TFUSE->include->register_type('slider_js_folder', get_template_directory() . '/theme_config/extensions/slider/designs/'.$slider['design'].'/static/js');
$TFUSE->include->js('slidesjs_opt', 'slider_js_folder', 'tf_head',11);
$slider_options = array();
if (isset($slider['general']['slider_randomize'])) $slider_options['randomize'] = true; else $slider_options['randomize'] = false;
if (isset($slider['general']['slider_play'])) $slider_options['play'] = $slider['general']['slider_play']; else $slider_options['play'] = 7000;
if (isset($slider['general']['slider_pause'])) $slider_options['pause'] = $slider['general']['slider_pause']; else $slider_options['pause'] = 7000;
if (isset($slider['general']['slider_hoverPause'])) $slider_options['hoverPause'] = true; else $slider_options['hoverPause'] = false;
if (isset($slider['general']['slider_slideSpeed'])) $slider_options['slideSpeed'] = $slider['general']['slider_slideSpeed']; else $slider_options['slideSpeed'] = 700;
if (isset($slider['general']['slider_slideEasing'])) $slider_options['slideEasing'] = $slider['general']['slider_slideEasing']; else $slider_options['slideEasing'] = 'easeInOutExpo';

$TFUSE->include->js_enq('slider_options', $slider_options);
?>
<!-- top Slider/Image -->
<div class="header_slider">

    <?php global $quote_before_slider;?>
    <?php if (!empty($quote_before_slider)) :?>
    <div class="header_quote">
        <p><?php echo $quote_before_slider; ?></p>
    </div>
    <?php endif;?>
    <!-- header slider -->
    <div class="top_slider">
        <div class="slides_container">

                    <?php foreach ($slider['slides'] as $slide) : ?>
                            <div class="slide">
                                <a href="<?php if(!empty($slide['slide_url'])) { echo $slide['slide_url'];} elseif( !empty($slide['slide_link_url'])){ echo $slide['slide_link_url']; } else { echo '#'; } ?>" target="_self"><img src="<?php echo $slide['slide_src']; ?>" alt=""></a>
                                <?php if (!empty($slide['slide_title']) || !empty($slide['slide_link_text'])) : ?>
                                <?php if (empty($slide['slide_link_url']) || ($slide['slide_link_url']== '') ) $slide['slide_link_url'] = '#'; ?>
                                        <div class="caption">
                                            <p><span><?php echo $slide['slide_title']; ?></span> <?php if(!empty($slide['slide_link_text'])) echo '<a href="' . $slide['slide_link_url'] . '" class="link-more" target="' . $slide['slide_link_target'] . '">' . $slide['slide_link_text'] . '</a></p>'; ?>
                                        </div>
                                <?php endif; ?>
                            </div>
                    <?php endforeach; ?>

        </div>
    </div>
</div>
<!--/ top Slider/Image -->