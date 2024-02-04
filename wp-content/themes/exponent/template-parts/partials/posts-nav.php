<?php
    $posts_nav_sticky = get_query_var( 'single_nav_sticky', false );
    $taxonomy = get_query_var( 'taxonomy', 'category' );
    if(get_post_type()=='portfolio'){
        $home_url = get_query_var( 'home_url', be_get_posts_page_url() );
    }else{
        $home_url = get_permalink( get_option( 'page_for_posts' ));
    }
    $nav_within_category = get_query_var( 'nav_within_cats', false );
    $is_portfolio = get_query_var( 'be_portfolio_nav', true );
    $prev_post = $is_portfolio ? get_next_post( $nav_within_category, '', $taxonomy ) :  get_previous_post( $nav_within_category, '', $taxonomy );
    $next_post = $is_portfolio ? get_previous_post( $nav_within_category, '', $taxonomy ) : get_next_post( $nav_within_category, '', $taxonomy );
    if( !empty( $prev_post ) || !empty( $next_post ) ) {
?>
    <div class="<?php echo be_themes_get_class( 'posts-nav', !empty( $posts_nav_sticky ) ? 'posts-nav-sticky' : '', empty( $prev_post ) ? 'posts-nav-pad-prev' : '' ); ?>">
        <?php if( !empty( $prev_post ) ) { ?>
            <div class="<?php echo be_themes_get_class( 'posts-nav-prev' ); ?>">
                <a href="<?php echo get_the_permalink( $prev_post->ID ); ?>" class="<?php echo be_themes_get_class( 'posts-nav-prev-link', 'posts-nav-link' ); ?>">
                    <svg class="<?php echo be_themes_get_class( 'posts-nav-prev-icon', 'posts-nav-icon' ); ?>" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="18px" viewBox="0 0 30 18" enable-background="new 0 0 30 18" xml:space="preserve">
                        <path class="<?php echo be_themes_get_class( 'posts-nav-prev-arrow', 'posts-nav-arrow' ); ?>" d="M2.511,9.007l7.185-7.221c0.407-0.409,0.407-1.071,0-1.48s-1.068-0.409-1.476,0L0.306,8.259
                                                c-0.408,0.41-0.408,1.072,0,1.481l7.914,7.952c0.407,0.408,1.068,0.408,1.476,0s0.407-1.07,0-1.479L2.511,9.007z">
                        </path>
                        <path class="<?php echo be_themes_get_class( 'posts-nav-prev-bar', 'posts-nav-bar' ); ?>" fill-rule="evenodd" clip-rule="evenodd" d="M30,9c0,0.553-0.447,1-1,1H1c-0.551,0-1-0.447-1-1c0-0.552,0.449-1,1-1h28.002
                                                C29.554,8,30,8.448,30,9z">
                        </path>
                    </svg>
                    <div class="<?php echo be_themes_get_class( 'posts-nav-prev-post' ); ?>">
                        <div class="<?php echo be_themes_get_class( 'posts-nav-post-location' ); ?>"> <?php echo esc_html__( 'Previous', 'exponent' ); ?> </div>
                        <div class="<?php echo be_themes_get_class( 'posts-nav-post-title' ); ?>"> 
                            <?php echo get_the_title( $prev_post->ID ); ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>
        <div class="<?php echo be_themes_get_class( 'posts-nav-home' ); ?>">
            <a href="<?php echo esc_url( $home_url );?>" class="<?php echo be_themes_get_class( 'posts-nav-home-link' ); ?>">
                <div class="exp-home-grid-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
        </div>
        <?php if( !empty( $next_post ) ) { ?>
            <div class="<?php echo be_themes_get_class( 'posts-nav-next' ); ?>">
                <a href="<?php echo get_the_permalink( $next_post->ID ); ?>" class="<?php echo be_themes_get_class( 'posts-nav-next-link', 'posts-nav-link' ); ?>">
                    <div class="<?php echo be_themes_get_class( 'posts-nav-next-post' ); ?>">
                        <div class="<?php echo be_themes_get_class( 'posts-nav-post-location' ); ?>"> <?php echo esc_html__( 'Next', 'exponent' ); ?> </div>
                        <div class="<?php echo be_themes_get_class( 'posts-nav-post-title' ); ?>"> 
                            <?php echo get_the_title( $next_post->ID ); ?>
                        </div>
                    </div>
                    <svg class="<?php echo be_themes_get_class( 'posts-nav-next-icon', 'posts-nav-icon' ); ?>" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="18px" viewBox="0 0 30 18" enable-background="new 0 0 30 18" xml:space="preserve">
                        <path class="<?php echo be_themes_get_class( 'posts-nav-next-arrow', 'posts-nav-arrow' ); ?>" d="M20.305,16.212c-0.407,0.409-0.407,1.071,0,1.479s1.068,0.408,1.476,0l7.914-7.952c0.408-0.409,0.408-1.071,0-1.481
                            l-7.914-7.952c-0.407-0.409-1.068-0.409-1.476,0s-0.407,1.071,0,1.48l7.185,7.221L20.305,16.212z">
                        </path>
                        <path class="<?php echo be_themes_get_class( 'posts-nav-next-bar', 'posts-nav-bar' ); ?>" fill-rule="evenodd" clip-rule="evenodd" d="M1,8h28.001c0.551,0,1,0.448,1,1c0,0.553-0.449,1-1,1H1c-0.553,0-1-0.447-1-1
                            C0,8.448,0.447,8,1,8z">
                        </path>
                    </svg>
                </a>
            </div>
        <?php } ?>   
    </div>
<?php
    }
