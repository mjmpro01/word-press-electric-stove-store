<?php
/**
 * Shortcodes for use in page content / Gutenberg.
 */

declare(strict_types=1);

// [kitfix_booking_form]
add_shortcode('kitfix_booking_form', 'kitfix_sc_booking_form');

function kitfix_sc_booking_form(array $atts): string
{
    $atts = shortcode_atts(['style' => 'compact'], $atts, 'kitfix_booking_form');
    ob_start();
    ?>
    <div class="kf-booking-form-wrap">
      <h3 class="kf-form-title">Đặt lịch sửa chữa</h3>
      <form class="kf-form kf-sc-booking" method="post" novalidate>
        <?php wp_nonce_field('kitfix_booking', 'kitfix_nonce'); ?>
        <div class="kf-form-row">
          <div class="kf-form-group">
            <label class="kf-label">Họ và tên *</label>
            <input type="text" name="booking_name" class="kf-input" placeholder="Nguyễn Văn A" required>
          </div>
          <div class="kf-form-group">
            <label class="kf-label">Số điện thoại *</label>
            <input type="tel" name="booking_phone" class="kf-input" placeholder="0918 611 092" required>
          </div>
        </div>
        <div class="kf-form-group">
          <label class="kf-label">Thiết bị cần sửa *</label>
          <select name="booking_service" class="kf-select" required>
            <option value="">Chọn thiết bị...</option>
            <?php foreach (kitfix_get_services() as $svc): ?>
              <option><?php echo esc_html($svc['title']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="kf-form-group">
          <label class="kf-label">Địa chỉ *</label>
          <input type="text" name="booking_address" class="kf-input" placeholder="Số nhà, đường, quận..." required>
        </div>
        <button type="submit" class="kf-form-submit">Đặt lịch ngay — Miễn phí chẩn đoán</button>
      </form>
    </div>
    <?php
    return (string)ob_get_clean();
}

// [kitfix_services]
add_shortcode('kitfix_services', 'kitfix_sc_services');

function kitfix_sc_services(): string
{
    ob_start();
    echo '<div class="kf-services-grid">';
    foreach (kitfix_get_services() as $slug => $svc):
    ?>
      <a href="<?php echo esc_url($svc['url']); ?>" class="kf-service-card">
        <div class="kf-service-icon" style="background:<?php echo esc_attr($svc['bg']); ?>">
          <?php kitfix_icon($svc['icon'], 24, $svc['color']); ?>
        </div>
        <div>
          <h3 class="kf-service-title"><?php echo esc_html($svc['title']); ?></h3>
          <p class="kf-service-desc"><?php echo esc_html($svc['desc']); ?></p>
        </div>
        <div style="margin-top:auto;">
          <div class="kf-service-price"><?php echo esc_html($svc['price']); ?></div>
        </div>
      </a>
    <?php endforeach;
    echo '</div>';
    return (string)ob_get_clean();
}
