<?php
/**
 * ACF Pro field group registrations.
 * Runs only when ACF is active.
 */

declare(strict_types=1);

add_action('acf/init', function (): void {

    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    /* ── Homepage hero ── */
    acf_add_local_field_group([
        'key'    => 'group_homepage_hero',
        'title'  => 'Hero – Trang chủ',
        'fields' => [
            [
                'key'           => 'field_hero_image',
                'label'         => 'Ảnh hero',
                'name'          => 'hero_image',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'kitfix-hero',
                'library'       => 'all',
                'instructions'  => 'Khuyến nghị: 1280×600 px, dạng JPG/WebP.',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'templates/page-homepage.php',
                ],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'side',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
    ]);
});
