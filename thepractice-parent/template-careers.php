<?php
/*
Template Name: Careers
*/

get_header();

$sidebar_position = tfuse_sidebar_position();
?>

<div id="middle" <?php tfuse_class('middle'); ?>>

    <div class="content" role="main">

        <article class="post-item post-detail">

            <?php tfuse_custom_title(); ?>


            <div class="entry">

                <?php while ( have_posts() ) : the_post(); ?>

                <?php the_content(); ?>

                <?php endwhile; // end of the loop. ?>

                <?php get_template_part( 'content', 'careers-form' ); ?>

                <?php tfuse_shortcode_content('after'); ?>

                <div class="clear"></div>
            </div><!--/ .entry -->

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