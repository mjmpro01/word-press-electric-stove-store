<?php
/**
 * KitFix24H Theme — functions.php
 *
 * PSR-12 compliant; WordPress Coding Standards for hooks/filters.
 */

declare(strict_types=1);

define('KITFIX_VERSION', defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? (string) filemtime(__FILE__) : '1.0.1');
define('KITFIX_DIR',  get_template_directory());
define('KITFIX_URI',  get_template_directory_uri());

/* ── Load sub-files ── */
require_once KITFIX_DIR . '/inc/setup.php';
require_once KITFIX_DIR . '/inc/enqueue.php';
require_once KITFIX_DIR . '/inc/nav-walker.php';
require_once KITFIX_DIR . '/inc/template-tags.php';
require_once KITFIX_DIR . '/inc/shortcodes.php';
require_once KITFIX_DIR . '/inc/woocommerce.php';
require_once KITFIX_DIR . '/inc/acf-fields.php';
