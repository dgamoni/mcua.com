<?php
/**
 * The template for displaying content in the single.php template.
 * To override this template in a child theme, copy this file 
 * to your child theme's folder.
 *
 * @since The Practice 1.0
 */
?>

 <article class="post-item post-detail">
     

     <header>
         
     </header>


    <div class="entry">

        <?php 


            $date = get_field('odor_date');
            echo $date;
            // $date = new DateTime($date);
            // echo $date->format('j M Y');
        ?>

        <div class="clear"></div>
    </div>



 </article>
<!--/ post item -->

