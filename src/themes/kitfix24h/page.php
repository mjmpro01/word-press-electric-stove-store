<?php
/**
 * Default page template.
 */
get_header();
kitfix_header('light');
kitfix_breadcrumb([['label' => get_the_title()]]);
?>

<?php
$is_woo_full = function_exists('is_cart') && (is_cart() || is_checkout() || is_account_page());
?>
<main style="padding:48px 0;">
  <div class="kf-container">
    <?php if ($is_woo_full): ?>
      <div class="kf-woo-page">
        <?php while (have_posts()): the_post(); ?>
          <?php the_content(); ?>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <div style="max-width:800px;margin:0 auto;">
        <?php while (have_posts()): the_post(); ?>
          <article style="background:#fff;border-radius:var(--radius);border:1px solid var(--gray-200);padding:40px;">
            <h1 style="font-size:32px;font-weight:800;color:#1B4D7A;margin-bottom:24px;"><?php the_title(); ?></h1>
            <div style="font-size:16px;line-height:1.8;color:#4A5568;">
              <?php the_content(); ?>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php
kitfix_footer();
kitfix_float_bar();
get_footer();
?>
