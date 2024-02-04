<?php
    $sidebar = be_themes_get_option( 'blog_single_sidebar' );
    $sidebar_position = be_themes_get_option( 'blog_single_sidebar_position' );
    $sidebar_sticky = be_themes_get_option( 'blog_single_sidebar_sticky' );
    $content = get_the_content();
?> 
<?php do_action( 'be_themes_before_single_post_details' ); ?>
<?php get_template_part( 'template-parts/partials/content-pad', 'start' ); ?>
<?php if( !empty( $sidebar ) ) : ?>
    <div class="<?php echo be_themes_get_class( 'wrap' ); ?>">
    <?php 
        set_query_var( 'be_sidebar_position', $sidebar_position );
        get_template_part( 'template-parts/posts/sidebar', 'start' ); 
    ?>
<?php endif; ?>
<div class="<?php echo be_themes_get_class( 'post-details' ); ?>">
    <?php if( !empty( $content ) ) : ?>
        <div class="<?php echo be_themes_get_class( 'post-single-content' ); ?>">
            <?php the_content(); ?>
        </div>
    <?php endif; ?>
    <div class="<?php echo be_themes_get_class( 'smart-read' ); ?>">
    <?php 
        get_template_part( 'template-parts/posts/single', 'footer' );
    ?>
    </div>
</div>
<?php if( !empty( $sidebar ) ) :
    set_query_var('sidebar_sticky', $sidebar_sticky);
    get_template_part( 'template-parts/posts/sidebar', 'end' );
?>
    </div> <!-- End exp wrap -->
<?php 
    endif; 
    get_template_part( 'template-parts/partials/content-pad', 'end' );
    do_action( 'be_themes_after_single_post_details' );
    get_template_part( 'template-parts/posts/related', 'posts' );
?>
<?php if ( comments_open() || get_comments_number() ) : ?>
    <div class="<?php echo be_themes_get_class( 'wrap', 'smart-read' ); ?>">
        <?php 
            do_action( 'be_themes_before_single_post_comments' );
            comments_template(); 
            do_action( 'be_themes_after_single_post_comments' );
        ?>
    </div>
<?php endif; ?>