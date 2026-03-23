<?php
/**
 * DPP Export API Controller
 * REST API endpoints for Digital Product Passport data
 */

namespace App\Controller\Api;

use App\Model\DataObject\DppFashionProduct;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DppExportController
 * 
 * @Route("/api/dpp")
 */
class DppExportController
{
    /**
     * Export DPP data as JSON
     * 
     * @Route("/{productId}/export", methods={"GET"})
     * @param string $productId - Product ID or SKU
     * @return JsonResponse
     */
    public function exportDpp(string $productId): JsonResponse
    {
        try {
            // In a real implementation, fetch from database
            $product = $this->getProductData($productId);
            
            if (!$product) {
                return new JsonResponse(
                    ['error' => 'Product not found'],
                    Response::HTTP_NOT_FOUND
                );
            }

            $dppData = $this->buildDppJson($product);
            
            return new JsonResponse($dppData, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Batch export multiple products
     * 
     * @Route("/batch/export", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function batchExport(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $productIds = $data['productIds'] ?? [];

        $results = [];
        foreach ($productIds as $productId) {
            $product = $this->getProductData($productId);
            if ($product) {
                $results[] = $this->buildDppJson($product);
            }
        }

        return new JsonResponse([
            'count' => count($results),
            'products' => $results
        ]);
    }

    /**
     * Get product data (mock implementation)
     * In real app: fetch from database/Pimcore
     */
    private function getProductData(string $productId): ?array
    {
        // Mock data - in real implementation, query database
        $mockProducts = [
            'SKU-ORGANIC-TEE-001' => [
                'productId' => 'SKU-ORGANIC-TEE-001',
                'productName' => 'Organic Cotton T-Shirt',
                'sku' => 'SKU-ORGANIC-TEE-001',
                'category' => 'T-Shirts',
                'description' => 'Premium organic cotton t-shirt made from certified sustainable cotton',
                'manufacturerName' => 'EcoFashion Ltd',
                'manufacturerCountry' => 'DE',
            ],
            'SKU-RECYCLED-JEANS-001' => [
                'productId' => 'SKU-RECYCLED-JEANS-001',
                'productName' => 'Recycled Denim Jeans',
                'sku' => 'SKU-RECYCLED-JEANS-001',
                'category' => 'Jeans',
                'description' => '100% recycled denim with sustainable production',
                'manufacturerName' => 'SustainableDenim Co',
                'manufacturerCountry' => 'IT',
            ]
        ];

        return $mockProducts[$productId] ?? null;
    }

    /**
     * Build DPP JSON structure according to EU standards
     */
    private function buildDppJson(array $product): array
    {
        return [
            'dpp' => [
                'version' => '1.0',
                'standard' => 'EU-DPP-2023',
                'timestamp' => (new \DateTime())->format('c'),
            ],
            'product' => [
                'identification' => [
                    'productId' => $product['productId'],
                    'sku' => $product['sku'],
                    'productName' => $product['productName'],
                    'category' => $product['category'],
                    'description' => $product['description'],
                ],
                'manufacturer' => [
                    'name' => $product['manufacturerName'],
                    'country' => $product['manufacturerCountry'],
                ],
            ],
            'sustainability' => [
                'materials' => $this->getMaterialsData($product['productId']),
                'carbonFootprint' => [
                    'total_kg_co2' => 2.5,
                    'scope' => ['production', 'transportation'],
                    'methodology' => 'ISO 14040',
                ],
                'waterConsumption' => [
                    'total_liters' => 2500,
                    'scope' => ['cultivation', 'processing'],
                ],
                'chemicalUsage' => [
                    'dyes' => ['Reactive Red 195', 'Acid Yellow 25'],
                    'finishing' => ['Formaldehyde-free finishing'],
                ],
            ],
            'durability' => [
                'estimatedLifespanMonths' => 24,
                'repairability' => [
                    'score' => 8,
                    'repairGuideUrl' => 'https://example.com/repair/SKU-001',
                    'replacementPartsAvailable' => true,
                ],
            ],
            'endOfLife' => [
                'recyclable' => true,
                'recyclabilityScore' => 85,
                'recyclingInstructions' => 'Separate fasteners and return to certified recycling center',
                'recyclingProgram' => 'EcoFashion Take-Back Program',
            ],
            'compliance' => [
                'certifications' => [
                    'GOTS - Global Organic Textile Standard',
                    'Fair Trade Certified',
                    'OEKO-TEX Standard 100',
                ],
                'standards' => [
                    'ISO 14062:2002 - Environmental management in product design',
                    'EU 2014/30/EU - EMC Directive',
                ],
                'regulatoryStatus' => 'Compliant',
            ],
            'supplyChain' => [
                'origin' => [
                    'country' => 'INDIA',
                    'facility' => 'GreenTex Mills, Tamil Nadu',
                ],
                'steps' => [
                    [
                        'stage' => 'Raw Material Cultivation',
                        'location' => 'INDIA',
                        'certifications' => ['GOTS'],
                    ],
                    [
                        'stage' => 'Spinning & Weaving',
                        'location' => 'INDIA',
                        'certifications' => ['OEKO-TEX'],
                    ],
                    [
                        'stage' => 'Dyeing & Finishing',
                        'location' => 'ITALY',
                        'certifications' => ['OEKO-TEX', 'ZDHC'],
                    ],
                    [
                        'stage' => 'Manufacturing',
                        'location' => 'VIETNAM',
                        'certifications' => ['Fair Trade', 'SA8000'],
                    ],
                ],
            ],
            'metadata' => [
                'dppCreatedAt' => (new \DateTime())->format('c'),
                'lastUpdatedAt' => (new \DateTime())->format('c'),
                'version' => '1.0',
                'language' => 'en',
            ],
        ];
    }

    /**
     * Get materials data for a product
     */
    private function getMaterialsData(string $productId): array
    {
        if ($productId === 'SKU-ORGANIC-TEE-001') {
            return [
                [
                    'materialName' => 'Organic Cotton',
                    'materialType' => 'Natural Fiber',
                    'percentage' => 100,
                    'originCountry' => 'INDIA',
                    'certification' => 'GOTS',
                    'sourceType' => 'Organic',
                    'co2_per_kg' => 1.2,
                    'waterConsumption_liters_per_kg' => 1800,
                    'chemicalTreatment' => 'None',
                ],
            ];
        }

        if ($productId === 'SKU-RECYCLED-JEANS-001') {
            return [
                [
                    'materialName' => 'Recycled Denim',
                    'materialType' => 'Synthetic Blend',
                    'percentage' => 85,
                    'originCountry' => 'NETHERLANDS',
                    'certification' => 'Global Recycled Standard',
                    'sourceType' => 'Recycled',
                    'co2_per_kg' => 0.8,
                    'waterConsumption_liters_per_kg' => 50,
                    'chemicalTreatment' => 'Low-impact dyes',
                ],
                [
                    'materialName' => 'Virgin Cotton',
                    'materialType' => 'Natural Fiber',
                    'percentage' => 15,
                    'originCountry' => 'PAKISTAN',
                    'certification' => 'OEKO-TEX',
                    'sourceType' => 'Conventional',
                    'co2_per_kg' => 1.5,
                    'waterConsumption_liters_per_kg' => 2700,
                    'chemicalTreatment' => 'Standard processing',
                ],
            ];
        }

        return [];
    }
}
