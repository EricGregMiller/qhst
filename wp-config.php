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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'theolo14_wo473');

/** MySQL database username */
define('DB_USER', 'theolo14_wo473');

/** MySQL database password */
define('DB_PASSWORD', 'S!hp3293-T');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '2iemvpekjyjgafz7g58pcqmikv9xhrlikflucauk85p2tsd8phmfy3mdnxstr2ke');
define('SECURE_AUTH_KEY',  'rtu5dp7j35txgx9hksbgmtqsjftxnlkokivyysfxzuhhed6karvprccqrqns7xzy');
define('LOGGED_IN_KEY',    '1orznqebszxjmqty6ppqh65zclqwverhgmhdskaq7pze3ut1okdnhp1tdkijoula');
define('NONCE_KEY',        'rxjrf9uqelxwoeqlnww90iiobhazfxhk7qa5iffavmlxvcd1jmy8kqbsdnmbep9g');
define('AUTH_SALT',        'pjx0u9wc9bbqfvizdlyeyxs93i9cktfzygebab4mqcprdg3x013yrk01abc3tlzg');
define('SECURE_AUTH_SALT', 'd8wykobhdtkjcos8ybcyadpeuo6at0zmdw0tsftfpvywosxpdfqsalqpvg0ebfox');
define('LOGGED_IN_SALT',   'mtsppnivjs3ejnjntvjk8mimbvdkyceoyotw4btogrljpgdvmwvqmskq9adzry1l');
define('NONCE_SALT',       'jskcvzm0zsee9rktoqvtqgoomrveixud0yctq1xpvwuwqihsci5gxqfylk8qwewy');

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
