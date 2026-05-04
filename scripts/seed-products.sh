#!/bin/sh
set -e

WP="wp --path=/var/www/html --allow-root"

echo "🛒 Seeding WooCommerce products (phụ kiện & linh kiện)..."

# ── Tạo danh mục sản phẩm ──────────────────────────────────────────────────

create_cat() {
  NAME="$1"; SLUG="$2"; PARENT="${3:-0}"
  EXISTS=$($WP term list product_cat --taxonomy=product_cat --field=term_id --name="$NAME" --format=ids 2>/dev/null | head -1)
  if [ -z "$EXISTS" ]; then
    ID=$($WP term create product_cat "$NAME" --slug="$SLUG" --parent="$PARENT" --porcelain 2>/dev/null)
    echo "   Tạo danh mục '$NAME' (ID $ID)"
  else
    ID="$EXISTS"
    echo "   Danh mục '$NAME' đã có (ID $ID)"
  fi
  echo "$ID"
}

echo "📂 Tạo danh mục..."
CAT_BEP_TU=$(create_cat "Linh kiện bếp từ" "linh-kien-bep-tu")
CAT_BEP_HN=$(create_cat "Linh kiện bếp hồng ngoại" "linh-kien-bep-hong-ngoai")
CAT_LO=$(create_cat "Linh kiện lò nướng & vi sóng" "linh-kien-lo-nuong")
CAT_HUT=$(create_cat "Linh kiện máy hút mùi" "linh-kien-may-hut-mui")
CAT_PKC=$(create_cat "Phụ kiện chung" "phu-kien-chung")

# ── Helper: tạo sản phẩm nếu chưa có ──────────────────────────────────────

create_product() {
  TITLE="$1"; PRICE="$2"; CAT_ID="$3"; DESC="$4"; SKU="$5"

  EXISTS=$($WP post list --post_type=product --post_status=publish \
    --meta_key=_sku --meta_value="$SKU" --fields=ID --format=ids 2>/dev/null | head -1)

  if [ -n "$EXISTS" ]; then
    echo "   '$TITLE' đã có (ID $EXISTS)"
    return
  fi

  ID=$($WP post create \
    --post_type=product \
    --post_status=publish \
    --post_title="$TITLE" \
    --post_content="$DESC" \
    --porcelain --allow-root 2>/dev/null)

  $WP post meta update "$ID" _price         "$PRICE"  --allow-root --quiet
  $WP post meta update "$ID" _regular_price "$PRICE"  --allow-root --quiet
  $WP post meta update "$ID" _sku           "$SKU"    --allow-root --quiet
  $WP post meta update "$ID" _stock_status  "instock" --allow-root --quiet
  $WP post meta update "$ID" _manage_stock  "no"      --allow-root --quiet
  $WP post meta update "$ID" _visibility    "visible" --allow-root --quiet
  $WP post term set "$ID" product_cat "$CAT_ID" --by=id --allow-root --quiet 2>/dev/null

  # Đặt product type = simple
  $WP post term set "$ID" product_type "simple" --allow-root --quiet 2>/dev/null

  echo "   ✓ '$TITLE' — $(printf "%'.f" $PRICE)đ (ID $ID)"
}

# ── Linh kiện bếp từ ──────────────────────────────────────────────────────

echo "🔧 Linh kiện bếp từ..."

create_product \
  "Bo mạch điều khiển bếp từ Midea" \
  "450000" "$CAT_BEP_TU" \
  "Bo mạch điều khiển thay thế cho bếp từ Midea các dòng MC-IH2016, MC-IH2018. Hàng chính hãng, bảo hành 3 tháng." \
  "BM-MIDEA-001"

create_product \
  "IGBT transistor bếp từ (Q5L00065) 25A/1200V" \
  "85000" "$CAT_BEP_TU" \
  "Transistor IGBT 25A 1200V dùng cho bếp từ các hãng Sunhouse, Kangaroo, Electrolux. Linh kiện phổ thông, tương thích rộng." \
  "IGBT-25A-001"

create_product \
  "Quạt tản nhiệt bếp từ 12V DC" \
  "55000" "$CAT_BEP_TU" \
  "Quạt làm mát 12V DC kích thước 80x80x25mm, tốc độ 2400RPM, thay thế cho bếp từ đủ hãng." \
  "FAN-12V-80MM"

create_product \
  "Mâm dây điện từ (cuộn dây) bếp từ 220V" \
  "180000" "$CAT_BEP_TU" \
  "Cuộn dây cảm ứng từ thay thế đường kính 180mm, phù hợp bếp từ đơn Kangaroo, Sunhouse, Electrolux." \
  "COIL-180MM-001"

create_product \
  "Cảm biến nhiệt độ NTC bếp từ" \
  "35000" "$CAT_BEP_TU" \
  "Thermistor NTC 100kΩ dùng để đo nhiệt mặt kính bếp từ, bếp hồng ngoại. Hàng tốt, độ bền cao." \
  "NTC-100K-001"

create_product \
  "Mặt kính bếp từ đơn 30x30cm (chịu nhiệt)" \
  "320000" "$CAT_BEP_TU" \
  "Mặt kính ceramic chịu nhiệt thay thế kích thước 30x30cm. Phù hợp bếp từ đơn nhiều hãng thông dụng tại Việt Nam." \
  "GLASS-30X30"

# ── Linh kiện bếp hồng ngoại ─────────────────────────────────────────────

echo "🔧 Linh kiện bếp hồng ngoại..."

create_product \
  "Dây điện trở hồng ngoại 220V/1000W" \
  "120000" "$CAT_BEP_HN" \
  "Dây điện trở hồng ngoại công suất 1000W/220V, chiều dài 120cm. Thay thế cho bếp hồng ngoại Kangaroo, Sunhouse, Electrolux." \
  "HEATER-1000W"

create_product \
  "Bo mạch bếp hồng ngoại Kangaroo KG188" \
  "280000" "$CAT_BEP_HN" \
  "Bo điều khiển nguyên bản cho bếp hồng ngoại Kangaroo KG188, KG198. Hàng zin tháo máy, kiểm tra kỹ trước khi giao." \
  "BM-KG188"

create_product \
  "Rơ le nhiệt bếp hồng ngoại 16A/250V" \
  "45000" "$CAT_BEP_HN" \
  "Rơ le bảo vệ quá nhiệt 16A/250V, reset tự động. Dùng cho bếp hồng ngoại, lò nướng, máy sưởi." \
  "RELAY-16A"

create_product \
  "Mặt kính bếp hồng ngoại đơn (chịu nhiệt cao)" \
  "290000" "$CAT_BEP_HN" \
  "Kính chịu nhiệt cao 800°C kích thước 28x28cm, thay thế cho bếp hồng ngoại đơn thông dụng." \
  "GLASS-HN-28X28"

# ── Linh kiện lò nướng & vi sóng ─────────────────────────────────────────

echo "🔧 Linh kiện lò nướng & vi sóng..."

create_product \
  "Đèn lò nướng 25W/300°C E14" \
  "45000" "$CAT_LO" \
  "Bóng đèn lò nướng chịu nhiệt 300°C, 25W, đuôi E14. Thay thế cho lò nướng Electrolux, Sanaky, Kangaroo, Sunhouse." \
  "BULB-25W-E14"

create_product \
  "Thanh điện trở lò nướng trên/dưới 220V/800W" \
  "95000" "$CAT_LO" \
  "Thanh nhiệt lò nướng 800W/220V, kích thước 28cm. Dùng cho lò nướng điện thể tích 25-35 lít phổ thông." \
  "HEATER-LO-800W"

create_product \
  "Thermostat điều nhiệt lò nướng 50-300°C" \
  "75000" "$CAT_LO" \
  "Van điều nhiệt cơ lò nướng dải 50-300°C, chân cắm 6.35mm. Phù hợp hầu hết lò nướng điện thông thường." \
  "THERMO-300C"

create_product \
  "Mâm xoay lò vi sóng 25cm (kính cường lực)" \
  "85000" "$CAT_LO" \
  "Đĩa xoay tròn lò vi sóng đường kính 25cm, kính cường lực chịu nhiệt. Phù hợp lò vi sóng Sharp, LG, Samsung, Electrolux." \
  "PLATE-VS-25CM"

create_product \
  "Chân đế xoay lò vi sóng (bộ 3 bánh xe)" \
  "35000" "$CAT_LO" \
  "Bộ 3 bánh xe đỡ mâm xoay lò vi sóng nhựa chịu nhiệt, đường kính vòng tròn 14-16cm." \
  "WHEEL-VS-3PC"

create_product \
  "Đèn lò vi sóng 20W/240V E17" \
  "40000" "$CAT_LO" \
  "Bóng đèn lò vi sóng 20W, đuôi E17, điện áp 240V. Thay thế cho lò vi sóng Sharp, Panasonic, LG." \
  "BULB-VS-20W"

# ── Linh kiện máy hút mùi ────────────────────────────────────────────────

echo "🔧 Linh kiện máy hút mùi..."

create_product \
  "Lưới lọc dầu mỡ máy hút mùi nhôm (50x55cm)" \
  "95000" "$CAT_HUT" \
  "Lưới lọc nhôm đa lớp kích thước 50x55cm, cắt vừa tất cả máy hút mùi. Rửa được, tái sử dụng nhiều lần." \
  "FILTER-AL-5055"

create_product \
  "Motor quạt hút mùi bếp 220V/60W" \
  "380000" "$CAT_HUT" \
  "Motor quạt hút mùi 60W/220V, lưu lượng gió 550m³/h. Thay thế cho máy hút mùi âm tủ, treo tường các hãng thông dụng." \
  "MOTOR-HUT-60W"

create_product \
  "Bóng đèn LED máy hút mùi 2W/220V G4" \
  "28000" "$CAT_HUT" \
  "Bóng LED G4 2W ánh sáng trắng 6000K, thay thế đèn halogen máy hút mùi. Tiết kiệm điện, tuổi thọ cao." \
  "LED-G4-2W"

create_product \
  "Công tắc tốc độ máy hút mùi 3 nấc" \
  "65000" "$CAT_HUT" \
  "Công tắc điều tốc 3 nấc (thấp/trung/cao) cho máy hút mùi, điện áp 250V/6A. Phù hợp hầu hết máy hút mùi cơ." \
  "SWITCH-HUT-3SP"

# ── Phụ kiện chung ────────────────────────────────────────────────────────

echo "🔧 Phụ kiện chung..."

create_product \
  "Dây nguồn 3 chân 1.5m (16A/250V)" \
  "45000" "$CAT_PKC" \
  "Dây nguồn điện 3 chân (đất) chuẩn Việt Nam, dài 1.5m, tiết diện 1.5mm². Thay thế cho lò nướng, máy hút mùi, bếp điện." \
  "CABLE-3PIN-15M"

create_product \
  "Cầu chì ống 20A/250V (hộp 10 cái)" \
  "30000" "$CAT_PKC" \
  "Cầu chì ống thủy tinh 20A/250V kích thước 5x20mm, hộp 10 cái. Bảo vệ mạch điện thiết bị gia dụng." \
  "FUSE-20A-10PC"

create_product \
  "Keo tản nhiệt CPU (ống 5g)" \
  "25000" "$CAT_PKC" \
  "Keo silicon dẫn nhiệt, ống 5g, dùng thoa lên IGBT và các linh kiện tỏa nhiệt trong bếp từ, bếp hồng ngoại." \
  "PASTE-THERMAL-5G"

create_product \
  "Bộ vít sửa chữa điện tử đa năng (24 đầu)" \
  "120000" "$CAT_PKC" \
  "Bộ tua vít đa năng 24 đầu (Phillips, Torx, Pentalobe...) cán từ tính, chuyên dùng sửa thiết bị điện tử gia dụng." \
  "TOOLS-SCREW-24"

echo ""
echo "✅ Seeding phụ kiện hoàn tất!"
$WP post list --post_type=product --post_status=publish \
  --fields=ID,post_title --format=table --allow-root 2>/dev/null
