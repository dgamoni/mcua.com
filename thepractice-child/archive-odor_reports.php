<?php

// odor_reports

get_header();

?>

    <!-- middle -->
    <div id="middle" <?php tfuse_class('cols2'); ?>>

        <div class="content odor_content" role="main">

                <h1>ODOR REPORTS</h1>

                <?php if (have_posts()) : $count = 0; ?>

                    <div class="container-fluid" >
                      
                        <div class="table-row header">
          
                            <div class="wrapper dates">
                                  <div class="column date">Date</div>
                                  <div class="column date time">Time</div>
                                  <div class="column date time">Caller</div>
                            </div>

                            <div class="wrapper attributes">
                                <div class="wrapper title-comment-module-reporter">
                                    <div class="wrapper title-comment">
                                          <div class="column title">Street</div>
                                          <div class="column comment_">Municipality</div>
                                          <div class="column reporter">Odor Type</div>
                                    </div>

                                </div>
                            </div>

                        </div>  <!--     end header     -->   

                        <?php while (have_posts()) : the_post(); $count++; ?>

                            <?php get_template_part('includes/listing', 'odor'); ?>

                        <?php endwhile; ?>

                     </div> <!-- end container-fluid -->

                <?php else: ?>
                        <!-- <h5><?php _e('Sorry, no posts matched your criteria.', 'tfuse') ?></h5> -->
                <?php endif; ?>

                <?php tfuse_pagination(); ?>
        </div>
        <!--/ content -->


        <div class="clear"></div>
    </div>
    <!--/ middle -->


</div>
<!--/ container -->

<?php get_footer(); ?>