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
         <?php if ( !tfuse_page_options('disable_published_date',false,$post->ID) ) : ?>
         <div class="date-box">
             <?php echo get_the_date('M'); ?> <?php echo get_the_date('j')?>
         </div>
         <?php endif; ?>
         <h1><?php the_title(); ?></h1>
     </header>
    <?php if ( !tfuse_page_options('disable_post_meta') ) : ?>
     <div class="post-meta">
            <?php
            $category = get_the_category();
            $category_id = get_cat_ID( $category[0]->cat_name );
            $category_link = get_category_link( $category_id );
            ?>
         <em class="alignleft"><?php _e('Posted by ','tfuse'); ?><span class="author"><?php the_author(); ?></span> <span class="separator">|</span> <?php _e('filed in','tfuse'); ?>  <a href="<?php echo esc_url( $category_link ); ?>" class="parent"><?php echo $category[0]->cat_name; ?></a></em>
             <?php if ( !tfuse_page_options('disable_comments') )
                    {
                        echo '<a href="'; comments_link(); echo '" class="link-comments">'; comments_number(__('no comments','tfuse'), "1 ".__('comment','tfuse'), "% ".__('comments','tfuse')); echo '</a>';
                    } ?>
    </div>
    <?php endif;?>

    <div class="entry">
        <?php tfuse_media(); ?>
        <?php the_content(); ?>
        <div class="clear"></div>
    </div>

    <?php if ( !tfuse_page_options('disable_share_buttons') || !tfuse_page_options('disable_comments') ) : ?>
    <div class="post-meta-bot">
        <?php if ( !tfuse_page_options('disable_share_buttons') ) : ?>
        <p class="post-share"><span><?php _e('Share this article on','tfuse'); ?>: </span>
            <a href="http://www.facebook.com/sharer.php?u=<?php echo encodeURIComponent(get_permalink());?>%2F&t=<?php echo encodeURIComponent(get_the_title());?>" class="link_share_fb" target="_blank" alt="share this on facebook">&nbsp;</a>
            <a href="http://twitter.com/share?url=<?php the_permalink();?>&amp;text=<?php the_title();?>&amp;count=horiztonal" data-count="horiztonal"  class="link_share_twitter" target="_blank" alt="share this on twitter">&nbsp;</a>
            <a href="mailto:your@email.address" class="link_share_mail" alt="share this with a friend">&nbsp;</a>
        </p>
        <?php endif; ?>
        <?php if (!tfuse_page_options('disable_comments')) : ?>
        <a href="#addcomments" class="link-more"><?php _e('ADD A COMMENT','tfuse'); ?></a>
        <?php endif;?>
    </div>
    <?php endif;?>
    <!--/ post details -->

 </article>
<!--/ post item -->

