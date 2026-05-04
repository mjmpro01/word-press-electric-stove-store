<?php
/**
 * AJAX handlers for booking form submissions.
 * Both logged-in and guest users can submit.
 */

declare(strict_types=1);

add_action('wp_ajax_kitfix_submit_booking',        'kitfix_handle_booking');
add_action('wp_ajax_nopriv_kitfix_submit_booking', 'kitfix_handle_booking');

function kitfix_handle_booking(): void
{
    // Verify nonce
    if (!check_ajax_referer('kitfix_booking', 'kitfix_nonce', false)) {
        wp_send_json_error(['message' => 'Phiên làm việc hết hạn. Vui lòng tải lại trang.'], 403);
    }

    // Sanitize inputs
    $name     = sanitize_text_field(wp_unslash($_POST['booking_name']    ?? ''));
    $phone    = sanitize_text_field(wp_unslash($_POST['booking_phone']   ?? ''));
    $service  = sanitize_text_field(wp_unslash($_POST['booking_service'] ?? ''));
    $address  = sanitize_text_field(wp_unslash($_POST['booking_address'] ?? ''));
    $district = sanitize_text_field(wp_unslash($_POST['booking_district']?? ''));
    $date     = sanitize_text_field(wp_unslash($_POST['booking_date']    ?? ''));
    $time     = sanitize_text_field(wp_unslash($_POST['booking_time']    ?? ''));
    $note     = sanitize_textarea_field(wp_unslash($_POST['booking_note']?? ''));
    $brand    = sanitize_text_field(wp_unslash($_POST['booking_brand']   ?? ''));
    $symptoms = sanitize_textarea_field(wp_unslash($_POST['booking_symptoms'] ?? ''));

    // Require minimum fields
    if (empty($name) || empty($phone) || empty($service)) {
        wp_send_json_error(['message' => 'Vui lòng điền đầy đủ họ tên, số điện thoại và thiết bị.'], 422);
    }

    // Validate Vietnamese phone number
    if (!preg_match('/^(0|\+84)[0-9]{8,10}$/', preg_replace('/[\s.]/', '', $phone))) {
        wp_send_json_error(['message' => 'Số điện thoại không hợp lệ.'], 422);
    }

    // Create booking post
    $post_title = sprintf('%s — %s — %s', $name, $service, wp_date('d/m/Y H:i'));
    $post_id = wp_insert_post([
        'post_type'   => 'kf_booking',
        'post_title'  => $post_title,
        'post_status' => 'publish',
    ]);

    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => 'Không thể lưu lịch đặt. Vui lòng gọi điện trực tiếp.'], 500);
    }

    // Save meta
    $meta = compact('name', 'phone', 'service', 'brand', 'symptoms', 'address', 'district', 'date', 'time', 'note');
    foreach ($meta as $key => $value) {
        update_post_meta($post_id, "booking_{$key}", $value);
    }
    update_post_meta($post_id, 'booking_status', 'new');

    // Send notification email to admin
    kitfix_send_booking_email($post_id, compact('name', 'phone', 'service', 'address', 'district', 'date', 'time', 'note'));

    wp_send_json_success([
        'message'    => 'Đặt lịch thành công! Chúng tôi sẽ gọi xác nhận trong 15 phút.',
        'booking_id' => $post_id,
    ]);
}

function kitfix_send_booking_email(int $post_id, array $data): void
{
    $admin_email = get_option('admin_email');
    $subject     = sprintf('[KitFix24H] Lịch đặt mới từ %s — %s', $data['name'], $data['service']);
    $body        = sprintf(
        "Khách hàng: %s\nĐiện thoại: %s\nThiết bị: %s\nĐịa chỉ: %s, %s\nNgày hẹn: %s %s\nGhi chú: %s\n\nLink: %s",
        $data['name'],
        $data['phone'],
        $data['service'],
        $data['address'],
        $data['district'],
        $data['date'],
        $data['time'],
        $data['note'] ?: '(không có)',
        admin_url("post.php?post={$post_id}&action=edit")
    );
    wp_mail($admin_email, $subject, $body);
}
