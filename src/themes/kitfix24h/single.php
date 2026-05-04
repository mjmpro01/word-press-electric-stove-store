<?php
/**
 * Single dịch vụ template.
 */
get_header();
kitfix_header('light');
kitfix_breadcrumb([
    ['label' => 'Dịch vụ', 'url' => home_url('/dich-vu/')],
    ['label' => get_the_title()],
]);

while (have_posts()): the_post();
$read_time = ceil(str_word_count(strip_tags(get_the_content())) / 200);
?>

<div style="background:#F5F7FA;padding:48px 0;">
  <div class="kf-container">
    <div class="kf-post-layout">

      <!-- Article -->
      <article class="kf-post-body">
        <!-- Meta -->
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
          <?php $cats = get_the_category(); if ($cats): ?>
            <span class="kf-blog-cat" style="background:#EEF1F5;color:#1B4D7A;">
              <?php echo esc_html($cats[0]->name); ?>
            </span>
          <?php endif; ?>
          <span style="font-size:13px;color:#9BAABF;display:flex;align-items:center;gap:4px;">
            <?php kitfix_icon('calendar', 14, '#9BAABF'); ?>
            <?php the_date('d/m/Y'); ?>
          </span>
          <span style="font-size:13px;color:#9BAABF;display:flex;align-items:center;gap:4px;">
            <?php kitfix_icon('clock', 14, '#9BAABF'); ?>
            <?php echo esc_html($read_time); ?> phút đọc
          </span>
        </div>

        <h1><?php the_title(); ?></h1>

        <?php if (has_post_thumbnail()): ?>
          <div style="margin:24px 0;border-radius:10px;overflow:hidden;">
            <?php the_post_thumbnail('kitfix-hero', ['style' => 'width:100%;max-height:400px;object-fit:cover;']); ?>
          </div>
        <?php endif; ?>

        <div style="font-size:16px;line-height:1.8;color:#4A5568;">
          <?php the_content(); ?>
        </div>

        <!-- Tags -->
        <?php the_tags('<div style="margin-top:32px;padding-top:20px;border-top:1px solid #EEF1F5;"><div style="display:flex;flex-wrap:wrap;gap:8px;">', '', '</div></div>'); ?>

        <!-- Share -->
        <div style="margin-top:32px;padding-top:20px;border-top:1px solid #EEF1F5;display:flex;align-items:center;gap:12px;">
          <span style="font-size:14px;font-weight:600;color:#1B4D7A;">Chia sẻ:</span>
          <a href="https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" target="_blank" rel="noopener noreferrer" style="padding:8px 16px;background:#1877F2;color:#fff;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;">Facebook</a>
          <a href="https://zalo.me/share?url=<?php the_permalink(); ?>" target="_blank" rel="noopener noreferrer" style="padding:8px 16px;background:#0068FF;color:#fff;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;">Zalo</a>
        </div>
      </article>

      <!-- Sidebar -->
      <aside class="kf-post-sidebar">

        <!-- Booking CTA -->
        <div class="kf-sidebar-card" style="background:#1B4D7A;color:#fff;">
          <h3 style="font-size:16px;font-weight:700;margin-bottom:10px;">Thiết bị đang gặp lỗi?</h3>
          <p style="font-size:13px;opacity:.8;margin-bottom:16px;line-height:1.6;">KTV có mặt trong 60 phút. Chẩn đoán miễn phí tại nhà.</p>
          <a href="tel:0918611092" class="kf-btn kf-btn-primary" style="width:100%;justify-content:center;margin-bottom:10px;">
            <?php kitfix_icon('phone', 16); ?> Gọi ngay
          </a>
          <a href="<?php echo esc_url(home_url('/dat-lich/')); ?>" class="kf-btn kf-btn-ghost" style="width:100%;justify-content:center;font-size:14px;">
            <?php kitfix_icon('calendar', 16); ?> Đặt lịch
          </a>
        </div>

        <!-- Services -->
        <div class="kf-sidebar-card">
          <h3 style="font-size:15px;font-weight:700;color:#1B4D7A;margin-bottom:16px;">Dịch vụ sửa chữa</h3>
          <?php foreach (kitfix_get_services() as $slug => $svc): ?>
            <a href="<?php echo esc_url($svc['url']); ?>" style="display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid #F5F7FA;text-decoration:none;color:inherit;">
              <div style="width:36px;height:36px;border-radius:8px;background:<?php echo esc_attr($svc['bg']); ?>;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <?php kitfix_icon($svc['icon'], 18, $svc['color']); ?>
              </div>
              <span style="font-size:14px;font-weight:600;"><?php echo esc_html($svc['title']); ?></span>
            </a>
          <?php endforeach; ?>
        </div>

        <!-- Related posts -->
        <?php
        $cats = get_the_category();
        if ($cats) {
            $related = new WP_Query([
                'category__in'   => [$cats[0]->term_id],
                'post__not_in'   => [get_the_ID()],
                'posts_per_page' => 4,
                'orderby'        => 'rand',
            ]);
            if ($related->have_posts()):
        ?>
          <div class="kf-sidebar-card">
            <h3 style="font-size:15px;font-weight:700;color:#1B4D7A;margin-bottom:16px;">Dịch vụ liên quan</h3>
            <?php while ($related->have_posts()): $related->the_post(); ?>
              <a href="<?php the_permalink(); ?>" style="display:flex;gap:12px;padding:10px 0;border-bottom:1px solid #F5F7FA;text-decoration:none;color:inherit;">
                <div style="font-size:13px;font-weight:600;flex:1;line-height:1.5;"><?php the_title(); ?></div>
              </a>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>
        <?php endif; } ?>
      </aside>
    </div>
  </div>
</div>

<?php endwhile; ?>

<?php
kitfix_footer();
kitfix_float_bar();
get_footer();
?>
