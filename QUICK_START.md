# Quick Start - DPP Fashion API

## 30 Seconds to Working API

```bash
# 1. Start the container
docker-compose up -d

# 2. Test the API
curl http://localhost:8080/index.php?path=/api/dpp/products
```

**That's it!** The API is running at `http://localhost:8080`

## Test All Endpoints

### List Products
```bash
curl http://localhost:8080/index.php?path=/api/dpp/products
```

### Get One Product (Full DPP Data)
```bash
curl http://localhost:8080/index.php?path=/api/dpp/1/export
```

### Batch Export
```bash
curl -X POST http://localhost:8080/index.php?path=/api/dpp/batch/export \
  -H "Content-Type: application/json" \
  -d '{"productIds": [1,2,3]}'
```

## Available Products

| ID | Name | Price |
|----|------|-------|
| 1 | Organic Cotton T-Shirt | €49.99 |
| 2 | Recycled Denim Jeans | €89.99 |
| 3 | Merino Wool Jacket | €199.99 |

## What's in the Response?

Each product export includes:
- **Product Info**: Name, SKU, size, color, manufacturer
- **Materials**: Composition percentages, origin, certifications
- **Sustainability**: Carbon footprint, water usage, certifications
- **Durability**: Expected lifespan, care instructions
- **End-of-Life**: Recyclability, take-back schemes

## Stop the API

```bash
docker-compose down
```

---

See `README.md` for full documentation.
