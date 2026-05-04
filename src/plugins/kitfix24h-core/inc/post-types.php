<?php
/**
 * Custom post types and taxonomies.
 */

declare(strict_types=1);

add_action('init', 'kitfix_register_post_types');

function kitfix_register_post_types(): void
{
    // Service CPT
    register_post_type('kf_service', [
        'labels' => [
            'name'          => 'Dịch vụ',
            'singular_name' => 'Dịch vụ',
            'add_new_item'  => 'Thêm dịch vụ',
            'edit_item'     => 'Sửa dịch vụ',
        ],
        'public'            => true,
        'has_archive'       => 'dich-vu',
        'rewrite'           => ['slug' => 'dich-vu', 'with_front' => false],
        'menu_icon'         => 'dashicons-admin-tools',
        'supports'          => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'show_in_rest'      => true,
    ]);

    // Booking CPT (private — admin only)
    register_post_type('kf_booking', [
        'labels' => [
            'name'          => 'Lịch đặt',
            'singular_name' => 'Lịch đặt',
            'add_new_item'  => 'Thêm lịch đặt',
            'edit_item'     => 'Xem lịch đặt',
        ],
        'public'            => false,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'menu_icon'         => 'dashicons-calendar-alt',
        'supports'          => ['title', 'custom-fields'],
        'capability_type'   => 'post',
        'map_meta_cap'      => true,
    ]);

    // Testimonial CPT
    register_post_type('kf_testimonial', [
        'labels' => [
            'name'          => 'Đánh giá',
            'singular_name' => 'Đánh giá',
        ],
        'public'            => false,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'menu_icon'         => 'dashicons-star-filled',
        'supports'          => ['title', 'editor', 'custom-fields'],
        'show_in_rest'      => true,
    ]);
}

// ── Booking detail meta box ──────────────────────────────────────────────────
add_action('add_meta_boxes', 'kitfix_booking_meta_boxes');
add_action('save_post_kf_booking', 'kitfix_booking_save_status');

function kitfix_booking_meta_boxes(): void
{
    add_meta_box(
        'kf_booking_details',
        'Chi tiết lịch đặt',
        'kitfix_booking_detail_cb',
        'kf_booking',
        'normal',
        'high'
    );
    add_meta_box(
        'kf_booking_status_box',
        'Trạng thái',
        'kitfix_booking_status_cb',
        'kf_booking',
        'side',
        'high'
    );
}

function kitfix_booking_detail_cb(\WP_Post $post): void
{
    $id = $post->ID;
    $fields = [
        'booking_name'     => 'Họ và tên',
        'booking_phone'    => 'Số điện thoại',
        'booking_service'  => 'Thiết bị',
        'booking_brand'    => 'Thương hiệu',
        'booking_symptoms' => 'Mô tả lỗi',
        'booking_address'  => 'Địa chỉ',
        'booking_district' => 'Quận/Huyện',
        'booking_date'     => 'Ngày hẹn',
        'booking_time'     => 'Khung giờ',
        'booking_note'     => 'Ghi chú',
    ];
    echo '<table class="widefat striped" style="border-collapse:collapse;">';
    echo '<tbody>';
    foreach ($fields as $meta_key => $label) {
        $value = get_post_meta($id, $meta_key, true);
        if ($value === '' || $value === false) {
            continue;
        }
        printf(
            '<tr><th style="width:160px;padding:8px 12px;font-weight:600;text-align:left;">%s</th><td style="padding:8px 12px;">%s</td></tr>',
            esc_html($label),
            nl2br(esc_html($value))
        );
    }
    echo '</tbody></table>';

    $phone = get_post_meta($id, 'booking_phone', true);
    if ($phone) {
        printf(
            '<p style="margin-top:12px;"><a href="tel:%s" class="button button-primary">📞 Gọi %s</a></p>',
            esc_attr(preg_replace('/\D/', '', $phone)),
            esc_html($phone)
        );
    }
}

function kitfix_booking_status_cb(\WP_Post $post): void
{
    wp_nonce_field('kf_booking_status', 'kf_booking_status_nonce');
    $current = get_post_meta($post->ID, 'booking_status', true) ?: 'new';
    $options = [
        'new'       => '🆕 Mới',
        'confirmed' => '✅ Đã xác nhận',
        'done'      => '✔ Hoàn thành',
        'cancelled' => '❌ Huỷ',
    ];
    echo '<select name="kf_booking_status" style="width:100%;margin-top:4px;">';
    foreach ($options as $val => $label) {
        printf(
            '<option value="%s"%s>%s</option>',
            esc_attr($val),
            selected($current, $val, false),
            esc_html($label)
        );
    }
    echo '</select>';
}

function kitfix_booking_save_status(int $post_id): void
{
    if (
        ! isset($_POST['kf_booking_status_nonce']) ||
        ! wp_verify_nonce(sanitize_key($_POST['kf_booking_status_nonce']), 'kf_booking_status') ||
        defined('DOING_AUTOSAVE') && DOING_AUTOSAVE
    ) {
        return;
    }
    if (isset($_POST['kf_booking_status'])) {
        $allowed = ['new', 'confirmed', 'done', 'cancelled'];
        $status  = sanitize_key($_POST['kf_booking_status']);
        if (in_array($status, $allowed, true)) {
            update_post_meta($post_id, 'booking_status', $status);
        }
    }
}

// Admin columns for bookings
add_filter('manage_kf_booking_posts_columns', 'kitfix_booking_columns');
add_action('manage_kf_booking_posts_custom_column', 'kitfix_booking_column_data', 10, 2);

function kitfix_booking_columns(array $cols): array
{
    return [
        'cb'       => '<input type="checkbox">',
        'title'    => 'Khách hàng',
        'phone'    => 'Điện thoại',
        'service'  => 'Thiết bị',
        'date_booked' => 'Ngày hẹn',
        'status'   => 'Trạng thái',
        'date'     => 'Ngày gửi',
    ];
}

function kitfix_booking_column_data(string $col, int $post_id): void
{
    switch ($col) {
        case 'phone':
            echo esc_html(get_post_meta($post_id, 'booking_phone', true));
            break;
        case 'service':
            echo esc_html(get_post_meta($post_id, 'booking_service', true));
            break;
        case 'date_booked':
            $d = get_post_meta($post_id, 'booking_date', true);
            $t = get_post_meta($post_id, 'booking_time', true);
            echo esc_html($d . ($t ? " · $t" : ''));
            break;
        case 'status':
            $status = get_post_meta($post_id, 'booking_status', true) ?: 'new';
            $labels = ['new' => '🆕 Mới', 'confirmed' => '✅ Đã xác nhận', 'done' => '✔ Hoàn thành', 'cancelled' => '❌ Huỷ'];
            echo esc_html($labels[$status] ?? $status);
            break;
    }
}
