<?php
/**
 * Theme setup: supports, image sizes, menus.
 */

declare(strict_types=1);

add_action('after_setup_theme', 'kitfix_setup');

function kitfix_setup(): void
{
    load_theme_textdomain('kitfix24h', KITFIX_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('custom-logo', [
        'height'      => 88,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    add_image_size('kitfix-card',   400, 300, true);
    add_image_size('kitfix-hero',  1280, 600, true);
    add_image_size('kitfix-thumb',  600, 400, true);

    register_nav_menus([
        'primary' => __('Menu chính', 'kitfix24h'),
        'footer'  => __('Menu footer', 'kitfix24h'),
    ]);
}

/* ── Body classes ── */
add_filter('body_class', 'kitfix_body_class');

function kitfix_body_class(array $classes): array
{
    $classes[] = 'kitfix-theme';
    if (is_front_page()) {
        $classes[] = 'page-homepage';
    }
    return $classes;
}
