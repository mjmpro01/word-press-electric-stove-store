#!/bin/sh
# Seed kf_service CPT posts with initial data.
# Safe to re-run — checks by service_slug meta before creating.

WP="wp --allow-root --path=/var/www/html"

echo "🌱 Seeding kf_service posts..."

# ──────────────────────────────────────────────────────────────────────────────
# Helper: create a service post if the slug meta doesn't already exist
# Usage: ensure_service <slug> <title> <price> <hero_desc>
# Returns the post ID via stdout
# ──────────────────────────────────────────────────────────────────────────────
ensure_service() {
    SLUG="$1"
    TITLE="$2"
    PRICE="$3"
    HERO_DESC="$4"

    # Find existing post by service_slug meta
    EXISTING_ID=$($WP post list \
        --post_type=kf_service \
        --post_status=publish \
        --meta_key=service_slug \
        --meta_value="$SLUG" \
        --fields=ID \
        --format=csv \
        --quiet 2>/dev/null | tail -1)

    if [ -n "$EXISTING_ID" ] && [ "$EXISTING_ID" != "ID" ]; then
        echo "$EXISTING_ID"
        return
    fi

    # Create post
    NEW_ID=$($WP post create \
        --post_type=kf_service \
        --post_status=publish \
        --post_title="$TITLE" \
        --porcelain \
        --quiet 2>/dev/null)

    $WP post meta update "$NEW_ID" service_slug "$SLUG" --quiet 2>/dev/null
    $WP post meta update "$NEW_ID" service_price_from "$PRICE" --quiet 2>/dev/null
    $WP post meta update "$NEW_ID" service_hero_desc "$HERO_DESC" --quiet 2>/dev/null

    echo "   ✓ Created '$TITLE' (ID $NEW_ID, slug: $SLUG)" >&2
    echo "$NEW_ID"
}

# ──────────────────────────────────────────────────────────────────────────────
# Helper: set a CMB2 repeatable group field (serialized array)
# Usage: set_group_meta <post_id> <meta_key> <json_value>
# ──────────────────────────────────────────────────────────────────────────────
set_group_meta() {
    POST_ID="$1"
    META_KEY="$2"
    PHP_ARRAY="$3"

    $WP eval "update_post_meta($POST_ID, '$META_KEY', $PHP_ARRAY);" --quiet 2>/dev/null
}

# ══════════════════════════════════════════════════════════════════════════════
# 1. BẾP TỪ
# ══════════════════════════════════════════════════════════════════════════════
ID=$(ensure_service \
    "bep-tu" \
    "Sửa bếp từ" \
    "Từ 150.000đ" \
    "Sửa không lên lửa, báo lỗi E0–E9, thay mâm từ, bo mạch — tận nơi trong 60 phút")

set_group_meta "$ID" "service_symptoms" "array(
    array('text' => 'Bếp không lên nguồn, màn hình không sáng'),
    array('text' => 'Báo lỗi E0, E1, E2, E3, E4, E6, E8, E9'),
    array('text' => 'Bếp lên nguồn nhưng không nấu được, mặt bếp lạnh'),
    array('text' => 'Tự ngắt giữa chừng, bật lại không được'),
    array('text' => 'Quạt tản nhiệt kêu to bất thường'),
    array('text' => 'Cảm ứng đơ, chạm không phản hồi'),
    array('text' => 'Mặt kính bếp nứt, vỡ'),
)"

set_group_meta "$ID" "service_fixes" "array(
    array('text' => 'Kiểm tra nguồn điện, cầu chì, điện trở bảo vệ'),
    array('text' => 'Thay IGBT công suất bị chết'),
    array('text' => 'Vệ sinh, thay mâm từ (cuộn dây cảm ứng)'),
    array('text' => 'Thay bo mạch điều khiển chính'),
    array('text' => 'Thay quạt tản nhiệt'),
    array('text' => 'Thay tấm cảm ứng điều khiển'),
    array('text' => 'Thay mặt kính ceramic chịu nhiệt'),
)"

set_group_meta "$ID" "service_errors" "array(
    array('code' => 'E0', 'desc' => 'Không phát hiện nồi — đặt lại nồi hoặc thay mâm từ',  'severity' => 'yellow'),
    array('code' => 'E1', 'desc' => 'Nhiệt độ quá cao — tắt bếp, để nguội',                 'severity' => 'orange'),
    array('code' => 'E2', 'desc' => 'Cảm biến nhiệt hỏng — cần thay cảm biến',              'severity' => 'orange'),
    array('code' => 'E3', 'desc' => 'Điện áp đầu vào quá thấp — kiểm tra nguồn điện',       'severity' => 'yellow'),
    array('code' => 'E4', 'desc' => 'Điện áp đầu vào quá cao — nguy cơ cháy bo mạch',       'severity' => 'red'),
    array('code' => 'E6', 'desc' => 'Lỗi IGBT — thay IGBT hoặc bo mạch ngay',               'severity' => 'red'),
    array('code' => 'E8', 'desc' => 'Quạt tản nhiệt hỏng — thay quạt',                      'severity' => 'orange'),
    array('code' => 'E9', 'desc' => 'Lỗi bo mạch điều khiển — cần thay mạch',               'severity' => 'red'),
)"

set_group_meta "$ID" "service_pricing" "array(
    array('service_name' => 'Kiểm tra, vệ sinh bếp',        'price' => '150.000đ',             'note' => 'Miễn phí nếu sửa'),
    array('service_name' => 'Thay IGBT công suất',           'price' => '350.000 – 550.000đ',   'note' => ''),
    array('service_name' => 'Thay bo mạch điều khiển',       'price' => '450.000 – 750.000đ',   'note' => 'Theo hãng'),
    array('service_name' => 'Thay mâm từ (cuộn cảm ứng)',    'price' => '250.000 – 400.000đ',   'note' => ''),
    array('service_name' => 'Thay mặt kính ceramic',         'price' => '400.000 – 800.000đ',   'note' => 'Theo kích thước'),
    array('service_name' => 'Thay quạt tản nhiệt',           'price' => '180.000 – 280.000đ',   'note' => ''),
    array('service_name' => 'Thay tấm cảm ứng',              'price' => '200.000 – 350.000đ',   'note' => ''),
)"

set_group_meta "$ID" "service_faq" "array(
    array('question' => 'Bếp từ báo lỗi E0 có nghĩa là gì?',         'answer' => 'E0 nghĩa là bếp không nhận nồi. Thử đặt lại nồi đúng tâm bếp. Nếu vẫn báo lỗi, có thể mâm từ bị hỏng cần thay mới.'),
    array('question' => 'Sửa bếp từ mất bao lâu?',                    'answer' => 'Hầu hết lỗi phổ biến (IGBT, cảm ứng, quạt) được sửa ngay tại nhà trong 30–90 phút. Lỗi bo mạch phức tạp hơn có thể mang về xưởng 1–2 ngày.'),
    array('question' => 'Bếp từ tôi còn bảo hành không cần sửa riêng?', 'answer' => 'Nếu bếp còn bảo hành hãng, hãy liên hệ trung tâm bảo hành trước. Chúng tôi phục vụ bếp hết bảo hành hoặc khi hãng yêu cầu chờ lâu.'),
    array('question' => 'Chi phí sửa có tính phí kiểm tra không?',    'answer' => 'Phí kiểm tra 150.000đ, miễn phí nếu bạn đồng ý sửa tại chỗ. Kỹ thuật viên báo giá trước khi làm, không phát sinh ngoài dự toán.'),
)"

echo "   ✓ Bếp từ done (ID $ID)" >&2

# ══════════════════════════════════════════════════════════════════════════════
# 2. BẾP HỒNG NGOẠI
# ══════════════════════════════════════════════════════════════════════════════
ID=$(ensure_service \
    "bep-hong-ngoai" \
    "Sửa bếp hồng ngoại" \
    "Từ 120.000đ" \
    "Khắc phục lỗi nhiệt, mặt kính vỡ, cảm ứng hỏng — bảo hành 3 tháng")

set_group_meta "$ID" "service_symptoms" "array(
    array('text' => 'Bếp không lên nguồn'),
    array('text' => 'Báo lỗi H hoặc E kèm số'),
    array('text' => 'Mặt kính nứt vỡ, đổi màu đen'),
    array('text' => 'Cảm ứng chạm không phản hồi hoặc tự kích hoạt'),
    array('text' => 'Không đủ nhiệt, nấu lâu chín'),
    array('text' => 'Tiếng kêu lạ khi hoạt động'),
)"

set_group_meta "$ID" "service_fixes" "array(
    array('text' => 'Kiểm tra cầu chì, nguồn điện'),
    array('text' => 'Thay bóng đèn hồng ngoại (halogen tube)'),
    array('text' => 'Thay mặt kính ceramic chịu nhiệt'),
    array('text' => 'Thay tấm cảm ứng điều khiển'),
    array('text' => 'Thay bo mạch điều khiển'),
    array('text' => 'Thay cảm biến nhiệt'),
)"

set_group_meta "$ID" "service_errors" "array(
    array('code' => 'E1', 'desc' => 'Cảm biến nhiệt hỏng',              'severity' => 'orange'),
    array('code' => 'E2', 'desc' => 'Nhiệt độ quá cao — tắt bếp để nguội', 'severity' => 'orange'),
    array('code' => 'E3', 'desc' => 'Nguồn điện không ổn định',          'severity' => 'yellow'),
    array('code' => 'H',  'desc' => 'Bếp đang nóng, chưa thể chạm',     'severity' => 'yellow'),
)"

set_group_meta "$ID" "service_pricing" "array(
    array('service_name' => 'Kiểm tra, vệ sinh bếp',       'price' => '120.000đ',           'note' => 'Miễn phí nếu sửa'),
    array('service_name' => 'Thay bóng đèn hồng ngoại',    'price' => '200.000 – 350.000đ', 'note' => 'Theo hãng'),
    array('service_name' => 'Thay mặt kính ceramic',        'price' => '350.000 – 700.000đ', 'note' => 'Theo kích thước'),
    array('service_name' => 'Thay bo mạch điều khiển',      'price' => '400.000 – 650.000đ', 'note' => ''),
    array('service_name' => 'Thay tấm cảm ứng',             'price' => '180.000 – 300.000đ', 'note' => ''),
)"

set_group_meta "$ID" "service_faq" "array(
    array('question' => 'Bếp hồng ngoại và bếp từ khác nhau thế nào?', 'answer' => 'Bếp hồng ngoại dùng bóng đèn halogen phát nhiệt hồng ngoại, dùng được mọi loại nồi. Bếp từ dùng từ trường, chỉ dùng được nồi nhiễm từ nhưng tiết kiệm điện hơn.'),
    array('question' => 'Mặt kính bếp hồng ngoại bị vỡ nhỏ có nguy hiểm không?', 'answer' => 'Nguy hiểm! Ngừng sử dụng ngay vì mảnh kính có thể nứt thêm khi nhiệt độ cao, gây bỏng. Liên hệ thay kính ngay để đảm bảo an toàn.'),
    array('question' => 'Thay bóng đèn hồng ngoại tốn bao nhiêu?',    'answer' => 'Chi phí thay bóng đèn halogen từ 200.000–350.000đ tuỳ hãng và công suất. Thời gian thay khoảng 30–45 phút tại nhà.'),
)"

echo "   ✓ Bếp hồng ngoại done (ID $ID)" >&2

# ══════════════════════════════════════════════════════════════════════════════
# 3. LÒ NƯỚNG
# ══════════════════════════════════════════════════════════════════════════════
ID=$(ensure_service \
    "lo-nuong" \
    "Sửa lò nướng" \
    "Từ 200.000đ" \
    "Không lên nhiệt, dây nhiệt hỏng, timer lỗi, quạt đối lưu yếu — sửa tại nhà")

set_group_meta "$ID" "service_symptoms" "array(
    array('text' => 'Lò không lên nguồn'),
    array('text' => 'Lên nguồn nhưng không nóng'),
    array('text' => 'Nướng không đều, một phía cháy phía kia sống'),
    array('text' => 'Quạt đối lưu không quay hoặc kêu to'),
    array('text' => 'Timer / đồng hồ không hoạt động'),
    array('text' => 'Đèn lò không sáng'),
    array('text' => 'Cửa lò đóng không kín, bản lề hỏng'),
)"

set_group_meta "$ID" "service_fixes" "array(
    array('text' => 'Thay dây nhiệt (thanh nhiệt) trên/dưới'),
    array('text' => 'Thay motor quạt đối lưu'),
    array('text' => 'Thay thermostat / cảm biến nhiệt'),
    array('text' => 'Thay timer cơ hoặc bo mạch điều khiển'),
    array('text' => 'Thay bóng đèn lò'),
    array('text' => 'Thay gioăng cửa, sửa bản lề'),
    array('text' => 'Thay công tắc, núm vặn'),
)"

set_group_meta "$ID" "service_errors" "array(
    array('code' => 'E1',  'desc' => 'Cảm biến nhiệt hỏng',          'severity' => 'orange'),
    array('code' => 'E2',  'desc' => 'Nhiệt độ vượt ngưỡng an toàn', 'severity' => 'red'),
    array('code' => 'F10', 'desc' => 'Lỗi cảm biến RTD (lò điện tử)','severity' => 'orange'),
)"

set_group_meta "$ID" "service_pricing" "array(
    array('service_name' => 'Kiểm tra, vệ sinh lò',         'price' => '200.000đ',           'note' => 'Miễn phí nếu sửa'),
    array('service_name' => 'Thay thanh nhiệt trên/dưới',   'price' => '250.000 – 450.000đ', 'note' => 'Mỗi thanh'),
    array('service_name' => 'Thay motor quạt đối lưu',      'price' => '300.000 – 500.000đ', 'note' => ''),
    array('service_name' => 'Thay thermostat / cảm biến',   'price' => '200.000 – 350.000đ', 'note' => ''),
    array('service_name' => 'Thay timer / bo mạch',         'price' => '350.000 – 650.000đ', 'note' => ''),
    array('service_name' => 'Thay gioăng cửa lò',           'price' => '150.000 – 250.000đ', 'note' => ''),
)"

set_group_meta "$ID" "service_faq" "array(
    array('question' => 'Lò nướng không lên nhiệt là hỏng gì?',     'answer' => 'Thường do thanh nhiệt (heating element) đứt, thermostat chết, hoặc nguồn điện. Kỹ thuật viên kiểm tra và xác định nguyên nhân chính xác trong 15 phút đầu.'),
    array('question' => 'Nướng không đều có phải mua lò mới không?', 'answer' => 'Chưa cần! Thường do quạt đối lưu hỏng hoặc một thanh nhiệt bị yếu. Thay thanh nhiệt hoặc motor quạt rẻ hơn nhiều so với mua lò mới.'),
    array('question' => 'Bảo hành sau sửa bao lâu?',                'answer' => 'Linh kiện thay mới được bảo hành 3 tháng. Nếu lỗi tái phát trong thời gian bảo hành, chúng tôi đến sửa miễn phí.'),
)"

echo "   ✓ Lò nướng done (ID $ID)" >&2

# ══════════════════════════════════════════════════════════════════════════════
# 4. LÒ VI SÓNG
# ══════════════════════════════════════════════════════════════════════════════
ID=$(ensure_service \
    "lo-vi-song" \
    "Sửa lò vi sóng" \
    "Từ 180.000đ" \
    "Không quay, không nóng, hỏng magnetron, bàn phím lỗi — bảo hành 3 tháng")

set_group_meta "$ID" "service_symptoms" "array(
    array('text' => 'Lò không lên nguồn'),
    array('text' => 'Lên nguồn nhưng không hâm nóng thức ăn'),
    array('text' => 'Mâm xoay không quay'),
    array('text' => 'Phát ra tiếng kêu lớn hoặc tia lửa điện'),
    array('text' => 'Bàn phím / màn hình cảm ứng lỗi'),
    array('text' => 'Cửa lò đóng không kín, latch hỏng'),
    array('text' => 'Đèn trong lò không sáng'),
)"

set_group_meta "$ID" "service_fixes" "array(
    array('text' => 'Thay magnetron (nguồn phát vi sóng)'),
    array('text' => 'Thay diode, tụ điện cao áp'),
    array('text' => 'Thay motor mâm xoay'),
    array('text' => 'Thay bàn phím màng hoặc bo mạch'),
    array('text' => 'Thay khóa cửa (door latch / switch)'),
    array('text' => 'Thay bóng đèn trong lò'),
    array('text' => 'Vệ sinh, thay tấm chắn mica'),
)"

set_group_meta "$ID" "service_errors" "array(
    array('code' => 'F-1',  'desc' => 'Lỗi cảm biến nhiệt độ',        'severity' => 'orange'),
    array('code' => 'F-3',  'desc' => 'Cảm biến hơi nước hỏng',        'severity' => 'yellow'),
    array('code' => 'SE',   'desc' => 'Lỗi cảm ứng / bàn phím',        'severity' => 'yellow'),
    array('code' => 'DOOR', 'desc' => 'Cửa chưa đóng kín — kiểm tra latch', 'severity' => 'orange'),
)"

set_group_meta "$ID" "service_pricing" "array(
    array('service_name' => 'Kiểm tra, vệ sinh lò vi sóng',  'price' => '180.000đ',           'note' => 'Miễn phí nếu sửa'),
    array('service_name' => 'Thay magnetron',                 'price' => '500.000 – 900.000đ', 'note' => 'Theo công suất'),
    array('service_name' => 'Thay diode / tụ cao áp',         'price' => '200.000 – 350.000đ', 'note' => ''),
    array('service_name' => 'Thay motor mâm xoay',            'price' => '180.000 – 300.000đ', 'note' => ''),
    array('service_name' => 'Thay bàn phím / bo mạch',        'price' => '350.000 – 600.000đ', 'note' => ''),
    array('service_name' => 'Thay khóa cửa',                  'price' => '150.000 – 250.000đ', 'note' => ''),
)"

set_group_meta "$ID" "service_faq" "array(
    array('question' => 'Lò vi sóng không nóng có phải thay magnetron không?', 'answer' => 'Không nhất thiết. Trước tiên kiểm tra diode và tụ cao áp (rẻ hơn nhiều). Magnetron hỏng thường kèm tiếng kêu bất thường hoặc không có bức xạ vi sóng chút nào.'),
    array('question' => 'Tia lửa trong lò vi sóng có nguy hiểm không?',  'answer' => 'Nguy hiểm — tắt và rút điện ngay! Nguyên nhân thường là tấm mica bẩn/cháy hoặc bộ phận kim loại chạm nhau. Không dùng tiếp khi chưa được kiểm tra.'),
    array('question' => 'Sửa lò vi sóng có đáng không so với mua mới?', 'answer' => 'Đáng nếu lò dùng dưới 7 năm và chi phí sửa dưới 50% giá lò mới. Chúng tôi tư vấn trung thực sau khi chẩn đoán — không ép sửa nếu không hiệu quả kinh tế.'),
)"

echo "   ✓ Lò vi sóng done (ID $ID)" >&2

# ══════════════════════════════════════════════════════════════════════════════
# 5. MÁY HÚT MÙI
# ══════════════════════════════════════════════════════════════════════════════
ID=$(ensure_service \
    "may-hut-mui" \
    "Sửa máy hút mùi" \
    "Từ 100.000đ" \
    "Mất hút, ồn quá mức, đèn hỏng, thay motor và lọc than hoạt tính")

set_group_meta "$ID" "service_symptoms" "array(
    array('text' => 'Máy không hút hoặc hút rất yếu'),
    array('text' => 'Tiếng ồn lớn, rung bất thường'),
    array('text' => 'Đèn chiếu sáng không hoạt động'),
    array('text' => 'Bảng điều khiển / cảm ứng không phản hồi'),
    array('text' => 'Mùi khét, cháy từ máy'),
    array('text' => 'Lưới lọc dầu biến dạng, cần thay'),
)"

set_group_meta "$ID" "service_fixes" "array(
    array('text' => 'Vệ sinh lưới lọc dầu, ống dẫn khí'),
    array('text' => 'Thay motor hút (blower motor)'),
    array('text' => 'Thay bóng đèn LED / halogen'),
    array('text' => 'Thay bảng mạch điều khiển / cảm ứng'),
    array('text' => 'Thay lọc than hoạt tính (cho máy không ống)'),
    array('text' => 'Thay lưới lọc dầu'),
    array('text' => 'Cân chỉnh cánh quạt, chống rung'),
)"

set_group_meta "$ID" "service_pricing" "array(
    array('service_name' => 'Kiểm tra, vệ sinh máy hút mùi',  'price' => '100.000đ',           'note' => 'Miễn phí nếu sửa'),
    array('service_name' => 'Thay motor hút',                  'price' => '350.000 – 650.000đ', 'note' => 'Theo công suất'),
    array('service_name' => 'Thay bóng đèn',                   'price' => '80.000 – 150.000đ',  'note' => 'Mỗi bóng'),
    array('service_name' => 'Thay lọc than hoạt tính',         'price' => '150.000 – 300.000đ', 'note' => 'Nên thay 6 tháng/lần'),
    array('service_name' => 'Thay lưới lọc dầu',               'price' => '100.000 – 200.000đ', 'note' => 'Theo kích thước'),
    array('service_name' => 'Thay bảng điều khiển',            'price' => '300.000 – 550.000đ', 'note' => ''),
)"

set_group_meta "$ID" "service_faq" "array(
    array('question' => 'Máy hút mùi hút yếu phải làm gì đầu tiên?',  'answer' => 'Vệ sinh lưới lọc dầu và ống dẫn khí trước — đây là nguyên nhân phổ biến nhất. Nếu sau vệ sinh vẫn yếu, khả năng motor bị mòn cần thay.'),
    array('question' => 'Lọc than hoạt tính cần thay bao lâu một lần?','answer' => 'Thông thường 6 tháng/lần với gia đình nấu ăn hàng ngày. Máy hút tuần hoàn (không ống ra ngoài) cần thay thường xuyên hơn.'),
    array('question' => 'Máy hút mùi kêu to là hỏng gì?',             'answer' => 'Thường do cánh quạt mất cân bằng (có dầu bám), vòng bi motor mòn, hoặc ốc vít lỏng. Vệ sinh và cân chỉnh thường giải quyết được, nặng hơn thì thay motor.'),
)"

echo "   ✓ Máy hút mùi done (ID $ID)" >&2

echo ""
echo "✅ All 5 kf_service posts seeded!"
$WP post list --post_type=kf_service --fields=ID,post_title,post_status 2>/dev/null
