<?php
    $quote_author = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'quote_author', true );
    $quote = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'quote', true );
    $quote_color = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'quote_color', true );
    $quote_bg_color = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'quote_bg_color', true );

    if( !empty( $quote ) ) {
        $quote_style = '';
        $box_shadow_class = '';
        $border_radius = exponent_get_post_loop_prop( 'border_radius' );
        if( !empty( $border_radius ) ) {
            $border_radius = "border-radius : {$border_radius}px;";
        }else {
            $border_radius = '';
        }
        if( !empty( $quote_color ) ) {
            $quote_color = "color : {$quote_color};";
        }else {
            $quote_color = '';
        }
        if( !empty( $quote_bg_color ) ) {
            $quote_bg_color = "background : {$quote_bg_color};";
        }else {
            $quote_bg_color = '';
        }
        if( !empty( $quote_bg_color ) || !empty( $quote_color ) ) {
            $quote_style = sprintf( 'style = "%s%s"', $quote_color, $quote_bg_color );
        }
        ?>
            <div class="<?php echo be_themes_get_class( 'post-quote' ); ?>" <?php echo !empty( $quote_style ) ? $quote_style : ''; ?>>
                <div class="<?php echo be_themes_get_class( 'post-quote-icon' ); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="29" height="26" viewBox="0 0 29 26">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.949 26H0V14.814C0 12.7984 0.213717 10.9005 0.641156 9.12016C1.0686 7.33978 1.72619 5.77778 2.61395 4.43411C3.50171 3.09043 4.63605 2.01551 6.01701 1.2093C7.39797 0.403097 9.00906 0 10.8503 0V5.03876C9.73242 5.03876 8.81179 5.32429 8.08844 5.89535C7.36508 6.46641 6.77325 7.22222 6.31293 8.16279C5.85261 9.10336 5.54025 10.1615 5.37585 11.3372C5.21145 12.5129 5.12925 13.6718 5.12925 14.814H10.949V26ZM29 26H18.051V14.814C18.051 12.7984 18.2647 10.9005 18.6922 9.12016C19.1196 7.33978 19.7772 5.77778 20.665 4.43411C21.5527 3.09043 22.6871 2.01551 24.068 1.2093C25.449 0.403097 27.0601 0 28.9014 0V5.03876C27.7834 5.03876 26.8628 5.32429 26.1395 5.89535C25.4161 6.46641 24.8243 7.22222 24.364 8.16279C23.9036 9.10336 23.5913 10.1615 23.4269 11.3372C23.2625 12.5129 23.1803 13.6718 23.1803 14.814H29V26Z"/>
                    </svg>
                </div>
                <div class="<?php echo be_themes_get_class( 'post-quote-text' ); ?>">
                    <?php echo esc_html( $quote ); ?>
                </div>
                <div class="<?php echo be_themes_get_class( 'post-quote-author' ); ?>">
                    <?php echo esc_html( $quote_author ); ?>
                </div>
            </div>
        <?php
    }