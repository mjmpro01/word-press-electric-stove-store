#!/bin/sh
set -e

echo "⏳ Waiting for WordPress to be ready..."
until wp core is-installed --path=/var/www/html --allow-root 2>/dev/null || [ -f /var/www/html/wp-config.php ]; do
  sleep 3
done
sleep 5

echo "📦 Installing WordPress..."
wp core install \
  --path=/var/www/html \
  --url="${SITE_URL:-https://kitfix24h.com}" \
  --title="KitFix24H — Sửa Bếp Từ Tại Nhà" \
  --admin_user="${WP_ADMIN_USER:-admin}" \
  --admin_password="${WP_ADMIN_PASSWORD:-admin123}" \
  --admin_email="${WP_ADMIN_EMAIL:-duyminh2032000@gmail.com}" \
  --skip-email \
  --allow-root 2>/dev/null || echo "(already installed)"

echo "🎨 Activating theme..."
wp theme activate kitfix24h --path=/var/www/html --allow-root

echo "🔌 Activating plugin..."
wp plugin activate kitfix24h-core --path=/var/www/html --allow-root

echo "🛒 Installing WooCommerce..."
wp plugin install woocommerce --activate --path=/var/www/html --allow-root 2>/dev/null || \
  wp plugin activate woocommerce --path=/var/www/html --allow-root 2>/dev/null || true

echo "📋 Installing Advanced Custom Fields..."
wp plugin install advanced-custom-fields --activate --path=/var/www/html --allow-root 2>/dev/null || \
  wp plugin activate advanced-custom-fields --path=/var/www/html --allow-root 2>/dev/null || true

echo "🌐 Setting Vietnamese language..."
wp language core install vi --path=/var/www/html --allow-root || true
wp site switch-language vi --path=/var/www/html --allow-root || true

echo "📝 Creating demo pages (skip if exists)..."
create_page_if_missing() {
  TITLE="$1"
  TEMPLATE="$2"
  SLUG="$3"
  # Check by slug (post_name) so multiple pages with the same template are handled correctly
  EXISTS=$(wp post list --path=/var/www/html --post_type=page --post_status=publish \
    --fields=ID,post_name --format=csv --allow-root 2>/dev/null | grep ",$SLUG$" | cut -d, -f1)
  if [ -z "$EXISTS" ] || [ "$EXISTS" = "ID" ]; then
    ID=$(wp post create \
      --path=/var/www/html \
      --post_type=page --post_status=publish \
      --post_title="$TITLE" \
      --post_name="$SLUG" \
      --page_template="$TEMPLATE" \
      --allow-root --porcelain 2>/dev/null)
    wp post meta update "$ID" _wp_page_template "$TEMPLATE" --path=/var/www/html --allow-root --quiet 2>/dev/null
    echo "   Created '$TITLE' (ID $ID)"
  else
    echo "   '$TITLE' already exists (ID $EXISTS)"
  fi
}

create_page_if_missing "Trang chủ"         "templates/page-homepage.php"       "trang-chu"
create_page_if_missing "Bếp từ"            "templates/page-service-detail.php" "bep-tu"
create_page_if_missing "Bếp hồng ngoại"    "templates/page-service-detail.php" "bep-hong-ngoai"
create_page_if_missing "Lò nướng"          "templates/page-service-detail.php" "lo-nuong"
create_page_if_missing "Lò vi sóng"        "templates/page-service-detail.php" "lo-vi-song"
create_page_if_missing "Máy hút mùi"       "templates/page-service-detail.php" "may-hut-mui"
create_page_if_missing "Đặt lịch"          "templates/page-booking.php"        "dat-lich"
create_page_if_missing "Về chúng tôi"      "templates/page-about.php"          "ve-chung-toi"

echo "🏠 Setting front page..."
HOME_ID=$(wp post list --path=/var/www/html --post_type=page \
  --meta_key=_wp_page_template --meta_value="templates/page-homepage.php" \
  --fields=ID --format=ids --allow-root 2>/dev/null | head -1)
if [ -n "$HOME_ID" ]; then
  wp option update show_on_front page --path=/var/www/html --allow-root
  wp option update page_on_front "$HOME_ID" --path=/var/www/html --allow-root
  echo "   Front page ID: $HOME_ID"
fi

echo "🔗 Setting pretty permalinks..."
wp rewrite structure "/%postname%/" --path=/var/www/html --allow-root
wp rewrite flush --path=/var/www/html --allow-root

echo "⚙️  Configuring WooCommerce..."
wp option update woocommerce_currency            VND         --path=/var/www/html --allow-root
wp option update woocommerce_currency_pos        right_space --path=/var/www/html --allow-root
wp option update woocommerce_price_decimal_sep   ""          --path=/var/www/html --allow-root
wp option update woocommerce_price_thousand_sep  "."         --path=/var/www/html --allow-root
wp option update woocommerce_price_num_decimals  0           --path=/var/www/html --allow-root
wp option update woocommerce_default_country     VN          --path=/var/www/html --allow-root
wp option update woocommerce_calc_taxes          no          --path=/var/www/html --allow-root
wp option update woocommerce_enable_reviews      no          --path=/var/www/html --allow-root
# Enable COD payment
wp option update woocommerce_cod_settings \
  '{"enabled":"yes","title":"Thanh toán khi nhận hàng (COD)","description":"","instructions":"Vui lòng chuẩn bị tiền mặt khi nhận hàng.","enable_for_methods":[],"enable_for_virtual":"yes"}' \
  --path=/var/www/html --allow-root 2>/dev/null || true

echo "🛍️  Creating WooCommerce pages..."
create_woo_page() {
  TITLE="$1"; SLUG="$2"; CONTENT="$3"; OPTION_KEY="$4"
  EXISTS=$(wp post list --path=/var/www/html --post_type=page --post_status=publish \
    --fields=ID,post_name --format=csv --allow-root 2>/dev/null | grep ",$SLUG$" | cut -d, -f1)
  if [ -z "$EXISTS" ] || [ "$EXISTS" = "ID" ]; then
    ID=$(wp post create --path=/var/www/html --post_type=page --post_status=publish \
      --post_title="$TITLE" --post_name="$SLUG" --post_content="$CONTENT" \
      --allow-root --porcelain 2>/dev/null)
    echo "   Created '$TITLE' (ID $ID)"
  else
    ID="$EXISTS"
    echo "   '$TITLE' already exists (ID $ID)"
  fi
  [ -n "$OPTION_KEY" ] && [ -n "$ID" ] && \
    wp option update "$OPTION_KEY" "$ID" --path=/var/www/html --allow-root --quiet 2>/dev/null
}

create_woo_page "Phụ kiện & Linh kiện" "shop"      ""                         "woocommerce_shop_page_id"
create_woo_page "Giỏ hàng"             "gio-hang"  "[woocommerce_cart]"       "woocommerce_cart_page_id"
create_woo_page "Thanh toán"           "thanh-toan" "[woocommerce_checkout]"  "woocommerce_checkout_page_id"
create_woo_page "Tài khoản"            "tai-khoan" "[woocommerce_my_account]" "woocommerce_myaccount_page_id"

echo "🌱 Seeding service CPT data..."
if [ -f /scripts/seed-services.sh ]; then
  sh /scripts/seed-services.sh
else
  echo "   (seed-services.sh not mounted — skip)"
fi

echo "🌟 Seeding testimonials..."
if [ -f /scripts/seed-testimonials.sh ]; then
  sh /scripts/seed-testimonials.sh
else
  echo "   (seed-testimonials.sh not mounted — skip)"
fi

echo ""
echo "✅ Done! Open ${SITE_URL:-http://localhost:8080}"
echo "   Admin: ${SITE_URL:-http://localhost:8080}/wp-admin"
echo "   User: ${WP_ADMIN_USER:-admin} / ${WP_ADMIN_PASSWORD:-admin123}"
