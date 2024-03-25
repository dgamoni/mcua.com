jQuery(document).ready(function($) {
    jQuery('.top_slider').slides({
        play: parseInt(tf_script.slider_options.play),
        pause: parseInt(tf_script.slider_options.pause),
        hoverPause: tf_script.slider_options.hoverPause,
        randomize: tf_script.slider_options.randomize,
        generateNextPrev: true,
        effect: 'slide',
        fadeSpeed: 250,
        slideSpeed: parseInt(tf_script.slider_options.slideSpeed),
        slideEasing: tf_script.slider_options.slideEasing,
        preloadImage: 'images/loading.gif'
    });
    // Pagination item width
    var pageItem = jQuery('.top_slider .pagination li');
    var pageItemWidth = 100 / pageItem.length;
    pageItem.css("width",""+ pageItemWidth + "%");
});
