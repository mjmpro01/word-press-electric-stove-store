<?php
/**
 * WooCommerce single product — KitFix24H layout.
 */

defined('ABSPATH') || exit;

get_header();
kitfix_header('light');

while (have_posts()):
    the_post();
    global $product;
    $price_html   = $product->get_price_html();
    $gallery_ids  = $product->get_gallery_image_ids();
    $main_img_id  = $product->get_image_id();
    $cats         = wc_get_product_category_list($product->get_id(), ', ');
    $rating       = $product->get_average_rating();
    $rating_count = $product->get_rating_count();
    $badge        = '';
    if ($product->is_on_sale())    $badge = 'Giảm giá';
    elseif ($product->is_featured()) $badge = 'Nổi bật';
?>

<?php kitfix_breadcrumb([
    ['label' => 'Phụ kiện', 'url' => home_url('/shop/')],
    ['label' => get_the_title()],
]); ?>

<div class="kf-container" style="padding:40px 24px;">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:start;">

    <!-- Gallery column -->
    <div>
      <!-- Main image -->
      <div style="border-radius:12px;overflow:hidden;background:#F5F7FA;display:flex;align-items:center;justify-content:center;min-height:380px;margin-bottom:12px;position:relative;">
        <?php if ($badge): ?>
          <div style="position:absolute;top:12px;left:12px;background:#F47B20;color:#fff;font-size:12px;font-weight:700;padding:4px 10px;border-radius:20px;z-index:1;">
            <?php echo esc_html($badge); ?>
          </div>
        <?php endif; ?>
        <?php if ($main_img_id): ?>
          <?php echo wp_get_attachment_image($main_img_id, 'kitfix-thumb', false, ['style' => 'width:100%;height:380px;object-fit:cover;']); ?>
        <?php else: ?>
          <div style="text-align:center;color:#C5D0DE;">
            <?php kitfix_icon('tool', 64, '#C5D0DE'); ?>
            <p style="font-size:12px;margin-top:8px;font-family:monospace;">ảnh sản phẩm</p>
          </div>
        <?php endif; ?>
      </div>

      <!-- Thumbnail row -->
      <?php if (!empty($gallery_ids)): ?>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
          <?php foreach ($gallery_ids as $img_id): ?>
            <div style="width:72px;height:72px;border-radius:8px;overflow:hidden;border:2px solid #DDE3EC;cursor:pointer;">
              <?php echo wp_get_attachment_image($img_id, 'thumbnail', false, ['style' => 'width:72px;height:72px;object-fit:cover;']); ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Info column -->
    <div>
      <!-- Category -->
      <?php if ($cats): ?>
        <p style="font-size:13px;color:#F47B20;font-weight:600;margin-bottom:8px;"><?php echo wp_kses_post($cats); ?></p>
      <?php endif; ?>

      <h1 style="font-size:26px;font-weight:800;color:#0D2137;margin-bottom:12px;"><?php the_title(); ?></h1>

      <!-- Rating -->
      <?php if ($rating_count > 0): ?>
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
          <?php kitfix_stars((int)round((float)$rating)); ?>
          <span style="font-size:14px;color:#5C6E87;"><?php echo esc_html($rating); ?> (<?php echo esc_html($rating_count); ?> đánh giá)</span>
        </div>
      <?php endif; ?>

      <!-- Price -->
      <div style="font-size:32px;font-weight:800;color:#F47B20;margin-bottom:20px;">
        <?php echo wp_kses_post($price_html); ?>
      </div>

      <!-- Short description -->
      <?php if ($product->get_short_description()): ?>
        <div style="font-size:14px;color:#5C6E87;line-height:1.7;margin-bottom:20px;border-left:3px solid #1B4D7A;padding-left:14px;">
          <?php echo wp_kses_post($product->get_short_description()); ?>
        </div>
      <?php endif; ?>

      <!-- Add to cart -->
      <div style="margin-bottom:20px;">
        <?php woocommerce_template_single_add_to_cart(); ?>
      </div>

      <!-- Guarantees -->
      <div style="background:#F0FDF4;border:1px solid #A7F3D0;border-radius:10px;padding:14px 16px;display:flex;flex-direction:column;gap:8px;">
        <?php
        $guarantees = [
            ['shield',  'Linh kiện chính hãng, có tem nhà phân phối'],
            ['clock',   'Giao hàng nội thành HCM trong ngày'],
            ['check',   'Bảo hành 3–12 tháng tùy sản phẩm'],
        ];
        foreach ($guarantees as [$icon, $text]):
        ?>
          <div style="display:flex;align-items:center;gap:8px;">
            <?php kitfix_icon($icon, 15, '#10B981'); ?>
            <span style="font-size:13px;color:#047857;"><?php echo esc_html($text); ?></span>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- SKU / stock -->
      <div style="margin-top:16px;font-size:13px;color:#9BAABF;">
        <?php if ($product->get_sku()): ?>
          <span>Mã SP: <strong><?php echo esc_html($product->get_sku()); ?></strong></span> &nbsp;·&nbsp;
        <?php endif; ?>
        <?php if ($product->is_in_stock()): ?>
          <span style="color:#10B981;font-weight:600;"><?php kitfix_icon('check-circle', 13, '#10B981'); ?> Còn hàng</span>
        <?php else: ?>
          <span style="color:#EF4444;font-weight:600;">Hết hàng</span>
        <?php endif; ?>
      </div>
    </div>

  </div>

  <!-- Tabs: description / compatibility / reviews -->
  <div style="margin-top:56px;">
    <div style="display:flex;gap:0;border-bottom:2px solid #DDE3EC;margin-bottom:24px;" role="tablist">
      <?php
      $tabs = ['desc' => 'Mô tả chi tiết', 'compat' => 'Tương thích', 'reviews' => 'Đánh giá'];
      foreach ($tabs as $tab_id => $tab_label):
      ?>
        <button
          role="tab"
          data-product-tab="<?php echo esc_attr($tab_id); ?>"
          style="padding:12px 20px;font-size:14px;font-weight:600;border:none;background:none;cursor:pointer;color:#9BAABF;border-bottom:2px solid transparent;margin-bottom:-2px;"
          class="kf-product-tab <?php echo $tab_id === 'desc' ? 'active' : ''; ?>">
          <?php echo esc_html($tab_label); ?>
        </button>
      <?php endforeach; ?>
    </div>

    <!-- Description panel -->
    <div data-product-panel="desc" style="font-size:15px;color:#334155;line-height:1.8;">
      <?php the_content(); ?>
      <?php if (!get_the_content()): ?>
        <p style="color:#9BAABF;font-style:italic;">Chưa có mô tả chi tiết.</p>
      <?php endif; ?>
    </div>

    <!-- Compatibility panel -->
    <div data-product-panel="compat" hidden style="font-size:14px;color:#5C6E87;line-height:1.8;">
      <?php
      $compat = get_post_meta(get_the_ID(), 'product_compatibility', true);
      if ($compat):
          echo wp_kses_post(wpautop($compat));
      else:
      ?>
        <p>Linh kiện tương thích với các hãng: <strong>Bosch, Siemens, Electrolux, Sunhouse, Kangaroo, Midea, LG, Samsung, Teka</strong> và nhiều thương hiệu khác. Vui lòng liên hệ để xác nhận model cụ thể.</p>
        <p><a href="tel:0918611092" class="kf-btn kf-btn-blue" style="font-size:13px;">Gọi tư vấn: 0918.611.092</a></p>
      <?php endif; ?>
    </div>

    <!-- Reviews panel -->
    <div data-product-panel="reviews" hidden>
      <?php comments_template(); ?>
    </div>
  </div>

  <!-- Related products -->
  <?php
  $related_args = [
      'post_type'      => 'product',
      'posts_per_page' => 4,
      'post__not_in'   => [get_the_ID()],
      'tax_query'      => [[
          'taxonomy' => 'product_cat',
          'field'    => 'term_id',
          'terms'    => wp_list_pluck(wc_get_product_terms($product->get_id(), 'product_cat'), 'term_id'),
      ]],
  ];
  $related = new WP_Query($related_args);
  if ($related->have_posts()):
  ?>
    <div style="margin-top:56px;">
      <h2 style="font-size:22px;font-weight:800;color:#0D2137;margin-bottom:24px;">Sản phẩm liên quan</h2>
      <div class="kf-product-grid">
        <?php while ($related->have_posts()): $related->the_post(); global $product; ?>
          <div class="kf-product-card">
            <a href="<?php the_permalink(); ?>" class="kf-product-image">
              <?php if (has_post_thumbnail()):
                    the_post_thumbnail('kitfix-card', ['style' => 'width:100%;height:160px;object-fit:cover;']);
              else: ?>
                <?php kitfix_icon('tool', 32, '#C5D0DE'); ?>
              <?php endif; ?>
            </a>
            <div class="kf-product-info">
              <a href="<?php the_permalink(); ?>">
                <h4 class="kf-product-title"><?php the_title(); ?></h4>
              </a>
              <span style="font-size:16px;font-weight:800;color:#F47B20;"><?php echo wp_kses_post($product->get_price_html()); ?></span>
            </div>
          </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
  <?php endif; ?>

</div>

<script>
(function(){
  var tabs = document.querySelectorAll('[data-product-tab]');
  tabs.forEach(function(tab){
    tab.addEventListener('click', function(){
      tabs.forEach(function(t){ t.classList.remove('active'); t.style.color='#9BAABF'; t.style.borderBottomColor='transparent'; });
      tab.classList.add('active'); tab.style.color='#1B4D7A'; tab.style.borderBottomColor='#1B4D7A';
      document.querySelectorAll('[data-product-panel]').forEach(function(p){ p.hidden = true; });
      var panel = document.querySelector('[data-product-panel="'+tab.dataset.productTab+'"]');
      if(panel) panel.hidden = false;
    });
  });
  // Set first tab active style
  var first = document.querySelector('[data-product-tab].active');
  if(first){ first.style.color='#1B4D7A'; first.style.borderBottomColor='#1B4D7A'; }
})();
</script>

<?php endwhile; ?>

<?php
kitfix_footer();
kitfix_float_bar();
get_footer();
?>
