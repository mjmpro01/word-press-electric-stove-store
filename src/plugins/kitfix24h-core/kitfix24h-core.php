<?php
/**
 * Plugin Name:  KitFix24H Core
 * Plugin URI:   https://kitfix24h.vn
 * Description:  Custom post types, AJAX booking handler, ACF field registration for KitFix24H.
 * Version:      1.0.0
 * Author:       KitFix24H
 * Text Domain:  kitfix24h-core
 * Requires PHP: 8.1
 * Requires at least: 6.4
 */

declare(strict_types=1);

define('KITFIX_CORE_DIR', plugin_dir_path(__FILE__));
define('KITFIX_CORE_VERSION', '1.0.0');

require_once KITFIX_CORE_DIR . 'inc/post-types.php';
require_once KITFIX_CORE_DIR . 'inc/ajax-handlers.php';
require_once KITFIX_CORE_DIR . 'inc/cmb2-fields.php';

// ACF Pro fields only if ACF is active
if (function_exists('acf_add_local_field_group')) {
    require_once KITFIX_CORE_DIR . 'inc/acf-fields.php';
}
