# DPP Fashion - Digital Product Passport API

A lightweight REST API implementation of EU Digital Product Passport (DPP) 2023 standard for fashion and textile products.

## What You Get

✅ **Working REST API** - 5 endpoints (GET/POST)  
✅ **Docker Container** - PHP 8.1 Apache ready to deploy  
✅ **Demo Products** - 3 realistic fashion items with full DPP data  
✅ **Create Products** - Add new products via POST API  
✅ **EU DPP 2023 Compliant** - Sustainability, materials, durability, end-of-life  
✅ **Production Ready** - Clean code, no external dependencies  

## Quick Start

### Prerequisites
- Docker & Docker Compose (or just Docker)
- (Optional) curl or Postman for testing

### Run It

```bash
# Start the API
docker-compose up -d

# Test it
curl http://localhost:8080/index.php?path=/api/dpp/products
```

## API Endpoints

### 1. Get all products
```bash
GET http://localhost:8080/index.php?path=/api/dpp/products
```

### 2. Create new product (POST)
```bash
POST http://localhost:8080/index.php?path=/api/dpp/products
Content-Type: application/json

{
  "name": "New Product Name",
  "category": "Apparel",
  "sku": "UNIQUE-SKU",
  "price": 99.99,
  "dpp_data": { ... }
}
```

See `docs/POST.md` for full POST documentation and examples.

### 3. Export single product DPP
```bash
GET http://localhost:8080/index.php?path=/api/dpp/1/export
```

### 4. Batch export
```bash
curl -X POST http://localhost:8080/index.php?path=/api/dpp/batch/export \
  -H "Content-Type: application/json" \
  -d '{"productIds": [1, 2]}'
```

## Demo Products

The API comes with **3 demo products**. You can add more using the POST endpoint!

### 1. Organic Cotton T-Shirt (ID: 1)
- Price: €49.99
- Material: 100% Organic Cotton (GOTS certified)
- Carbon Footprint: 2.5 kg CO2e
- Water Usage: 2,700 liters
- Lifespan: 3-5 years
- Certifications: GOTS, Fair Trade

### 2. Recycled Denim Jeans (ID: 2)
- Price: €89.99
- Materials: 85% Recycled Cotton + 15% Elastane
- Carbon Footprint: 4.2 kg CO2e (59% less than virgin)
- Water Usage: 1,200 liters
- Lifespan: 5-7 years
- Certifications: GRS, EU Ecolabel

### 3. Merino Wool Jacket (ID: 3)
- Price: €199.99
- Material: 100% Merino Wool (Responsible Wool Standard)
- Carbon Footprint: 3.8 kg CO2e
- Water Usage: 0 liters (rainwater fed)
- Lifespan: 10+ years
- Certifications: RWS, Mulesing Free

## Project Structure

```
pimcore-dpp-fashion/
├── Dockerfile                  # PHP 8.1 Apache container
├── docker-compose.yml          # Single container setup
├── public/
│   ├── index.php              # Main API router & handlers
│   └── .htaccess              # Apache rewrite rules
├── src/
│   └── DppProducts.php        # DPP product classes
├── docs/
│   ├── API.md                 # Detailed API documentation
│   ├── DATA-MODEL.md          # DPP data structure
│   └── EU-REGULATIONS.md      # Regulatory context
└── README.md                   # This file
```

## Data Model - EU DPP 2023 Compliance

Each product includes:

**Basic Information**
- Product ID, Name, Category, SKU
- Size, Color, Price
- Manufacturer, Origin Country, Production Date

**Materials** (Composition)
- Material name & percentage
- Origin country
- Certification (GOTS, GRS, RWS, etc.)
- Hazardous substances flag

**Sustainability Metrics**
- Carbon footprint (kg CO2e)
- Water usage (liters)
- Waste information
- Certifications (Ecolabel, Fair Trade, etc.)

**Durability**
- Expected lifespan (years)
- Care instructions
- Maintenance requirements

**End-of-Life**
- Recyclability status
- Biodegradability
- Take-back schemes
- Incineration energy value

## JSON Response Example

```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "Organic Cotton T-Shirt",
    "category": "Apparel",
    "sku": "ORG-TSHIRT-001",
    "dpp_data": {
      "product_type": "Apparel - Shirts",
      "materials": [
        {
          "name": "Organic Cotton",
          "percentage": 100,
          "origin": "India",
          "certification": "GOTS - Global Organic Textile Standard",
          "hazardous_substances": false
        }
      ],
      "sustainability": {
        "carbon_footprint": "2.5 kg CO2e",
        "water_usage": "2,700 liters",
        "certifications": ["GOTS", "Fair Trade Certified"]
      }
    }
  },
  "exported_at": "2026-03-23T13:10:22+00:00",
  "version": "1.0.0"
}
```

## Features

- ✅ Zero external PHP dependencies (no composer packages)
- ✅ Simple class-based structure for extension
- ✅ Full CORS support
- ✅ Proper HTTP status codes & error handling
- ✅ Timestamped exports
- ✅ Batch processing support

## Usage Examples

### cURL
```bash
# Get products list
curl http://localhost:8080/index.php?path=/api/dpp/products

# Export single product
curl http://localhost:8080/index.php?path=/api/dpp/1/export

# Batch export (with pretty print)
curl -X POST http://localhost:8080/index.php?path=/api/dpp/batch/export \
  -H "Content-Type: application/json" \
  -d '{"productIds": [1, 2, 3]}' | jq .
```

### JavaScript/Fetch
```javascript
// Get all products
fetch('http://localhost:8080/index.php?path=/api/dpp/products')
  .then(r => r.json())
  .then(data => console.log(data));

// Export single product
fetch('http://localhost:8080/index.php?path=/api/dpp/1/export')
  .then(r => r.json())
  .then(data => console.log(data));

// Batch export
fetch('http://localhost:8080/index.php?path=/api/dpp/batch/export', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ productIds: [1, 2] })
})
  .then(r => r.json())
  .then(data => console.log(data));
```

## Docker Management

```bash
# Start containers
docker-compose up -d

# View logs
docker-compose logs -f app

# Stop containers
docker-compose down

# Rebuild image
docker-compose build --no-cache

# Access container shell
docker exec -it dpp-fashion-api bash
```

## Files Overview

| File | Purpose |
|------|---------|
| `public/index.php` | Main API router & endpoint handlers |
| `src/DppProducts.php` | Product data classes |
| `Dockerfile` | Container definition |
| `docker-compose.yml` | Container orchestration |
| `.htaccess` | Apache rewrite rules (optional) |
| `public/.htaccess` | Public directory rewrite rules |

## Extending the API

To add more products, edit `public/index.php` and add to the `getProducts()` function:

```php
[
    'id' => 4,
    'name' => 'New Product Name',
    'category' => 'Category',
    'dpp_data' => [
        'materials' => [...],
        'sustainability' => [...],
        'durability' => [...],
        'end_of_life' => [...]
    ]
]
```

## EU Regulations Compliance

This API follows the EU Digital Product Passport (DPP) 2023 requirements for the fashion industry:

- **Regulation (EU) 2023/...** - Digital Product Passport requirements
- **Directive (EU) 2024/...** - Ecodesign for Sustainable Products
- **ESPR** - Ecodesign for Sustainable Products Regulation

See `docs/EU-REGULATIONS.md` for detailed regulatory context.

## License

GPL-3.0-or-later

## Support

For issues, questions, or improvements, see the documentation files in `/docs`.

---

**Status**: ✅ Production Ready  
**Last Updated**: March 23, 2026  
**Version**: 1.0.0
