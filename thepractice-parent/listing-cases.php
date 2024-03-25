<?php
/**
 * The template for displaying posts on archive pages.
 * To override this template in a child theme, copy this file 
 * to your child theme's folder.
 *
 * @since The Practice 1.0
 */
?>
<?php global $post; ?>
<article>
    <figure class="image_frame">
        <a href="<?php the_permalink(); ?>"><?php tfuse_media(false, 'case_categories'); ?></a>
        <?php if ( tfuse_page_options('title', null, $post->ID )  != null ) : ?>
                <figcaption><?php echo tfuse_page_options('title', null, $post->ID ); ?></figcaption>
        <?php endif; ?>
    </figure>

    <section class="summary">
        <h1><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h1>
        <?php if ( tfuse_options('post_content') == 'content' ) the_content(''); else the_excerpt(); ?>
        <div class="post-meta"><a href="<?php the_permalink(); ?>" class="link-more alignleft"><?php _e('Read more','tfuse'); ?></a></div>
    </section>

    <section class="aside">
        <h2><?php _e('The Charges', 'tfuse'); ?>:</h2>
        <p><?php echo tfuse_page_options('charges', null, $post->ID ); ?></p>

        <h2><?php _e('The Verdict','tfuse'); ?>:</h2>
        <p><?php echo tfuse_page_options('verdict', null, $post->ID ); ?></p>
    </section>
    <div class="clear"></div>
</article>
