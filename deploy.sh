#!/bin/bash
# Usage: ./deploy.sh user@your-vps-ip [domain]
# Example: ./deploy.sh root@123.456.789.0 kitfix24h.vn
set -e

VPS="${1:?Thiếu địa chỉ VPS. Dùng: ./deploy.sh user@host [domain]}"
DOMAIN="${2:-}"
REMOTE_DIR="/opt/kitfix24h"

echo "==> Deploy tới $VPS ..."

# ─── 1. Sync source lên VPS ──────────────────────────────────────────────────
echo "[1/5] Sync files..."
rsync -az --delete \
  --exclude='.git' \
  --exclude='.claude' \
  --exclude='node_modules' \
  ./ "$VPS:$REMOTE_DIR/"

# ─── 2. Chuẩn bị .env trên VPS ──────────────────────────────────────────────
echo "[2/5] Kiểm tra .env trên VPS..."
ssh "$VPS" "
  if [ ! -f $REMOTE_DIR/.env ]; then
    cp $REMOTE_DIR/.env.example $REMOTE_DIR/.env
    echo '⚠️  Chưa có .env — đã copy từ .env.example.'
    echo '   Hãy sửa $REMOTE_DIR/.env rồi chạy lại deploy.sh'
    exit 1
  fi
"

# ─── 3. Cập nhật domain trong nginx.conf ────────────────────────────────────
if [ -n "$DOMAIN" ]; then
  echo "[3/5] Cập nhật domain $DOMAIN vào nginx.conf..."
  ssh "$VPS" "
    sed -i 's/DOMAIN_PLACEHOLDER/$DOMAIN/g' $REMOTE_DIR/docker/nginx.conf
  "
else
  echo "[3/5] Bỏ qua domain (không truyền tham số domain)"
fi

# ─── 4. Build image và khởi động ────────────────────────────────────────────
echo "[4/5] Build image + docker compose up..."
ssh "$VPS" "
  cd $REMOTE_DIR
  docker compose -f docker-compose.prod.yml build --no-cache wordpress
  docker compose -f docker-compose.prod.yml up -d db nginx wordpress
  echo 'Chờ WordPress khởi động (20s)...'
  sleep 20
  docker compose -f docker-compose.prod.yml run --rm wpcli
"

# ─── 5. Cấp SSL (nếu có domain) ─────────────────────────────────────────────
if [ -n "$DOMAIN" ]; then
  echo "[5/5] Cấp SSL cho $DOMAIN ..."
  ssh "$VPS" "
    cd $REMOTE_DIR
    docker compose -f docker-compose.prod.yml run --rm certbot certonly \
      --webroot --webroot-path=/var/www/certbot \
      --email \$(grep WP_ADMIN_EMAIL .env | cut -d= -f2) \
      --agree-tos --no-eff-email \
      -d $DOMAIN -d www.$DOMAIN || true
    docker compose -f docker-compose.prod.yml exec nginx nginx -s reload || true
  "
else
  echo "[5/5] Bỏ qua SSL (không có domain)"
fi

echo ""
echo "✅ Deploy xong!"
echo "   Site: ${DOMAIN:+https://$DOMAIN}${DOMAIN:-http://$VPS:80}"
echo "   Admin: ${DOMAIN:+https://$DOMAIN}${DOMAIN:-http://$VPS:80}/wp-admin"
