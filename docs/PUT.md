# PUT - Update Products

## Overview

You can now update any product field using the **PUT** endpoint. This is useful for changing `product_type`, sustainability data, or any other field.

## Endpoint

```
PUT /api/dpp/{id}
```

## Request Format

### Headers
```
Content-Type: application/json
```

### Body

You can update any field(s). Only include the fields you want to change:

```json
{
  "name": "Updated Name",
  "category": "Updated Category",
  "dpp_data": {
    "product_type": "Accessories - Jewelry",
    "materials": [...],
    "sustainability": {...}
  }
}
```

## Response

### Success (200 OK)

```json
{
  "status": "success",
  "message": "Product updated successfully",
  "data": {
    "id": 4,
    "name": "Golden Chain 40k",
    "category": "Accessoire",
    "updated_at": "2026-03-23T14:00:00+00:00",
    ...
  }
}
```

### Error (404 Not Found)

```json
{
  "error": "Product not found"
}
```

## Examples

### cURL - Update product_type

```bash
curl -X PUT http://localhost:8080/index.php?path=/api/dpp/4 \
  -H "Content-Type: application/json" \
  -d '{
    "dpp_data": {
      "product_type": "Accessories - Jewelry"
    }
  }'
```

### cURL - Update entire DPP data

```bash
curl -X PUT http://localhost:8080/index.php?path=/api/dpp/4 \
  -H "Content-Type: application/json" \
  -d '{
    "dpp_data": {
      "product_type": "Accessories - Jewelry",
      "materials": [
        {
          "name": "Gold",
          "percentage": 100,
          "origin": "Austria",
          "certification": "Xetra-Gold",
          "hazardous_substances": false
        }
      ],
      "sustainability": {
        "carbon_footprint": "2.5 kg CO2e",
        "water_usage": "8,000 liters",
        "certifications": ["Gold"]
      }
    }
  }'
```

### cURL - Update multiple fields

```bash
curl -X PUT http://localhost:8080/index.php?path=/api/dpp/4 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Golden Chain 50k",
    "price": 12999.99,
    "color": "Rose Gold",
    "dpp_data": {
      "product_type": "Accessories - Fine Jewelry"
    }
  }'
```

### Postman

1. Set method to **PUT**
2. URL: `http://localhost:8080/index.php?path=/api/dpp/4`
3. Go to **Body** tab
4. Select **raw** and **JSON**
5. Enter your update JSON:

```json
{
  "dpp_data": {
    "product_type": "Accessories - Jewelry"
  }
}
```

6. Click **Send**

### JavaScript/Fetch

```javascript
const updates = {
  dpp_data: {
    product_type: "Accessories - Jewelry",
    sustainability: {
      carbon_footprint: "2.5 kg CO2e",
      water_usage: "8,000 liters"
    }
  }
};

fetch('http://localhost:8080/index.php?path=/api/dpp/4', {
  method: 'PUT',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify(updates)
})
  .then(r => r.json())
  .then(data => console.log(data));
```

## Updatable Fields

✅ All fields except:
- `id` - Cannot be changed
- `created_at` - Cannot be changed (creation timestamp is immutable)

✅ Can be updated:
- `name`
- `category`
- `sku`
- `description`
- `manufacturer`
- `origin_country`
- `production_date`
- `price`
- `currency`
- `size`
- `color`
- `dpp_data` (all fields within)

## Partial Updates

You only need to send the fields you want to change:

```json
{
  "dpp_data": {
    "product_type": "New Type"
  }
}
```

This will update ONLY the `product_type` inside `dpp_data` and keep all other fields unchanged.

## Timestamps

- `created_at` - Set when product is first created, never changes
- `updated_at` - Updated automatically whenever you modify the product

## Notes

- PUT preserves all data not explicitly updated
- Fields are replaced entirely (not merged for nested objects)
- Timestamps are managed automatically
- All updates persist to the JSON file

---

See `POST.md` for creating new products and `GET.md` for retrieving products.
