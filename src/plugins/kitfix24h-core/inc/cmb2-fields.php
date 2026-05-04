<?php
/**
 * CMB2 field registration for kf_service CPT.
 * Replaces ACF Pro dependency for service management.
 */

declare(strict_types=1);

add_action('cmb2_admin_init', 'kitfix_register_service_fields');

function kitfix_register_service_fields(): void
{
    // ── Service: basic info ──────────────────────────────────────────────────
    $basic = new_cmb2_box([
        'id'           => 'kf_service_basic',
        'title'        => 'Thông tin cơ bản',
        'object_types' => ['kf_service'],
        'context'      => 'normal',
        'priority'     => 'high',
    ]);

    $basic->add_field([
        'id'      => 'service_slug',
        'name'    => 'Slug dịch vụ',
        'type'    => 'select',
        'desc'    => 'Dùng để xác định icon, màu sắc và trang chi tiết.',
        'options' => [
            'bep-tu'         => 'Bếp từ',
            'bep-hong-ngoai' => 'Bếp hồng ngoại',
            'lo-nuong'       => 'Lò nướng',
            'lo-vi-song'     => 'Lò vi sóng',
            'may-hut-mui'    => 'Máy hút mùi',
        ],
    ]);

    $basic->add_field([
        'id'   => 'service_price_from',
        'name' => 'Giá từ',
        'type' => 'text',
        'desc' => 'VD: từ 150.000đ — hiển thị trên card dịch vụ',
    ]);

    $basic->add_field([
        'id'   => 'service_hero_desc',
        'name' => 'Mô tả hero',
        'type' => 'textarea_small',
        'desc' => 'Câu mô tả dưới tiêu đề trang dịch vụ.',
        'attributes' => ['rows' => 3],
    ]);

    // ── Service: symptoms (repeatable) ──────────────────────────────────────
    $symptoms = new_cmb2_box([
        'id'           => 'kf_service_symptoms',
        'title'        => 'Triệu chứng thường gặp',
        'object_types' => ['kf_service'],
    ]);

    $symptoms->add_field([
        'id'          => 'service_symptoms',
        'name'        => 'Danh sách triệu chứng',
        'type'        => 'group',
        'repeatable'  => true,
        'options'     => [
            'group_title'   => 'Triệu chứng {#}',
            'add_button'    => 'Thêm triệu chứng',
            'remove_button' => 'Xoá',
            'sortable'      => true,
        ],
        'fields' => [
            [
                'id'   => 'text',
                'name' => 'Mô tả triệu chứng',
                'type' => 'text',
            ],
        ],
    ]);

    // ── Service: fixes (repeatable) ──────────────────────────────────────────
    $fixes = new_cmb2_box([
        'id'           => 'kf_service_fixes',
        'title'        => 'Phương án sửa chữa',
        'object_types' => ['kf_service'],
    ]);

    $fixes->add_field([
        'id'          => 'service_fixes',
        'name'        => 'Danh sách sửa chữa',
        'type'        => 'group',
        'repeatable'  => true,
        'options'     => [
            'group_title'   => 'Sửa chữa {#}',
            'add_button'    => 'Thêm phương án',
            'remove_button' => 'Xoá',
            'sortable'      => true,
        ],
        'fields' => [
            [
                'id'   => 'text',
                'name' => 'Phương án',
                'type' => 'text',
            ],
        ],
    ]);

    // ── Service: error codes (repeatable) ────────────────────────────────────
    $errors = new_cmb2_box([
        'id'           => 'kf_service_errors',
        'title'        => 'Bảng mã lỗi',
        'object_types' => ['kf_service'],
    ]);

    $errors->add_field([
        'id'          => 'service_errors',
        'name'        => 'Mã lỗi',
        'type'        => 'group',
        'repeatable'  => true,
        'options'     => [
            'group_title'   => 'Mã lỗi {#}',
            'add_button'    => 'Thêm mã lỗi',
            'remove_button' => 'Xoá',
            'sortable'      => true,
        ],
        'fields' => [
            [
                'id'   => 'code',
                'name' => 'Mã lỗi (VD: E1)',
                'type' => 'text_small',
            ],
            [
                'id'   => 'desc',
                'name' => 'Mô tả lỗi',
                'type' => 'text',
            ],
            [
                'id'      => 'severity',
                'name'    => 'Mức độ',
                'type'    => 'select',
                'options' => [
                    'yellow' => 'Nhẹ (vàng)',
                    'orange' => 'Trung bình (cam)',
                    'red'    => 'Nghiêm trọng (đỏ)',
                ],
            ],
        ],
    ]);

    // ── Service: pricing (repeatable) ────────────────────────────────────────
    $pricing = new_cmb2_box([
        'id'           => 'kf_service_pricing',
        'title'        => 'Bảng giá dịch vụ',
        'object_types' => ['kf_service'],
    ]);

    $pricing->add_field([
        'id'          => 'service_pricing',
        'name'        => 'Danh mục giá',
        'type'        => 'group',
        'repeatable'  => true,
        'options'     => [
            'group_title'   => 'Dịch vụ {#}',
            'add_button'    => 'Thêm dòng giá',
            'remove_button' => 'Xoá',
            'sortable'      => true,
        ],
        'fields' => [
            [
                'id'   => 'service_name',
                'name' => 'Tên dịch vụ',
                'type' => 'text',
            ],
            [
                'id'   => 'note',
                'name' => 'Ghi chú (tùy chọn)',
                'type' => 'text_small',
            ],
            [
                'id'   => 'price',
                'name' => 'Giá',
                'type' => 'text_small',
                'desc' => 'VD: 350.000 – 650.000đ',
            ],
        ],
    ]);

    // ── Service: FAQ (repeatable) ────────────────────────────────────────────
    $faq = new_cmb2_box([
        'id'           => 'kf_service_faq',
        'title'        => 'Câu hỏi thường gặp (FAQ)',
        'object_types' => ['kf_service'],
    ]);

    $faq->add_field([
        'id'          => 'service_faq',
        'name'        => 'FAQ',
        'type'        => 'group',
        'repeatable'  => true,
        'options'     => [
            'group_title'   => 'Câu hỏi {#}',
            'add_button'    => 'Thêm câu hỏi',
            'remove_button' => 'Xoá',
            'sortable'      => true,
        ],
        'fields' => [
            [
                'id'   => 'question',
                'name' => 'Câu hỏi',
                'type' => 'text',
            ],
            [
                'id'   => 'answer',
                'name' => 'Trả lời',
                'type' => 'textarea_small',
                'attributes' => ['rows' => 3],
            ],
        ],
    ]);

    // ── Testimonial fields (replaces ACF) ────────────────────────────────────
    $review = new_cmb2_box([
        'id'           => 'kf_testimonial_fields',
        'title'        => 'Thông tin đánh giá',
        'object_types' => ['kf_testimonial'],
    ]);

    $review->add_field([
        'id'         => 'rating',
        'name'       => 'Điểm (1-5)',
        'type'       => 'select',
        'options'    => ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'],
        'default'    => '5',
    ]);
    $review->add_field(['id' => 'location', 'name' => 'Địa điểm',     'type' => 'text']);
    $review->add_field(['id' => 'service',  'name' => 'Dịch vụ dùng', 'type' => 'text']);
}
