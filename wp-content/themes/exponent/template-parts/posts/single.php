<?php
    $related_posts = be_themes_get_option( 'related_posts' );
    $post_header_style = be_themes_get_option_with_override( 'single_title_style', 'single_post_override' );
    $sidebar = be_themes_get_option( 'blog_single_sidebar' );
	$sidebar_position = be_themes_get_option( 'blog_single_sidebar_position' );
    while( have_posts() ) {
        the_post();
?>
    <div id="post-<?php the_ID(); ?>" <?php post_class( be_themes_get_class( 'post-single' ) ); ?>>
        <?php get_template_part( 'template-parts/posts/single', 'header' ); ?>
            <?php if( !empty( $sidebar ) ) : ?>
                <div class="<?php echo be_themes_get_class( 'wrap' ); ?>">
                <?php set_query_var( 'be_sidebar_position', $sidebar_position ); ?>
                <?php get_template_part( 'template-parts/posts/sidebar', 'start' ); ?>
            <?php endif; ?>
                <div class="<?php echo be_themes_get_class( 'post-details' ); ?>">
                        <div class="<?php echo be_themes_get_class( 'post-single-content' ); ?> clearfix">
                            <?php the_content(); ?>
                        </div>
                        <div class="<?php echo be_themes_get_class( 'smart-read' ); ?>">
                            <?php get_template_part( 'template-parts/posts/single', 'footer' ); ?>
                        </div>
                    <?php if( !empty( $related_posts ) ) : ?>
                        </div>  <!-- End Post Details -->
                        <?php if( !empty( $sidebar ) ) : ?>
                            <?php get_template_part( 'template-parts/posts/sidebar', 'end' ); ?>
                            </div> <!-- End exp wrap -->
                        <?php endif; ?>
                        <?php get_template_part( 'template-parts/posts/related', 'posts' ); ?>
                        <div class="<?php echo be_themes_get_class( 'wrap' ); ?>">
                            <div class="<?php echo be_themes_get_class( 'smart-read' ); ?>">
                                <?php comments_template(); ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="<?php echo be_themes_get_class( 'smart-read' ); ?>">
                            <?php comments_template(); ?>
                        </div>
                    </div>
                </div>
            <?php if( !empty( $sidebar ) ) : ?>
                <?php get_template_part( 'template-parts/posts/sidebar', 'end' ); ?>
                </div> <!-- End exp wrap -->
            <?php endif; ?>
        <?php endif; ?>
        <?php get_template_part( 'template-parts/posts/single', 'nav' ); ?>
    </div>
<?php    
    }
?>