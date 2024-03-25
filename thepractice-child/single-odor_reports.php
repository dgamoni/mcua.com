<?php get_header(); ?>


<div id="middle" <?php tfuse_class('middle'); ?>>

    <div class="content odor_content" role="main">

        <h1>ODOR REPORTS</h1>

            <?php while ( have_posts() ) : the_post(); ?>

                <?php

                    get_template_part( 'includes/content', 'single-odor' );

                ?>

            <?php endwhile; // end of the loop. ?>

    </div>
    <!--/ content -->


    <div class="clear"></div>
</div>
<!--/ middle -->
</div>
<!--/ container -->
<?php get_footer(); ?>