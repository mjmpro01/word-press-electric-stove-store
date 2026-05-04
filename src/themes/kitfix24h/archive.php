<?php
/**
 * Dịch vụ archive / category list.
 */
get_header();
kitfix_header('light');
$cat_obj = get_queried_object();
$breadcrumbs = [['label' => 'Dịch vụ', 'url' => home_url('/dich-vu/')]];
if ($cat_obj instanceof WP_Term) {
    $breadcrumbs[] = ['label' => $cat_obj->name];
}
kitfix_breadcrumb($breadcrumbs);
?>

<div style="background:linear-gradient(135deg,#123557 0%,#1B4D7A 100%);color:#fff;padding:36px 0;">
  <div class="kf-container">
    <h1 style="font-size:32px;font-weight:800;margin-bottom:8px;">
      <?php
      if (is_category()) {
          echo 'Danh mục: ' . esc_html(single_cat_title('', false));
      } else {
          echo 'Dịch vụ &amp; Hướng dẫn sửa chữa';
      }
      ?>
    </h1>
    <p style="font-size:15px;opacity:.8;">Mẹo sửa chữa, bảo dưỡng thiết bị bếp từ đội ngũ KitFix24H</p>
  </div>
</div>

<main style="padding:48px 0;background:#F5F7FA;">
  <div class="kf-container">
    <div style="display:grid;grid-template-columns:1fr 280px;gap:32px;" class="kf-blog-layout">

      <!-- Posts grid -->
      <div>
        <?php if (have_posts()): ?>
          <div class="kf-blog-grid">
            <?php while (have_posts()): the_post(); ?>
              <a href="<?php the_permalink(); ?>" class="kf-blog-card">
                <div class="kf-blog-image">
                  <?php if (has_post_thumbnail()):
                        the_post_thumbnail('kitfix-card', ['style' => 'width:100%;height:180px;object-fit:cover;']);
                  else: ?>
                    <?php kitfix_icon('tool', 36, '#C5D0DE'); ?>
                    <span style="font-size:11px;color:#C5D0DE;font-family:monospace;">ảnh dịch vụ</span>
                  <?php endif; ?>
                </div>
                <div class="kf-blog-body">
                  <?php $cats = get_the_category(); if ($cats): ?>
                    <span class="kf-blog-cat" style="background:#EEF1F5;color:#1B4D7A;">
                      <?php echo esc_html($cats[0]->name); ?>
                    </span>
                  <?php endif; ?>
                  <h2 class="kf-blog-title"><?php the_title(); ?></h2>
                  <p class="kf-blog-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                  <div class="kf-blog-meta">
                    <span><?php echo get_the_date('d/m/Y'); ?></span>
                    <span><?php echo esc_html(ceil(str_word_count(strip_tags(get_the_content())) / 200)); ?> phút đọc</span>
                  </div>
                  <div class="kf-blog-read-more">Đọc thêm <?php kitfix_icon('chevron-right', 14, '#1B4D7A'); ?></div>
                </div>
              </a>
            <?php endwhile; ?>
          </div>

          <!-- Pagination -->
          <div style="margin-top:40px;">
            <?php
            the_posts_pagination([
                'mid_size'  => 2,
                'prev_text' => '← Trước',
                'next_text' => 'Tiếp →',
            ]);
            ?>
          </div>

        <?php else: ?>
          <p style="text-align:center;padding:48px 0;color:#9BAABF;">Chưa có nội dung.</p>
        <?php endif; ?>
      </div>

      <!-- Sidebar -->
      <aside>
        <!-- Search -->
        <div style="background:#fff;border:1px solid #DDE3EC;border-radius:10px;padding:20px;margin-bottom:20px;">
          <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <div style="position:relative;">
              <div style="position:absolute;left:12px;top:50%;transform:translateY(-50%);">
                <?php kitfix_icon('search', 16, '#9BAABF'); ?>
              </div>
              <input type="search" name="s" class="kf-input" placeholder="Tìm dịch vụ..." style="padding-left:38px;" value="<?php echo esc_attr(get_search_query()); ?>">
              <input type="hidden" name="post_type" value="post">
            </div>
          </form>
        </div>

        <!-- Categories -->
        <div style="background:#fff;border:1px solid #DDE3EC;border-radius:10px;overflow:hidden;margin-bottom:20px;">
          <div style="padding:14px 16px;border-bottom:1px solid #EEF1F5;font-size:13px;font-weight:700;color:#1B4D7A;">Danh mục</div>
          <?php
          $cats = get_categories(['hide_empty' => true]);
          foreach ($cats as $cat):
          ?>
            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="kf-cat-btn <?php echo is_category($cat->term_id) ? 'active' : ''; ?>" style="display:flex;">
              <?php echo esc_html($cat->name); ?>
              <span class="kf-cat-count"><?php echo esc_html($cat->count); ?></span>
            </a>
          <?php endforeach; ?>
        </div>

        <!-- CTA -->
        <div style="background:#1B4D7A;border-radius:10px;padding:24px;color:#fff;text-align:center;">
          <h3 style="font-size:16px;font-weight:700;margin-bottom:10px;">Cần sửa chữa gấp?</h3>
          <p style="font-size:13px;opacity:.8;margin-bottom:16px;line-height:1.6;">KTV có mặt trong 60 phút. Chẩn đoán miễn phí.</p>
          <a href="tel:0918611092" class="kf-btn kf-btn-primary" style="width:100%;justify-content:center;">
            <?php kitfix_icon('phone', 16); ?> 0918.611.092
          </a>
        </div>
      </aside>

    </div>
  </div>
</main>

<style>@media(max-width:900px){.kf-blog-layout{grid-template-columns:1fr!important}aside{display:none;}}</style>

<?php
kitfix_footer();
kitfix_float_bar();
get_footer();
?>
