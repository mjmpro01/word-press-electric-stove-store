<?php
/**
 * Template Name: Về chúng tôi (About)
 * Template Post Type: page
 */

get_header();
kitfix_header('light');
kitfix_breadcrumb([['label' => 'Về chúng tôi']]);
?>

<!-- ── Hero ── -->
<section style="background:linear-gradient(135deg,#123557 0%,#1B4D7A 100%);color:#fff;padding:72px 0;position:relative;overflow:hidden;">
  <div class="kf-hero-pattern"></div>
  <div style="position:absolute;top:-60px;right:-60px;width:280px;height:280px;border-radius:50%;background:rgba(244,123,32,.12);pointer-events:none;"></div>
  <div class="kf-container" style="position:relative;">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center;" class="kf-about-hero-grid">
      <div>
        <span class="kf-pill kf-pill-orange">Câu chuyện của chúng tôi</span>
        <h1 style="font-size:42px;font-weight:800;line-height:1.2;margin-bottom:20px;">
          20 năm gắn bó<br>
          <span style="color:#F47B20;">với bếp Việt</span>
        </h1>
        <p style="font-size:16px;opacity:.82;line-height:1.8;margin-bottom:28px;max-width:480px;">
          KitFix24H được thành lập từ niềm tin đơn giản: mỗi gia đình xứng đáng có một chiếc bếp hoạt động tốt,
          và dịch vụ sửa chữa phải minh bạch, đúng giờ và đáng tin cậy.
        </p>
        <div style="display:flex;gap:16px;flex-wrap:wrap;">
          <a href="<?php echo esc_url(home_url('/dat-lich/')); ?>" class="kf-btn kf-btn-primary kf-btn-lg">
            <?php kitfix_icon('calendar', 17); ?> Đặt lịch ngay
          </a>
          <a href="tel:0918611092" class="kf-btn kf-btn-ghost kf-btn-lg">
            <?php kitfix_icon('phone', 17); ?> 0918.611.092
          </a>
        </div>
      </div>
      <div style="display:flex;flex-direction:column;gap:12px;" class="kf-about-hero-right">
        <div style="height:240px;background:rgba(255,255,255,.08);border:2px dashed rgba(255,255,255,.18);border-radius:12px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;">
          <?php kitfix_icon('users', 40, 'rgba(255,255,255,0.25)'); ?>
          <span style="color:rgba(255,255,255,.3);font-size:12px;font-family:monospace;">ảnh đội ngũ kỹ thuật viên</span>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
          <?php
          $stats = [
              ['20',    '', 'Năm kinh nghiệm'],
              ['5.000', '+', 'Khách hàng hài lòng'],
              ['300',   '+', 'Ca sửa chữa/tháng'],
              ['4.9★',  '', 'Đánh giá trung bình'],
          ];
          foreach ($stats as [$val, $suf, $label]):
          ?>
            <div class="kf-stat">
              <div class="kf-stat-val"><?php echo esc_html($val . $suf); ?></div>
              <div class="kf-stat-label"><?php echo esc_html($label); ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <style>@media(max-width:900px){.kf-about-hero-grid{grid-template-columns:1fr!important}.kf-about-hero-right{display:none!important}h1{font-size:32px!important}}</style>
</section>

<!-- ── Core values ── -->
<section style="padding:72px 0;background:#F5F7FA;">
  <div class="kf-container">
    <div class="kf-section-header centered">
      <h2 class="kf-section-title">Giá trị cốt lõi</h2>
      <p class="kf-section-subtitle">Những cam kết chúng tôi giữ vững qua 20 năm hoạt động</p>
    </div>
    <div class="kf-values-grid">
      <?php
      $values = [
          ['shield',    'Minh bạch tuyệt đối',   'Báo giá trước khi sửa. Không phát sinh chi phí ngoài hợp đồng. Xuất hóa đơn đầy đủ.', '#1B4D7A', 'rgba(27,77,122,.06)'],
          ['clock',     'Đúng giờ, đúng hẹn',    'Cam kết có mặt trong khung giờ đã hẹn. Nếu trễ, chúng tôi giảm 10% phí dịch vụ.', '#F47B20', 'rgba(244,123,32,.06)'],
          ['tool',      'Tay nghề thực chiến',    'Mỗi KTV phải trải qua ít nhất 2 năm học việc trước khi đi làm độc lập tại nhà khách.', '#10B981', 'rgba(16,185,129,.06)'],
          ['heart',     'Bảo hành dài hạn',       '12 tháng bảo hành tất cả dịch vụ. Linh kiện lỗi trong bảo hành thay miễn phí không hỏi.', '#EF4444', 'rgba(239,68,68,.06)'],
          ['thumbs-up', 'Linh kiện chính hãng',   '100% phụ tùng có tem nhà phân phối, mã QR xác thực. Không dùng hàng nhái, hàng tái sinh.', '#8B5CF6', 'rgba(139,92,246,.06)'],
          ['users',     'Đội ngũ chuyên nghiệp',  '10 kỹ thuật viên được đào tạo bài bản, trang bị đầy đủ dụng cụ chuyên dụng.', '#0EA5E9', 'rgba(14,165,233,.06)'],
      ];
      foreach ($values as [$icon, $title, $desc, $color, $bg]):
      ?>
        <div class="kf-value-card">
          <div class="kf-value-icon" style="background:<?php echo esc_attr($bg); ?>">
            <?php kitfix_icon($icon, 24, $color); ?>
          </div>
          <h3 style="font-size:16px;font-weight:700;margin-bottom:8px;"><?php echo esc_html($title); ?></h3>
          <p style="font-size:14px;color:#5C6E87;line-height:1.7;"><?php echo esc_html($desc); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── 20-year timeline ── -->
<section style="padding:72px 0;background:#fff;">
  <div class="kf-container">
    <div class="kf-section-header centered">
      <h2 class="kf-section-title">Hành trình 20 năm</h2>
      <p class="kf-section-subtitle">Từ garage nhỏ đến dịch vụ tin cậy của hàng nghìn gia đình</p>
    </div>
    <div class="kf-timeline">
      <?php
      $events = [
          ['2005', 'Khởi nghiệp từ garage', 'Anh Nguyễn Minh Khoa mở xưởng sửa bếp nhỏ tại Tân Bình với 2 kỹ thuật viên, chuyên sửa bếp gas và bếp điện truyền thống.', false],
          ['2010', 'Mở rộng sang bếp từ',  'Bếp từ bắt đầu phổ biến ở Việt Nam. KitFix là một trong những đơn vị đầu tiên tại TP.HCM đào tạo chuyên sâu về bếp từ.', false],
          ['2015', 'Ra mắt dịch vụ tại nhà', 'Chuyển mô hình sang 100% dịch vụ tại nhà. Đội ngũ lên 6 KTV, mở rộng ra tất cả quận nội thành TP.HCM.', false],
          ['2020', 'KitFix24H — Phục vụ 24 giờ', 'Đổi tên thành KitFix24H, cam kết có mặt trong 60 phút bất kể thời điểm trong ngày. Ra mắt dịch vụ đặt lịch online.', false],
          ['2025', '5.000+ khách hàng tin tưởng', 'Đội ngũ 10 KTV, hơn 5.000 lượt sửa chữa, đánh giá 4.9/5 trên Google Maps. Mở thêm shop phụ kiện online.', true],
      ];
      foreach ($events as [$year, $title, $desc, $current]):
      ?>
        <div class="kf-timeline-item">
          <div class="kf-timeline-dot <?php echo $current ? 'current' : ''; ?>">
            <?php if ($current): kitfix_icon('star', 10, 'white', 0); endif; ?>
          </div>
          <div class="kf-timeline-year"><?php echo esc_html($year); ?></div>
          <h3 class="kf-timeline-title"><?php echo esc_html($title); ?></h3>
          <p class="kf-timeline-desc"><?php echo esc_html($desc); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Team ── -->
<section style="padding:72px 0;background:#F5F7FA;">
  <div class="kf-container">
    <div class="kf-section-header centered">
      <h2 class="kf-section-title">Đội ngũ kỹ thuật viên</h2>
      <p class="kf-section-subtitle">Được đào tạo chuyên sâu, trang bị đầy đủ, phục vụ tận tâm</p>
    </div>
    <div class="kf-team-grid">
      <?php
      $team = [
          ['Nguyễn Minh Khoa', 'Sáng lập & Kỹ thuật trưởng', '20 năm kinh nghiệm', 'Bếp từ cao cấp (Bosch, Siemens)'],
          ['Trần Văn Hùng',    'Kỹ thuật viên cao cấp',       '12 năm kinh nghiệm', 'Lò vi sóng, lò nướng'],
          ['Lê Thị Thanh',     'Kỹ thuật viên',               '7 năm kinh nghiệm',  'Máy hút mùi, bếp hồng ngoại'],
          ['Phạm Đức Anh',     'Kỹ thuật viên',               '5 năm kinh nghiệm',  'Bếp từ, bếp điện từ'],
      ];
      foreach ($team as [$name, $role, $exp, $spec]):
          $initials = mb_substr(explode(' ', $name)[count(explode(' ', $name)) - 1], 0, 1);
      ?>
        <div class="kf-team-card">
          <div class="kf-team-avatar">
            <div class="kf-team-initials"><?php echo esc_html($initials); ?></div>
            <span style="font-size:11px;color:#9BAABF;font-family:monospace;">ảnh KTV</span>
          </div>
          <div class="kf-team-info">
            <h3 class="kf-team-name"><?php echo esc_html($name); ?></h3>
            <div class="kf-team-role"><?php echo esc_html($role); ?></div>
            <div style="display:flex;flex-direction:column;gap:5px;">
              <div style="font-size:12px;color:#5C6E87;">🏆 <?php echo esc_html($exp); ?></div>
              <div style="font-size:12px;color:#5C6E87;">🔧 <?php echo esc_html($spec); ?></div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Certifications ── -->
<section style="padding:56px 0;background:#fff;">
  <div class="kf-container">
    <div class="kf-section-header centered" style="margin-bottom:36px;">
      <h2 class="kf-section-title" style="font-size:28px;">Chứng nhận &amp; Đối tác</h2>
    </div>
    <div class="kf-certs">
      <?php
      $certs = [
          ['Đăng ký kinh doanh', 'UBND TP.HCM',         '#1B4D7A'],
          ['Đối tác dịch vụ Bosch', 'Authorized Service', '#EF4444'],
          ['Đối tác Sunhouse',  'Certified Technician',  '#F47B20'],
          ['Bảo hành 12 tháng', 'Cam kết chính sách',   '#10B981'],
          ['ISO 9001:2015',      'Chất lượng dịch vụ',   '#8B5CF6'],
      ];
      foreach ($certs as [$label, $sub, $color]):
      ?>
        <div class="kf-cert">
          <div class="kf-cert-icon" style="background:<?php echo esc_attr($color); ?>22;">
            <?php kitfix_icon('award', 22, $color); ?>
          </div>
          <div>
            <div style="font-size:14px;font-weight:700;"><?php echo esc_html($label); ?></div>
            <div style="font-size:12px;color:#9BAABF;"><?php echo esc_html($sub); ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── CTA Banner ── -->
<section style="padding:64px 0;background:linear-gradient(135deg,#123557,#1B4D7A);">
  <div class="kf-container" style="text-align:center;">
    <h2 style="font-size:32px;font-weight:800;color:#fff;margin-bottom:12px;">Bạn đang gặp sự cố?</h2>
    <p style="font-size:16px;color:rgba(255,255,255,.8);max-width:500px;margin:0 auto 32px;line-height:1.7;">
      Đừng để thiết bị hỏng làm gián đoạn cuộc sống. Gọi ngay hoặc đặt lịch — KTV có mặt trong 60 phút.
    </p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
      <a href="tel:0918611092" class="kf-btn kf-btn-primary kf-btn-lg">
        <?php kitfix_icon('phone', 18); ?> Gọi ngay: 0918.611.092
      </a>
      <a href="<?php echo esc_url(home_url('/dat-lich/')); ?>" class="kf-btn kf-btn-ghost kf-btn-lg">
        <?php kitfix_icon('calendar', 18); ?> Đặt lịch sửa chữa
      </a>
    </div>
  </div>
</section>

<?php
kitfix_footer();
kitfix_float_bar();
get_footer();
?>
