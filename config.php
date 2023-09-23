<?php
/**
 * The base configuration for Toolkitspro
 *
 * The config.php creation script uses this file during the installation.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Database table prefix
 *
 * @package Toolkitspro
 */


/** Database Settings */
define( 'DB_NAME', '{{dbname}}' );
define( 'DB_USER', '{{dbuser}}' );
define( 'DB_PASSWORD', '{{dbpass}}' );
define( 'DB_HOST', '{{dbhost}}' );
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
define( 'TABLE_PREFIX', '{{dbprefix}}' );

/**
 * For developers: Toolkitspro debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use AST_DEBUG
 * in their development environments.
 */
define( 'AST_DEBUG', false );


/** Timezone */
define( 'TIMEZONE', 'Asia/Kathmandu' );


/** Absolute path to the Toolkitspro directory. */
define( 'ASTROOTPATH', __DIR__ . '/' );

/** Include Route Constants */
require_once ASTROOTPATH . "app/routes/const.php";
