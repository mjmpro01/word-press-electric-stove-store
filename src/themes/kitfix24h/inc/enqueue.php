<?php
/**
 * Enqueue styles & scripts.
 */

declare(strict_types=1);

add_action('wp_enqueue_scripts', 'kitfix_enqueue');

function kitfix_enqueue(): void
{
    // Google Fonts — Be Vietnam Pro
    wp_enqueue_style(
        'be-vietnam-pro',
        'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap',
        [],
        null
    );

    // Design system CSS
    wp_enqueue_style(
        'kitfix-styles',
        KITFIX_URI . '/assets/css/kitfix-styles.css',
        ['be-vietnam-pro'],
        KITFIX_VERSION
    );

    // Theme style.css (identity only — no actual styles)
    wp_enqueue_style('kitfix-theme', get_stylesheet_uri(), ['kitfix-styles'], KITFIX_VERSION);

    // Main JS
    wp_enqueue_script(
        'kitfix-main',
        KITFIX_URI . '/assets/js/main.js',
        [],
        KITFIX_VERSION,
        true
    );

    // Pass data to JS
    wp_localize_script('kitfix-main', 'KITFIX', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('kitfix_booking'),
        'phone'   => '0918611092',
        'zaloUrl' => 'https://zalo.me/0918611092',
    ]);
}

// Block editor styles
add_action('enqueue_block_editor_assets', 'kitfix_enqueue_editor');

function kitfix_enqueue_editor(): void
{
    wp_enqueue_style(
        'kitfix-editor',
        KITFIX_URI . '/assets/css/kitfix-styles.css',
        [],
        KITFIX_VERSION
    );
}
