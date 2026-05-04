<?php
/**
 * Template Name: Trang chủ (Homepage)
 * Template Post Type: page
 */

get_header();
kitfix_header('light');
?>

<!-- ── HERO ── -->
<section class="kf-hero" aria-label="Giới thiệu dịch vụ">
  <div class="kf-hero-pattern"></div>
  <div class="kf-hero-blob-1"></div>
  <div class="kf-hero-blob-2"></div>

  <div class="kf-container">
    <div class="kf-hero-grid">

      <!-- Left: copy -->
      <div>
        <span class="kf-pill kf-pill-orange">
          <?php kitfix_icon('zap', 13, '#FDBA74'); ?>
          Dịch vụ tại nhà — Có mặt trong 60 phút
        </span>

        <h1>
          Sửa chữa thiết bị<br>
          <span class="kf-hero-accent">bếp &amp; gia dụng</span><br>
          tại TP.HCM
        </h1>

        <p class="kf-hero-desc">
          Chuyên sửa bếp từ, bếp hồng ngoại, lò nướng, lò vi sóng, máy hút mùi.
          Kỹ thuật viên giàu kinh nghiệm, bảo hành 12 tháng.
        </p>

        <div class="kf-hero-ctas">
          <a href="tel:0918611092" class="kf-btn kf-btn-primary kf-btn-lg">
            <?php kitfix_icon('phone', 18); ?> Gọi ngay: 0918.611.092
          </a>
          <a href="<?php echo esc_url(home_url('/dat-lich/')); ?>" class="kf-btn kf-btn-ghost kf-btn-lg">
            <?php kitfix_icon('calendar', 18); ?> Đặt lịch sửa chữa
          </a>
        </div>

        <div class="kf-hero-trust">
          <?php
          $trust = [
              ['award',   'Kinh nghiệm', '20 năm'],
              ['shield',  'Bảo hành',    '12 tháng'],
              ['map-pin', 'Phục vụ',     'TP.HCM'],
          ];
          foreach ($trust as [$icon, $label, $value]):
          ?>
            <div class="kf-trust-item">
              <div class="kf-trust-icon"><?php kitfix_icon($icon, 16, '#FDBA74'); ?></div>
              <div>
                <div class="kf-trust-label"><?php echo esc_html($label); ?></div>
                <div class="kf-trust-value"><?php echo esc_html($value); ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Right: visual -->
      <div class="kf-hero-visual">
        <?php
        $hero_img  = function_exists('get_field') ? get_field('hero_image') : null;
        $img_src   = $hero_img['url']   ?? '';
        $img_alt   = $hero_img['alt']   ?? '';
        $img_w     = $hero_img['width'] ?? '';
        $img_h     = $hero_img['height'] ?? '';

        if ($img_src):
        ?>
          <img
            src="<?php echo esc_url($img_src); ?>"
            alt="<?php echo esc_attr($img_alt ?: get_the_title()); ?>"
            width="<?php echo esc_attr((string) $img_w); ?>"
            height="<?php echo esc_attr((string) $img_h); ?>"
            loading="eager"
            fetchpriority="high"
            class="kf-hero-img"
          >
        <?php elseif (has_post_thumbnail()): ?>
          <?php the_post_thumbnail('kitfix-hero', ['class' => 'kf-hero-img', 'loading' => 'eager', 'fetchpriority' => 'high']); ?>
        <?php else: ?>
          <img
            src="<?php echo esc_url(KITFIX_URI . '/assets/images/ki-thuat-vien.png'); ?>"
            alt="Kỹ thuật viên KitFix24H sửa bếp từ tại nhà"
            loading="eager"
            fetchpriority="high"
            class="kf-hero-img"
          >
        <?php endif; ?>
        <div class="kf-hero-features">
          <?php
          $features = [
              ['check-circle', 'Chẩn đoán miễn phí',    '#10B981'],
              ['clock',        'Có mặt trong 60 phút',   '#F47B20'],
              ['shield',       'Bảo hành linh kiện',     '#60A5FA'],
              ['star',         '4.9/5 từ 500+ khách',    '#FBBF24'],
          ];
          foreach ($features as [$icon, $text, $color]):
          ?>
            <div class="kf-hero-feature">
              <?php kitfix_icon($icon, 20, $color); ?>
              <span><?php echo esc_html($text); ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ── SERVICES ── -->
<section class="kf-services" id="services" aria-label="Dịch vụ sửa chữa">
  <div class="kf-container">
    <div class="kf-section-header centered">
      <span class="kf-pill kf-pill-blue">DỊCH VỤ CỦA CHÚNG TÔI</span>
      <h2 class="kf-section-title">5 dịch vụ sửa chữa chuyên nghiệp</h2>
      <p class="kf-section-subtitle">Kỹ thuật viên được đào tạo chuyên sâu, linh kiện chính hãng, bảo hành dài hạn</p>
    </div>

    <div class="kf-services-grid">
      <?php foreach (kitfix_get_services() as $slug => $svc): ?>
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
            <div class="kf-service-more">
              Xem chi tiết <?php kitfix_icon('chevron-right', 13, '#1B4D7A'); ?>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── HOW IT WORKS ── -->
<section class="kf-howitworks" aria-label="Quy trình làm việc">
  <div class="kf-container">
    <div class="kf-section-header centered">
      <h2 class="kf-section-title" style="color:#1B4D7A;">Quy trình làm việc</h2>
      <p class="kf-section-subtitle" style="margin:10px auto 0;">Minh bạch từ đầu đến cuối — không phí ẩn, không ngạc nhiên</p>
    </div>
    <div class="kf-steps">
      <?php
      $steps = [
          ['01', 'Liên hệ đặt lịch',      'Gọi điện hoặc nhắn Zalo, mô tả thiết bị hỏng. Chúng tôi tư vấn miễn phí và xác nhận lịch hẹn.'],
          ['02', 'Kỹ thuật viên đến nhà',  'KTV có mặt đúng giờ, mang theo đầy đủ dụng cụ và linh kiện phổ biến nhất.'],
          ['03', 'Chẩn đoán &amp; báo giá','Kiểm tra thiết bị, xác định lỗi, báo giá chi tiết trước khi sửa. Không phát sinh phí ẩn.'],
          ['04', 'Sửa chữa &amp; bàn giao','Sửa xong test kỹ trước mặt khách. Xuất phiếu bảo hành 12 tháng.'],
      ];
      foreach ($steps as $i => [$num, $title, $desc]):
      ?>
        <div class="kf-step">
          <?php if ($i < 3): ?>
            <div class="kf-step-connector"></div>
          <?php endif; ?>
          <div class="kf-step-num"><?php echo esc_html($num); ?></div>
          <h3 class="kf-step-title"><?php echo wp_kses_post($title); ?></h3>
          <p class="kf-step-desc"><?php echo esc_html($desc); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── PRICING ── -->
<section class="kf-pricing" id="pricing" aria-label="Bảng giá">
  <div class="kf-container">
    <div class="kf-section-header centered">
      <h2 class="kf-section-title">Bảng giá dịch vụ</h2>
      <p class="kf-section-subtitle">Giá tham khảo — báo giá chính xác sau khi kiểm tra thực tế. Cam kết không phát sinh</p>
    </div>

    <div class="kf-pricing-accordion" data-accordion>
      <?php
      $pricing_cats = [
        'Bếp từ / Bếp hồng ngoại' => [
          ['Kiểm tra, chẩn đoán', 'Miễn phí', 'Khi sửa chữa'],
          ['Thay mâm từ', '350.000 – 650.000đ', 'Tùy hãng'],
          ['Thay bo mạch điều khiển', '450.000 – 950.000đ', 'Hàng chính hãng'],
          ['Thay mặt kính', '280.000 – 550.000đ', 'Phụ thuộc kích thước'],
          ['Sửa lỗi cảm ứng', '150.000 – 350.000đ', ''],
        ],
        'Lò nướng / Lò vi sóng' => [
          ['Thay dây nhiệt', '200.000 – 380.000đ', 'Tùy công suất'],
          ['Thay magnetron', '650.000 – 1.200.000đ', 'Linh kiện chính hãng'],
          ['Sửa timer, bàn phím', '180.000 – 320.000đ', ''],
          ['Thay quạt đối lưu', '250.000 – 420.000đ', ''],
        ],
        'Máy hút mùi' => [
          ['Thay motor quạt', '300.000 – 550.000đ', 'Motor chính hãng'],
          ['Vệ sinh tổng quát', '100.000 – 180.000đ', ''],
          ['Thay lọc than hoạt tính', '80.000 – 150.000đ', 'Lọc tiêu chuẩn'],
          ['Sửa đèn chiếu sáng', '80.000 – 200.000đ', ''],
        ],
      ];
      foreach ($pricing_cats as $cat_title => $items):
      ?>
        <div class="kf-pricing-item">
          <button class="kf-pricing-toggle" data-pricing-toggle type="button">
            <span class="kf-pricing-toggle-title"><?php echo esc_html($cat_title); ?></span>
            <span class="kf-pricing-toggle-chevron">
              <?php kitfix_icon('chevron-down', 18, '#1B4D7A'); ?>
            </span>
          </button>
          <div class="kf-pricing-body" hidden>
            <?php foreach ($items as [$service, $price, $note]): ?>
              <div class="kf-pricing-row">
                <div>
                  <div class="kf-pricing-service"><?php echo esc_html($service); ?></div>
                  <?php if ($note): ?>
                    <div class="kf-pricing-note"><?php echo esc_html($note); ?></div>
                  <?php endif; ?>
                </div>
                <div class="kf-pricing-price"><?php echo esc_html($price); ?></div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="kf-pricing-note-footer">* Giá trên chưa bao gồm VAT. Giá chính xác sau khi kiểm tra thực tế.</p>
  </div>
</section>

<!-- ── TESTIMONIALS ── -->
<section class="kf-testimonials" aria-label="Đánh giá khách hàng">
  <div class="kf-container">
    <div class="kf-section-header centered">
      <h2 class="kf-section-title">Khách hàng nói gì về chúng tôi</h2>
      <div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:12px;">
        <?php kitfix_stars(5, 20); ?>
        <span style="font-size:16px;font-weight:700;">4.9/5</span>
        <span style="font-size:14px;color:#5C6E87;">từ 500+ đánh giá thực tế</span>
      </div>
    </div>

    <div class="kf-reviews-grid">
      <?php
      $reviews = [
        ['L', 'Nguyễn Thị Lan',  'Quận 3, TP.HCM',    5, 'Gọi lúc 8 giờ sáng, 9 giờ kỹ thuật viên đã có mặt. Sửa bếp từ Bosch xong trong vòng 45 phút. Giá hợp lý, có phiếu bảo hành đầy đủ.'],
        ['T', 'Trần Minh Tuấn',  'Thủ Đức, TP.HCM',   5, 'Lò vi sóng Sharp nhà mình bị hỏng magnetron. KTV giải thích rõ ràng trước khi sửa, báo giá chính xác. Đã dùng được 6 tháng vẫn tốt.'],
        ['H', 'Phạm Thu Hương',  'Bình Thạnh, TP.HCM', 5, 'Máy hút mùi bị ồn kinh khủng. Nhắn Zalo tối qua, sáng nay đã có người đến. Sửa nhanh, nhân viên lịch sự, dọn dẹp sạch sau khi làm.'],
        ['N', 'Lê Đức Nam',      'Quận 7, TP.HCM',    5, 'Đã dùng dịch vụ 3 lần rồi, lần nào cũng hài lòng. Đặc biệt tin tưởng vì họ dùng linh kiện chính hãng và bảo hành dài.'],
      ];
      foreach ($reviews as [$initial, $name, $location, $rating, $text]):
      ?>
        <div class="kf-review">
          <?php kitfix_stars((float)$rating, 14); ?>
          <p class="kf-review-text">"<?php echo esc_html($text); ?>"</p>
          <div class="kf-review-footer">
            <div class="kf-avatar"><?php echo esc_html($initial); ?></div>
            <div>
              <div class="kf-reviewer-name"><?php echo esc_html($name); ?></div>
              <div class="kf-reviewer-loc"><?php echo esc_html($location); ?></div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── SHOP PREVIEW ── -->
<section class="kf-shop-preview" aria-label="Phụ kiện linh kiện">
  <div class="kf-container">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:40px;flex-wrap:wrap;gap:16px;">
      <div>
        <h2 style="font-size:28px;font-weight:800;color:#1B4D7A;">Phụ kiện &amp; linh kiện thay thế</h2>
        <p style="font-size:15px;color:#5C6E87;margin-top:6px;">Linh kiện chính hãng, đúng model, bảo hành đầy đủ</p>
      </div>
      <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="kf-btn kf-btn-outline">
        Xem tất cả <?php kitfix_icon('arrow-right', 14); ?>
      </a>
    </div>

    <?php
    $shop_args = [
        'post_type'      => 'product',
        'posts_per_page' => 4,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    $shop_query = new WP_Query($shop_args);
    if ($shop_query->have_posts()):
    ?>
      <div class="kf-shop-grid">
        <?php while ($shop_query->have_posts()): $shop_query->the_post();
              $product = function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null;
              if (!$product) continue; ?>
          <div class="kf-product">
            <div class="kf-product-img">
              <?php if (has_post_thumbnail()):
                    the_post_thumbnail('kitfix-card', ['style' => 'width:100%;height:160px;object-fit:cover;']);
              else: ?>
                <?php kitfix_icon('tool', 32, '#9BAABF'); ?>
                <span style="font-size:11px;color:#9BAABF;font-family:monospace;">ảnh sản phẩm</span>
              <?php endif; ?>
            </div>
            <div class="kf-product-body">
              <h4 class="kf-product-name"><?php the_title(); ?></h4>
              <div>
                <span class="kf-product-price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
              </div>
              <a href="<?php the_permalink(); ?>" class="kf-btn kf-btn-blue kf-btn-sm" style="width:100%;justify-content:center;margin-top:12px;">
                Xem sản phẩm
              </a>
            </div>
          </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else: ?>
      <!-- Static fallback until WooCommerce products exist -->
      <div class="kf-shop-grid">
        <?php
        $demo_products = [
          ['Mâm từ bếp từ Sunhouse', '320.000đ', '380.000đ', 'Bán chạy'],
          ['Bo mạch điều khiển Elmich', '480.000đ', null, null],
          ['Mặt kính bếp từ 30cm', '195.000đ', '240.000đ', 'Giảm 19%'],
          ['Dây nhiệt lò nướng 1500W', '85.000đ', null, null],
        ];
        foreach ($demo_products as [$name, $price, $old, $badge]):
        ?>
          <div class="kf-product">
            <div class="kf-product-img">
              <?php if ($badge): ?>
                <div class="kf-product-badge"><?php echo esc_html($badge); ?></div>
              <?php endif; ?>
              <?php kitfix_icon('tool', 32, '#9BAABF'); ?>
              <span style="font-size:11px;color:#9BAABF;font-family:monospace;">ảnh sản phẩm</span>
            </div>
            <div class="kf-product-body">
              <h4 class="kf-product-name"><?php echo esc_html($name); ?></h4>
              <div>
                <span class="kf-product-price"><?php echo esc_html($price); ?></span>
                <?php if ($old): ?>
                  <span class="kf-product-old-price"><?php echo esc_html($old); ?></span>
                <?php endif; ?>
              </div>
              <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="kf-btn kf-btn-blue kf-btn-sm" style="width:100%;justify-content:center;margin-top:12px;">
                Mua ngay
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- ── BOOKING CTA ── -->
<section class="kf-booking-cta" aria-label="Đặt lịch sửa chữa">
  <div class="kf-container">
    <div class="kf-booking-grid">

      <!-- Info -->
      <div class="kf-booking-info">
        <h2>Đặt lịch sửa chữa<br>ngay hôm nay</h2>
        <p>KTV sẽ liên hệ xác nhận trong vòng 15 phút. Cam kết đến đúng giờ, báo giá minh bạch.</p>
        <?php
        $features = [
          ['clock',        'Phục vụ 7:00 – 21:00, kể cả cuối tuần'],
          ['map-pin',      '2 Bạch Đằng, Tân Sơn Hòa, TP.HCM'],
          ['shield',       'Bảo hành 12 tháng sau sửa chữa'],
          ['check-circle', 'Chẩn đoán miễn phí tại nhà'],
        ];
        foreach ($features as [$icon, $text]):
        ?>
          <div class="kf-booking-feature">
            <div class="kf-booking-feature-icon"><?php kitfix_icon($icon, 18, '#FDBA74'); ?></div>
            <span style="font-size:15px;opacity:.9;"><?php echo esc_html($text); ?></span>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Quick booking form -->
      <div class="kf-booking-form-wrap">
        <h3 class="kf-form-title">Đặt lịch sửa chữa</h3>
        <form class="kf-form" id="kf-quick-booking" method="post" novalidate>
          <?php wp_nonce_field('kitfix_booking', 'kitfix_nonce'); ?>
          <div class="kf-form-row">
            <div class="kf-form-group">
              <label class="kf-label" for="booking_name">Họ và tên *</label>
              <input type="text" id="booking_name" name="booking_name" class="kf-input" placeholder="Nguyễn Văn A" required>
            </div>
            <div class="kf-form-group">
              <label class="kf-label" for="booking_phone">Số điện thoại *</label>
              <input type="tel" id="booking_phone" name="booking_phone" class="kf-input" placeholder="0918 611 092" required>
            </div>
          </div>
          <div class="kf-form-group">
            <label class="kf-label" for="booking_service">Thiết bị cần sửa *</label>
            <select id="booking_service" name="booking_service" class="kf-select" required>
              <option value="">Chọn thiết bị...</option>
              <?php foreach (kitfix_get_services() as $svc): ?>
                <option value="<?php echo esc_attr($svc['title']); ?>"><?php echo esc_html($svc['title']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="kf-form-group">
            <label class="kf-label" for="booking_address">Địa chỉ *</label>
            <input type="text" id="booking_address" name="booking_address" class="kf-input" placeholder="Số nhà, đường, quận..." required>
          </div>
          <div class="kf-form-group">
            <label class="kf-label" for="booking_note">Mô tả lỗi (không bắt buộc)</label>
            <textarea id="booking_note" name="booking_note" class="kf-textarea" rows="3" placeholder="VD: Bếp từ không lên lửa, báo lỗi E1..."></textarea>
          </div>
          <button type="submit" class="kf-form-submit">Đặt lịch ngay — Miễn phí chẩn đoán</button>
          <p class="kf-form-footer">Hoặc gọi trực tiếp: <a href="tel:0918611092">0918.611.092</a></p>
        </form>
        <div id="kf-booking-success" class="kf-success" hidden>
          <div class="kf-success-icon"><?php kitfix_icon('check-circle', 32, '#10B981'); ?></div>
          <h3 style="font-size:20px;font-weight:700;color:#1B4D7A;margin-bottom:8px;">Đặt lịch thành công!</h3>
          <p style="color:#5C6E87;font-size:14px;">Chúng tôi sẽ gọi lại xác nhận trong 15 phút.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<?php
kitfix_footer();
kitfix_float_bar();
get_footer();
?>
