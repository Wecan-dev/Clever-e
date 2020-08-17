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
define( 'DB_USER', 'adminwecan' );

/** MySQL database password */
define( 'DB_PASSWORD', '_*8gTYWqM9FHU' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
define( 'FS_METHOD', 'direct' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'dtDr0ZY$u)S:H)!pT%z=+YC;grzbb8&0/Mcf3mb-[VF~Uh}o5e8XEAI`^V<h25nV' );
define( 'SECURE_AUTH_KEY',  'u)(7sQZu*?0dDdjhpP[RU*E !/o8Ka9jM}bBre7qCC!*F+rWcClH!lY>)c4gJDLv' );
define( 'LOGGED_IN_KEY',    '^B0[5s:Vz*_#w_Q#(?e)7S*HUeeXKMYh?$,k>:0=]U{#c`{>O<8bABiuqnM})ram' );
define( 'NONCE_KEY',        'qa Mu;WHBMuL4%Bc+$C2ywr<5wJi!>{ue^+Z)-i|6*~~2,l}=JZ0B0:^8H(rCY%~' );
define( 'AUTH_SALT',        '68N5IAPORN^i#pRV/+@4~2Qql2rwC%94zxXh|b5Xb&wo( @qHQuNm1#Z^9g)`/o&' );
define( 'SECURE_AUTH_SALT', 'z)VR~i`z((lgtF;>aFH;nd6~*<lJaGnw<7F1Ut>oG%B/c98omYJcy(Xu^+or~^!F' );
define( 'LOGGED_IN_SALT',   '!fTgW!I@}aB[t0nevysQ{ %T]qh-,wla p$o0%5#RL]}L2h8*`<&`DKRq-3Qq*Th' );
define( 'NONCE_SALT',       'SiNo2v;&c9&%71g[M%/~l/N|1Iulz}Jc[Qip,t^]IVp UI)KQ4[1@B5TV:(=.1o+' );

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
