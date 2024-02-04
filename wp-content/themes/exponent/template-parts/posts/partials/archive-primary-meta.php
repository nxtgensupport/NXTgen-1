<?php
    $allowed_metas = array( 'categories', 'date', 'author', );
    if( !empty( $be_primary_meta ) ) : 
?>
    <div class="<?php echo be_themes_get_class( 'post-primary-meta' ); ?>">
        <?php 
        foreach( $be_primary_meta as $meta ) {
            if( in_array( $meta, $allowed_metas ) ) {
                get_template_part( 'template-parts/posts/partials/archive-meta', $meta );
            }
        }
        ?>
    </div>
<?php
    endif; 
?>
