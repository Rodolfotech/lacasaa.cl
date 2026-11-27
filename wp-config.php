<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'proyecto4' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'admin' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '@zcGK_F1]a56=h~[E(L)~f=9|pxjL-uP,X=Tgw{o57#+OYi-Lg6)d>QDN9qug!Vb' );
define( 'SECURE_AUTH_KEY',  '&YRBwcF$S{&~ua;U$W}qr&,JB+pm4i24T{P_`,P`C^)/qPU:<Z:7+>>/0`)CLKy#' );
define( 'LOGGED_IN_KEY',    ':-!q$UkjF2I@$w-ZOy4Jbr-x]QRsv=$.1@}%(cvHa%ZQ7tz6/aHy}am*WVzTv@?7' );
define( 'NONCE_KEY',        '4cB5_0eQ*Ls}2olHlxK+7L-HvzVEUB^T3:+_f$ah+4t!.|+owup[^UL37Rs@bk&E' );
define( 'AUTH_SALT',        'y/ECX<#R-dDGdUo6vr}hV160>)hX*ld,o^+OEA}:qP1Q>Svu6(m2sA-LED>MuId1' );
define( 'SECURE_AUTH_SALT', 'xAIL{#;M|UYg.[tZ-HnXYa:ex!$tMo>LE(F$dP3/=MUYveV!$a{h&Qay6Umkjx34' );
define( 'LOGGED_IN_SALT',   'Ug|?Q6@rHJnV1 [<DOAAVaR[G$I?B+dF4`:hLAG%aP1+I>b9ayJz[t^Uso8|a c-' );
define( 'NONCE_SALT',       'Mq`w]oUBK1A ~Q#fnt{:1>;f#hkm%y~stT(tGABQf7Vt4SZ@Pf^#?a.FOMMU<)RL' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
