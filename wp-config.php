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
define( 'DB_NAME', 'db_clever' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '5Q)|4(vQy.Z5CgnmD |N5-tZ8fZlAvd/+@RXi Nry]^v!LeuJfEr9@@qP;xweTb?' );
define( 'SECURE_AUTH_KEY',  '>Q&(C4yK;>Y=N-hboK}N!Iskg0+U=^6;5lh0/V_(. 7^bN+4q|x=swb{4qaLQpH>' );
define( 'LOGGED_IN_KEY',    '|_W}Y` $mQr)bxOOtPS.(3SMAEq^;I8[38,2x^N3rT@@}r,M/&p_<bbREmFsAZtV' );
define( 'NONCE_KEY',        'Fv*EIlOla[zR,O6ta@ihJbB}EE)g_9uNs6>,6sVPpQyug#o~O Qi]WiDf4^O]gI|' );
define( 'AUTH_SALT',        'e^Uh)[+|0*u]SA(f9kiC_A?[|4E1S.YxHZ?pZSFu0`33pxa;:{IZNY* `]&QBT%%' );
define( 'SECURE_AUTH_SALT', '}V:+<o &&q]S&UuTC#UIaU)7:]N97qdCY(8u]e.|A$@=.M{mREIg}k2>U.KRBPQ8' );
define( 'LOGGED_IN_SALT',   'yf_D<R&pp rXLNNEV4VqPhnwJalCvB;M):=xUBQ2{O%scavrVF<WraABanzb%Oll' );
define( 'NONCE_SALT',       'LlH77yWVJ[p+OA<;d,ETsTa<z~q!Fenxh7LeMS3)|<KBtkq&_JmDB5e#VqwvVu9a' );

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
