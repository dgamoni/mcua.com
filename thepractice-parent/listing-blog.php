<?php
/**
 * The template for displaying posts on archive pages.
 * To override this template in a child theme, copy this file 
 * to your child theme's folder.
 *
 * @since The Practice 1.0
 */
?>

    <article class="post-item">
        <header>
            <div class="date-box"><?php echo get_the_date('F');?> <?php echo get_the_date('j')?></div>
            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        </header>

        <div class="entry">
            <?php tfuse_media(); ?>
            <?php if ( tfuse_options('post_content') == 'content' ) the_content(); else the_excerpt(); ?>
            <div class="clear"></div>
        </div>

        <div class="post-meta">
            <div class="alignleft"><a href="<?php the_permalink(); ?>" class="link-more"><?php _e('Read more', 'tfuse'); ?></a></div>
            <em><?php _e('Posted by','tfuse');?> <span class="author"><?php echo get_the_author();?></span> <span class="separator">|</span> <a href="<?php if (!tfuse_page_options('disable_comments')) { the_permalink();echo '#comments';} else echo '#'; ?>" class="link-comments"><?php comments_number(__('no comments','tfuse'), "1 ".__('comment','tfuse'), "% ".__('comments','tfuse')); ?></a></em>
        </div>
    </article>
