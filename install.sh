#!/bin/bash

# Pimcore DPP Fashion - Installation Script
# This script sets up the Pimcore 10 DPP Fashion demo project

set -e

echo "========================================="
echo "Pimcore DPP Fashion - Installation"
echo "========================================="
echo ""

# Step 1: Copy environment file
echo "📋 Setting up environment..."
if [ ! -f .env.local ]; then
    cp .env.example .env.local
    echo "✅ .env.local created"
else
    echo "⚠️  .env.local already exists, skipping"
fi

# Step 2: Install dependencies
echo ""
echo "📦 Installing PHP dependencies..."
docker-compose exec -T app composer install

echo ""
echo "📦 Installing Node dependencies..."
docker-compose exec -T app npm install

# Step 3: Database setup
echo ""
echo "🗄️  Setting up database..."
docker-compose exec -T app bin/console pimcore:setup:db

# Step 4: Create admin user
echo ""
echo "👤 Creating admin user..."
docker-compose exec -T app bin/console pimcore:user:create \
    --username=admin \
    --password=admin123 \
    --email=admin@example.com \
    --firstname=Admin \
    --lastname=User \
    --admin=1 || echo "⚠️  Admin user may already exist"

# Step 5: Load demo data
echo ""
echo "📊 Loading demo data..."
docker-compose exec -T app bin/console app:dpp:load-demo-data

# Step 6: Cache warm-up
echo ""
echo "🔥 Warming up cache..."
docker-compose exec -T app bin/console cache:warm

echo ""
echo "========================================="
echo "✅ Installation complete!"
echo "========================================="
echo ""
echo "🌐 Pimcore Admin: http://localhost:8080/admin"
echo "🔐 Username: admin"
echo "🔐 Password: admin123"
echo ""
echo "📡 API Endpoints:"
echo "   • Export single product: GET /api/dpp/{productId}/export"
echo "   • Batch export: POST /api/dpp/batch/export"
echo ""
echo "📝 Next steps:"
echo "   1. Open http://localhost:8080/admin in your browser"
echo "   2. Login with admin / admin123"
echo "   3. Explore DPP Fashion products"
echo "   4. Test API endpoints with curl or Postman"
echo ""
