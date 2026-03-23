<?php
/**
 * DPP Textile Material Class
 */

namespace App\Model\DataObject;

use Pimcore\Model\DataObject;

/**
 * Class DppMaterial
 * 
 * Represents textile materials and compositions
 * Used for storing detailed material information per garment
 */
class DppMaterial extends DataObject
{
    public const OBJECT_TYPE_VARIANT = 'variant';

    /**
     * @var string|null
     */
    private ?string $materialName = null;

    /**
     * @var string|null - e.g., "Cotton", "Polyester", "Wool"
     */
    private ?string $materialType = null;

    /**
     * @var float - Percentage in product (0-100)
     */
    private float $percentage = 0;

    /**
     * @var string|null - ISO country code of origin
     */
    private ?string $originCountry = null;

    /**
     * @var string|null - GST1 Certification or other eco-labels
     */
    private ?string $certification = null;

    /**
     * @var string|null - Recycled/Virgin/Bio-based
     */
    private ?string $sourceType = null;

    /**
     * @var float - CO2 kg per kg of material
     */
    private float $co2PerKg = 0;

    /**
     * @var float - Water consumption in liters per kg
     */
    private float $waterConsumption = 0;

    /**
     * @var string|null - Chemical treatment used
     */
    private ?string $chemicalTreatment = null;

    public function getMaterialName(): ?string
    {
        return $this->materialName;
    }

    public function setMaterialName(?string $materialName): void
    {
        $this->materialName = $materialName;
    }

    public function getMaterialType(): ?string
    {
        return $this->materialType;
    }

    public function setMaterialType(?string $materialType): void
    {
        $this->materialType = $materialType;
    }

    public function getPercentage(): float
    {
        return $this->percentage;
    }

    public function setPercentage(float $percentage): void
    {
        $this->percentage = $percentage;
    }

    public function getOriginCountry(): ?string
    {
        return $this->originCountry;
    }

    public function setOriginCountry(?string $originCountry): void
    {
        $this->originCountry = $originCountry;
    }

    public function getCertification(): ?string
    {
        return $this->certification;
    }

    public function setCertification(?string $certification): void
    {
        $this->certification = $certification;
    }

    public function getSourceType(): ?string
    {
        return $this->sourceType;
    }

    public function setSourceType(?string $sourceType): void
    {
        $this->sourceType = $sourceType;
    }

    public function getCo2PerKg(): float
    {
        return $this->co2PerKg;
    }

    public function setCo2PerKg(float $co2PerKg): void
    {
        $this->co2PerKg = $co2PerKg;
    }

    public function getWaterConsumption(): float
    {
        return $this->waterConsumption;
    }

    public function setWaterConsumption(float $waterConsumption): void
    {
        $this->waterConsumption = $waterConsumption;
    }

    public function getChemicalTreatment(): ?string
    {
        return $this->chemicalTreatment;
    }

    public function setChemicalTreatment(?string $chemicalTreatment): void
    {
        $this->chemicalTreatment = $chemicalTreatment;
    }
}
