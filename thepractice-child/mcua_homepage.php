<?php

/*

Template Name: MCUA Home

*/
    global $is_tf_blog_page,$post,$is_tf_front_page;
    $id_post = $post->ID;
    if(tfuse_options('blog_page') != 0 && $id_post == tfuse_options('blog_page')) $is_tf_blog_page = true;
    get_header();
    if ($is_tf_blog_page)die;
?>
<?php $sidebar_position = tfuse_sidebar_position(); ?>

<div id="middle" <?php tfuse_class('middle'); ?>>

    <div class="content" role="main">

        <article class="post-item post-detail">

                <?php tfuse_custom_title(); ?>
                <div class="entry">

                    <?php while ( have_posts() ) : the_post();
                            the_content();
                            break;
                        endwhile; // end of the loop.
                    ?>

                    <?php tfuse_shortcode_content('after'); ?>
                    <div class="clear"></div>
                </div><!--/ .entry -->
                <?php if (!tfuse_page_options('disable_comments')) : ?>
                <div class="post-meta-bot">
                    <a href="#addcomments" class="link-more"><?php _e('ADD A COMMENT','tfuse'); ?></a>
                </div>
                <?php endif; ?>
                <?php tfuse_comments(); ?>

        </article>

    </div>

        <?php if ( $sidebar_position == 'right' || $sidebar_position == 'left' ) : ?>
        <!-- sidebar -->
        <div class="sidebar">
            <?php get_sidebar(); ?>
        </div>
        <!--/ sidebar -->
        <?php endif; ?>

    <div class="clear"></div>
</div>
</div>
<!--/ middle -->

<?php get_footer(); ?>