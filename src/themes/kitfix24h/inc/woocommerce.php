<?php
/**
 * WooCommerce integration.
 */

declare(strict_types=1);

// Remove default WooCommerce wrappers
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// Add KitFix wrappers
add_action('woocommerce_before_main_content', 'kitfix_woo_wrapper_start', 10);
add_action('woocommerce_after_main_content',  'kitfix_woo_wrapper_end', 10);

function kitfix_woo_wrapper_start(): void
{
    // archive-product.php and single-product.php manage their own layout
    if (is_shop() || is_product()) {
        return;
    }
    get_header();
    kitfix_header('light');
    echo '<main style="padding:48px 0;background:#F5F7FA;"><div class="kf-container">';
}

function kitfix_woo_wrapper_end(): void
{
    if (is_shop() || is_product()) {
        return;
    }
    echo '</div></main>';
    kitfix_footer();
    kitfix_float_bar();
    get_footer();
}

// Product image size
add_filter('woocommerce_get_image_size_single', function (array $size): array {
    return ['width' => 600, 'height' => 400, 'crop' => 1];
});

// Custom loop template
add_action('woocommerce_before_shop_loop_item_title', 'kitfix_woo_loop_thumb', 10);

function kitfix_woo_loop_thumb(): void
{
    global $product;
    echo '<div class="kf-product-img">';
    if (has_post_thumbnail()) {
        the_post_thumbnail('kitfix-card', ['style' => 'width:100%;height:160px;object-fit:cover;']);
    } else {
        kitfix_icon('tool', 32, '#9BAABF');
        echo '<span style="font-size:11px;color:#9BAABF;font-family:monospace;">ảnh sản phẩm</span>';
    }
    echo '</div>';
}

// Cart fragments
add_filter('woocommerce_add_to_cart_fragments', 'kitfix_cart_count_fragment');

function kitfix_cart_count_fragment(array $fragments): array
{
    $count = WC()->cart->get_cart_contents_count();
    $hidden = $count === 0 ? ' style="display:none;"' : '';
    $fragments['.kf-cart-count'] = '<span class="kf-cart-count"' . $hidden . '>' . $count . '</span>';
    return $fragments;
}
