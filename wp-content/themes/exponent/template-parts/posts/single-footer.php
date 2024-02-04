<?php
    $author_share_args = array (
        'parent_class'      => be_themes_get_class( 'post-single-footer-author-share', 'reset-line-height' )
    );

    $author_name = get_the_author_meta( 'display_name' );
    $author_description = get_the_author_meta('description');
    $author_id = get_the_author_meta( 'ID' );
    $single_share = be_themes_get_option( 'single_posts_share' );
?>
<div class="<?php echo be_themes_get_class( 'smart-read' ); ?>">
    <?php do_action( 'be_themes_single_post_before_footer' ); ?>
    <div class="<?php echo be_themes_get_class( 'post-single-footer' ); ?>">
        <?php if( has_tag( '', get_the_ID() ) ) : ?>
            <div class="<?php echo be_themes_get_class( 'post-single-footer-tags' ); ?>">
                <?php echo be_themes_get_terms( get_the_ID(), 'post_tag', be_themes_get_class( 'post-single-footer-tax' ), '', '' ); ?>
            </div>
        <?php endif; ?>
        <?php if( (function_exists( 'exponent_get_share_button' ) && !empty( $single_share )) || (!empty( $author_name ) && !empty( $author_description )) )  : ?>
            <hr class="<?php echo be_themes_get_class( 'post-single-footer-separator' ); ?>"/>
        <?php endif; ?>
        <?php if( function_exists( 'exponent_get_share_button' ) && !empty( $single_share ) ) : ?>
            <div class="<?php echo be_themes_get_class( 'post-single-footer-share' ); ?>">
                <?php echo exponent_get_share_button( get_the_permalink(), get_the_title(), get_the_ID(), 'tiny', '', '', true ); ?>
            </div>
        <?php endif; ?>
        <?php if( !empty( $author_name ) && !empty( $author_description ) ) : ?>
            <div class="<?php echo be_themes_get_class( 'post-single-footer-author' ); ?>">
                <div class="<?php echo be_themes_get_class( 'post-single-footer-author-image' ); ?>">
                    <?php 
                        echo get_avatar( $author_id, 88 );
                    ?>
                </div>
                <div class="<?php echo be_themes_get_class( 'post-single-footer-author-details' ); ?>">
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="<?php echo be_themes_get_class( 'post-single-footer-author-name' ); ?>">
                        <?php echo esc_html( $author_name ); ?>
                    </a>
                    <p class="<?php echo be_themes_get_class( 'post-single-footer-author-description' ); ?>"><?php echo nl2br( $author_description ); ?></p>
                    <?php echo be_themes_get_author_share( $author_share_args ); ?>
                </div>    
            </div>
        <?php endif; ?>
    </div>
    <?php do_action( 'be_themes_single_post_after_footer' ); ?>
</div>