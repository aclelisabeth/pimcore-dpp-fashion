# DPP Data Model Documentation

## Overview

The DPP (Digital Product Passport) data model for fashion and textiles is structured to capture all relevant information about a product's environmental and social impact throughout its lifecycle.

## Main Classes

### 1. DppFashionProduct (Core Product Class)

Main product entity representing a complete fashion item with all DPP information.

**Location:** `src/Model/DataObject/DppFashionProduct.php`

#### Basic Identification
```php
- productId: string          // Unique product identifier
- productName: string        // Product name
- sku: string               // Stock Keeping Unit
- category: string          // Product category (T-Shirts, Jeans, etc.)
- description: string       // Product description
- productImageUrl: string   // Image URL
```

#### Manufacturer Information
```php
- manufacturerName: string        // Company name
- manufacturerCountry: string     // ISO country code
```

#### Materials Composition
```php
- materials: array<DppMaterial>   // Array of material objects with percentages and properties
```

#### Sustainability Metrics
```php
- totalCo2FootprintKg: float              // Total CO2 emissions in kg
- totalWaterConsumptionL: float           // Total water in liters
- chemicalLoadScore: float                // 0-100 score of chemical impact
```

#### Durability & Repairability
```php
- estimatedLifespanMonths: int            // Expected product lifetime
- repairGuideUrl: string                  // Link to repair instructions
- partsReplaceable: boolean               // Can parts be replaced?
- replacementParts: array<string>         // List of available replacement parts
```

#### Certifications & Standards
```php
- certifications: array<string>           // List of certifications (GOTS, OEKO-TEX, etc.)
```

#### Supply Chain
```php
- supplyChainSteps: array<SupplyChainStep>  // Production steps with locations
```

#### End-of-Life
```php
- recyclingInstructions: string           // How to recycle/dispose
- recyclable: boolean                     // Is product recyclable?
- recyclingProgram: string                // Take-back program name
```

#### Compliance
```php
- standards: array<string>                // List of standards (ISO, EU directives)
- chemicals: array<string>                // Chemicals used in production
```

#### Metadata
```php
- productionDate: DateTime                // When was it produced?
- createdAt: DateTime                     // When was DPP created?
- updatedAt: DateTime                     // Last update timestamp
```

---

### 2. DppMaterial (Material Composition Class)

Represents individual materials in a product with detailed environmental impact data.

**Location:** `src/Model/DataObject/DppMaterial.php`

#### Material Properties
```php
- materialName: string           // e.g., "Organic Cotton", "Recycled Polyester"
- materialType: string           // Natural, Synthetic, Regenerated, Bio-based
- percentage: float              // Percentage in final product (0-100)
```

#### Origin & Sourcing
```php
- originCountry: string          // ISO country code
- sourceType: string             // Organic, Conventional, Recycled, Bio-based
- certification: string          // e.g., "GOTS", "GRS", "OEKO-TEX"
```

#### Environmental Impact
```php
- co2PerKg: float               // CO2 emissions per kg of material
- waterConsumption: float        // Liters of water per kg of material
```

#### Processing
```php
- chemicalTreatment: string     // e.g., "Low-impact dyes", "Formaldehyde-free"
```

---

## Data Structures (JSON Format)

### Product Object
```json
{
  "productId": "SKU-ORGANIC-TEE-001",
  "productName": "Organic Cotton T-Shirt",
  "sku": "SKU-ORGANIC-TEE-001",
  "category": "T-Shirts",
  "description": "Premium organic cotton t-shirt",
  "manufacturerName": "EcoFashion Ltd",
  "manufacturerCountry": "DE"
}
```

### Material Object
```json
{
  "materialName": "Organic Cotton",
  "materialType": "Natural Fiber",
  "percentage": 100,
  "originCountry": "INDIA",
  "certification": "GOTS",
  "sourceType": "Organic",
  "co2PerKg": 1.2,
  "waterConsumption": 1800,
  "chemicalTreatment": "None"
}
```

### Sustainability Object
```json
{
  "totalCo2FootprintKg": 2.5,
  "totalWaterConsumptionL": 2500,
  "chemicalLoadScore": 15
}
```

### Durability Object
```json
{
  "estimatedLifespanMonths": 24,
  "repairGuideUrl": "https://example.com/repair/SKU-001",
  "partsReplaceable": true,
  "replacementParts": [
    "Zipper",
    "Button",
    "Hem tape"
  ]
}
```

### SupplyChain Object
```json
{
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
    }
  ]
}
```

---

## Data Relationships

```
DppFashionProduct
├── materials (0..*)
│   └── DppMaterial
├── certifications (0..*)
├── supplyChainSteps (0..*)
├── standards (0..*)
└── chemicals (0..*)
```

---

## Enumerations

### Material Types
- `Natural Fiber` - Cotton, wool, linen, silk
- `Synthetic` - Polyester, nylon, acrylic, spandex
- `Regenerated` - Viscose, modal, lyocell
- `Bio-based` - Polylactic acid (PLA), polyhydroxyalkanoates (PHA)

### Source Types
- `Organic` - Certified organic farming
- `Conventional` - Standard agricultural practices
- `Recycled` - Post-consumer or post-industrial waste
- `Bio-based` - From renewable plant sources

### Product Categories
- `T-Shirts`
- `Jeans`
- `Dresses`
- `Jackets`
- `Shoes`
- `Accessories`

---

## Common Certifications

### Environmental
- **GOTS** - Global Organic Textile Standard
- **OEKO-TEX** - Standard 100 / STeP
- **GRS** - Global Recycled Standard
- **ZDHC** - Zero Discharge of Hazardous Chemicals
- **Fair Trade Certified**
- **RWS** - Responsible Wool Standard

### Social
- **SA8000** - Social Accountability Standard
- **Fair Trade Certified**
- **B Corp Certified**

### Environmental Management
- **ISO 14001** - Environmental management systems
- **ISO 14040** - Life cycle assessment (LCA)
- **ISO 14062** - Environmental management in product design

---

## Standards & Regulations

### EU Standards
- **EU 2014/30/EU** - EMC Directive
- **EU 2015/863/EU** - RoHS Directive
- **EU 2011/65/EU** - Restriction of Hazardous Substances

### ISO Standards
- **ISO 14040/44** - Life Cycle Assessment
- **ISO 14062** - Environmental Management in Product Design
- **ISO 14064** - Greenhouse Gases

### Industry Specific
- **ISO 3448** - Textile fibers
- **ISO 105** - Color fastness testing

---

## Environmental Impact Metrics

### Carbon Footprint (kg CO2 equivalent)
Typical values for fashion:
- Organic cotton (per kg): 1.0-1.5 kg CO2
- Conventional cotton (per kg): 1.8-2.2 kg CO2
- Polyester (per kg): 2.5-3.5 kg CO2
- Recycled polyester (per kg): 0.5-1.0 kg CO2

**Full garment examples:**
- T-shirt (200g): 2.0-2.5 kg CO2
- Jeans (600g): 5-8 kg CO2
- Jacket (1kg): 8-15 kg CO2

### Water Consumption (liters per kg)
- Cotton (conventional): 2,500-2,700 L/kg
- Cotton (organic): 1,000-1,800 L/kg
- Polyester: 50-100 L/kg
- Wool: 700-1,200 L/kg

### Chemical Load Score (0-100)
- **0-25:** Low impact (minimal chemical use)
- **25-50:** Moderate impact (standard dyeing)
- **50-75:** High impact (multiple chemical treatments)
- **75-100:** Very high impact (intensive processing)

---

## Lifespan & Durability

### Estimated Lifespan by Category
- **T-Shirts:** 18-24 months (50-100 washes)
- **Jeans:** 36-60 months (100-200 washes)
- **Jackets:** 36-72 months (30-50 washes)
- **Shoes:** 12-24 months (100-300 km wear)

### Repairability Score (0-10)
- **8-10:** Highly repairable (quality construction, available parts)
- **6-8:** Moderately repairable (some parts replaceable)
- **4-6:** Limited repairability (basic seams only)
- **0-4:** Difficult to repair (proprietary components)

---

## Recyclability Score (0-100)

### Calculation Factors
- Material homogeneity (can it be recycled as one material?)
- Component separability (easy to disassemble?)
- Market demand (is recycled material wanted?)
- Infrastructure availability (are facilities available?)

### Score Breakdown
- **85-100:** Excellent (100% recyclable with standard processes)
- **70-85:** Good (>80% recyclable, minor processing)
- **50-70:** Fair (50-80% recyclable, some losses)
- **0-50:** Poor (significant material waste in recycling)

---

## Data Quality Requirements

### Mandatory Fields
- Product ID & SKU
- Product Name
- Manufacturer
- Materials (at least one)
- Certifications (at least one)
- Supply chain origin

### Recommended Fields
- Material percentages (sum to 100%)
- CO2 & water metrics
- Durability information
- Repair guide
- Certifications with links

### Optional Fields
- Exact chemical list
- Detailed supply chain steps
- Alternative materials
- Product images
- Batch/lot number

---

## Data Validation Rules

```php
// Material validation
- percentage >= 0 AND <= 100
- All materials percentage sum = 100%
- co2PerKg >= 0
- waterConsumption >= 0

// Durability validation
- estimatedLifespanMonths > 0
- repairabilityScore >= 0 AND <= 10
- recyclabilityScore >= 0 AND <= 100

// Sustainability validation
- totalCo2FootprintKg >= 0
- totalWaterConsumptionL >= 0
- chemicalLoadScore >= 0 AND <= 100

// Product validation
- productId not empty and unique
- sku not empty and unique
- manufacturerCountry valid ISO-3166-1 alpha-2
```

---

## Extending the Data Model

### Adding New Certifications
1. Add to `certifications` array in `DppFashionProduct`
2. Update validation rules
3. Add to API response

### Adding New Metrics
1. Add property to `DppFashionProduct` class
2. Update getter/setter methods
3. Add to JSON export in API controller
4. Update JSON Schema

### Adding New Supply Chain Steps
```php
$supplyChainStep = [
    'stage' => 'New Stage Name',
    'location' => 'COUNTRY-CODE',
    'certifications' => ['Cert1', 'Cert2'],
    'duration' => 'Days/weeks',
    'distance' => 'km if transportation'
];
```

---

## Version History

### v1.0 (Current)
- Initial DPP model for fashion/textiles
- EU DPP 2023 compliance
- Basic CRUD operations
- REST API export

### Future (v1.1)
- GraphQL API
- Advanced analytics
- Batch operations
- Multi-language support

---

## References

- [Global Organic Textile Standard (GOTS)](https://www.global-standard.org/)
- [OEKO-TEX Standards](https://www.oeko-tex.com/)
- [Global Recycled Standard (GRS)](https://www.globalrecycledstandard.org/)
- [ZDHC Gateway](https://www.zdhcgateway.com/)
- [EU Digital Product Passport](https://ec.europa.eu/growth/tools-databases/epr/)
- [ISO 14040/44 - Life Cycle Assessment](https://www.iso.org/standards/collection/std_iso_14040_14040.html)

