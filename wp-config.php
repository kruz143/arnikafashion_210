<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'New_Arnika' );

/** MySQL database username */
define( 'DB_USER', 'Shailly' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Shailly@1103' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ffct,]4nx`aYH#K|mJh]!Bb!L[p-2Yx.QuC@Q=Sj%+_aqMv8p+PO.A%&pLDYeDno' );
define( 'SECURE_AUTH_KEY',  's+M@x9xY^ug9;Xxtv1J[I.*A![ed3kZnjuWO@ O3:P`@aIA|~5`n<]7:< @!)3&h' );
define( 'LOGGED_IN_KEY',    'Z2r2u>i0k4aB&|QA_*s^;JN@|wgRbiL#_0XHmh8~8~k@_;%UdpA[Rpm< J>%HKp)' );
define( 'NONCE_KEY',        '*&ouPbd@>%nah*7E,6F~R;L-57P76*DQ(gR`eZQ#&N=ZZK@`N/8gU$=lAx)Cs?/S' );
define( 'AUTH_SALT',        '_6:Axc. >`TMcZ9WiM~kR]Os~=o$6)0b=[C#glL7r1|oGee]cw]T7o/&<tseFf.i' );
define( 'SECURE_AUTH_SALT', '3+?slCUOd/D@{F=~2pT GzOoqs!`[%Oz$YrK 4OVjO>01yIMuXz8Z=6KZ>$/0Wg9' );
define( 'LOGGED_IN_SALT',   '[UCu9!4o.2,|-}[^-]:0f_BZ(W)^yL<zNt2pJ]HhrX6b%G>L7WX_%Q=5*fD<jTL`' );
define( 'NONCE_SALT',       'P9C*R5NjXZTT0g~[]4u(u3|3-0kFEU4W!b3r*oHNx~(&Yh HHPVguhi1j,0?x[E(' );
define( 'WP_MEMORY_LIMIT', '256M' );
/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
