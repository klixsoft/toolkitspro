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
define( 'DB_NAME', 'admin_toolkitspro' );
define( 'DB_USER', 'admin_toolkitspro' );
define( 'DB_PASSWORD', 't5gfgWG0hz(cOCF' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
define( 'TABLE_PREFIX', 'ast_' );

/**
 * For developers: Toolkitspro debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use AST_DEBUG
 * in their development environments.
 */
define( 'AST_DEBUG', true );

/** Timezone */
define( 'TIMEZONE', 'Asia/Kathmandu' );

/** Absolute path to the Toolkitspro directory. */
define( 'ASTROOTPATH', __DIR__ . '/' );

/** Include Route Constants */
require_once ASTROOTPATH . "app/routes/const.php";