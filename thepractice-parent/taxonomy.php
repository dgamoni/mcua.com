<?php get_header();  ?>
<!-- middle -->
<div id="middle" <?php tfuse_class('cols2',false, 'case_categories'); ?>>

    <div class="content" role="main">

        <!--  postlist / cases -->
        <div class="postlist">

        <?php if (have_posts()) : $count = 0; ?>

        <?php while (have_posts()) : the_post(); $count++; ?>

            <?php get_template_part('listing', 'cases'); ?>

            <?php endwhile; else: ?>

        <h5><?php _e('Sorry, no posts matched your criteria.', 'tfuse') ?></h5>

        <?php endif; ?>

        <?php tfuse_pagination(); ?>

        </div>
        <!--/  postlist / cases -->

    </div>
    <!--/ content -->

</div>
<!--/ middle -->
</div>
<!--/ container -->

<?php get_footer(); ?>