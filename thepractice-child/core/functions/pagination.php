<?php 

if (!function_exists('tfuse_pagination_child')) :
/**
 * Display pagination to next/previous pages when applicable.
 * 
 * To override tfuse_pagination() in a child theme, add your own tfuse_pagination() 
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */
    function tfuse_pagination_child($query = '', $args = array()){

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
                    <?php $prev_posts = get_previous_posts_link(__('<span><</span>', 'tfuse')); ?>
                    <?php $next_posts = get_next_posts_link(__('<span>></span>', 'tfuse')); ?>
                    <?php if ($prev_posts != '') echo $prev_posts; 
                    else echo '<span class="page_prev" style="background-color: #E6E6E6; background:url(' . $template_directory . 'images/pagination_arrows.png) 0 0 no-repeat; background-position: 0 -38px;" href="javascript:void(0);"><span><</span></span>';?>
                    <?php if ($next_posts != '') echo $next_posts; 
                    else echo '<span class="page_next" style="background-color: #E6E6E6; background:url(' . $template_directory . 'images/pagination_arrows.png) 0 0 no-repeat;" href="javascript:void(0);"><span>></span></span>';?>
                    <?php echo $page_links; ?>
                </div>
            </div>

            <?php
        }
        else
            return $page_links;

    }

endif; // tfuse_pagination 