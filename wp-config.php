<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'u145218313_XQQQG');

/** Database username */
define('DB_USER', 'u145218313_2PXSx');

/** Database password */
define('DB_PASSWORD', '39x1Fscrwn');

/** Database hostname */
define('DB_HOST', '127.0.0.1');

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'lT`{@mxJrQExwa]Yz:Yr}(]oIhMv cJQ@pd%#wJ5CqD/C..GhN4Z#^*<[aO)BvOS');
define('SECURE_AUTH_KEY', 'I;RA^)Ts}Cijx<(zuLWploXxz:`}!pIZdPTdJcPtg-jqMS<&BJ|6OnZA{2M]fVnp');
define('LOGGED_IN_KEY', 'M6[s`&HOj)Cx{V%r6{$W}0(buAO:R6x9vUu1|63{EP*RVEh]?vI|1)4ovk*b&tu%');
define('NONCE_KEY', 'alx>Yr+N7]s.U+],w7IW^J$-JoTMk{FZAc,$OAWRh?q;J&s}SMlv#_m-HR/SPr5A');
define('AUTH_SALT', 'CPoRiGg_]9A6Mo9j?H3plx[r|;~FH*KGg7zK-cD<Tl$sdDU2%OB%lxA7C *.Jr=r');
define('SECURE_AUTH_SALT', '=fE./~VxX40&X-*f#dTXK&[Qli!:0doD$X~:c*<$TfK >!f,kUCRY63~IiCe!40o');
define('LOGGED_IN_SALT', 'uZc{eH>;1oTZW*1CWrw9BcJAFT@86Z4JX)<m|^[[|eI6N&<A%YtEO$*;C.9k[sCp');
define('NONCE_SALT', 'Esjk4v:JFhH6iY-ctkg~v>v?Ns!,|Fm:n2aiJ?g~%B3epdU0G-,1_8bU0 !hxC&%');
define( 'WP_CACHE_KEY_SALT', '% QaD3;v?<K&`n>1YcFRX.uBwGt^LDr,2%1^<3Tp~w;4OGE+{{hEw<NI/ZZ#w`;z' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', true );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
