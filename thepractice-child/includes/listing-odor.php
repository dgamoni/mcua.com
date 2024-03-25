<?php
/**
 * The template for displaying posts on archive pages.
 * To override this template in a child theme, copy this file 
 * to your child theme's folder.
 *
 * @since The Practice 1.0
 */
?>


<?php 
    $odor_date = get_field('odor_date');
    $odor_time = get_field('odor_time');
    $odor_caller = get_field('odor_caller');


    $odor_street = get_field('odor_street');
    $odor_municipality = get_field('odor_municipality');
    $odor_type = get_field('odor_type');
?>





<div class="table-row">


    <div class="wrapper dates">
        <div class="column date">
            <!-- <a href="<?php the_permalink(); ?>"> -->
            <?php echo $odor_date;?>
            <!-- </a> -->
        </div>
        <div class="column date time"><?php echo $odor_time;?></div>
        <div class="column date time"><?php echo $odor_caller;?></div>
    </div> <!-- end wrapper dates -->

    <div class="wrapper attributes">
      
        <div class="wrapper title-comment-module-reporter">
        
            <div class="wrapper title-comment">
                  <div class="column title"><?php echo $odor_street;?></div>
                  <div class="column comment_"><?php echo $odor_municipality;?></div>
                  <div class="column reporter"><?php echo $odor_type;?></div>
            </div>


        </div>

    </div> <!-- end wrapper attributes -->

</div><!--  end table-row -->


