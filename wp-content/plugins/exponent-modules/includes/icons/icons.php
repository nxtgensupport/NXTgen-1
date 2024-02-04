<?php
add_action( 'tatsu_deregister_icons', 'exponent_modules_deregister_font_awesome' );
function exponent_modules_deregister_font_awesome() {
	tatsu_deregister_icon_kit( 'font_awesome' );
}
?>