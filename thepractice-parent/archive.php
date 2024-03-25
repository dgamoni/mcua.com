<?php

get_header();

$sidebar_position = tfuse_sidebar_position(); ?>

<!-- middle -->
<div id="middle" <?php tfuse_class('cols2'); ?>>

    <div class="content" role="main">

            <?php if (have_posts()) : $count = 0; ?>

            <?php while (have_posts()) : the_post(); $count++; ?>

                <?php get_template_part('listing', 'blog'); ?>

                <?php endwhile; else: ?>

            <h5><?php _e('Sorry, no posts matched your criteria.', 'tfuse') ?></h5>

            <?php endif; ?>

            <?php tfuse_pagination(); ?>
    </div>
    <!--/ content -->

    <?php if ( $sidebar_position == 'right' || $sidebar_position == 'left' ) : ?>
    <!-- sidebar -->
    <div class="sidebar">
        <?php get_sidebar(); ?>
    </div>
    <!--/ sidebar -->
    <?php endif; ?>

    <div class="clear"></div>
</div>
<!--/ middle -->
</div>
<!--/ container -->

<?php get_footer(); ?>