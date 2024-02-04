<?php

if( !function_exists( 'exponent_add_contact_methods' ) ) {
    add_filter('user_contactmethods','exponent_add_contact_methods',10,1);
    function exponent_add_contact_methods( $contactmethods ) {
        $contactmethods['twitter'] = 'Twitter'; // Add Twitter
        $contactmethods['facebook'] = 'Facebook'; // Add Facebook
        $contactmethods[ 'googleplus' ] = 'Google Plus';
        $contactmethods[ 'linkedin' ] = 'Linked In';
        $contactmethods[ 'pinterest' ]  = 'Pinterest';
        return $contactmethods;
    }
}