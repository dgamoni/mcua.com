<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to tfuse_comment() which is
 * located in the functions.php file.
 *
 */
?>
        
    <div class="comment-list" id="comments">

    <?php if ( post_password_required() ) : ?>
    <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'tfuse' ); ?></p>
    </div><!-- #comments -->
<?php
    /* Stop the rest of comments.php from being processed,
    * but don't kill the script entirely -- we still have
    * to fully load the template.
    */
    return;
endif;
?>

<?php // You can start editing here -- including this comment! ?>

<?php if ( have_comments() ) : ?>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
    <nav id="comment-nav-above">
        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Newer Comments', 'tfuse' ) ); ?></div>
        <div class="nav-next"><?php next_comments_link( __( 'Older Comments &rarr;', 'tfuse' ) ); ?></div>
    </nav>
    <?php endif; // check for comment navigation ?>

<ol>
    <?php
    /* Loop through and list the comments. Tell wp_list_comments()
    * to use tfuse_comment() to format the comments.
    * If you want to overload this in a child theme then you can
    * copy file comments-template.php to child theme or
    * define your own tfuse_comment() and that will be used instead.
    * See tfuse_comment() in comments-template.php for more.
    */
    get_template_part( 'comments', 'template' );
    wp_list_comments( array( 'callback' => 'tfuse_comment' ) );

    ?>
</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
    <nav id="comment-nav-below">
        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'tfuse' ) ); ?></div>
        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'tfuse' ) ); ?></div>
    </nav>
    <?php endif; // check for comment navigation ?>

<?php elseif ( comments_open() ) : // If comments are open, but there are no comments ?>

<p class="nocomments"><?php _e('No comments yet.', 'tfuse') ?></p>

<?php endif; ?>
<div id="respond">
    <!-- add comment -->
    <div class="add-comment" id="addcomments">
        <h3><?php _e('Leave a Comment', 'tfuse') ?> <?php cancel_comment_reply_link('(CANCEL REPLY)'); ?></h3>

        <div class="comment-form">

            <?php if ( get_option('comment_registration') && !$user_ID ) : //If registration required & not logged in. ?>

            <p><?php _e('You must be', 'tfuse') ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in', 'tfuse') ?></a> <?php _e('to post a comment.', 'tfuse') ?></p>

            <?php else : //No registration required ?>

            <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentForm">

                <?php if ( $user_ID ) : //If user is logged in ?>

                <p><?php _e('Logged in as', 'tfuse') ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(); ?>" title="<?php _e('Log out of this account', 'tfuse') ?>"><?php _e('Logout', 'tfuse') ?> &raquo;</a></p>

                <?php else : //If user is not logged in ?>

                <div class="row alignleft infieldlabel">
                    <label for="name"><strong><?php _e('Name', 'tfuse') ?> *</strong></label>
                    <input type="text" name="author" id="name" value="<?php echo $comment_author; ?>" class="inputtext input_middle required"  tabindex="1" />
                </div>

                <div class="space"></div>

                <div class="row alignleft infieldlabel">
                    <label for="email"><strong><?php _e( 'Email', 'tfuse'); ?></strong> <?php  _e( '(never published)', 'tfuse' ); ?></label>
                    <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" class="inputtext input_middle required"  tabindex="2" />
                </div>

                <div class="clear"></div>

                <?php endif; // End if logged in ?>

                <div class="row infieldlabel">
                    <label for="message"><strong><?php _e('Comment *','tfuse'); ?></strong></label>
                    <textarea cols="30" rows="10" name="comment" id="message" class="textarea textarea_middle required" tabindex="4"></textarea>
                </div>

                <div class="row rowSubmit">
                    <input name="submit" type="submit" id="submit" class="btn-submit" value="<?php _e('SEND MESSAGE', 'tfuse') ?>" />
                    <a onclick="document.getElementById('commentForm').reset();return false" href="#" class="link-reset"><?php _e('reset all fields','tfuse')?></a>
                    <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
                </div>

                <?php comment_id_fields(); ?>
                <?php do_action('comment_form', $post->ID); ?>

            </form><!-- /#commentform -->

            <?php endif; // If registration required ?>

        </div>

    </div>
    <!--/add comment -->
</div><!-- /#respond -->
</div>
