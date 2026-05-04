<?php
/**
 * Site header.
 *
 * @var array{variant: string} $args
 */
$variant = $args['variant'] ?? 'light';
$is_bold = $variant === 'bold';
$header_class = 'kf-header' . ($is_bold ? ' bold' : '');
$phone = '0918611092';
$zalo  = 'https://zalo.me/0918611092';
?>
<header class="<?php echo esc_attr($header_class); ?>" id="kf-header">
  <div class="kf-container">
    <div class="kf-header-inner">

      <!-- Logo -->
      <a href="<?php echo esc_url(home_url('/')); ?>" class="kf-logo" aria-label="KitFix24H — Trang chủ">
        <?php if (has_custom_logo()): the_custom_logo(); else: ?>
          <img src="<?php echo esc_url(KITFIX_URI . '/assets/images/logo.png'); ?>" alt="KitFix24H" width="132" height="44" loading="eager">
        <?php endif; ?>
      </a>

      <!-- Desktop nav -->
      <nav class="kf-nav" aria-label="Menu chính">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="kf-nav-link<?php echo is_front_page() ? ' active' : ''; ?>">Trang chủ</a>
        <a href="<?php echo esc_url(home_url('/dich-vu/')); ?>" class="kf-nav-link<?php echo is_page_template('templates/page-service-detail.php') ? ' active' : ''; ?>">Dịch vụ</a>
        <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="kf-nav-link<?php echo (function_exists('is_shop') && (is_shop() || is_product())) ? ' active' : ''; ?>">Phụ kiện</a>
        <a href="<?php echo esc_url(home_url('/ve-chung-toi/')); ?>" class="kf-nav-link<?php echo is_page('ve-chung-toi') ? ' active' : ''; ?>">Về chúng tôi</a>
      </nav>

      <!-- Header actions -->
      <div class="kf-header-actions">
        <a href="tel:<?php echo esc_attr($phone); ?>" class="kf-hotline" aria-label="Gọi ngay <?php echo esc_attr($phone); ?>">
          <?php kitfix_icon('phone', 16); ?>
          <?php echo esc_html(implode('.', str_split($phone, 4))); ?>
        </a>
        <a href="<?php echo esc_url($zalo); ?>" class="kf-zalo-btn" target="_blank" rel="noopener noreferrer" aria-label="Nhắn Zalo">
          <?php kitfix_zalo_icon(16); ?>
          Zalo
        </a>
        <?php if (function_exists('WC')): ?>
          <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="kf-cart-btn" aria-label="Giỏ hàng">
            <?php kitfix_icon('shopping-cart', 20); ?>
            <span class="kf-cart-count"><?php echo WC()->cart ? absint(WC()->cart->get_cart_contents_count()) : 0; ?></span>
          </a>
        <?php endif; ?>
        <button class="kf-menu-toggle" id="kf-menu-toggle" aria-label="Mở menu" aria-expanded="false" aria-controls="kf-mobile-nav">
          <?php kitfix_icon('menu', 24); ?>
        </button>
      </div>

    </div><!-- /.kf-header-inner -->

    <!-- Mobile nav -->
    <div class="kf-mobile-nav" id="kf-mobile-nav" aria-hidden="true">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="kf-mobile-nav-link">Trang chủ</a>
      <a href="<?php echo esc_url(home_url('/dich-vu/')); ?>" class="kf-mobile-nav-link">Dịch vụ</a>
      <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="kf-mobile-nav-link">Phụ kiện</a>
      <a href="<?php echo esc_url(home_url('/ve-chung-toi/')); ?>" class="kf-mobile-nav-link">Về chúng tôi</a>
      <a href="<?php echo esc_url(home_url('/dat-lich/')); ?>" class="kf-btn kf-btn-primary" style="margin-top:8px;justify-content:center;">
        <?php kitfix_icon('calendar', 16); ?>
        Đặt lịch sửa chữa
      </a>
    </div>

  </div><!-- /.kf-container -->
</header>
