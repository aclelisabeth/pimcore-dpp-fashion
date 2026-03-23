# POST - Create New Products

## Overview

You can now add new products to the API using the **POST** endpoint. Products are stored in a JSON file and persist between API calls.

## Endpoint

```
POST /api/dpp/products
```

## Request Format

### Headers
```
Content-Type: application/json
```

### Body
```json
{
  "name": "Product Name",
  "category": "Apparel",
  "sku": "UNIQUE-SKU",
  "description": "Product description",
  "manufacturer": "Company Name",
  "origin_country": "Country Code (e.g., DE)",
  "price": 99.99,
  "currency": "EUR",
  "size": "M",
  "color": "Color Name",
  "dpp_data": {
    "product_type": "Apparel - Shirts",
    "materials": [
      {
        "name": "Cotton",
        "percentage": 100,
        "origin": "India",
        "certification": "GOTS",
        "hazardous_substances": false
      }
    ],
    "sustainability": {
      "carbon_footprint": "2.5 kg CO2e",
      "water_usage": "2,700 liters",
      "waste": "Minimal",
      "certifications": ["GOTS", "Fair Trade"]
    },
    "durability": {
      "expected_lifespan": "3-5 years",
      "care_instructions": "Machine wash 30°C",
      "maintenance": "No bleach"
    },
    "end_of_life": {
      "recyclable": true,
      "biodegradable": true,
      "take_back_scheme": "Available",
      "incineration_value": "High energy"
    }
  }
}
```

## Required Fields

- `name` - Product name
- `category` - Product category (e.g., "Apparel")
- `sku` - Unique Stock Keeping Unit
- `dpp_data` - DPP (Digital Product Passport) data object

## Optional Fields

- `description` - Product description
- `manufacturer` - Manufacturer name
- `origin_country` - Country code
- `price` - Product price
- `currency` - Currency code (EUR, USD, etc.)
- `size` - Size information
- `color` - Color name

## Response

### Success (201 Created)

```json
{
  "status": "success",
  "message": "Product created successfully",
  "data": {
    "id": 4,
    "name": "Linen Summer Shirt",
    "category": "Apparel",
    "sku": "LINEN-SHIRT-004",
    "created_at": "2026-03-23T13:43:01+00:00",
    "updated_at": "2026-03-23T13:43:01+00:00",
    "dpp_data": { ... }
  }
}
```

### Error (400 Bad Request)

If required fields are missing:
```json
{
  "error": "Missing required field: name"
}
```

## Examples

### cURL - Basic Product

```bash
curl -X POST http://localhost:8080/index.php?path=/api/dpp/products \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Linen Summer Shirt",
    "category": "Apparel",
    "sku": "LINEN-SHIRT-004",
    "description": "Breathable linen summer shirt",
    "manufacturer": "LinenWear Co",
    "origin_country": "FR",
    "price": 59.99,
    "currency": "EUR",
    "dpp_data": {
      "product_type": "Apparel - Shirts",
      "materials": [
        {
          "name": "Linen",
          "percentage": 100,
          "origin": "France",
          "certification": "OEKO-TEX",
          "hazardous_substances": false
        }
      ],
      "sustainability": {
        "carbon_footprint": "1.8 kg CO2e",
        "water_usage": "800 liters",
        "certifications": ["OEKO-TEX"]
      }
    }
  }'
```

### JavaScript/Fetch

```javascript
const newProduct = {
  name: "Hemp T-Shirt",
  category: "Apparel",
  sku: "HEMP-TSHIRT-005",
  description: "100% hemp sustainable t-shirt",
  manufacturer: "HempWear",
  origin_country": "AT",
  price: 45.00,
  currency: "EUR",
  dpp_data: {
    product_type: "Apparel - Shirts",
    materials: [
      {
        name: "Hemp",
        percentage: 100,
        origin: "Austria",
        certification: "Certified Organic",
        hazardous_substances: false
      }
    ],
    sustainability: {
      carbon_footprint: "1.2 kg CO2e",
      water_usage: "500 liters",
      certifications: ["Organic"]
    }
  }
};

fetch('http://localhost:8080/index.php?path=/api/dpp/products', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify(newProduct)
})
  .then(r => r.json())
  .then(data => console.log(data))
  .catch(err => console.error(err));
```

### Python/Requests

```python
import requests
import json

new_product = {
    "name": "Wool Sweater",
    "category": "Apparel",
    "sku": "WOOL-SWEATER-006",
    "manufacturer": "WoolCraft",
    "origin_country": "NZ",
    "price": 79.99,
    "dpp_data": {
        "product_type": "Apparel - Knitwear",
        "materials": [
            {
                "name": "Merino Wool",
                "percentage": 100,
                "origin": "New Zealand",
                "certification": "RWS",
                "hazardous_substances": False
            }
        ],
        "sustainability": {
            "carbon_footprint": "3.5 kg CO2e",
            "water_usage": "100 liters",
            "certifications": ["RWS"]
        }
    }
}

response = requests.post(
    'http://localhost:8080/index.php?path=/api/dpp/products',
    json=new_product,
    headers={'Content-Type': 'application/json'}
)

print(response.json())
```

## Data Persistence

- Products are stored in: `data/products.json`
- The file is created automatically on first use
- Products persist between API restarts ✅
- Products are NOT committed to git (in `.gitignore`)

## Workflow

1. **POST** to `/api/dpp/products` → Create new product
2. **GET** `/api/dpp/products` → See all products (including new ones)
3. **GET** `/api/dpp/{id}/export` → Export specific product
4. **POST** `/api/dpp/batch/export` → Export multiple products

## API Endpoints Summary

| Method | Endpoint | Purpose |
|--------|----------|---------|
| GET | `/` | API info |
| GET | `/api/dpp/products` | List all products |
| POST | `/api/dpp/products` | Create new product |
| GET | `/api/dpp/{id}/export` | Export single product |
| POST | `/api/dpp/batch/export` | Batch export |

## Notes

- Each new product gets a unique auto-incrementing ID
- `created_at` and `updated_at` timestamps are added automatically
- If not provided, `production_date` defaults to today
- DPP data should follow EU DPP 2023 standards
- All fields in response are echoed back (for validation)

---

See `QUICK_START.md` for basic usage.
