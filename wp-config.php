<?php
/** Enable W3 Total Cache */
define('WP_CACHE', false); // Added by W3 Total Cache

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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'inharmonie');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'Xz`T=Vr`~*6Eb<b;)LCVMinlJ4)eh(/8tP$R<BO!D12  =S;A]{%[X?8]qvfqL=7');
define('SECURE_AUTH_KEY',  '|2A_lHSaZi@``;>S_/ME[N/ *bM7ce>qWF282&Q{K2#$YL&Nf#y>)/pSI^$!oV~*');
define('LOGGED_IN_KEY',    'D4flS^GN{xH57 Q~e:fGT-eZwvmWf$6Tmqpuo|oY:/F>Q d|jtU79 Av[)P>jsCo');
define('NONCE_KEY',        'rb3iKH{2prBRw(gn{FC(i4ok=FXo*Qu]~La(OaK7CmCr>pHO-^x31&J)?8w/G]#g');
define('AUTH_SALT',        '~KD$6,s2<J,zzAA|SgHVL:MPl1V]4;I:xY^k-g:=&<Ds:q@>Rf$a`/COISQrUt5F');
define('SECURE_AUTH_SALT', 'uv;0zDfV960#~y&J.0>LsV&jQo-u.:I/.X+m(s?i86qPyW!&I#kkeK>P-s&m{-&w');
define('LOGGED_IN_SALT',   ';FUgdvvzvNVc5#ZFW8X{OUsiiT@te:pNHP{2%+8C^SPcQ*@iL%OY_4PR7NfrJ,~P');
define('NONCE_SALT',       'B[L[cR2$T<Rwab|NBB2z<?o_YfmGuH@zq3V/cs-vdAN4rf`<pQkE$RQs?A}/u&)y');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
