<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'infinix');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'DB69transsion');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '5lu?<D=g:)6f-+`6})Y!Lm|yPj0Dom ;Uc?>U%,1_lju`ywDfAjc2?C>s>x?:&?I');
define('SECURE_AUTH_KEY',  'fsppVcM}<Z:F-txcII#BTQu_7T,bwFOS+Oi|@}tg%B3K(S5kP*n=0,0<Id~;k1}`');
define('LOGGED_IN_KEY',    '#l};&{IuZFFB~p&-f0q7;i7/J;g-cP/o{tSo ACjb>)|.DePvq=&4T ;P}X,5&-n');
define('NONCE_KEY',        'k ,2_{^|o3~fb 8&,X--eeufu0RIk]?6qNzz6X?2rsB`^R`7W9;;QmEVaO|@Uve^');
define('AUTH_SALT',        '0cLXz<(dEat<(Q8O]4g4V+K0XGyiSlf4%!hf$]g_2&|5:6hddG`/U;*c<Hp=XovT');
define('SECURE_AUTH_SALT', 'Ox=>FT||xLjg79WAdu{)mRm^7Vj D1nc1#gMTU4TIa?ys6_>8rH#H2N|_Cn2@HlV');
define('LOGGED_IN_SALT',   '?pN3KOw|DbX6RP/9n92)/u*P/k}U MkOds_swA0cE6BbcU+1fk?I65qEWfR>6QYK');
define('NONCE_SALT',       'qW>dEi7XnUV5=Gs:=r9.2bayT;(ih kDS6[rYY/l4k?>cJT-Z?~/N:5{V8ukyS&^');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */


define('WP_ALLOW_MULTISITE', true);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'infinixmobility.com');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);


// define('WP_HOME','http://infinixmobility.com');
// define('WP_SITEURL','http://infinixmobility.com');


/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
