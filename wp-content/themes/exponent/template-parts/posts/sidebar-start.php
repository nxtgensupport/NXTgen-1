<?php
    $sidebar_position = get_query_var( 'be_sidebar_position', 'right' );
    $sidebar_with_margin = get_query_var( 'be_sidebar_with_margin', false );

?>
    <div class="be-row-wrap">
    <div class="be-row be-sidebar-layout be-sidebar-<?php echo esc_attr( $sidebar_position ); ?> <?php echo !empty( $sidebar_with_margin ) ? 'be-sidebar-with-margin' : ''; ?>">
    <div class="be-col" >
