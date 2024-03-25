<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <title><?php
        if(tfuse_options('disable_tfuse_seo_tab')) {
            wp_title( '|', true, 'right' );
            bloginfo( 'name' );
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) )
                echo " | $site_description";
        } else
            wp_title('');
    ?></title>
    <?php tfuse_meta(); ?>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link href="http://fonts.googleapis.com/css?family=Cardo:400italic,400|Lato:400,400italic,700" rel="stylesheet">
    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- favicon.ico and apple-touch-icon.png -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon-57x57-iphone.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72-ipad.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114-iphone4.png">

    <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri() ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo tfuse_options('feedburner_url', get_bloginfo_rss('rss2_url')); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <?php
        if ( is_singular() && get_option( 'thread_comments' ) )
                wp_enqueue_script( 'comment-reply' );

        tfuse_head();
        wp_head();
    ?>
<style type="text/css">
<!--
@media only screen and (min-width: 900px)  {
	#apollo-bar {
		display: hidden;
		text-align: center;
		margin-bottom: 20px;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
		-webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
		-moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
		border-bottom: 3px solid #fff;
		height: 50px;
}
}
-->
</style>
</head>
<body <?php body_class($class); ?> <?php tfuse_custom_background();?>>
<div class="body_wrap">

    <div class="header_container">
		<?php if(is_front_page()): ?>
    		<div style="text-align: right; padding-right: 60px; font-size: 18px; color: #000;text-decoration: underline;">For odor concerns at any time, please call 732-588-1051.</div>
    		<a href="<?php bloginfo('url'); ?>/odor_reports/" class="home_reports_link">ODOR REPORTS</a>
        <?php endif; ?>
        <header>

            <div class="header_left">
                <div class="logo">
                    <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>"><img src="<?php echo tfuse_logo(); ?>" alt="<?php bloginfo('name'); ?>"  border="0" /></a>
                    <strong><?php bloginfo('name'); ?></strong>
                </div>

            </div>
            <div class="header_right">
                <?php  tfuse_menu('default');  ?>
                <!--/ topmenu -->
            </div>
            <div class="clear"></div>
        </header>
        <?php tfuse_header_content(); ?>
    </div>

<div class="container">
<!--/ header -->
<?php
    global $is_tf_blog_page;
    if($is_tf_blog_page) tfuse_category_on_blog_page();