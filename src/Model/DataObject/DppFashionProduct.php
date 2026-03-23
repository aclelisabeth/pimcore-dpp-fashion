<?php
/**
 * DPP Fashion Product Class
 * Main product class for Fashion/Textiles with DPP data
 */

namespace App\Model\DataObject;

/**
 * Class DppFashionProduct
 * 
 * Main product class for fashion items with complete DPP information
 */
class DppFashionProduct
{
    private ?string $productId = null;
    private ?string $productName = null;
    private ?string $sku = null;
    private ?string $category = null;
    
    // Basic Info
    private ?string $description = null;
    private ?string $productImageUrl = null;
    private ?string $manufacturerName = null;
    private ?string $manufacturerCountry = null;
    
    // Material Information
    private array $materials = [];
    
    // Sustainability Metrics
    private float $totalCo2FootprintKg = 0;
    private float $totalWaterConsumptionL = 0;
    private float $chemicalLoadScore = 0; // 0-100
    
    // Durability & Repairability
    private int $estimatedLifespanMonths = 24;
    private ?string $repairGuideUrl = null;
    private bool $partsReplaceable = false;
    private array $replacementParts = [];
    
    // Supply Chain & Certifications
    private array $certifications = [];
    private array $supplyChainSteps = [];
    
    // End of Life & Recyclability
    private ?string $recyclingInstructions = null;
    private bool $recyclable = false;
    private ?string $recyclingProgram = null;
    
    // Compliance & Standards
    private array $standards = [];
    private array $chemicals = [];
    
    // Metadata
    private ?\DateTime $productionDate = null;
    private ?\DateTime $createdAt = null;
    private ?\DateTime $updatedAt = null;

    // Getters and Setters
    public function getProductId(): ?string { return $this->productId; }
    public function setProductId(?string $productId): void { $this->productId = $productId; }

    public function getProductName(): ?string { return $this->productName; }
    public function setProductName(?string $productName): void { $this->productName = $productName; }

    public function getSku(): ?string { return $this->sku; }
    public function setSku(?string $sku): void { $this->sku = $sku; }

    public function getCategory(): ?string { return $this->category; }
    public function setCategory(?string $category): void { $this->category = $category; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): void { $this->description = $description; }

    public function getProductImageUrl(): ?string { return $this->productImageUrl; }
    public function setProductImageUrl(?string $productImageUrl): void { $this->productImageUrl = $productImageUrl; }

    public function getManufacturerName(): ?string { return $this->manufacturerName; }
    public function setManufacturerName(?string $manufacturerName): void { $this->manufacturerName = $manufacturerName; }

    public function getManufacturerCountry(): ?string { return $this->manufacturerCountry; }
    public function setManufacturerCountry(?string $manufacturerCountry): void { $this->manufacturerCountry = $manufacturerCountry; }

    public function getMaterials(): array { return $this->materials; }
    public function setMaterials(array $materials): void { $this->materials = $materials; }

    public function getTotalCo2FootprintKg(): float { return $this->totalCo2FootprintKg; }
    public function setTotalCo2FootprintKg(float $co2): void { $this->totalCo2FootprintKg = $co2; }

    public function getTotalWaterConsumptionL(): float { return $this->totalWaterConsumptionL; }
    public function setTotalWaterConsumptionL(float $water): void { $this->totalWaterConsumptionL = $water; }

    public function getChemicalLoadScore(): float { return $this->chemicalLoadScore; }
    public function setChemicalLoadScore(float $score): void { $this->chemicalLoadScore = $score; }

    public function getEstimatedLifespanMonths(): int { return $this->estimatedLifespanMonths; }
    public function setEstimatedLifespanMonths(int $months): void { $this->estimatedLifespanMonths = $months; }

    public function getRepairGuideUrl(): ?string { return $this->repairGuideUrl; }
    public function setRepairGuideUrl(?string $url): void { $this->repairGuideUrl = $url; }

    public function isPartsReplaceable(): bool { return $this->partsReplaceable; }
    public function setPartsReplaceable(bool $replaceable): void { $this->partsReplaceable = $replaceable; }

    public function getReplacementParts(): array { return $this->replacementParts; }
    public function setReplacementParts(array $parts): void { $this->replacementParts = $parts; }

    public function getCertifications(): array { return $this->certifications; }
    public function setCertifications(array $certifications): void { $this->certifications = $certifications; }

    public function getSupplyChainSteps(): array { return $this->supplyChainSteps; }
    public function setSupplyChainSteps(array $steps): void { $this->supplyChainSteps = $steps; }

    public function getRecyclingInstructions(): ?string { return $this->recyclingInstructions; }
    public function setRecyclingInstructions(?string $instructions): void { $this->recyclingInstructions = $instructions; }

    public function isRecyclable(): bool { return $this->recyclable; }
    public function setRecyclable(bool $recyclable): void { $this->recyclable = $recyclable; }

    public function getRecyclingProgram(): ?string { return $this->recyclingProgram; }
    public function setRecyclingProgram(?string $program): void { $this->recyclingProgram = $program; }

    public function getStandards(): array { return $this->standards; }
    public function setStandards(array $standards): void { $this->standards = $standards; }

    public function getChemicals(): array { return $this->chemicals; }
    public function setChemicals(array $chemicals): void { $this->chemicals = $chemicals; }

    public function getProductionDate(): ?\DateTime { return $this->productionDate; }
    public function setProductionDate(?\DateTime $date): void { $this->productionDate = $date; }

    public function getCreatedAt(): ?\DateTime { return $this->createdAt; }
    public function setCreatedAt(?\DateTime $date): void { $this->createdAt = $date; }

    public function getUpdatedAt(): ?\DateTime { return $this->updatedAt; }
    public function setUpdatedAt(?\DateTime $date): void { $this->updatedAt = $date; }
}
