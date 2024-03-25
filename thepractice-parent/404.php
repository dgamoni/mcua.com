<?php
   header("Status: 301 Moved Permanently");
   header("Location:http://www.mcua.com");
?>
<?php get_header(); ?>
<?php $sidebar_position = tfuse_sidebar_position(); ?>

<div id="middle" <?php tfuse_class('middle'); ?>>

    <div class="content" role="main">

        <article class="post-item post-detail">

                <?php tfuse_custom_title(); ?>


                <div class="entry">
                    <h1><?php _e('404 Error', 'tfuse') ?></h1>
                    <p><?php _e('Page not found', 'tfuse') ?></p>
                    <p><?php _e('The page you were looking for doesn&rsquo;t seem to exist', 'tfuse') ?>.</p>
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