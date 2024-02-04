<?php
    $icon_enabled = !empty( $be_meta_date_icon ) ? true : false;
    $date_format = get_option( 'date_format' );
?>
    <a href="<?php the_permalink(); ?>" class="<?php echo be_themes_get_class( $icon_enabled ? 'post-date-with-icon' : 'post-date' ); ?>">
        <?php if( $icon_enabled ) : ?>
            <div class="<?php echo be_themes_get_class( 'post-date-icon' ); ?>">
                <i class="exp-icon exponent-icon-clock2">
                </i>
            </div>
            <div class="<?php echo be_themes_get_class( 'post-date' ); ?>">
                <?php echo get_the_date( $date_format ); ?>
            </div>
        <?php else: ?>
            <?php echo get_the_date( $date_format ); ?>
        <?php endif; ?>
    </a>