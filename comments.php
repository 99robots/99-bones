<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.  The actual display of comments is
 * handled by a callback to gabfire_comment which is
 * located in the functions.php file.
 */
?>

<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'gabfire' ); ?></p>
	</div><!-- #comments -->

	<?php
	/* Stop the rest of comments.php from being processed,
	 * but don't kill the script entirely -- we still have
	 * to fully load the template.
	 */
	return;
	endif;

		// You can start editing here -- including this comment!
	?>

	<?php if ( have_comments() ) : ?>
		<h3 id="comments-title">
			<?php
			printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'gabfire' ),
			number_format_i18n( get_comments_number() ), '&#34;<span>' . get_the_title() . '</span>&#34;' );
			?>
		</h3>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<div class="navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'gabfire' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'gabfire' ) ); ?></div>
		</div> <!-- /navigation -->
	<?php endif; // check for comment navigation ?>

	<ol class="commentlist">
		<?php
		/* Loop through and list the comments. Tell wp_list_comments()
		 * to use gabfire_comment() to format the comments.
		 * If you want to overload this in a child theme then you can
		 * define gabfire_comment() and that will be used instead.
		 * See gabfire_comment() in includes/theme-comments.php
		 */
		wp_list_comments( array( 'callback' => 'gabfire_comment' ) );
		?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<div class="navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'gabfire' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'gabfire' ) ); ?></div>
		</div> <!-- /navigation -->
	<?php endif; // check for comment navigation ?>

	<?php else : // or, if we don't have comments:

		/* If there are no comments and comments are closed,
		 * let's leave a little note, shall we?
		 */
		if ( ! comments_open() ) :
			/* <p class="nocomments"><?php _e( 'Comments are closed.', 'gabfire' ); ?></p> */
		endif; // end ! comments_open() ?>

	<?php endif; // end have_comments() ?>

	<?php if (get_option('comment_registration') && !$user_ID) : ?>
		<p>
			<?php _e('You must be logged in to post a comment' , 'gabfire'); ?> 
			<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">
				<?php _e('Login' , 'gabfire'); ?>
			</a>
		</p>
	<?php else : ?>

	<?php if ( ! comments_open() ) : ?>
		<?php /* <p class="alert alert-info"><?php _e( 'Comments are closed.' , 'gabfire' ); ?></p> */ ?>
	<?php endif; ?>	
	
	<?php 
	global $required_text, $aria_req, $user_identity, $req, $commenter;
	$args = array(
		'id_form' => 'commentform',
		'id_submit' => 'submit',
		'title_reply' => __( 'Leave a Reply' , 'gabfire' ),
		'title_reply_to' => __( 'Leave a Reply to %s', 'gabfire' ),
		'cancel_reply_link' => __( 'Cancel Reply' , 'gabfire' ),
		'label_submit' => __( 'Post Comment' , 'gabfire' ),
		
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" placeholder="' . __( 'Add your comment', 'gabfire' ) . '" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'gabfire' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'gabfire' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.' , 'gabfire' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after' => '',
		
		'fields' => apply_filters( 'comment_form_default_fields', array(
		'author' => '<div class="form-field-wrapper"><div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span><input class="form-control" id="author" name="author" type="text" placeholder="' . __( 'Name', 'gabfire' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . '/></div></div>',
		
		'email' => '<div class="form-field-wrapper mid-input-item"><div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span><input class="form-control" id="email" name="email" type="text" placeholder="' . __( 'Email', 'gabfire' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' /></div></div>',	
		
		'url' => '<div class="form-field-wrapper"><div class="input-group"><span class="input-group-addon"><i class="fa fa-home"></i></span><input class="form-control" placeholder="' . __( 'Website', 'gabfire' ) . '" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div>' ) ) );	
	
	comment_form($args); ?>

	<?php endif; ?>

</div><!-- #comments -->