<?php
/**
 * ACF Pro field group registration.
 * Only runs when ACF Pro is active.
 */

declare(strict_types=1);

add_action('acf/init', 'kitfix_register_acf_fields');

function kitfix_register_acf_fields(): void
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // ── Service page fields ──
    acf_add_local_field_group([
        'key'    => 'group_kf_service_page',
        'title'  => 'Thông tin dịch vụ',
        'fields' => [
            [
                'key'     => 'field_service_slug',
                'label'   => 'Slug dịch vụ',
                'name'    => 'service_slug',
                'type'    => 'select',
                'choices' => [
                    'bep-tu'         => 'Bếp từ',
                    'bep-hong-ngoai' => 'Bếp hồng ngoại',
                    'lo-nuong'       => 'Lò nướng',
                    'lo-vi-song'     => 'Lò vi sóng',
                    'may-hut-mui'    => 'Máy hút mùi',
                ],
                'instructions' => 'Chọn loại dịch vụ hiển thị trên trang này.',
            ],
            [
                'key'          => 'field_service_faq',
                'label'        => 'FAQ',
                'name'         => 'service_faq',
                'type'         => 'repeater',
                'sub_fields'   => [
                    ['key' => 'field_faq_q', 'label' => 'Câu hỏi', 'name' => 'question', 'type' => 'text'],
                    ['key' => 'field_faq_a', 'label' => 'Trả lời',  'name' => 'answer',   'type' => 'textarea'],
                ],
            ],
        ],
        'location' => [[
            ['param' => 'page_template', 'operator' => '==', 'value' => 'templates/page-service-detail.php'],
        ]],
    ]);

    // ── Homepage fields ──
    acf_add_local_field_group([
        'key'    => 'group_kf_homepage',
        'title'  => 'Cài đặt trang chủ',
        'fields' => [
            [
                'key'   => 'field_hero_cta_text',
                'label' => 'Nút CTA chính',
                'name'  => 'hero_cta_text',
                'type'  => 'text',
                'default_value' => 'Gọi ngay: 0918.611.092',
            ],
            [
                'key'   => 'field_show_pricing',
                'label' => 'Hiển thị bảng giá',
                'name'  => 'show_pricing',
                'type'  => 'true_false',
                'default_value' => 1,
            ],
        ],
        'location' => [[
            ['param' => 'page_template', 'operator' => '==', 'value' => 'templates/page-homepage.php'],
        ]],
    ]);

    // ── Testimonial fields ──
    acf_add_local_field_group([
        'key'    => 'group_kf_testimonial',
        'title'  => 'Thông tin đánh giá',
        'fields' => [
            ['key' => 'field_review_rating',   'label' => 'Điểm (1-5)',   'name' => 'rating',   'type' => 'number', 'min' => 1, 'max' => 5, 'default_value' => 5],
            ['key' => 'field_review_location', 'label' => 'Địa điểm',    'name' => 'location', 'type' => 'text'],
            ['key' => 'field_review_service',  'label' => 'Dịch vụ dùng', 'name' => 'service',  'type' => 'text'],
        ],
        'location' => [[
            ['param' => 'post_type', 'operator' => '==', 'value' => 'kf_testimonial'],
        ]],
    ]);
}
