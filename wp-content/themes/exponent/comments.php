<?php
/**
 * The template for displaying Comments.
 */
	
 $comment_form_args = exponent_get_comment_form_args();
?>

	<?php do_action( 'be_themes_before_comments' ); ?>

	<div id="comments" class="<?php echo be_themes_get_class( 'comments', have_comments() ? 'comments-with-content' : 'comments-without-content', post_password_required() ? 'comments-content-protected' : '' ); ?>">
		<?php if ( post_password_required() ) : ?>
			<div class="<?php echo be_themes_get_class( 'comments-password-required' ); ?>">
				<?php echo esc_html__('This post is password protected. Enter the password to view any comments.', 'exponent'); ?>
			</div>
		<?php elseif( have_comments() ) : ?>
			<h5 class="<?php echo be_themes_get_class( 'comments-title' ); ?>">
				<?php 
					echo esc_html( sprintf( _nx( '1 Comment', '%s Comments', get_comments_number(), 'number of comments', 'exponent' ), number_format_i18n( get_comments_number() ) ) );
				?>
			</h5>
			<div class="<?php echo be_themes_get_class( 'comment-list' ); ?>">
				<ul class="<?php echo be_themes_get_class( 'comment-list-inner' ); ?>">
					<?php
						wp_list_comments( array( 'callback' => 'exponent_comments' ) );
					?>
				</ul>
				<?php if( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
					<div class="exp-pagination">
						<?php the_comments_pagination(); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php if( !comments_open() && !is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
				<p class="<?php echo be_themes_get_class( 'comments-closed' ); ?>">
					<?php echo esc_html__('Comments are closed.', 'exponent' ); ?>
				</p>
			<?php endif; ?>
		<?php endif; ?>
		<?php comment_form($comment_form_args); ?>
	</div>