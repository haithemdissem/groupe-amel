<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', 'groupeamel_db' );

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
define( 'AUTH_KEY',         'bYSK8?uN(jr~4Rw1V,WH$W5s}w8K.cXZpR4~Cmk~E3DSWLRirn$o9g@iroaF|1P!' );
define( 'SECURE_AUTH_KEY',  '<fxS _c;+;G](:1l&)O/7?-S(mX$mZbnsk~ f<g;i~ZXcH=SCnmY/DMtxN`<xV|i' );
define( 'LOGGED_IN_KEY',    '{<1_3q_:Z/Ko#oh~gF?4g_.},tjK+F~t;;m__2*hYG]+@#p&e9Wa)c]-:AY.Kk#~' );
define( 'NONCE_KEY',        ',0ExsBSN2dyP{oA6#gPim?.eYNJT u_umDJs=+_zbr@Y^8hoO#O|tLc|MdX`[-#-' );
define( 'AUTH_SALT',        ')PdFQ(Ot%CgT`#r0.%5d`6#^#9uj&>``>nj;@%c61Eld,gLCK%~Q#?f-FzF#?ovw' );
define( 'SECURE_AUTH_SALT', 'x![Chl Q,oU=++jFa%u3ra1ej z@O0_y#Jo%v% Tt.`+c1!@4ITe&!2mG2*WB pO' );
define( 'LOGGED_IN_SALT',   ']v{;J7//4~gz=o45.)3+{:f5,XdE3?IeovFvD%fpFY52|G>OgNAF&AL&n/$SN.9K' );
define( 'NONCE_SALT',       'J+sp/{o<<,RH!:qHC3NnzVG[3aU*}{KasP2@]Fm3d7$!_^pv46f:E(RyaHAGynyC' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '8fpb7';

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
define('FS_METHOD', 'direct');