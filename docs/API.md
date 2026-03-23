# DPP API Documentation

## Base URL
```
http://localhost:8080/api/dpp
```

## Endpoints

### 1. Export Single Product
Exports a complete Digital Product Passport for a single product.

**Endpoint:**
```
GET /api/dpp/{productId}/export
```

**Path Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| productId | string | Product ID or SKU |

**Query Parameters:**
| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| format | string | json | Export format (json, xml, pdf) |
| language | string | en | Language code (en, de, fr, it) |

**Example Request:**
```bash
curl http://localhost:8080/api/dpp/SKU-ORGANIC-TEE-001/export
```

**Example Response (200 OK):**
```json
{
  "dpp": {
    "version": "1.0",
    "standard": "EU-DPP-2023",
    "timestamp": "2024-03-23T10:30:00+00:00"
  },
  "product": {
    "identification": {
      "productId": "SKU-ORGANIC-TEE-001",
      "sku": "SKU-ORGANIC-TEE-001",
      "productName": "Organic Cotton T-Shirt",
      "category": "T-Shirts",
      "description": "Premium organic cotton t-shirt made from certified sustainable cotton"
    },
    "manufacturer": {
      "name": "EcoFashion Ltd",
      "country": "DE"
    }
  },
  "sustainability": {
    "materials": [
      {
        "materialName": "Organic Cotton",
        "materialType": "Natural Fiber",
        "percentage": 100,
        "originCountry": "INDIA",
        "certification": "GOTS (Global Organic Textile Standard)",
        "sourceType": "Organic",
        "co2_per_kg": 1.2,
        "waterConsumption_liters_per_kg": 1800,
        "chemicalTreatment": "None"
      }
    ],
    "carbonFootprint": {
      "total_kg_co2": 2.5,
      "scope": ["production", "transportation"],
      "methodology": "ISO 14040"
    },
    "waterConsumption": {
      "total_liters": 2500,
      "scope": ["cultivation", "processing"]
    },
    "chemicalUsage": {
      "dyes": ["Reactive Red 195", "Acid Yellow 25"],
      "finishing": ["Formaldehyde-free finishing"]
    }
  },
  "durability": {
    "estimatedLifespanMonths": 24,
    "repairability": {
      "score": 8,
      "repairGuideUrl": "https://example.com/repair/SKU-001",
      "replacementPartsAvailable": true
    }
  },
  "endOfLife": {
    "recyclable": true,
    "recyclabilityScore": 85,
    "recyclingInstructions": "Separate fasteners and return to certified recycling center",
    "recyclingProgram": "EcoFashion Take-Back Program"
  },
  "compliance": {
    "certifications": [
      "GOTS - Global Organic Textile Standard",
      "Fair Trade Certified",
      "OEKO-TEX Standard 100"
    ],
    "standards": [
      "ISO 14062:2002 - Environmental management in product design",
      "EU 2014/30/EU - EMC Directive"
    ],
    "regulatoryStatus": "Compliant"
  },
  "supplyChain": {
    "origin": {
      "country": "INDIA",
      "facility": "GreenTex Mills, Tamil Nadu"
    },
    "steps": [
      {
        "stage": "Raw Material Cultivation",
        "location": "INDIA",
        "certifications": ["GOTS"]
      },
      {
        "stage": "Spinning & Weaving",
        "location": "INDIA",
        "certifications": ["OEKO-TEX"]
      },
      {
        "stage": "Dyeing & Finishing",
        "location": "ITALY",
        "certifications": ["OEKO-TEX", "ZDHC"]
      },
      {
        "stage": "Manufacturing",
        "location": "VIETNAM",
        "certifications": ["Fair Trade", "SA8000"]
      }
    ]
  },
  "metadata": {
    "dppCreatedAt": "2024-01-15T08:00:00+00:00",
    "lastUpdatedAt": "2024-03-23T10:30:00+00:00",
    "version": "1.0",
    "language": "en"
  }
}
```

**Error Response (404 Not Found):**
```json
{
  "error": "Product not found"
}
```

**Error Response (500 Internal Server Error):**
```json
{
  "error": "Database connection error"
}
```

---

### 2. Batch Export
Exports DPP data for multiple products in a single request.

**Endpoint:**
```
POST /api/dpp/batch/export
```

**Headers:**
```
Content-Type: application/json
```

**Request Body:**
```json
{
  "productIds": [
    "SKU-ORGANIC-TEE-001",
    "SKU-RECYCLED-JEANS-001",
    "SKU-WOOL-JACKET-001"
  ],
  "format": "json",
  "includeMetadata": true
}
```

**Example Request:**
```bash
curl -X POST http://localhost:8080/api/dpp/batch/export \
  -H "Content-Type: application/json" \
  -d '{
    "productIds": [
      "SKU-ORGANIC-TEE-001",
      "SKU-RECYCLED-JEANS-001"
    ]
  }'
```

**Example Response (200 OK):**
```json
{
  "count": 2,
  "timestamp": "2024-03-23T10:35:00+00:00",
  "products": [
    {
      "productId": "SKU-ORGANIC-TEE-001",
      "dpp": { ... }
    },
    {
      "productId": "SKU-RECYCLED-JEANS-001",
      "dpp": { ... }
    }
  ]
}
```

---

## Response Format Details

### Product Identification
```json
"identification": {
  "productId": "unique-identifier",
  "sku": "SKU-CODE",
  "productName": "Product Name",
  "category": "T-Shirts|Jeans|Dresses|Jackets|Shoes|Accessories",
  "description": "Product description",
  "imageUrl": "https://example.com/image.jpg"
}
```

### Materials Array
Each material object in the array contains:
```json
{
  "materialName": "Material Name",
  "materialType": "Natural Fiber|Synthetic|Regenerated|Bio-based",
  "percentage": 100,
  "originCountry": "ISO-COUNTRY-CODE",
  "certification": "Certification Name",
  "sourceType": "Organic|Conventional|Recycled|Bio-based",
  "co2_per_kg": 1.2,
  "waterConsumption_liters_per_kg": 1800,
  "chemicalTreatment": "Treatment description"
}
```

### Sustainability Metrics
```json
"sustainability": {
  "materials": [...],
  "carbonFootprint": {
    "total_kg_co2": 2.5,
    "scope": ["production", "transportation", "packaging", "usage", "end-of-life"],
    "methodology": "ISO 14040"
  },
  "waterConsumption": {
    "total_liters": 2500,
    "scope": ["cultivation", "processing"]
  },
  "chemicalUsage": {
    "dyes": ["Dye Name"],
    "finishing": ["Finishing Chemical"]
  }
}
```

### Durability & Repairability
```json
"durability": {
  "estimatedLifespanMonths": 24,
  "repairability": {
    "score": 8,
    "repairGuideUrl": "https://example.com/repair",
    "replacementPartsAvailable": true
  }
}
```

### End-of-Life & Recyclability
```json
"endOfLife": {
  "recyclable": true,
  "recyclabilityScore": 85,
  "recyclingInstructions": "Separation and disposal instructions",
  "recyclingProgram": "Program name"
}
```

### Compliance & Certifications
```json
"compliance": {
  "certifications": [
    "GOTS - Global Organic Textile Standard",
    "OEKO-TEX Standard 100",
    "Fair Trade Certified"
  ],
  "standards": [
    "ISO 14062:2002",
    "EU 2014/30/EU"
  ],
  "regulatoryStatus": "Compliant|Non-compliant|Pending"
}
```

### Supply Chain
```json
"supplyChain": {
  "origin": {
    "country": "COUNTRY-NAME",
    "facility": "Facility Name and Location"
  },
  "steps": [
    {
      "stage": "Production Stage",
      "location": "COUNTRY-CODE",
      "certifications": ["Certification Name"]
    }
  ]
}
```

---

## HTTP Status Codes

| Code | Status | Description |
|------|--------|-------------|
| 200 | OK | Request successful |
| 400 | Bad Request | Invalid parameters |
| 404 | Not Found | Product not found |
| 422 | Unprocessable Entity | Data validation failed |
| 429 | Too Many Requests | Rate limit exceeded |
| 500 | Internal Server Error | Server error |

---

## Error Codes & Messages

### 404 Not Found
```json
{
  "error": "Product not found",
  "code": "PRODUCT_NOT_FOUND",
  "productId": "INVALID-SKU"
}
```

### 400 Bad Request
```json
{
  "error": "Invalid format parameter",
  "code": "INVALID_FORMAT",
  "validFormats": ["json", "xml", "pdf"]
}
```

### 422 Unprocessable Entity
```json
{
  "error": "Validation failed",
  "code": "VALIDATION_ERROR",
  "details": {
    "materials": ["At least one material is required"],
    "carbonFootprint": ["CO2 value must be positive"]
  }
}
```

### 429 Too Many Requests
```json
{
  "error": "Rate limit exceeded",
  "code": "RATE_LIMIT_EXCEEDED",
  "retryAfter": 60
}
```

---

## Usage Examples

### cURL

**Get single product:**
```bash
curl -X GET \
  'http://localhost:8080/api/dpp/SKU-ORGANIC-TEE-001/export' \
  -H 'Accept: application/json'
```

**Batch export:**
```bash
curl -X POST \
  'http://localhost:8080/api/dpp/batch/export' \
  -H 'Content-Type: application/json' \
  -d '{
    "productIds": ["SKU-ORGANIC-TEE-001", "SKU-RECYCLED-JEANS-001"]
  }'
```

### JavaScript/Node.js

**Fetch single product:**
```javascript
fetch('http://localhost:8080/api/dpp/SKU-ORGANIC-TEE-001/export')
  .then(res => res.json())
  .then(data => console.log(data))
  .catch(err => console.error(err));
```

**Batch export:**
```javascript
const productIds = ['SKU-ORGANIC-TEE-001', 'SKU-RECYCLED-JEANS-001'];

fetch('http://localhost:8080/api/dpp/batch/export', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ productIds })
})
  .then(res => res.json())
  .then(data => console.log(data))
  .catch(err => console.error(err));
```

### Python

```python
import requests
import json

# Single product
response = requests.get(
    'http://localhost:8080/api/dpp/SKU-ORGANIC-TEE-001/export'
)
product = response.json()
print(json.dumps(product, indent=2))

# Batch export
data = {
    'productIds': [
        'SKU-ORGANIC-TEE-001',
        'SKU-RECYCLED-JEANS-001'
    ]
}
response = requests.post(
    'http://localhost:8080/api/dpp/batch/export',
    json=data
)
products = response.json()
print(json.dumps(products, indent=2))
```

---

## Rate Limiting

Currently: **No rate limiting** (development mode)

For production:
- Limit: 100 requests per minute per IP
- Batch limit: 10 products per request
- Response: HTTP 429 with `Retry-After` header

---

## Caching

- Responses cached for 1 hour (3600 seconds)
- Cache key: `dpp:{productId}:{language}`
- Headers: `Cache-Control: public, max-age=3600`

---

## Authentication (Future)

Currently: **No authentication required**

Planned for production:
- API Key authentication
- OAuth2
- JWT tokens

---

## Versioning

Current API Version: **1.0**

URL: `/api/dpp/v1/{endpoint}`

---

## Support

For API issues:
1. Check error response for details
2. Validate request format against JSON Schema
3. Check server logs: `docker-compose logs app`

