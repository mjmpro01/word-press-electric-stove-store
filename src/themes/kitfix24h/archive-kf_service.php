<?php
/**
 * Archive template for kf_service CPT — /dich-vu/
 */

$meta_map = kitfix_service_meta();
$fallback_icon = ['icon' => 'tool', 'color' => '#1B4D7A', 'bg' => '#EFF6FF'];

$services = get_posts([
    'post_type'      => 'kf_service',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);

get_header();
kitfix_header('light');
kitfix_breadcrumb([['label' => 'Dịch vụ sửa chữa']]);
?>

<section class="kf-page-hero" aria-label="Dịch vụ sửa chữa">
  <div class="kf-hero-pattern"></div>
  <div class="kf-container" style="position:relative;text-align:center;padding:56px 0 48px;">
    <span class="kf-pill kf-pill-orange"><?php kitfix_icon('zap', 13, '#FDBA74'); ?> Dịch vụ tại nhà — TP.HCM</span>
    <h1 style="font-size:38px;font-weight:800;line-height:1.2;margin:16px 0 12px;">Dịch vụ sửa chữa gia dụng</h1>
    <p style="font-size:16px;opacity:.82;max-width:560px;margin:0 auto 28px;line-height:1.7;">
      Chuyên sửa bếp từ, bếp hồng ngoại, lò nướng, lò vi sóng, máy hút mùi.<br>
      Có mặt trong 60 phút — Bảo hành 12 tháng.
    </p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
      <a href="tel:0918611092" class="kf-btn kf-btn-primary kf-btn-lg">
        <?php kitfix_icon('phone', 17); ?> Gọi ngay: 0918.611.092
      </a>
      <a href="<?php echo esc_url(home_url('/dat-lich/')); ?>" class="kf-btn kf-btn-ghost kf-btn-lg">
        <?php kitfix_icon('calendar', 17); ?> Đặt lịch sửa
      </a>
    </div>
  </div>
</section>

<section style="padding:64px 0;background:#fff;">
  <div class="kf-container">

    <?php if (empty($services)): ?>
      <p style="text-align:center;color:#5C6E87;">Chưa có dịch vụ nào.</p>
    <?php else: ?>
      <div class="kf-services-grid" style="grid-template-columns:repeat(auto-fill,minmax(280px,1fr));">
        <?php foreach ($services as $post):
          $slug  = get_post_meta($post->ID, 'service_slug', true) ?: $post->post_name;
          $style = $meta_map[$slug] ?? $fallback_icon;
          $price = get_post_meta($post->ID, 'service_price_from', true) ?: 'Liên hệ báo giá';
          $desc  = get_post_meta($post->ID, 'service_hero_desc', true)
                ?: wp_trim_words(wp_strip_all_tags($post->post_content), 15, '...');
        ?>
          <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="kf-service-card">
            <div class="kf-service-icon" style="background:<?php echo esc_attr($style['bg']); ?>">
              <?php kitfix_icon($style['icon'], 24, $style['color']); ?>
            </div>
            <div>
              <h2 class="kf-service-title" style="font-size:17px;"><?php echo esc_html($post->post_title); ?></h2>
              <p class="kf-service-desc"><?php echo esc_html($desc); ?></p>
            </div>
            <div style="margin-top:auto;">
              <div class="kf-service-price"><?php echo esc_html($price); ?></div>
              <div class="kf-service-more">
                Xem chi tiết <?php kitfix_icon('chevron-right', 13, '#1B4D7A'); ?>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div style="margin-top:56px;background:#F5F7FA;border-radius:12px;padding:36px;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:28px;text-align:center;">
      <?php
      $trust = [
          ['award',        '20 năm',        'kinh nghiệm thực tế'],
          ['shield',       'Bảo hành 12T',  'sau mỗi lần sửa chữa'],
          ['clock',        '60 phút',       'kỹ thuật viên có mặt'],
          ['check-circle', 'Miễn phí',      'chẩn đoán tại nhà'],
      ];
      foreach ($trust as [$icon, $value, $label]):
      ?>
        <div>
          <div style="margin:0 auto 10px;width:48px;height:48px;background:#EFF6FF;border-radius:50%;display:flex;align-items:center;justify-content:center;">
            <?php kitfix_icon($icon, 22, '#1B4D7A'); ?>
          </div>
          <div style="font-size:20px;font-weight:800;color:#1B4D7A;"><?php echo esc_html($value); ?></div>
          <div style="font-size:13px;color:#5C6E87;margin-top:4px;"><?php echo esc_html($label); ?></div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<?php
kitfix_footer();
kitfix_float_bar();
get_footer();
?>
