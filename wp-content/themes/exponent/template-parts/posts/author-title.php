<?php
    $cur_auth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
    if(!empty( $cur_auth ) ) {
        $avatar = get_avatar( $cur_auth->ID );
        $author_share_args = array (
            'parent_class'      => be_themes_get_class( 'author-share', 'reset-line-height' )
        );
        $header_height = esc_attr( be_themes_get_option( 'author_hero_height' ) );
        $header_bg = be_themes_get_option( 'author_hero_background' );
        $overlay = be_themes_get_option( 'author_hero_overlay' );
        $overlay_color = esc_attr( be_themes_get_option( 'author_hero_overlay_color' ) );
        $overlay_style = '';
        if( !empty( $overlay ) && !empty( $overlay_color ) ) {
            $overlay_style = sprintf( 'style = "background : %s;"', $overlay_color );
        }
        
        $header_style = '';
        if( !empty( $header_height ) ) {
            $header_height = "height : {$header_height}vh;";
        }else {
            $header_height = '';
        }
        if( !empty( $header_bg ) ) {
            $header_bg = sprintf( 'background : %s;', be_themes_get_background( $header_bg ) );
        }else {
            $header_bg = '';
        }

        if( !empty( $header_bg ) || !empty( $header_height ) ) {
            $style = sprintf( 'style = "%s%s"', $header_height, $header_bg );
        }
?>
    <div class="<?php echo be_themes_get_class( 'author' ); ?>" <?php echo !empty( $style ) ? $style : ''; ?>>
        <?php if( !empty( $overlay ) ) : ?>
            <div class="<?php echo be_themes_get_class( 'author-overlay' ); ?>" <?php echo !empty( $overlay_style ) ? $overlay_style : ''; ?> >
            </div>
        <?php endif; ?>
        <div class="<?php echo be_themes_get_class( 'author-inner' ); ?>">
            <?php if( !empty( get_avatar( $cur_auth->ID ) ) ) : ?>
                <div class="<?php echo be_themes_get_class( 'author-thumb' ) ?>">
                    <?php echo get_avatar( $cur_auth->ID ); ?>
                </div>
            <?php endif; ?>
            <a href="<?php echo esc_url( $cur_auth->user_url ); ?>" class="<?php echo be_themes_get_class( 'author-name' ); ?>">
                <?php echo esc_html( $cur_auth->display_name ); ?>    
            </a>
            <div class="<?php echo be_themes_get_class( 'author-bio' ); ?>">
                <?php echo get_the_author_meta( 'description', $cur_auth->ID ); ?>
            </div>
            <?php echo be_themes_get_author_share( $author_share_args ); ?>
        </div>
    </div>
<?php
    }
