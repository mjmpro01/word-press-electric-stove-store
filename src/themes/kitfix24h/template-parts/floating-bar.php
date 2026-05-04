<?php
/**
 * Floating mobile action bar (fixed bottom, mobile only).
 */
$phone = '0918611092';
$zalo  = 'https://zalo.me/0918611092';
?>
<div class="kf-float-bar" aria-label="Hành động nhanh" role="region">
  <div class="kf-float-bar-inner">
    <a href="tel:<?php echo esc_attr($phone); ?>" class="kf-float-btn call">
      <?php kitfix_icon('phone', 20, '#1B4D7A'); ?>
      Gọi ngay
    </a>
    <a href="<?php echo esc_url($zalo); ?>" class="kf-float-btn zalo" target="_blank" rel="noopener noreferrer">
      <?php kitfix_zalo_icon(20, '#0068FF'); ?>
      Zalo
    </a>
    <a href="<?php echo esc_url(home_url('/dat-lich/')); ?>" class="kf-float-btn book">
      <?php kitfix_icon('calendar', 20, 'white'); ?>
      Đặt lịch
    </a>
  </div>
</div>
