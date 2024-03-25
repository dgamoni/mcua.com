<?php
if ( ! function_exists( 'tfuse_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own tfuse_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
function tfuse_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;

    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
    ?>
    <li class="post pingback">
        <div id="li-comment-<?php comment_ID() ?>" class="comment-body">

            <p><?php _e( 'Pingback:', 'tfuse' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'tfuse' ), '<span class="edit-link">', '</span>' ); ?></p>
        <div class="comment-entry">
            <?php comment_text() ?>
        </div>
        </div>
    <?php
            break;
        default :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

        <a name="comment-<?php comment_ID() ?>"></a>

        <div id="li-comment-<?php comment_ID() ?>" class="comment-body">

        <div class="comment-avatar">
            <div class="avatar"><?php echo get_avatar( $comment, 72 ); ?></div>
        </div>

        <div class="comment-text">

            <div class="comment-author">
                <a href="#" class="link-author"><?php comment_author_link() ?></a> <span class="comment-date"><?php comment_date('j M Y') ?></span> | <?php comment_reply_link( array_merge( $args, array( 'reply_text' => 'reply', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
            </div>

            <div class="comment-entry">
                <?php comment_text() ?>
            </div>

            <?php if ( $comment->comment_approved == '0' ) : ?>
                <p class='unapproved'><?php _e('Your comment is awaiting moderation.', 'tfuse'); ?></p>
                <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'tfuse' ); ?></em>
                <br />
            <?php endif; ?>

        </div>
        <!-- /.comment-head -->

        <div class="clear"></div>

        </div><!-- /.comment-container -->
        <div id="comment-<?php comment_ID(); ?>"></div>
    <?php
            break;
        endswitch;
}
endif; // ends check for tfuse_comment()
