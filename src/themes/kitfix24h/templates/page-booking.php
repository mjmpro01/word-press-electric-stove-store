<?php
/**
 * Template Name: Đặt lịch (Booking)
 * Template Post Type: page
 */

get_header();
kitfix_header('light');
kitfix_breadcrumb([['label' => 'Đặt lịch sửa chữa']]);
?>

<!-- Page banner -->
<div style="background:linear-gradient(135deg,#123557 0%,#1B4D7A 100%);color:#fff;padding:40px 0;">
  <div class="kf-container">
    <h1 style="font-size:36px;font-weight:800;margin-bottom:8px;">Đặt lịch sửa chữa</h1>
    <p style="font-size:16px;opacity:.8;">KTV xác nhận trong 15 phút · Chẩn đoán miễn phí · Bảo hành 12 tháng</p>
  </div>
</div>

<main style="padding:48px 0;">
  <div class="kf-container">
    <div style="display:grid;grid-template-columns:1.5fr 1fr;gap:32px;" class="kf-booking-page-grid">

      <!-- Multi-step booking form -->
      <div style="background:#fff;border:1px solid #DDE3EC;border-radius:12px;overflow:hidden;">

        <!-- Progress -->
        <div class="kf-booking-progress">
          <div class="kf-booking-steps" id="kf-steps">
            <?php
            $step_labels = ['Thiết bị', 'Thông tin', 'Thời gian', 'Xác nhận'];
            foreach ($step_labels as $i => $label):
            ?>
              <div style="flex:1;display:flex;align-items:center;" class="kf-step-wrap">
                <div>
                  <div class="kf-step-circle <?php echo $i === 0 ? 'active' : 'pending'; ?>" data-step="<?php echo $i; ?>">
                    <span class="kf-step-num-label"><?php echo $i + 1; ?></span>
                  </div>
                  <div class="kf-step-label <?php echo $i === 0 ? 'active' : ''; ?>"><?php echo esc_html($label); ?></div>
                </div>
                <?php if ($i < count($step_labels) - 1): ?>
                  <div class="kf-step-connector-line" data-connector="<?php echo $i; ?>"></div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Form body -->
        <div style="padding:28px;">
          <form id="kf-multistep-booking" method="post" novalidate>
            <?php wp_nonce_field('kitfix_booking', 'kitfix_nonce'); ?>

            <!-- Step 0: Device -->
            <div data-step-panel="0">
              <h3 style="font-size:18px;font-weight:800;color:#1B4D7A;margin-bottom:4px;">Chọn thiết bị cần sửa</h3>
              <p style="font-size:14px;color:#5C6E87;margin-bottom:20px;">Chọn loại thiết bị để chúng tôi chuẩn bị phụ tùng phù hợp</p>
              <div class="kf-svc-grid" style="margin-bottom:20px;">
                <?php
                $services = ['Bếp từ', 'Bếp hồng ngoại', 'Lò nướng', 'Lò vi sóng', 'Máy hút mùi'];
                foreach ($services as $svc_name):
                ?>
                  <button type="button" class="kf-svc-btn" data-value="<?php echo esc_attr($svc_name); ?>">
                    <?php echo esc_html($svc_name); ?>
                  </button>
                <?php endforeach; ?>
              </div>
              <input type="hidden" name="booking_service" id="booking_service_hidden">
              <div class="kf-form-group" style="margin-bottom:14px;">
                <label class="kf-label">Thương hiệu (không bắt buộc)</label>
                <input type="text" name="booking_brand" class="kf-input" placeholder="VD: Bosch, Sunhouse, Sharp...">
              </div>
              <div class="kf-form-group">
                <label class="kf-label">Mô tả lỗi</label>
                <textarea name="booking_symptoms" class="kf-textarea" rows="3" placeholder="VD: Không lên lửa, báo lỗi E1, màn hình chớp..."></textarea>
              </div>
            </div>

            <!-- Step 1: Contact -->
            <div data-step-panel="1" hidden>
              <h3 style="font-size:18px;font-weight:800;color:#1B4D7A;margin-bottom:4px;">Thông tin liên hệ</h3>
              <p style="font-size:14px;color:#5C6E87;margin-bottom:20px;">KTV sẽ liên hệ xác nhận lịch hẹn qua số điện thoại này</p>
              <div style="display:flex;flex-direction:column;gap:14px;">
                <div class="kf-form-row">
                  <div class="kf-form-group">
                    <label class="kf-label" for="b_name">Họ và tên *</label>
                    <input type="text" id="b_name" name="booking_name" class="kf-input" placeholder="Nguyễn Văn A" required>
                  </div>
                  <div class="kf-form-group">
                    <label class="kf-label" for="b_phone">Số điện thoại *</label>
                    <input type="tel" id="b_phone" name="booking_phone" class="kf-input" placeholder="0918 611 092" required>
                  </div>
                </div>
                <div class="kf-form-group">
                  <label class="kf-label" for="b_address">Địa chỉ cụ thể *</label>
                  <input type="text" id="b_address" name="booking_address" class="kf-input" placeholder="Số nhà, tên đường..." required>
                </div>
                <div class="kf-form-group">
                  <label class="kf-label" for="b_district">Quận / Huyện *</label>
                  <select id="b_district" name="booking_district" class="kf-select" required>
                    <option value="">Chọn quận/huyện...</option>
                    <?php
                    $districts = ['Quận 1','Quận 3','Quận 5','Quận 7','Quận 10','Bình Thạnh','Gò Vấp','Tân Bình','Tân Phú','Phú Nhuận','Thủ Đức','Bình Dương'];
                    foreach ($districts as $d): ?>
                      <option value="<?php echo esc_attr($d); ?>"><?php echo esc_html($d); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>

            <!-- Step 2: Schedule -->
            <div data-step-panel="2" hidden>
              <h3 style="font-size:18px;font-weight:800;color:#1B4D7A;margin-bottom:4px;">Chọn ngày &amp; giờ</h3>
              <p style="font-size:14px;color:#5C6E87;margin-bottom:20px;">Chúng tôi phục vụ 7:00 – 21:00, kể cả cuối tuần và lễ</p>
              <div style="display:flex;flex-direction:column;gap:14px;">
                <div class="kf-form-group">
                  <label class="kf-label" for="b_date">Ngày hẹn *</label>
                  <input type="date" id="b_date" name="booking_date" class="kf-input" required>
                </div>
                <div>
                  <label class="kf-label">Khung giờ *</label>
                  <div class="kf-time-grid">
                    <?php
                    $times = ['7:00 – 9:00','9:00 – 11:00','11:00 – 13:00','13:00 – 15:00','15:00 – 17:00','17:00 – 19:00','19:00 – 21:00'];
                    foreach ($times as $t):
                    ?>
                      <button type="button" class="kf-time-slot" data-value="<?php echo esc_attr($t); ?>">
                        <?php echo esc_html($t); ?>
                      </button>
                    <?php endforeach; ?>
                  </div>
                  <input type="hidden" name="booking_time" id="booking_time_hidden">
                </div>
                <div class="kf-form-group">
                  <label class="kf-label">Ghi chú thêm</label>
                  <textarea name="booking_note" class="kf-textarea" rows="2" placeholder="VD: Nhà có chó, gọi trước khi đến, tầng 3..."></textarea>
                </div>
              </div>
            </div>

            <!-- Step 3: Confirm -->
            <div data-step-panel="3" hidden>
              <h3 style="font-size:18px;font-weight:800;color:#1B4D7A;margin-bottom:4px;">Xác nhận thông tin</h3>
              <p style="font-size:14px;color:#5C6E87;margin-bottom:20px;">Kiểm tra lại thông tin trước khi gửi</p>
              <div class="kf-confirm-table" id="kf-confirm-summary"></div>
              <div style="margin-top:16px;padding:12px 16px;background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.25);border-radius:8px;">
                <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#059669;font-weight:600;">
                  <?php kitfix_icon('shield', 15, '#10B981'); ?>
                  Cam kết miễn phí kiểm tra &amp; báo giá trước khi sửa
                </div>
              </div>
            </div>

            <!-- Navigation -->
            <div style="display:flex;justify-content:space-between;margin-top:24px;gap:12px;">
              <button type="button" id="kf-step-back" class="kf-btn kf-btn-outline" style="display:none;">← Quay lại</button>
              <div></div>
              <button type="button" id="kf-step-next" class="kf-btn kf-btn-blue">Tiếp theo →</button>
              <button type="submit" id="kf-step-submit" class="kf-btn kf-btn-primary" style="display:none;">Xác nhận đặt lịch</button>
            </div>
          </form>

          <!-- Success state -->
          <div id="kf-booking-success-full" class="kf-success" hidden style="padding:32px 0;">
            <div class="kf-success-icon"><?php kitfix_icon('check-circle', 40, '#10B981'); ?></div>
            <h2 style="font-size:24px;font-weight:800;color:#1B4D7A;margin-bottom:10px;">Đặt lịch thành công! 🎉</h2>
            <p style="color:#5C6E87;font-size:15px;line-height:1.7;max-width:380px;margin:0 auto 8px;">
              Chúng tôi sẽ gọi lại xác nhận lịch hẹn trong vòng <strong>15 phút</strong>.
            </p>
            <div id="kf-success-summary" style="background:#F5F7FA;border-radius:8px;padding:16px 20px;margin:20px auto;max-width:340px;text-align:left;"></div>
            <button type="button" id="kf-new-booking" class="kf-btn kf-btn-blue">Đặt lịch mới</button>
          </div>
        </div>
      </div>

      <!-- Contact sidebar -->
      <div style="display:flex;flex-direction:column;gap:20px;">
        <!-- Direct contact -->
        <div style="background:#fff;border:1px solid #DDE3EC;border-radius:10px;padding:24px;">
          <h3 style="font-size:16px;font-weight:700;color:#1B4D7A;margin-bottom:16px;">Liên hệ trực tiếp</h3>
          <div style="display:flex;flex-direction:column;gap:14px;">
            <a href="tel:0918611092" style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:#1B4D7A;color:#fff;border-radius:8px;font-weight:700;font-size:15px;text-decoration:none;">
              <div style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;">
                <?php kitfix_icon('phone', 18, 'white'); ?>
              </div>
              <div>
                <div style="font-size:12px;opacity:.7;">Gọi ngay — 7:00 đến 21:00</div>
                <div>0918.611.092</div>
              </div>
            </a>
            <a href="https://zalo.me/0918611092" target="_blank" rel="noopener noreferrer" style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:#0068FF;color:#fff;border-radius:8px;font-weight:700;font-size:15px;text-decoration:none;">
              <div style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;">
                <?php kitfix_zalo_icon(18); ?>
              </div>
              <div>
                <div style="font-size:12px;opacity:.7;">Nhắn tin Zalo</div>
                <div>Chat ngay — phản hồi trong 5 phút</div>
              </div>
            </a>
          </div>
        </div>

        <!-- Address + hours -->
        <div style="background:#fff;border:1px solid #DDE3EC;border-radius:10px;padding:24px;">
          <h3 style="font-size:16px;font-weight:700;color:#1B4D7A;margin-bottom:16px;">Địa chỉ &amp; Giờ làm việc</h3>
          <div style="display:flex;flex-direction:column;gap:12px;">
            <div style="display:flex;gap:10px;">
              <?php kitfix_icon('map-pin', 18, '#F47B20'); ?>
              <span style="font-size:14px;color:#4A5568;line-height:1.5;">2 Bạch Đằng, Tân Sơn Hòa,<br>TP. Hồ Chí Minh</span>
            </div>
            <div style="display:flex;gap:10px;">
              <?php kitfix_icon('clock', 18, '#F47B20'); ?>
              <span style="font-size:14px;color:#4A5568;">Thứ Hai – Chủ Nhật: 7:00 – 21:00</span>
            </div>
            <div style="display:flex;gap:10px;">
              <?php kitfix_icon('calendar', 18, '#10B981'); ?>
              <span style="font-size:14px;color:#4A5568;">Phục vụ cả lễ, tết theo yêu cầu</span>
            </div>
          </div>
          <!-- Map placeholder -->
          <div style="margin-top:16px;height:140px;background:#F5F7FA;border-radius:8px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;border:1.5px dashed #DDE3EC;">
            <?php kitfix_icon('map-pin', 24, '#9BAABF'); ?>
            <span style="font-size:12px;color:#9BAABF;font-family:monospace;">Google Maps embed</span>
          </div>
        </div>

        <!-- Guarantee -->
        <div class="kf-guarantee">
          <h3 class="kf-guarantee-title">Cam kết của KitFix24H</h3>
          <?php
          $guarantees = [
              'Miễn phí chẩn đoán tại nhà',
              'Báo giá trước — không phát sinh phí ẩn',
              'Bảo hành 12 tháng sau sửa chữa',
              'Hoàn tiền 100% nếu không sửa được',
          ];
          foreach ($guarantees as $g):
          ?>
            <div class="kf-guarantee-item">
              <?php kitfix_icon('check', 15, '#10B981'); ?>
              <?php echo esc_html($g); ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</main>

<style>@media(max-width:900px){.kf-booking-page-grid{grid-template-columns:1fr!important}}</style>

<?php
kitfix_footer();
kitfix_float_bar();
get_footer();
?>
