<?php
/**
 * WooCommerce shop / product archive — KitFix24H layout.
 *
 * Matches the Shop.html design: sidebar categories + search + product grid.
 */

defined('ABSPATH') || exit;

get_header();
kitfix_header('light');
kitfix_breadcrumb([['label' => 'Phụ kiện & Linh kiện']]);
?>

<!-- Banner -->
<div style="background:linear-gradient(135deg,#123557 0%,#1B4D7A 100%);color:#fff;padding:36px 0;">
  <div class="kf-container">
    <h1 style="font-size:32px;font-weight:800;margin-bottom:8px;">Phụ kiện &amp; Linh kiện thay thế</h1>
    <p style="font-size:15px;opacity:.8;">Linh kiện chính hãng cho bếp từ, lò nướng, lò vi sóng, máy hút mùi — bảo hành đầy đủ</p>
  </div>
</div>

<div class="kf-container" style="padding:32px 24px;">

  <!-- Search + sort bar -->
  <div style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;align-items:center;">
    <form method="get" action="<?php echo esc_url(home_url('/')); ?>" style="flex:1;min-width:200px;position:relative;">
      <div style="position:absolute;left:12px;top:50%;transform:translateY(-50%);">
        <?php kitfix_icon('search', 16, '#9BAABF'); ?>
      </div>
      <input type="search" name="s" class="kf-input" placeholder="Tìm linh kiện, thương hiệu..." style="padding-left:38px;" value="<?php echo esc_attr(get_search_query()); ?>">
      <input type="hidden" name="post_type" value="product">
    </form>
    <?php woocommerce_catalog_ordering(); ?>
  </div>

  <div class="kf-shop-layout">

    <!-- Sidebar -->
    <aside class="kf-shop-sidebar">
      <!-- Price filter -->
      <div class="kf-sidebar-box" style="padding:16px;">
        <div style="font-size:13px;font-weight:700;color:#1B4D7A;margin-bottom:12px;">Khoảng giá</div>
        <?php if (function_exists('wc_get_min_max_price_meta_query')): ?>
          <?php the_widget('WC_Widget_Price_Filter'); ?>
        <?php else: ?>
          <p style="font-size:13px;color:#9BAABF;">Kích hoạt WooCommerce để lọc giá.</p>
        <?php endif; ?>
      </div>

      <!-- Guarantee badge -->
      <div class="kf-guarantee">
        <div style="display:flex;gap:8px;align-items:center;margin-bottom:8px;">
          <?php kitfix_icon('shield', 15, '#10B981'); ?>
          <span style="font-size:13px;font-weight:700;color:#059669;">Cam kết chính hãng</span>
        </div>
        <p style="font-size:12px;color:#047857;line-height:1.6;">100% linh kiện chính hãng, có tem nhà phân phối. Bảo hành 3–12 tháng tùy sản phẩm.</p>
      </div>
    </aside>

    <!-- Product grid -->
    <div>
      <?php if (woocommerce_product_loop()): ?>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
          <span style="font-size:14px;color:#5C6E87;">
            Hiển thị <strong><?php woocommerce_result_count(); ?></strong> sản phẩm
          </span>
        </div>

        <div class="kf-product-grid">
          <?php while (have_posts()): the_post(); setup_postdata($GLOBALS['post']); ?>
            <?php
            $product = wc_get_product(get_the_ID());
            if (!$product) { continue; }
            $price_html = $product->get_price_html();
            $badge = '';
            if ($product->is_on_sale()) $badge = 'Giảm giá';
            elseif ($product->is_featured()) $badge = 'Nổi bật';
            ?>
            <div class="kf-product-card">
              <a href="<?php the_permalink(); ?>" class="kf-product-image">
                <?php if ($badge): ?>
                  <div class="kf-product-badge"><?php echo esc_html($badge); ?></div>
                <?php endif; ?>
                <?php if (has_post_thumbnail()):
                      the_post_thumbnail('kitfix-card', ['style' => 'width:100%;height:160px;object-fit:cover;']);
                else: ?>
                  <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:160px;background:#F5F7FA;">
                    <?php kitfix_icon('tool', 36, '#C5D0DE'); ?>
                    <span style="font-size:11px;color:#C5D0DE;font-family:monospace;margin-top:8px;">ảnh sản phẩm</span>
                  </div>
                <?php endif; ?>
              </a>
              <div class="kf-product-info">
                <a href="<?php the_permalink(); ?>">
                  <h4 class="kf-product-title"><?php the_title(); ?></h4>
                </a>
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:auto;">
                  <span style="font-size:18px;font-weight:800;color:#F47B20;"><?php echo wp_kses_post($price_html); ?></span>
                  <?php woocommerce_template_loop_add_to_cart(['class' => 'kf-add-to-cart']); ?>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>

        <?php do_action('woocommerce_after_shop_loop'); ?>

      <?php else: ?>
        <div style="text-align:center;padding:64px 0;color:#9BAABF;">
          <?php kitfix_icon('search', 48, '#DDE3EC'); ?>
          <p style="margin-top:16px;font-size:16px;">Không tìm thấy sản phẩm phù hợp.</p>
          <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="kf-btn kf-btn-blue" style="margin-top:20px;">Xem tất cả sản phẩm</a>
        </div>
      <?php endif; ?>
    </div>

  </div>
</div>

<?php
kitfix_footer();
kitfix_float_bar();
get_footer();
?>
