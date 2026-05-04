#!/bin/sh
# Seed kf_testimonial CPT with sample customer reviews.
# Safe to re-run — skips if total count >= 10.

WP="wp --allow-root --path=/var/www/html"

COUNT=$($WP post list --post_type=kf_testimonial --post_status=publish \
    --fields=ID --format=ids --quiet 2>/dev/null | wc -w | tr -d ' ')

if [ "$COUNT" -ge 10 ]; then
    echo "   kf_testimonial already has $COUNT posts — skip"
    exit 0
fi

echo "🌟 Seeding customer testimonials..."

add_review() {
    NAME="$1"
    LOCATION="$2"
    SERVICE="$3"
    RATING="$4"
    CONTENT="$5"

    ID=$($WP post create \
        --post_type=kf_testimonial \
        --post_status=publish \
        --post_title="$NAME" \
        --post_content="$CONTENT" \
        --porcelain --quiet 2>/dev/null)

    $WP post meta update "$ID" rating   "$RATING"   --quiet 2>/dev/null
    $WP post meta update "$ID" location "$LOCATION" --quiet 2>/dev/null
    $WP post meta update "$ID" service  "$SERVICE"  --quiet 2>/dev/null

    echo "   ✓ $NAME — $SERVICE ($LOCATION)"
}

add_review \
    "Chị Lan Anh" \
    "Quận Bình Thạnh, TP.HCM" \
    "Sửa bếp từ" \
    "5" \
    "Bếp từ Bosch nhà mình báo lỗi E6, thợ đến trong vòng 45 phút, chẩn đoán hỏng IGBT, thay xong trong 1 tiếng. Giá hợp lý, thợ tư vấn tận tình, bếp chạy ngon lành. Sẽ giới thiệu cho hàng xóm!"

add_review \
    "Anh Minh Tuấn" \
    "Quận 7, TP.HCM" \
    "Sửa bếp từ" \
    "5" \
    "Gọi lúc 8 giờ tối, thợ vẫn đến trong 30 phút. Bếp Sunhouse không nhận nồi, thay mâm từ xong là bếp hoạt động bình thường. Bảo hành 3 tháng nên rất yên tâm. Dịch vụ 10/10!"

add_review \
    "Chị Thanh Hà" \
    "Quận Gò Vấp, TP.HCM" \
    "Sửa lò vi sóng" \
    "5" \
    "Lò vi sóng Sharp không nóng mà mâm vẫn quay, tưởng phải mua lò mới. Thợ kiểm tra nói hỏng magnetron, tư vấn thay hơn mua mới. Sau sửa lò như mới, tiết kiệm được hơn 2 triệu!"

add_review \
    "Chú Văn Hùng" \
    "Quận Tân Phú, TP.HCM" \
    "Sửa máy hút mùi" \
    "5" \
    "Máy hút mùi Canzy nhà tôi bị ồn, hút yếu. Thợ vệ sinh lọc dầu và thay motor, bây giờ yên tĩnh hơn hẳn. Thợ làm việc gọn gàng, dọn dẹp sạch sẽ sau khi xong. Rất hài lòng!"

add_review \
    "Chị Thu Thảo" \
    "Quận 12, TP.HCM" \
    "Sửa lò nướng" \
    "5" \
    "Lò nướng Sanaky không lên nhiệt nửa bên trên. Thợ chẩn đoán đứt dây nhiệt, thay mới trong 1 tiếng. Báo giá trước không phát sinh thêm, đúng như cam kết. Sẽ dùng dịch vụ lần sau!"

add_review \
    "Anh Quốc Bảo" \
    "Quận Thủ Đức, TP.HCM" \
    "Sửa bếp hồng ngoại" \
    "4" \
    "Bếp hồng ngoại nứt mặt kính, lo không thay được vì hiệu ít phổ biến. Thợ tìm được kính phù hợp sau 1 ngày, lắp vừa như ý. Trừ 1 sao vì phải chờ linh kiện nhưng thợ thông báo trước nên cũng thông cảm."

add_review \
    "Chị Ngọc Mai" \
    "Quận Bình Tân, TP.HCM" \
    "Sửa bếp từ" \
    "5" \
    "Lần đầu dùng dịch vụ sửa bếp tại nhà, ban đầu hơi lo nhưng thợ rất chuyên nghiệp. Giải thích rõ từng bước, chỉ cách dùng bếp đúng cách để không bị lỗi lại. Sẽ là khách hàng thường xuyên!"

add_review \
    "Anh Đức Thịnh" \
    "Quận 3, TP.HCM" \
    "Sửa lò vi sóng" \
    "5" \
    "Panasonic báo DOOR dù cửa đóng rồi. Thợ thay khóa cửa, xong trong 40 phút. Giá 200k, rẻ hơn tôi nghĩ nhiều. Nhân viên lịch sự, đúng giờ hẹn. Recommend mạnh!"

add_review \
    "Chị Bích Phượng" \
    "Huyện Nhà Bè, TP.HCM" \
    "Sửa máy hút mùi" \
    "5" \
    "Cứ nghĩ ở xa (Nhà Bè) thì không có thợ đến, nhưng vẫn phục vụ bình thường trong ngày. Máy hút mùi thay bóng đèn và vệ sinh lọc, giờ sáng và hút mạnh hơn nhiều. Hài lòng với dịch vụ!"

add_review \
    "Anh Trọng Nghĩa" \
    "Quận Phú Nhuận, TP.HCM" \
    "Sửa lò nướng" \
    "5" \
    "Lò nướng Sharp quạt đối lưu kêu to, nướng không đều. Thay motor quạt mới, lò êm và nướng đều 2 mặt. Thợ còn kiểm tra thanh nhiệt miễn phí và cho biết vẫn còn tốt. Trung thực, không ép sửa thêm!"

echo ""
echo "✅ Testimonials seeded!"
$WP post list --post_type=kf_testimonial --fields=ID,post_title,post_status 2>/dev/null
