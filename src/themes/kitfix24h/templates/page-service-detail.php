<?php
/**
 * Template Name: Trang dịch vụ (Service Detail)
 * Template Post Type: page
 */

// ── Determine which service to show ─────────────────────────────────────────
$page_slug    = get_post_field('post_name', get_the_ID());
$service_slug = $page_slug;

// ── Hardcoded fallback data (used when CPT has no content yet) ───────────────
$fallback = [
    'bep-tu' => [
        'title'    => 'Sửa bếp từ',       'short' => 'Bếp từ',
        'hero_desc'=> 'Chuyên sửa bếp từ mọi hãng: Bosch, Siemens, Sunhouse, Elmich, Canzy. Chẩn đoán chính xác, linh kiện chính hãng, bảo hành 12 tháng.',
        'symptoms' => ['Không lên lửa, màn hình tắt','Báo lỗi E0, E1, E2... E9','Cảm ứng không phản hồi','Mặt kính bị vỡ, nứt','Không nhận nồi / không đạt nhiệt độ','Đang dùng tự tắt bất thường','Tiếng kêu lạ khi hoạt động'],
        'fixes'    => ['Thay mâm từ (coil)','Thay bo mạch điều khiển','Thay mặt kính cảm ứng','Sửa lỗi cảm ứng, nút bấm','Thay quạt tản nhiệt','Thay mosfet, relay','Lập trình lại firmware'],
        'errors'   => [['E0','Lỗi cảm biến nhiệt độ đáy nồi','yellow'],['E1','Quá nhiệt — bề mặt bếp > 300°C','red'],['E2','Không phát hiện nồi hoặc nồi không tương thích','yellow'],['E3','Điện áp đầu vào quá thấp (< 170V)','orange'],['E4','Điện áp đầu vào quá cao (> 260V)','red'],['E5','Lỗi IGBT / mosfet — cần thay ngay','red'],['E6','Lỗi cảm biến nhiệt độ nội bộ','orange'],['E7','Quạt tản nhiệt hỏng hoặc bị kẹt','orange'],['E8','Mạch nguồn lỗi','red'],['E9','Lỗi giao tiếp bo mạch','orange']],
        'pricing'  => [['Kiểm tra & chẩn đoán','Miễn phí','khi sửa chữa'],['Thay mâm từ','350.000 – 650.000đ','tùy hãng, model'],['Thay bo mạch','450.000 – 950.000đ','linh kiện chính hãng'],['Thay mặt kính','280.000 – 550.000đ','tùy kích thước'],['Sửa lỗi cảm ứng','150.000 – 350.000đ',''],['Thay IGBT/Mosfet','200.000 – 450.000đ','']],
    ],
    'bep-hong-ngoai' => [
        'title'    => 'Sửa bếp hồng ngoại','short' => 'Bếp hồng ngoại',
        'hero_desc'=> 'Sửa bếp hồng ngoại các thương hiệu nội địa và nhập khẩu. Khắc phục lỗi nhiệt độ, mặt kính, cảm ứng không phản hồi.',
        'symptoms' => ['Không lên nhiệt, vòng hồng ngoại tắt','Cảm ứng không hoạt động','Mặt kính vỡ, nứt','Báo lỗi nhiệt','Tự tắt sau vài phút','Nút bấm hỏng'],
        'fixes'    => ['Thay dây nhiệt hồng ngoại','Thay mặt kính','Sửa bo mạch điều khiển','Thay nút bấm cơ / cảm ứng','Sửa relay nhiệt','Thay cầu chì bảo vệ'],
        'errors'   => [['F1','Cảm biến nhiệt độ hỏng','red'],['F2','Quá nhiệt bề mặt (> 280°C)','red'],['F3','Lỗi nguồn điện đầu vào','orange'],['F4','Ngắn mạch dây nhiệt','red']],
        'pricing'  => [['Kiểm tra & chẩn đoán','Miễn phí','khi sửa chữa'],['Thay dây nhiệt','200.000 – 380.000đ',''],['Thay mặt kính','220.000 – 480.000đ',''],['Sửa bo mạch','300.000 – 700.000đ',''],['Thay nút bấm','80.000 – 180.000đ','']],
    ],
    'lo-nuong' => [
        'title'    => 'Sửa lò nướng',      'short' => 'Lò nướng',
        'hero_desc'=> 'Chuyên sửa lò nướng các hãng Sanaky, Sharp, Panasonic. Khắc phục lỗi không lên nhiệt, quạt đối lưu, dây nhiệt, bảng điều khiển.',
        'symptoms' => ['Không lên nhiệt hoặc lên nhiệt chậm','Dây nhiệt bị đứt','Timer và nút bấm lỗi','Quạt đối lưu không quay','Đèn trong lò không sáng','Mùi khét khi dùng'],
        'fixes'    => ['Thay dây nhiệt trên/dưới','Thay thermostat','Sửa/thay timer cơ hoặc điện tử','Thay motor quạt đối lưu','Thay bóng đèn lò','Vệ sinh, bảo dưỡng tổng quát'],
        'errors'   => [],
        'pricing'  => [['Kiểm tra & chẩn đoán','Miễn phí','khi sửa chữa'],['Thay dây nhiệt','200.000 – 380.000đ','tùy công suất'],['Thay thermostat','150.000 – 280.000đ',''],['Sửa timer, bảng phím','180.000 – 320.000đ',''],['Thay quạt đối lưu','250.000 – 420.000đ','']],
    ],
    'lo-vi-song' => [
        'title'    => 'Sửa lò vi sóng',    'short' => 'Lò vi sóng',
        'hero_desc'=> 'Sửa lò vi sóng Sharp, Panasonic, Samsung. Chuyên chẩn đoán lỗi magnetron, không nóng, không quay, hỏng bảng phím.',
        'symptoms' => ['Lò không nóng dù đèn sáng và mâm quay','Mâm xoay không quay','Bảng phím không phản hồi','Lò không phát ra âm thanh','Tự ngắt giữa chừng','Lò phát tiếng kêu lạ'],
        'fixes'    => ['Thay magnetron','Thay motor mâm xoay','Thay bảng phím cảm ứng','Thay cầu chì cao thế','Thay tụ điện cao thế','Sửa mạch nguồn'],
        'errors'   => [],
        'pricing'  => [['Kiểm tra & chẩn đoán','Miễn phí','khi sửa chữa'],['Thay magnetron','650.000 – 1.200.000đ','linh kiện chính hãng'],['Thay motor mâm xoay','150.000 – 280.000đ',''],['Sửa timer, bàn phím','180.000 – 320.000đ',''],['Thay tụ cao thế','120.000 – 200.000đ','']],
    ],
    'may-hut-mui' => [
        'title'    => 'Sửa máy hút mùi',   'short' => 'Máy hút mùi',
        'hero_desc'=> 'Sửa máy hút mùi Canzy, Sunhouse, Ariston, Bosch. Khắc phục mất hút, ồn, đèn hỏng, thay motor, lọc than hoạt tính.',
        'symptoms' => ['Hút gió yếu hoặc không hút','Phát tiếng ồn lớn bất thường','Đèn chiếu sáng không hoạt động','Lọc bị tắc, nhiều dầu mỡ','Cảm ứng không phản hồi','Rò rỉ dầu mỡ xuống bếp'],
        'fixes'    => ['Thay motor quạt hút','Vệ sinh lọc kim loại','Thay lọc than hoạt tính','Sửa/thay đèn LED','Sửa bảng cảm ứng','Kiểm tra, thay cánh quạt'],
        'errors'   => [],
        'pricing'  => [['Kiểm tra & chẩn đoán','Miễn phí','khi sửa chữa'],['Thay motor quạt','300.000 – 550.000đ','motor chính hãng'],['Vệ sinh tổng quát','100.000 – 180.000đ',''],['Thay lọc than hoạt tính','80.000 – 150.000đ',''],['Sửa đèn chiếu sáng','80.000 – 200.000đ','']],
    ],
];

// ── Load from kf_service CPT if available ────────────────────────────────────
$svc = $fallback[$service_slug] ?? $fallback['bep-tu'];

$cpt_post = get_posts([
    'post_type'      => 'kf_service',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'meta_key'       => 'service_slug',
    'meta_value'     => $service_slug,
]);

if (!empty($cpt_post)) {
    $cpt_id = $cpt_post[0]->ID;

    $raw_symptoms = get_post_meta($cpt_id, 'service_symptoms', true) ?: [];
    $raw_fixes    = get_post_meta($cpt_id, 'service_fixes',    true) ?: [];
    $raw_errors   = get_post_meta($cpt_id, 'service_errors',   true) ?: [];
    $raw_pricing  = get_post_meta($cpt_id, 'service_pricing',  true) ?: [];
    $raw_faq      = get_post_meta($cpt_id, 'service_faq',      true) ?: [];

    $hero_desc = get_post_meta($cpt_id, 'service_hero_desc', true);
    $price_from = get_post_meta($cpt_id, 'service_price_from', true);

    // Merge CPT data over fallback (only override if non-empty)
    if (!empty($hero_desc))    $svc['hero_desc'] = $hero_desc;
    if (!empty($price_from))   $svc['price']     = $price_from;
    if (!empty($raw_symptoms)) $svc['symptoms']  = array_column($raw_symptoms, 'text');
    if (!empty($raw_fixes))    $svc['fixes']     = array_column($raw_fixes,    'text');
    if (!empty($raw_errors))   $svc['errors']    = array_map(
        fn($e) => [$e['code'] ?? '', $e['desc'] ?? '', $e['severity'] ?? 'yellow'],
        $raw_errors
    );
    if (!empty($raw_pricing))  $svc['pricing']   = array_map(
        fn($p) => [$p['service_name'] ?? '', $p['price'] ?? '', $p['note'] ?? ''],
        $raw_pricing
    );
    if (!empty($raw_faq))      $svc['faq']       = array_map(
        fn($f) => [$f['question'] ?? '', $f['answer'] ?? ''],
        $raw_faq
    );
    $svc['title'] = $cpt_post[0]->post_title ?: $svc['title'];
}

// Severity colour map
$sev_styles = [
    'red'    => ['#FEE2E2', '#EF4444'],
    'yellow' => ['#FEF9C3', '#CA8A04'],
    'orange' => ['#FFF7ED', '#EA580C'],
];

get_header();
kitfix_header('light');
kitfix_breadcrumb([['label' => $svc['title']]]);
?>

<!-- ── Service Hero ── -->
<section class="kf-page-hero" aria-label="<?php echo esc_attr($svc['title']); ?>">
  <div class="kf-hero-pattern"></div>
  <div class="kf-container" style="position:relative;">
    <div style="display:grid;grid-template-columns:1fr auto;gap:32px;align-items:center;" class="kf-service-hero-grid">
      <div>
        <span class="kf-pill kf-pill-orange">Dịch vụ tại nhà — TP.HCM</span>
        <h1 style="font-size:40px;font-weight:800;line-height:1.2;margin-bottom:16px;"><?php echo esc_html($svc['title']); ?></h1>
        <p style="font-size:16px;opacity:.82;max-width:520px;line-height:1.7;margin-bottom:28px;"><?php echo esc_html($svc['hero_desc']); ?></p>
        <div style="display:flex;gap:12px;flex-wrap:wrap;">
          <a href="tel:0918611092" class="kf-btn kf-btn-primary kf-btn-lg">
            <?php kitfix_icon('phone', 17); ?> Gọi ngay: 0918.611.092
          </a>
          <a href="<?php echo esc_url(home_url('/dat-lich/')); ?>" class="kf-btn kf-btn-ghost kf-btn-lg">
            <?php kitfix_icon('calendar', 17); ?> Đặt lịch sửa
          </a>
        </div>
      </div>
      <div style="display:flex;flex-direction:column;gap:10px;" class="kf-service-hero-badges">
        <?php
        $badges = [
            ['award',   '20 năm kinh nghiệm'],
            ['shield',  'Bảo hành 12 tháng'],
            ['clock',   'Có mặt trong 60 phút'],
        ];
        foreach ($badges as [$icon, $label]):
        ?>
          <div class="kf-trust-item">
            <?php kitfix_icon($icon, 18, '#FDBA74'); ?>
            <span style="font-size:14px;font-weight:600;"><?php echo esc_html($label); ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <style>.kf-service-hero-grid{} @media(max-width:768px){.kf-service-hero-grid{grid-template-columns:1fr!important}.kf-service-hero-badges{display:none!important}}</style>
</section>

<!-- ── Symptoms + Fixes ── -->
<section style="padding:64px 0;background:#fff;">
  <div class="kf-container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:32px;" class="kf-sf-grid">
      <div>
        <h2 style="font-size:22px;font-weight:800;color:#1B4D7A;margin-bottom:20px;">Triệu chứng thường gặp</h2>
        <div style="display:flex;flex-direction:column;gap:8px;">
          <?php foreach ($svc['symptoms'] as $symptom): ?>
            <div class="kf-symptom-item">
              <?php kitfix_icon('alert', 16, '#F47B20'); ?>
              <span><?php echo esc_html($symptom); ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div>
        <h2 style="font-size:22px;font-weight:800;color:#1B4D7A;margin-bottom:20px;">Dịch vụ sửa chữa</h2>
        <div style="display:flex;flex-direction:column;gap:8px;">
          <?php foreach ($svc['fixes'] as $fix): ?>
            <div class="kf-fix-item">
              <?php kitfix_icon('check', 16, '#10B981'); ?>
              <span><?php echo esc_html($fix); ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <style>@media(max-width:700px){.kf-sf-grid{grid-template-columns:1fr!important}}</style>
</section>

<!-- ── Error code table ── -->
<?php if (!empty($svc['errors'])): ?>
<section style="padding:48px 0;background:#F5F7FA;">
  <div class="kf-container">
    <h2 style="font-size:24px;font-weight:800;color:#1B4D7A;margin-bottom:24px;">
      Bảng mã lỗi <?php echo esc_html($svc['short']); ?>
    </h2>
    <div class="kf-error-table">
      <div class="kf-error-table-head">
        <span>Mã lỗi</span>
        <span>Nguyên nhân &amp; xử lý</span>
      </div>
      <?php foreach ($svc['errors'] as $i => [$code, $desc, $sev]):
            [$bg, $tx] = $sev_styles[$sev] ?? ['#F5F7FA', '#5C6E87'];
      ?>
        <div class="kf-error-row" style="background:<?php echo $i % 2 ? '#fff' : '#FAFBFC'; ?>">
          <span class="kf-error-code" style="background:<?php echo esc_attr($bg); ?>;color:<?php echo esc_attr($tx); ?>;">
            <?php echo esc_html($code); ?>
          </span>
          <span style="font-size:14px;"><?php echo esc_html($desc); ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── Inline booking ── -->
<section style="padding:56px 0;background:#1B4D7A;">
  <div class="kf-container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:start;" class="kf-bstrip-grid">
      <div style="color:#fff;">
        <h2 style="font-size:30px;font-weight:800;margin-bottom:16px;">Đặt lịch sửa chữa ngay</h2>
        <p style="opacity:.8;font-size:15px;line-height:1.7;margin-bottom:24px;">KTV sẽ liên hệ xác nhận trong 15 phút. Miễn phí kiểm tra và chẩn đoán tại nhà.</p>
        <div style="display:flex;gap:12px;">
          <a href="tel:0918611092" class="kf-btn kf-btn-primary">
            <?php kitfix_icon('phone', 17); ?> 0918.611.092
          </a>
          <a href="https://zalo.me/0918611092" class="kf-zalo-btn" target="_blank" rel="noopener noreferrer">Zalo</a>
        </div>
      </div>
      <div style="background:#fff;border-radius:10px;padding:28px;">
        <form class="kf-form" id="kf-service-booking" method="post" novalidate>
          <?php wp_nonce_field('kitfix_booking', 'kitfix_nonce'); ?>
          <input type="hidden" name="booking_service" value="<?php echo esc_attr($svc['title']); ?>">
          <input type="text"  name="booking_name"    class="kf-input"   placeholder="Họ tên *" required>
          <input type="tel"   name="booking_phone"   class="kf-input"   placeholder="Số điện thoại *" required>
          <select name="booking_device" class="kf-select" required>
            <option value="">Chọn thiết bị *</option>
            <?php foreach (kitfix_get_services() as $s): ?>
              <option value="<?php echo esc_attr($s['title']); ?>"
                <?php selected($s['title'], $svc['title']); ?>>
                <?php echo esc_html($s['title']); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <textarea name="booking_note" class="kf-textarea" rows="2" placeholder="Mô tả lỗi..."></textarea>
          <button type="submit" class="kf-form-submit">Đặt lịch ngay</button>
        </form>
      </div>
    </div>
  </div>
  <style>@media(max-width:700px){.kf-bstrip-grid{grid-template-columns:1fr!important}}</style>
</section>

<?php
kitfix_footer();
kitfix_float_bar();
get_footer();
?>
