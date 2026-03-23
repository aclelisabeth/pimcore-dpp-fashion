# Pimcore 10 Digital Product Passport (DPP) - Fashion Edition

A complete proof-of-concept implementation of EU Digital Product Passport (DPP) for fashion and textile products using Pimcore 10.

## Overview

This project demonstrates:
- **DPP Data Model** for fashion/textiles (materials, sustainability metrics, supply chain, durability, end-of-life)
- **REST API** for exporting DPP data in standardized JSON format
- **Pimcore 10 Integration** with custom data classes and product management
- **Docker Setup** for quick local development
- **Demo Data** with 3 realistic fashion products (organic t-shirt, recycled jeans, wool jacket)

## Quick Start

### Prerequisites
- Docker & Docker Compose
- Git

### Installation

1. **Clone and navigate:**
```bash
git clone https://github.com/YOUR-USERNAME/pimcore-dpp-fashion.git
cd pimcore-dpp-fashion
```

2. **Start Docker containers:**
```bash
docker-compose up -d
```

3. **Run installation script:**
```bash
chmod +x install.sh
./install.sh
```

4. **Access Pimcore Admin:**
   - URL: `http://localhost:8080/admin`
   - Username: `admin`
   - Password: `admin123`

## Project Structure

```
pimcore-dpp-fashion/
├── docker-compose.yml              # Docker setup for Pimcore, MySQL, Redis
├── composer.json                   # PHP dependencies
├── install.sh                      # Installation script
├── .env.example                    # Environment configuration template
├── demo-data.json                  # Sample DPP products
├── src/
│   ├── Bundle/
│   │   └── DppFashionBundle/       # Pimcore bundle
│   ├── Model/
│   │   └── DataObject/
│   │       ├── DppFashionProduct.php  # Main product class
│   │       └── DppMaterial.php        # Material/composition class
│   ├── Controller/
│   │   └── Api/
│   │       └── DppExportController.php # REST API endpoints
│   └── Resources/
│       └── schemas/
│           └── dpp-fashion-schema.json # JSON Schema for DPP validation
└── docs/
    ├── API.md                      # API Documentation
    ├── DATA-MODEL.md               # Data model explanation
    └── EU-REGULATIONS.md           # EU DPP regulatory context
```

## API Endpoints

### Export Single Product
```bash
GET /api/dpp/{productId}/export
```

Example:
```bash
curl http://localhost:8080/api/dpp/SKU-ORGANIC-TEE-001/export
```

Response: JSON DPP data structure with all sustainability, durability, and compliance information

### Batch Export
```bash
POST /api/dpp/batch/export
Content-Type: application/json

{
  "productIds": [
    "SKU-ORGANIC-TEE-001",
    "SKU-RECYCLED-JEANS-001",
    "SKU-WOOL-JACKET-001"
  ]
}
```

## DPP Data Structure

The DPP JSON includes these main sections:

### 1. **Product Identification**
- Product ID, SKU, name, category
- Manufacturer info

### 2. **Materials & Composition**
- Material type, percentage, origin
- Certifications (GOTS, OEKO-TEX, etc.)
- Environmental impact per material (CO2, water)
- Chemical treatments

### 3. **Sustainability Metrics**
- Carbon footprint (kg CO2)
- Water consumption (liters)
- Chemical usage
- Biodiversity impact

### 4. **Durability & Repairability**
- Estimated lifespan
- Repairability score (0-10)
- Replacement parts availability
- Care instructions

### 5. **End-of-Life & Recyclability**
- Recyclability score
- Recycling instructions
- Take-back programs
- Material recovery options

### 6. **Compliance & Certifications**
- Certification list (GOTS, Fair Trade, etc.)
- Standards compliance (ISO 14040, OEKO-TEX, etc.)
- Regulatory status

### 7. **Supply Chain Transparency**
- Origin country and facility
- Production steps with locations
- Certifications per step
- Labor standards

## Demo Products

The project includes 3 realistic fashion products:

### 1. Organic Cotton T-Shirt
- **SKU:** SKU-ORGANIC-TEE-001
- **Materials:** 100% Organic Cotton
- **Certifications:** GOTS, OEKO-TEX, Fair Trade
- **Supply Chain:** India → Italy → Vietnam
- **CO2 Footprint:** 2.5 kg
- **Water:** 2,500 liters

### 2. Recycled Denim Jeans
- **SKU:** SKU-RECYCLED-JEANS-001
- **Materials:** 85% Recycled Denim + 15% Virgin Cotton
- **Certifications:** Global Recycled Standard, OEKO-TEX, ZDHC
- **Supply Chain:** Netherlands → Italy → Portugal
- **CO2 Footprint:** 3.2 kg
- **Water:** 1,200 liters

### 3. Sustainable Wool Jacket
- **SKU:** SKU-WOOL-JACKET-001
- **Materials:** 95% Merino Wool + 5% Nylon
- **Certifications:** Responsible Wool Standard, OEKO-TEX, Fair Trade
- **Supply Chain:** New Zealand → Australia → UK → Ireland → Sweden
- **CO2 Footprint:** 4.1 kg
- **Water:** 1,800 liters

## EU Regulations & Context

### Digital Product Passport Directive
The DPP is mandated by the **ESPR (Ecopolicy Sustainability Requirements)** and will apply to:
- **Phase 1:** Electronics (starting 2026)
- **Phase 2:** Textiles & Fashion (2027-2028)
- **Phase 3:** Other categories TBD

### Key Requirements
✅ **Transparency:** Consumers can access environmental & social data  
✅ **Traceability:** Full supply chain visibility  
✅ **Sustainability:** Durability, repairability, recyclability scores  
✅ **Compliance:** Certification tracking  

## Technical Details

### Pimcore Classes
- `DppFashionProduct` - Main product class
- `DppMaterial` - Material composition details
- Metadata classes for certifications, standards, supply chain steps

### API Responses
All APIs return standardized JSON with:
- DPP metadata (version, standard, timestamp)
- Product identification
- Complete sustainability data
- Compliance & certification status
- Supply chain information

### JSON Schema
Validate DPP responses against `src/Resources/schemas/dpp-fashion-schema.json`

## Development Workflow

### 1. Access Pimcore Admin
```
http://localhost:8080/admin
Username: admin
Password: admin123
```

### 2. Create New Products
1. Navigate to Products section
2. Create new "DPP Fashion Product"
3. Fill in all required DPP fields
4. Save and publish

### 3. Export DPP Data
Use the REST API to export data:
```bash
curl http://localhost:8080/api/dpp/YOUR-SKU/export | jq
```

### 4. Test with Demo Data
Demo data is automatically loaded during installation (3 example products)

## Customization

### Add New Certifications
Edit demo data or extend `DppFashionProduct` class:
```php
$product->setCertifications([
    'Your Custom Certification' => 'Link'
]);
```

### Add New Supply Chain Steps
Extend `supplyChain` in the API controller or data model

### Customize DPP Fields
Modify `DppFashionProduct.php` and regenerate Pimcore classes

## Testing

### Test API with curl
```bash
# Get single product
curl http://localhost:8080/api/dpp/SKU-ORGANIC-TEE-001/export

# Batch export
curl -X POST http://localhost:8080/api/dpp/batch/export \
  -H "Content-Type: application/json" \
  -d '{
    "productIds": [
      "SKU-ORGANIC-TEE-001",
      "SKU-RECYCLED-JEANS-001"
    ]
  }'
```

### Validate against JSON Schema
```bash
ajv validate -s src/Resources/schemas/dpp-fashion-schema.json -d exported-dpp.json
```

## Troubleshooting

### Container Issues
```bash
# View logs
docker-compose logs -f app

# Restart containers
docker-compose restart

# Full reset
docker-compose down -v
docker-compose up -d
```

### Database Issues
```bash
# Recreate database
docker-compose exec app bin/console pimcore:setup:db
```

### Permission Issues
```bash
# Fix file permissions
docker-compose exec app chmod -R 755 var/
```

## Files & Configuration

### Key Files
- `docker-compose.yml` - Full Docker stack
- `src/Controller/Api/DppExportController.php` - Main API logic
- `src/Resources/schemas/dpp-fashion-schema.json` - DPP validation schema
- `demo-data.json` - Sample products

### Environment Variables
See `.env.example` for complete list

## Performance Considerations

- **Redis caching** configured for fast product lookups
- **API responses** optimized for large datasets
- **Database indexes** on product SKU and ID
- Supports batch operations for bulk exports

## Security

⚠️ **Development Only!** This is a demo project. For production:
- [ ] Implement proper authentication (OAuth2, JWT)
- [ ] Add request rate limiting
- [ ] Use HTTPS only
- [ ] Validate/sanitize all inputs
- [ ] Implement proper error handling
- [ ] Add audit logging
- [ ] Use environment-based secrets

## Future Enhancements

- [ ] QR code generation for DPP linking
- [ ] PDF export functionality
- [ ] Integration with EU DPP Registry
- [ ] Multi-language support
- [ ] Advanced analytics dashboard
- [ ] Supply chain verification tools
- [ ] Automated certificate validation
- [ ] GraphQL API

## License

MIT License - See LICENSE file

## Contributing

Contributions welcome! Please:
1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## Contact

For questions or issues:
- Create a GitHub Issue
- Contact: info@example.com

## References

- [EU Digital Product Passport](https://ec.europa.eu/growth/tools-databases/epr/)
- [ESPR Regulation](https://ec.europa.eu/environment/epr/)
- [Pimcore Documentation](https://pimcore.com/docs/pimcore/current/)
- [GOTS Standard](https://www.global-standard.org/)
- [OEKO-TEX](https://www.oeko-tex.com/)
- [Global Recycled Standard](https://www.globalrecycledstandard.org/)

---

**Built with ❤️ for sustainable fashion & transparency**
