<?php get_header(); ?>

<?php $sidebar_position = tfuse_sidebar_position(); ?>

<div id="middle" <?php tfuse_class('middle'); ?>>

    <div class="content" role="main">

            <?php while ( have_posts() ) : the_post(); ?>

                <?php
                        if ( 'cases' == get_post_type()) :
                            get_template_part( 'content', 'case' );
                        else :
                        get_template_part( 'content', 'single' );
                        get_template_part( 'content', 'author' );
                        endif;
                ?>

                <?php tfuse_comments(); ?>

            <?php endwhile; // end of the loop. ?>

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