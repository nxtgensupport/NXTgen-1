<div class="<?php echo be_themes_get_class( !empty( $be_meta_author_image ) ? 'post-author-with-image' : 'post-author' ); ?>">
    <?php if( !empty( $be_meta_author_image ) ) : ?>
        <div class="<?php echo be_themes_get_class( 'post-author-image' ); ?>">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
        </div>
        <div class="<?php echo be_themes_get_class( 'post-author' ); ?>">
            <?php echo  esc_html__('by ','exponent') . sprintf( '<a class="%s" href="%s">%s</a>', be_themes_get_class( 'post-author-name', !empty( $be_animated_author ) ? 'lively-link-style1' : '' ), get_author_posts_url( get_the_author_meta( 'ID' ) ), get_the_author() ); ?>
        </div>
    <?php else: ?>   
        <?php echo esc_html__('by ','exponent') . sprintf( '<a class="%s" href="%s">%s</a>', be_themes_get_class( 'post-author-name', !empty( $be_animated_author ) ? 'lively-link-style1' : '' ), get_author_posts_url( get_the_author_meta( 'ID' ) ), get_the_author() ); ?>
    <?php endif; ?>
</div>