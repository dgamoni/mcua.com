<?php

if (!function_exists('tfuse_browser_body_class')):

/* This Function Add the classes of body_class()  Function
 * To override tfuse_browser_body_class() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
*/

    add_filter('body_class', 'tfuse_browser_body_class');

    function tfuse_browser_body_class() {

        global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

        if ($is_lynx)
            $classes[] = 'lynx';
        elseif ($is_gecko)
            $classes[] = 'gecko';
        elseif ($is_opera)
            $classes[] = 'opera';
        elseif ($is_NS4)
            $classes[] = 'ns4';
        elseif ($is_safari)
            $classes[] = 'safari';
        elseif ($is_chrome)
            $classes[] = 'chrome';
        elseif ($is_IE) {
            $browser = $_SERVER['HTTP_USER_AGENT'];
            $browser = substr("$browser", 25, 8);
            if ($browser == "MSIE 7.0")
                $classes[] = 'ie7';
            elseif ($browser == "MSIE 6.0")
                $classes[] = 'ie6';
            elseif ($browser == "MSIE 8.0")
                $classes[] = 'ie8';
            else
                $classes[] = 'ie';
        }
        else
            $classes[] = 'unknown';

        if ($is_iphone)
            $classes[] = 'iphone';

        return $classes;
    } // End function tfuse_browser_body_class()
endif;


if (!function_exists('tfuse_class')) :
/* This Function Add the classes for middle container
 * To override tfuse_class() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
*/

    function tfuse_class($param, $return = false,$taxonomy = 'category') {
        $tfuse_class = '';
        global $header_element;
        $sidebar_position = tfuse_sidebar_position();
        if (($param == 'middle' || $param == 'cols2') && $taxonomy == 'case_categories')
        {
            if ($header_element == null)
                $tfuse_class = ' class="full_width noimage"';
            else
                $tfuse_class = ' class="full_width"';
        }
        elseif ($param == 'middle' || $param == 'cols2')
            {
                if ($sidebar_position == 'left')
                {
                    if ( $header_element != null && $header_element!= 'none' )    $tfuse_class = ' class="cols2 sidebar_left"';
                    else  $tfuse_class = ' class="cols2 sidebar_left noimage"';

                }

                elseif ($sidebar_position == 'right')
                {
                    if ($header_element != null && $header_element!= 'none' )    $tfuse_class = ' class="cols2 sidebar_right"';
                    else  $tfuse_class = ' class="cols2 sidebar_right noimage"';
                }

                else
                {
                   $tfuse_class = ' class="full_width"';
                }

            }

        if ($return)
            return $tfuse_class;
        else
            echo $tfuse_class;
    }
endif;


if (!function_exists('tfuse_sidebar_position')):
/* This Function Set sidebar position
 * To override tfuse_sidebar_position() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
*/
    function tfuse_sidebar_position() {
        global $TFUSE;

        $sidebar_position = $TFUSE->ext->sidebars->current_position;
        if ( empty($sidebar_position) ) $sidebar_position = 'full';

        return $sidebar_position;
    }

// End function tfuse_sidebar_position()
endif;


if (!function_exists('tfuse_count_post_visits')) :
/**
 * tfuse_count_post_visits.
 * 
 * To override tfuse_count_post_visits() in a child theme, add your own tfuse_count_post_visits() 
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */

    function tfuse_count_post_visits()
    {
        if ( !is_single() ) return;

        global $post;

        $tfuse_count =  get_post_meta($post->ID, TF_THEME_PREFIX . '_post_viewed', true);
        if ( empty($tfuse_count) ) $tfuse_count = 0;

        $popularArr = ( !empty( $_COOKIE['popular']) ) ? explode(',', $_COOKIE['popular']) : array();

        if ( !in_array($post->ID, $popularArr) )
        {
            update_post_meta($post->ID, TF_THEME_PREFIX . '_post_viewed', ++$tfuse_count);
            $popularArr[] = $post->ID;
            @setcookie('popular', implode(',', $popularArr),0,'/');
        }
    }
    add_action('wp_head', 'tfuse_count_post_visits');

// End function tfuse_count_post_visits()
endif;


if (!function_exists('tfuse_custom_title')):

    function tfuse_custom_title() {
        global $post,$front_page;
        $ID=$post->ID;
        $tfuse_title_type = tfuse_page_options('page_title');
        if ( $front_page )  {
            $page_id = tfuse_options('home_page');
            $tfuse_title_type = tfuse_page_options('page_title','',$page_id);
            $ID =$page_id;
        }

        if ($tfuse_title_type == 'hide_title')
            $title = '';
        elseif ($tfuse_title_type == 'custom_title')
            $title = tfuse_page_options('custom_title','',$ID);
        else
            $title = get_the_title($ID);

        echo ( $title ) ? '<h1>' . $title . '</h1>' : '';
    }

endif;

if (!function_exists('tfuse_archive_custom_title')):
/**
 *  Set the name of post archive.
 *
 * To override tfuse_archive_custom_title() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */

    function tfuse_archive_custom_title()
    {
        $cat_ID = 0;
        if ( is_category() )
        {
            $cat_ID = get_query_var('cat');
            $title = single_term_title( '', false );
        }
        elseif ( is_tax() )
        {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $cat_ID = $term->term_id;
            $title = single_term_title( $term->name , false );
        }
        elseif ( is_post_type_archive() )
        {
            $title = post_type_archive_title('',false);
        }

        $tfuse_title_type = tfuse_options('page_title',null,$cat_ID);

        if ($tfuse_title_type == 'hide_title')
            $title = '';
        elseif ($tfuse_title_type == 'custom_title')
            $title = tfuse_options('custom_title',null,$cat_ID);

        echo !empty($title) ? '<h1>' . $title . '</h1>' : '';
    }

endif;



if (!function_exists('tfuse_user_profile')) :
/**
 * Retrieve the requested data of the author of the current post.
 *  
 * @param array $fields first_name,last_name,email,url,aim,yim,jabber,facebook,twitter etc.
 * @return null|array The author's spefified fields from the current author's DB object.
 */
    function tfuse_user_profile( $fields = array() )
    {
        $tfuse_meta = null;

        // Get stnadard user contact info
        $standard_meta = array(
            'first_name' => get_the_author_meta('first_name'),
            'last_name' => get_the_author_meta('last_name'),
            'email'     => get_the_author_meta('email'),
            'url'       => get_the_author_meta('url'),
            'aim'       => get_the_author_meta('aim'),
            'yim'       => get_the_author_meta('yim'),
            'jabber'    => get_the_author_meta('jabber')
        );

        // Get extended user info if exists
        $custom_meta = (array) get_the_author_meta('theme_fuse_extends_user_options');

        $_meta = array_merge($standard_meta,$custom_meta);

        foreach ($_meta as $key => $item) {
            if ( !empty($item) && in_array($key, $fields) ) $tfuse_meta[$key] = $item;
        }

        return apply_filters('tfuse_user_profile', $tfuse_meta, $fields);
    }

endif;


if (!function_exists('tfuse_action_comments')) :
/**
 *  This function disable post commetns.
 *
 * To override tfuse_action_comments() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */

    function tfuse_action_comments() {
        global $post;
        if (!tfuse_page_options('disable_comments'))
            comments_template( '', true );
    }

    add_action('tfuse_comments', 'tfuse_action_comments');
endif;


if (!function_exists('tfuse_get_comments')):
/**
 *  Get post comments for a specific post.
 *
 * To override tfuse_get_comments() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */

    function tfuse_get_comments($return = TRUE, $post_ID) {
        $num_comments = get_comments_number($post_ID);

        if (comments_open($post_ID)) {
            if ($num_comments == 0) {
                $comments = __('No Comments');
            } elseif ($num_comments > 1) {
                $comments = $num_comments . __(' Comments');
            } else {
                $comments = "1 Comment";
            }
            $write_comments = '<a class="link-comments" href="' . get_comments_link() . '">' . $comments . '</a>';
        } else {
            $write_comments = __('Comments are off');
        }
        if ($return)
            return $write_comments;
        else
            echo $write_comments;
    }

endif;


if (!function_exists('tfuse_pagination')) :
/**
 * Display pagination to next/previous pages when applicable.
 * 
 * To override tfuse_pagination() in a child theme, add your own tfuse_pagination() 
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */
    function tfuse_pagination($query = '', $args = array()){

        global $wp_rewrite, $wp_query;
        $template_directory = get_template_directory_uri() . '/';

        if ( $query ) {

            $wp_query = $query;

        } // End IF Statement


        /* If there's not more than one page, return nothing. */
        if ( 1 >= $wp_query->max_num_pages )
            return false;

        /* Get the current page. */
        $current = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );

        /* Get the max number of pages. */
        $max_num_pages = intval( $wp_query->max_num_pages );

        /* Set up some default arguments for the paginate_links() function. */
        $defaults = array(
            'base' => add_query_arg( 'paged', '%#%' ),
            'format' => '',
            'total' => $max_num_pages,
            'current' => $current,
            'prev_next' => false,
            'show_all' => false,
            'end_size' => 2,
            'mid_size' => 1,
            'add_fragment' => '',
            'type' => 'plain',
            'before' => '',
            'after' => '',
            'echo' => true,
        );

        /* Add the $base argument to the array if the user is using permalinks. */
        if( $wp_rewrite->using_permalinks() )
            $defaults['base'] = user_trailingslashit( trailingslashit( get_pagenum_link() ) . 'page/%#%' );

        /* If we're on a search results page, we need to change this up a bit. */
        if ( is_search() ) {
            $search_permastruct = $wp_rewrite->get_search_permastruct();
            if ( !empty( $search_permastruct ) )
                $defaults['base'] = user_trailingslashit( trailingslashit( get_search_link() ) . 'page/%#%' );
        }

        /* Merge the arguments input with the defaults. */
        $args = wp_parse_args( $args, $defaults );

        /* Don't allow the user to set this to an array. */
        if ( 'array' == $args['type'] )
            $args['type'] = 'plain';

        /* Get the paginated links. */
        $page_links = paginate_links( $args );

        /* Remove 'page/1' from the entire output since it's not needed. */
        $page_links = str_replace( array( '&#038;paged=1\'', '/page/1\'' ), '\'', $page_links );

        /* Wrap the paginated links with the $before and $after elements. */
        $page_links = $args['before'] . $page_links . $args['after'];

        /* Return the paginated links for use in themes. */
        if ( $args['echo'] )
        {
            ?>
        <!-- pagination -->
	    	<div class="tf_pagination">
	            <div class="inner">
                    <?php $prev_posts = get_previous_posts_link(__('<span>NEWER</span>', 'tfuse')); ?>
                    <?php $next_posts = get_next_posts_link(__('<span>OLDER</span>', 'tfuse')); ?>
                    <?php if ($prev_posts != '') echo $prev_posts; else echo '<a class="page_prev" style="background-color: #E6E6E6; background:url(' . $template_directory . 'images/pagination_arrows.png) 0 0 no-repeat; background-position: 0 -38px;" href="javascript:void(0);"><span>OLDER</span></a>';?>
                    <?php if ($next_posts != '') echo $next_posts; else echo '<a class="page_next" style="background-color: #E6E6E6; background:url(' . $template_directory . 'images/pagination_arrows.png) 0 0 no-repeat;" href="javascript:void(0);"><span>NEWER</span></a>';?>
                    <?php echo $page_links; ?>
                </div>
            </div>

            <?php
        }
        else
            return $page_links;

    }

endif; // tfuse_pagination


if (!function_exists('next_posts_link_css')) :
    /**
     * Display pagination to next/previous pages when applicable.
     *
     * To override next_posts_link_css() in a child theme, add your own next_posts_link_css()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */
    function next_posts_link_css() {

        return 'class="page_next"';
    }
    add_filter('next_posts_link_attributes', 'next_posts_link_css' );
endif;


if (!function_exists('previous_posts_link_css')) :
    /**
     * Display pagination to next/previous pages when applicable.
     *
     * To override previous_posts_link_css() in a child theme, add your own previous_posts_link_css()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */
    function previous_posts_link_css() {

        return 'class="page_prev"';
    }
    add_filter('previous_posts_link_attributes', 'previous_posts_link_css' );
endif; // tfuse_pagination

if (!function_exists('tfuse_shortcode_content')) :
/**
 *  Get post comments for a specific post.
 *
 * To override tfuse_shortcode_content() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */

    function tfuse_shortcode_content($position = '', $return = false)
    {
        $page_shortcodes = '';

        $position = ( $position == 'before' ) ? 'content_top' : 'content_bottom';
        global $is_tf_front_page,$is_tf_blog_page;
        if ($is_tf_blog_page) {
            $position = $position.'_blog';
            $page_shortcodes = tfuse_options($position);
        }
        elseif ($is_tf_front_page) {
            if(tfuse_options('use_page_options') && tfuse_options('homepage_category')=='page'){
                $page_id = tfuse_options('home_page');
                $page_shortcodes = tfuse_page_options($position,'',$page_id);
            }
            else
                $page_shortcodes = tfuse_options($position);
        }
        elseif (is_singular()) {
            global $post;
            $page_shortcodes = tfuse_page_options($position);
        } elseif (is_category()) {
            $cat_ID = get_query_var('cat');
            $page_shortcodes = tfuse_options($position, '', $cat_ID);
        } elseif (is_tax()) {
            $taxonomy = get_query_var('taxonomy');
            $term = get_term_by('slug', get_query_var('term'), $taxonomy);
            $cat_ID = $term->term_id;
            $page_shortcodes = tfuse_options($position, '', $cat_ID);
        }

        $page_shortcodes = tfuse_qtranslate($page_shortcodes);

        $page_shortcodes = apply_filters('themefuse_shortcodes', $page_shortcodes);

        if ($return)
            return $page_shortcodes; else
            echo $page_shortcodes;
    }

// End function tfuse_shortcode_content()
endif;


if (!function_exists('tfuse_category_on_front_page')) :
    /**
     * Dsiplay homepage category
     *
     * To override tfuse_category_on_front_page() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_category_on_front_page()
    {
        if ( !is_front_page() ) return;

        global $is_tf_front_page,$homepage_categ;
        $is_tf_front_page = false;

        $homepage_category = tfuse_options('homepage_category');
        $homepage_category = explode(",",$homepage_category);
        foreach($homepage_category as $homepage)
        {
            $homepage_categ = $homepage;
        }

        if($homepage_categ == 'specific')
        {
            $is_tf_front_page = true;
            $archive = 'archive.php';
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $specific = tfuse_options('categories_select_categ');

            $items = get_option('posts_per_page');
            $ids = explode(",",$specific);
            $posts = array(); $num_post = 0;
            foreach ($ids as $id){
                $posts[] = get_posts(array('category' => $id));
            }
            foreach($posts as $post)
            {
                $num_posts = count($post);
                $num_post += $num_posts;
            }
            $max = $num_post/$items;
            if($num_posts%$items) $max++;

            $args = array(
                'cat' => $specific,
                'orderby' => 'date',
                'paged' => $paged
            );
            query_posts($args);


            wp_localize_script(
                'tf-load-posts',
                'nr_posts',
                array(
                    'max' => $max
                )
            );

            include_once(locate_template($archive));

            return;
        }
        elseif($homepage_categ == 'page')
        {
            global $front_page;
            $is_tf_front_page = true;
            $front_page = true;
            $archive = 'page.php';
            $page_id = tfuse_options('home_page');

            $args=array(
                'page_id' => $page_id,
                'post_type' => 'page',
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'ignore_sticky_posts'=> 1
            );
            query_posts($args);
            include_once(locate_template($archive));
            wp_reset_query();
            return;
        }
        elseif($homepage_categ == 'all')
        {
            $archive = 'archive.php';

            $is_tf_front_page = true;
            wp_reset_postdata();
            include_once(locate_template($archive));
            return;
        }

    }

// End function tfuse_category_on_front_page()
endif;

if (!function_exists('tfuse_category_on_blog_page')) :
    /**
     * Dsiplay blogpage category
     *
     * To override tfuse_category_on_blog_page() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_category_on_blog_page()
    {
        global $is_tf_blog_page,$blogpage_categ;
        if ( !$is_tf_blog_page ) return;
        $is_tf_blog_page = false;

        $blogpage_category = tfuse_options('blogpage_category');
        $blogpage_category = explode(",",$blogpage_category);
        foreach($blogpage_category as $blogpage)
        {
            $blogpage_categ = $blogpage;
        }

        if($blogpage_categ == 'specific')
        {
            $is_tf_blog_page = true;
            $archive = 'archive.php';
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $specific = tfuse_options('categories_select_categ_blog');

            $items = get_option('posts_per_page');
            $ids = explode(",",$specific);
            $posts = array(); $num_post = 0;
            foreach ($ids as $id){
                $posts[] = get_posts(array('category' => $id));
            }
            foreach($posts as $post)
            {
                $num_posts = count($post);
                $num_post += $num_posts;
            }
            $max = $num_post/$items;
            if($num_posts%$items) $max++;

            $args = array(
                'cat' => $specific,
                'orderby' => 'date',
                'paged' => $paged
            );
            query_posts($args);
            wp_localize_script(
                'tf-load-posts',
                'nr_posts',
                array(
                    'max' => $max
                )
            );
            include_once(locate_template($archive));
            return;
        }
        elseif($blogpage_categ == 'all')
        {
            $is_tf_blog_page = true;
            $archive = 'archive.php';
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $categories = get_categories();

            $ids = array();
            foreach($categories as $cats){
                $ids[] = $cats -> term_id;
            }
            $items = get_option('posts_per_page');
            $posts = array(); $num_post = 0;

            foreach ($ids as $id){
                $posts[] = get_posts(array('category' => $id));
            }
            foreach($posts as $post)
            {
                $num_posts = count($post);
                $num_post += $num_posts;
            }
            $max = $num_post/$items;
            if($num_posts%$items) $max++;

            $args = array(
                'orderby' => 'date',
                'paged' => $paged
            );
            query_posts($args);
            wp_localize_script(
                'tf-load-posts',
                'nr_posts',
                array(
                    'max' => $max
                )
            );
            include_once(locate_template($archive));
            return;
        }
    }
// End function tfuse_category_on_blog_page()
endif;


if (!function_exists('tfuse_action_footer')) :
/**
 * Dsiplay footer content
 *
 * To override tfuse_action_footer() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */

    function tfuse_action_footer() {

        if ( !tfuse_options('enable_footer_shortcodes') ) {
            ?>
            <div class="fcol f_col_1">
                <?php dynamic_sidebar('footer-1'); ?>
            </div><!--/ f_col_1 -->

            <div class="fcol f_col_2">
                <?php dynamic_sidebar('footer-2'); ?>
            </div><!--/ f_col_2 -->

            <div class="fcol f_col_3">
                <?php dynamic_sidebar('footer-3'); ?>
            </div><!--/ f_col_3 -->

            <div class="fcol f_col_4">
                <?php dynamic_sidebar('footer-4'); ?>
            </div><!--/ f_col_4 -->

            <div class="fcol f_col_5">
                <?php dynamic_sidebar('footer-5'); ?>
            </div><!--/ f_col_5 -->

            <?php
        } else {
            $footer_shortcodes = tfuse_options('footer_shortcodes');
            echo $page_shortcodes = apply_filters('themefuse_shortcodes', $footer_shortcodes);
        }
    }

    add_action('tfuse_footer', 'tfuse_action_footer');
endif;


if (!function_exists('tfuse_footer_support')) :
    /**
     * Dsiplay footer support
     *
     * To override tfuse_footer_support() in a child theme, add your own tfuse_footer_support()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_footer_support() {
        if ( tfuse_options('enable_footer_support') && tfuse_options('footer_support') != '' ) {

            echo tfuse_options('footer_support');

        }
    }

endif;


if (!function_exists('tfuse_comment_reply_link_filter')) :
    /**
     * Dsiplay comment reply link
     *
     * To override tfuse_comment_reply_link_filter() in a child theme, add your own tfuse_comment_reply_link_filter()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_comment_reply_link_filter( $output_reply_link = '') {

        $output_reply_link = str_replace( "class='comment-reply-link'", "class='link-reply'", $output_reply_link );

        return $output_reply_link;
    }
add_filter('comment_reply_link', 'tfuse_comment_reply_link_filter');
endif;


if (!function_exists('tfuse_register_link_filter')) :
    /**
     * Dsiplay register link
     *
     * To override tfuse_footer_support() in a child theme, add your own tfuse_footer_support()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_register_link_filter( $output_register_link = '') {

        $output_register_link = str_replace( "\">", "\"><span>", $output_register_link );
        $output_register_link = str_replace( "</a></li>", "</span></a></li>", $output_register_link );

        return $output_register_link;
    }
    add_filter('register', 'tfuse_register_link_filter');
endif;


if (!function_exists('tfuse_loginout_link_filter')) :
    /**
     * Dsiplay loginout link
     *
     * To override tfuse_loginout_link_filter() in a child theme, add your own tfuse_loginout_link_filter()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_loginout_link_filter( $output_loginout_link = '') {

        $output_loginout_link = str_replace( "\">", "\"><span>", $output_loginout_link );
        $output_loginout_link = str_replace( "</a>", "</span></a>", $output_loginout_link );

        return $output_loginout_link;
    }
    add_filter('loginout', 'tfuse_loginout_link_filter');
endif;


if (!function_exists('tfuse_to_top_enabled')) :
    /**
     * Display scroll
     *
     * To override tfuse_to_top_enabled() in a child theme, add your own tfuse_to_top_enabled()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_to_top_enabled() {

        if (!tfuse_options('disable_to_top'))
        {
            ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                // call scroll to top
                jQuery().UItoTop({ easingType: 'easeOutQuart' });
            });
        </script>
        <?php
        }

    }
    add_action('wp_footer', 'tfuse_to_top_enabled');
endif;




if (!function_exists('custom_excerpt_more')) :
    /**
     * Custom excerpt more
     *
     * To override custom_excerpt_more() in a child theme, add your own custom_excerpt_more()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function custom_excerpt_more() {

       $more = '...&nbsp;<a href="' . get_permalink() . '" class="link-more">READ MORE</a>';
        return $more;
    }
    add_filter( 'excerpt_more', 'custom_excerpt_more' );
endif;


if (!function_exists('tfuse_social_contact')) :
    /**
     * Dsiplay social contacts
     *
     * To override tfuse_social_contact() in a child theme, add your own tfuse_social_contact()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_social_contact()
    {

        if(tfuse_options('facebook') || tfuse_options('twitter') || tfuse_options('devian') || tfuse_options('flickr'))
        { ?>
            <div class="social_content">
            <span><?php _e('Also, you can find me on:','tfuse'); ?></span>
                <?php if (tfuse_options('facebook')) { ?> <a href="<?php echo tfuse_options('facebook'); ?>" target="_blank" class="social_icon_1"><?php _e('Facebook','tfuse'); ?></a> <?php } ?>
                <?php if (tfuse_options('twitter')) { ?>  <a href="<?php echo tfuse_options('twitter'); ?>" target="_blank" class="social_icon_2"><?php _e('Twitter','tfuse'); ?></a> <?php } ?>
                <?php if (tfuse_options('devian')) { ?>  <a href="<?php echo tfuse_options('devian'); ?>" target="_blank" class="social_icon_3"><?php _e('Devian Art','tfuse'); ?></a> <?php } ?>
                <?php if (tfuse_options('flickr')) { ?>    <a href="<?php echo tfuse_options('flickr'); ?>" target="_blank" class="social_icon_4"><?php _e('Flickr','tfuse'); ?></a> <?php } ?>
            </div>
      <?php }
    }

endif;


if (!function_exists('tfuse_custom_style')) :
    /**
     * Dsiplay custom style
     *
     * To override tfuse_custom_style() in a child theme, add your own tfuse_custom_style()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_custom_style($param = '')
    {
        if ( $param  == 'header')
        {
            if (tfuse_options('header_color'))
            {
                echo 'style="background-color:' . tfuse_options('header_color') . '"';
            }
        }
        elseif ( $param  == 'footer' )
        {
            if (tfuse_options('bottom_color'))
            {
                echo 'style="background-color:' . tfuse_options('bottom_color') . '"';
            }
        }
    }

endif;



if (!function_exists('tfuse_loveit')) :
    /**
     * Dsiplay love it
     *
     * To override tfuse_loveit() in a child theme, add your own tfuse_loveit()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_loveit($id = '')
    {

        $count1 = 0;
        if (is_numeric($id))
        {
            $count = get_post_meta($id,'tfuse_love_it', true);
        }
        if( $count == '' ) $count = $count1;

        echo '<input type="hidden" class="love_it_hidden" id="hidden_' . $id . '" value="' . $count .'">';

    }

endif;

if (!function_exists('tfuse_loved_class')) :
    /**
     * Dsiplay love it
     *
     * To override tfuse_loved_class() in a child theme, add your own tfuse_loved_class()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_loved_class($id = 0,$param = 'class')
    {
        if (isset($_COOKIE['tfuse_loves']))
        {
            $loves = explode(";", $_COOKIE['tfuse_loves']);

            if (in_array($id, $loves) )
            {
                if ($param == 'class') _e(' tfuse_loved','tfuse');
                else _e('Loved','tfuse');
            }
            else
            {
                if ($param == 'html') _e('Love it','tfuse');
                else  echo '';
            }
        }
        else
        {
            if ($param == 'html') _e('Love it','tfuse');
            else echo '';

        }

    }

endif;


if (!function_exists('tfuse_shorten_string')) :
    /**
     *
     *
     * To override tfuse_shorten_string() in a child theme, add your own tfuse_shorten_string()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

function tfuse_shorten_string($string, $wordsreturned)

{
    $retval = $string;

    $array = explode(" ", $string);
    if (count($array)<=$wordsreturned)

    {
        $retval = $string;
    }
    else

    {
        array_splice($array, $wordsreturned);
        $retval = implode(" ", $array)." ...";
    }
    return $retval;
}

endif;

function tfuse_custom_background()
{
    $template_directory = get_template_directory_uri() . '/';

    $color = tfuse_options('background_color') ? tfuse_options('background_color') : false;
    $pattern = tfuse_options('background_pattern') ? tfuse_options('background_pattern') : false;

    if ( !$pattern && !$color )
    {
        $pattern = $template_directory . 'images/pattern_1.png';
        $color = '#dadada';
    }

    if (isset($_GET['image'])) $pattern = $template_directory . 'images/' . $_GET['image'];
    if (isset($_GET['color']) ) $color =  '#' . $_GET['color'];

    $html = ' style="';
    if ($color) $html .= 'background-color:' . $color . ';';
    if ($pattern) $html .= 'background-image:url(' . $pattern . ');';
    $html .= '"';

    echo $html;
}

if (!function_exists('encodeURIComponent')) :
    /**
     *
     *
     * To override encodeURIComponent() in a child theme, add your own encodeURIComponent()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

function encodeURIComponent($str) {
    $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
    return strtr(rawurlencode($str), $revert);
}

endif;


if (!function_exists('tfuse_excerpt_more')) :
    /**
     *
     *
     * To override tfuse_excerpt_more() in a child theme, add your own tfuse_excerpt_more()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_excerpt_more( $more ) {
        return '.';
    }
    add_filter('excerpt_more', 'tfuse_excerpt_more');

endif;



if (!function_exists('tfuse_custom_posts_per_page')) :
    /**
     *
     *
     * To override tfuse_custom_posts_per_page() in a child theme, add your own tfuse_custom_posts_per_page()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_custom_posts_per_page($query)
    {
        $tax_name = '';
        if(isset($query->tax_query->queries[0]['taxonomy'])) $tax_name = $query->tax_query->queries[0]['taxonomy'];
        if ( 'case_categories' == $tax_name)
          {
              $query->query_vars['posts_per_page'] = tfuse_options('cases_per_page',4);
          }

        return $query;
    }

        add_filter( 'pre_get_posts', 'tfuse_custom_posts_per_page' );


endif;

if (!function_exists('tfuse_social_footer')) :
    /**
     *
     *
     * To override tfuse_social_footer() in a child theme, add your own tfuse_social_footer()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

        function tfuse_social_footer()
            {
                $rss_url = tfuse_options('feedburner_url',null);
                $fb_url = tfuse_options('facebook',null);
                $twitter_url = tfuse_options('twitter',null);

                ?>
                <?php if( ($rss_url == null) && ($fb_url == null) && ($twitter_url == null) ) return; ?>
                <div class="footer_social">
                    <strong><?php _e('Follow us on','tfuse'); ?>:</strong>
                    <?php if ( $fb_url != null){?><a href="<?php echo $fb_url; ?>" class="link-fb"><?php _e('Facebook','tfuse'); ?></a><?php } ?>
                    <?php if ( $twitter_url != null){?><a href="<?php echo $twitter_url; ?>" class="link-twitter"><?php _e('Twitter','tfuse'); ?></a><?php } ?>
                    <?php if ( $rss_url != null){?><a href="<?php echo $rss_url; ?>" class="link-rss"><?php _e('RSS','tfuse'); ?></a><?php } ?>
                </div>
      <?php }
endif;

if ( !function_exists('tfuse_img_content')):

    function tfuse_img_content(){
        $content = $link = '';
		$args = array(
			'numberposts'     => -1,
		); 
        $posts_array = get_posts( $args );
        $option_name = 'thumbnail_image';
		foreach($posts_array as $post):
                    
                    if(tfuse_page_options('thumbnail_image',false,$post->ID)) continue;
			$args = array(
			 'post_type' => 'attachment',
			 'numberposts' => -1,
			 'post_parent' => $post->ID
			); 
			$attachments = get_posts($args);
			if ($attachments) {
			 foreach ($attachments as $attachment) { 
                            $value = $attachment->guid; 
                            tfuse_set_page_option($option_name, $value, $post->ID);
                            tfuse_set_page_option('disable_image', true , $post->ID); 
                         }
			}
                        else
                        {
                            $content = $post->post_content;
                                if(!empty($content))
                                {   
                                    preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $content,$matches);
                                    $link = $matches[1]; 
                                    tfuse_set_page_option($option_name, $link , $post->ID);
                                    tfuse_set_page_option('disable_image', true , $post->ID);
                                }
                        }
                        
		endforeach;
                tfuse_set_option('enable_content_img',false, $cat_id = NULL);
    }
endif;

if ( tfuse_options('enable_content_img'))
{ 
    add_action('tfuse_head','tfuse_img_content');
}

if(function_exists('qtrans_convertURL'))    add_filter('post_type_link', 'qtrans_convertURL');
?>