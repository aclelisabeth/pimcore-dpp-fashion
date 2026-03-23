<?php
/**
 * DPP Products - Data structure for Digital Product Passport
 */

class DppProduct {
    public $id;
    public $name;
    public $category;
    public $sku;
    public $dpp_data;
    
    public function __construct($id, $name, $category, $sku, $dpp_data = []) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->sku = $sku;
        $this->dpp_data = $dpp_data;
    }
    
    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'sku' => $this->sku,
            'dpp_data' => $this->dpp_data
        ];
    }
}

class DppMaterial {
    public $name;
    public $percentage;
    public $origin;
    public $certification;
    public $hazardous_substances;
    
    public function __construct($name, $percentage, $origin, $certification, $hazardous = false) {
        $this->name = $name;
        $this->percentage = $percentage;
        $this->origin = $origin;
        $this->certification = $certification;
        $this->hazardous_substances = $hazardous;
    }
    
    public function toArray() {
        return [
            'name' => $this->name,
            'percentage' => $this->percentage,
            'origin' => $this->origin,
            'certification' => $this->certification,
            'hazardous_substances' => $this->hazardous_substances
        ];
    }
}
?>
