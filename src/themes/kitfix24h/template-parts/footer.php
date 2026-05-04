<?php
/**
 * Site footer.
 */
$phone = '0918611092';
$zalo  = 'https://zalo.me/0918611092';
?>
<footer class="kf-footer">
  <div class="kf-container">
    <div class="kf-footer-grid">

      <!-- Brand -->
      <div>
        <?php if (has_custom_logo()): ?>
          <div style="margin-bottom:16px;"><?php the_custom_logo(); ?></div>
        <?php else: ?>
          <img src="<?php echo esc_url(KITFIX_URI . '/assets/images/logo.png'); ?>" alt="KitFix24H" class="kf-footer-logo">
        <?php endif; ?>
        <p class="kf-footer-about">
          Chuyên sửa chữa thiết bị bếp và gia dụng tại TP.HCM. Hơn 20 năm kinh nghiệm, bảo hành 12 tháng.
        </p>
        <div class="kf-footer-actions">
          <a href="tel:<?php echo esc_attr($phone); ?>" class="kf-btn kf-btn-primary kf-btn-sm">
            <?php kitfix_icon('phone', 14); ?> <?php echo esc_html(implode('.', str_split($phone, 4))); ?>
          </a>
          <a href="<?php echo esc_url($zalo); ?>" class="kf-zalo-btn" target="_blank" rel="noopener noreferrer" style="padding:9px 13px;font-size:14px;">
            <?php kitfix_zalo_icon(14); ?> Zalo
          </a>
        </div>
      </div>

      <!-- Services -->
      <div>
        <p class="kf-footer-heading">Dịch vụ</p>
        <?php
        $services = [
            'Sửa bếp từ'         => '/dich-vu/bep-tu/',
            'Sửa bếp hồng ngoại' => '/dich-vu/bep-hong-ngoai/',
            'Sửa lò nướng'       => '/dich-vu/lo-nuong/',
            'Sửa lò vi sóng'     => '/dich-vu/lo-vi-song/',
            'Sửa máy hút mùi'    => '/dich-vu/may-hut-mui/',
        ];
        foreach ($services as $label => $path):
        ?>
          <a href="<?php echo esc_url(home_url($path)); ?>" class="kf-footer-link"><?php echo esc_html($label); ?></a>
        <?php endforeach; ?>
      </div>

      <!-- Links -->
      <div>
        <p class="kf-footer-heading">Khác</p>
        <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="kf-footer-link">Phụ kiện linh kiện</a>
        <a href="<?php echo esc_url(home_url('/ve-chung-toi/')); ?>" class="kf-footer-link">Về chúng tôi</a>
        <a href="<?php echo esc_url(home_url('/dat-lich/')); ?>" class="kf-footer-link">Đặt lịch sửa chữa</a>
        <a href="<?php echo esc_url(home_url('/chinh-sach-bao-hanh/')); ?>" class="kf-footer-link">Chính sách bảo hành</a>
      </div>

      <!-- Address -->
      <div>
        <p class="kf-footer-heading">Địa chỉ &amp; Giờ làm việc</p>
        <div class="kf-footer-address">
          <?php kitfix_icon('map-pin', 16, 'rgba(255,255,255,0.5)', 2); ?>
          <span class="kf-footer-address-text">2 Bạch Đằng, Tân Sơn Hòa,<br>TP. Hồ Chí Minh</span>
        </div>
        <div class="kf-footer-address">
          <?php kitfix_icon('clock', 16, 'rgba(255,255,255,0.5)', 2); ?>
          <span class="kf-footer-address-text">7:00 – 21:00, tất cả các ngày</span>
        </div>
        <div class="kf-footer-payment">
          <p class="kf-footer-payment-label">Phương thức thanh toán</p>
          <div class="kf-footer-payment-list">
            <?php foreach (['Tiền mặt', 'Chuyển khoản', 'Ví MoMo', 'ZaloPay'] as $method): ?>
              <span class="kf-payment-tag"><?php echo esc_html($method); ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

    </div><!-- /.kf-footer-grid -->

    <div class="kf-footer-bottom">
      <p>© <?php echo esc_html(date('Y')); ?> KitFix24H. Tất cả quyền được bảo lưu.</p>
      <p>Đăng ký kinh doanh số: 0123456789 — TP.HCM</p>
    </div>
  </div>
</footer>
