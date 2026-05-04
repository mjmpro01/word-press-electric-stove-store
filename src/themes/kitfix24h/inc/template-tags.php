<?php
/**
 * Reusable template helper functions (template tags).
 */

declare(strict_types=1);

/**
 * Render site header.
 */
function kitfix_header(string $variant = 'light'): void
{
    get_template_part('template-parts/header', null, ['variant' => $variant]);
}

/**
 * Render site footer.
 */
function kitfix_footer(): void
{
    get_template_part('template-parts/footer');
}

/**
 * Render floating mobile action bar.
 */
function kitfix_float_bar(): void
{
    get_template_part('template-parts/floating-bar');
}

/**
 * Render breadcrumb.
 *
 * @param array<int, array{label: string, url?: string}> $items
 */
function kitfix_breadcrumb(array $items): void
{
    echo '<div class="kf-breadcrumb-bar"><div class="kf-container"><nav class="kf-breadcrumb" aria-label="Breadcrumb">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Trang chủ', 'kitfix24h') . '</a>';
    foreach ($items as $item) {
        echo '<span class="kf-breadcrumb-sep">›</span>';
        if (!empty($item['url'])) {
            echo '<a href="' . esc_url($item['url']) . '">' . esc_html($item['label']) . '</a>';
        } else {
            echo '<span>' . esc_html($item['label']) . '</span>';
        }
    }
    echo '</nav></div></div>';
}

/**
 * Inline SVG icons (Lucide-style, matches design).
 *
 * @param string $name
 * @param int    $size
 * @param string $color
 * @param int    $strokeWidth
 */
function kitfix_icon(string $name, int $size = 20, string $color = 'currentColor', int $strokeWidth = 2): void
{
    $paths = [
        'phone'        => '<path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.4 19.79 19.79 0 01.1 4.82 2 2 0 012.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>',
        'calendar'     => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
        'shield'       => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
        'clock'        => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'map-pin'      => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>',
        'award'        => '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>',
        'star'         => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
        'check'        => '<polyline points="20 6 9 17 4 12"/>',
        'check-circle' => '<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
        'chevron-right'=> '<polyline points="9 18 15 12 9 6"/>',
        'chevron-down' => '<polyline points="6 9 12 15 18 9"/>',
        'arrow-right'  => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
        'menu'         => '<line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>',
        'x'            => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'zap'          => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
        'flame'        => '<path d="M8.5 14.5A2.5 2.5 0 0011 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 11-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 002.5 3z"/>',
        'tool'         => '<path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>',
        'alert'        => '<path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
        'search'       => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
        'shopping-cart'=> '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>',
        'wind'         => '<path d="M17.7 7.7a2.5 2.5 0 111.8 4.3H2"/><path d="M9.6 4.6A2 2 0 1111 8H2"/><path d="M12.6 19.4A2 2 0 1114 16H2"/>',
        'microwave'    => '<rect x="2" y="5" width="20" height="14" rx="2"/><rect x="5" y="8" width="10" height="8" rx="1"/><circle cx="18" cy="10" r="1"/><circle cx="18" cy="14" r="1"/>',
        'users'        => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>',
        'heart'        => '<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>',
        'thumbs-up'    => '<path d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3H14z"/><path d="M7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3"/>',
    ];

    $d = $paths[$name] ?? '<circle cx="12" cy="12" r="10"/>';

    printf(
        '<svg width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="%s" stroke-width="%d" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%s</svg>',
        $size,
        $size,
        esc_attr($color),
        $strokeWidth,
        $d
    );
}

/**
 * Render star rating.
 */
function kitfix_stars(float $rating = 5.0, int $size = 16): void
{
    echo '<div class="kf-stars">';
    for ($i = 1; $i <= 5; $i++) {
        $color = $i <= round($rating) ? '#F59E0B' : '#E5E7EB';
        echo '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="' . esc_attr($color) . '" stroke="none" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>';
    }
    echo '</div>';
}

/**
 * Zalo icon SVG.
 */
function kitfix_zalo_icon(int $size = 16, string $fill = 'white'): void
{
    printf(
        '<svg width="%d" height="%d" viewBox="0 0 24 24" fill="%s" aria-hidden="true"><text x="12" y="17" text-anchor="middle" font-size="14" font-weight="800">Z</text></svg>',
        $size,
        $size,
        esc_attr($fill)
    );
}

/**
 * Service data keyed by slug.
 *
 * @return array<string, array<string, mixed>>
 */
/**
 * Static icon/color map — these never change and don't belong in the DB.
 */
function kitfix_service_meta(): array
{
    return [
        'bep-tu'         => ['icon' => 'flame',     'color' => '#EF4444', 'bg' => '#FEF2F2'],
        'bep-hong-ngoai' => ['icon' => 'zap',       'color' => '#F59E0B', 'bg' => '#FFFBEB'],
        'lo-nuong'       => ['icon' => 'flame',     'color' => '#F47B20', 'bg' => '#FFF7ED'],
        'lo-vi-song'     => ['icon' => 'microwave', 'color' => '#8B5CF6', 'bg' => '#F5F3FF'],
        'may-hut-mui'    => ['icon' => 'wind',      'color' => '#0EA5E9', 'bg' => '#F0F9FF'],
    ];
}

/**
 * Return services array — reads ALL published kf_service CPT posts.
 * Falls back to 5 hardcoded entries only when no CPT posts exist.
 *
 * @return array<string, array{title:string,icon:string,color:string,bg:string,desc:string,price:string,post_id:int,url:string}>
 */
function kitfix_get_services(): array
{
    $meta_map = kitfix_service_meta();

    $fallback_icon  = ['icon' => 'tool',  'color' => '#1B4D7A', 'bg' => '#EFF6FF'];
    $fallback_price = 'Liên hệ báo giá';

    $posts = get_posts([
        'post_type'      => 'kf_service',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);

    if (!empty($posts)) {
        $services = [];
        foreach ($posts as $post) {
            $slug  = get_post_meta($post->ID, 'service_slug', true) ?: $post->post_name;
            $style = $meta_map[$slug] ?? $fallback_icon;
            $price = get_post_meta($post->ID, 'service_price_from', true) ?: $fallback_price;
            $desc  = get_post_meta($post->ID, 'service_hero_desc', true)
                  ?: wp_trim_words(wp_strip_all_tags($post->post_content), 14, '...');

            $services[$slug] = array_merge($style, [
                'title'   => $post->post_title,
                'desc'    => $desc,
                'price'   => $price,
                'post_id' => $post->ID,
                'url'     => get_permalink($post->ID),
            ]);
        }
        return $services;
    }

    // Fallback khi chưa có CPT nào
    return [
        'bep-tu'         => array_merge($meta_map['bep-tu'],         ['title' => 'Sửa bếp từ',         'desc' => 'Sửa không lên lửa, báo lỗi E0–E9, thay mâm từ, bo mạch',  'price' => 'Từ 150.000đ', 'post_id' => 0, 'url' => home_url('/dich-vu/bep-tu/')]),
        'bep-hong-ngoai' => array_merge($meta_map['bep-hong-ngoai'], ['title' => 'Sửa bếp hồng ngoại', 'desc' => 'Khắc phục lỗi nhiệt, mặt kính vỡ, cảm ứng hỏng',           'price' => 'Từ 120.000đ', 'post_id' => 0, 'url' => home_url('/dich-vu/bep-hong-ngoai/')]),
        'lo-nuong'       => array_merge($meta_map['lo-nuong'],        ['title' => 'Sửa lò nướng',        'desc' => 'Không lên nhiệt, dây nhiệt hỏng, timer lỗi, quạt đối lưu', 'price' => 'Từ 200.000đ', 'post_id' => 0, 'url' => home_url('/dich-vu/lo-nuong/')]),
        'lo-vi-song'     => array_merge($meta_map['lo-vi-song'],      ['title' => 'Sửa lò vi sóng',      'desc' => 'Không quay, không nóng, hỏng magnetron, bàn phím',          'price' => 'Từ 180.000đ', 'post_id' => 0, 'url' => home_url('/dich-vu/lo-vi-song/')]),
        'may-hut-mui'    => array_merge($meta_map['may-hut-mui'],     ['title' => 'Sửa máy hút mùi',     'desc' => 'Mất hút, ồn, đèn hỏng, thay motor, lọc than hoạt tính',   'price' => 'Từ 100.000đ', 'post_id' => 0, 'url' => home_url('/dich-vu/may-hut-mui/')]),
    ];
}
