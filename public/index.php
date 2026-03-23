<?php
/**
 * Pimcore DPP Fashion - REST API
 * Digital Product Passport for Fashion/Textiles
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Load demo products
require_once __DIR__ . '/../src/DppProducts.php';

// Simple router
$request_uri = $_GET['path'] ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_method = $_SERVER['REQUEST_METHOD'];

// Remove /public from path if present
$request_uri = str_replace('/public', '', $request_uri);
$request_uri = str_replace('index.php', '', $request_uri);
$request_uri = '/' . ltrim($request_uri, '/');

// Route handling
if (preg_match('/^\/api\/dpp\/(\d+)\/export$/', $request_uri, $matches)) {
    // GET /api/dpp/{productId}/export
    $product_id = (int)$matches[1];
    
    if ($request_method === 'GET') {
        handleSingleExport($product_id);
    }
} elseif ($request_uri === '/api/dpp/batch/export' && $request_method === 'POST') {
    // POST /api/dpp/batch/export
    handleBatchExport();
} elseif ($request_uri === '/api/dpp/products' && $request_method === 'GET') {
    // GET /api/dpp/products - list all products
    handleProductsList();
} elseif ($request_uri === '/' || $request_uri === '') {
    // GET / - API info
    handleApiInfo();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
}

function handleApiInfo() {
    echo json_encode([
        'name' => 'Pimcore DPP Fashion API',
        'version' => '1.0.0',
        'description' => 'Digital Product Passport REST API for Fashion/Textiles',
        'endpoints' => [
            'GET /api/dpp/products' => 'List all products',
            'GET /api/dpp/{productId}/export' => 'Export single product DPP data',
            'POST /api/dpp/batch/export' => 'Batch export multiple products (body: {"productIds": [1, 2, 3]})',
        ],
        'demo_products' => [1, 2, 3]
    ]);
}

function handleProductsList() {
    $products = getProducts();
    $list = array_map(function($p) {
        return [
            'id' => $p['id'],
            'name' => $p['name'],
            'category' => $p['category']
        ];
    }, $products);
    
    echo json_encode([
        'status' => 'success',
        'count' => count($list),
        'products' => $list
    ]);
}

function handleSingleExport($product_id) {
    $products = getProducts();
    
    $product = null;
    foreach ($products as $p) {
        if ($p['id'] === $product_id) {
            $product = $p;
            break;
        }
    }
    
    if (!$product) {
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
        return;
    }
    
    echo json_encode([
        'status' => 'success',
        'data' => $product,
        'exported_at' => date('c'),
        'version' => '1.0.0'
    ]);
}

function handleBatchExport() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['productIds']) || !is_array($input['productIds'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request body. Expected: {"productIds": [1, 2, 3]}']);
        return;
    }
    
    $products = getProducts();
    $exported = [];
    
    foreach ($input['productIds'] as $id) {
        foreach ($products as $p) {
            if ($p['id'] === $id) {
                $exported[] = $p;
                break;
            }
        }
    }
    
    echo json_encode([
        'status' => 'success',
        'count' => count($exported),
        'data' => $exported,
        'exported_at' => date('c'),
        'version' => '1.0.0'
    ]);
}

function getProducts() {
    return [
        [
            'id' => 1,
            'name' => 'Organic Cotton T-Shirt',
            'category' => 'Apparel',
            'description' => 'Premium organic cotton t-shirt with sustainable production',
            'sku' => 'ORG-TSHIRT-001',
            'size' => 'M',
            'color' => 'Natural White',
            'price' => 49.99,
            'currency' => 'EUR',
            'manufacturer' => 'EcoFab Fashion',
            'origin_country' => 'DE',
            'production_date' => '2024-01-15',
            'dpp_data' => [
                'product_type' => 'Apparel - Shirts',
                'weight' => '0.18 kg',
                'dimensions' => '0.30m x 0.20m',
                'materials' => [
                    [
                        'name' => 'Organic Cotton',
                        'percentage' => 100,
                        'origin' => 'India',
                        'certification' => 'GOTS - Global Organic Textile Standard',
                        'hazardous_substances' => false
                    ]
                ],
                'sustainability' => [
                    'carbon_footprint' => '2.5 kg CO2e',
                    'water_usage' => '2,700 liters',
                    'waste' => 'Minimal - 3% factory waste recycled',
                    'certifications' => ['GOTS', 'Fair Trade Certified']
                ],
                'durability' => [
                    'expected_lifespan' => '3-5 years',
                    'care_instructions' => 'Machine wash 30°C, line dry',
                    'maintenance' => 'No bleach, cold water recommended'
                ],
                'end_of_life' => [
                    'recyclable' => true,
                    'biodegradable' => true,
                    'take_back_scheme' => 'Available through brand website',
                    'incineration_value' => 'High energy content'
                ]
            ]
        ],
        [
            'id' => 2,
            'name' => 'Recycled Denim Jeans',
            'category' => 'Apparel',
            'description' => 'Premium jeans made from 85% recycled materials',
            'sku' => 'REC-JEANS-002',
            'size' => '32',
            'color' => 'Deep Blue',
            'price' => 89.99,
            'currency' => 'EUR',
            'manufacturer' => 'SustainDenim Co',
            'origin_country' => 'PT',
            'production_date' => '2024-02-20',
            'dpp_data' => [
                'product_type' => 'Apparel - Trousers',
                'weight' => '0.68 kg',
                'dimensions' => '0.85m x 0.35m',
                'materials' => [
                    [
                        'name' => 'Recycled Cotton',
                        'percentage' => 85,
                        'origin' => 'EU Textile Waste',
                        'certification' => 'GRS - Global Recycled Standard',
                        'hazardous_substances' => false
                    ],
                    [
                        'name' => 'Elastane',
                        'percentage' => 15,
                        'origin' => 'Germany',
                        'certification' => 'Standard Grade',
                        'hazardous_substances' => false
                    ]
                ],
                'sustainability' => [
                    'carbon_footprint' => '4.2 kg CO2e',
                    'water_usage' => '1,200 liters (59% less than virgin cotton)',
                    'waste' => 'Zero waste to landfill',
                    'certifications' => ['GRS', 'EU Ecolabel']
                ],
                'durability' => [
                    'expected_lifespan' => '5-7 years',
                    'care_instructions' => 'Wash inside out, 40°C max, air dry',
                    'maintenance' => 'Dry clean not required'
                ],
                'end_of_life' => [
                    'recyclable' => true,
                    'biodegradable' => false,
                    'take_back_scheme' => 'Industry collection program',
                    'incineration_value' => 'High energy content'
                ]
            ]
        ],
        [
            'id' => 3,
            'name' => 'Merino Wool Jacket',
            'category' => 'Apparel',
            'description' => 'Fine merino wool jacket with sustainable herding practices',
            'sku' => 'WOOL-JACKET-003',
            'size' => 'L',
            'color' => 'Charcoal Grey',
            'price' => 199.99,
            'currency' => 'EUR',
            'manufacturer' => 'Alpine Textiles',
            'origin_country' => 'AT',
            'production_date' => '2024-03-10',
            'dpp_data' => [
                'product_type' => 'Apparel - Outerwear',
                'weight' => '0.95 kg',
                'dimensions' => '0.65m x 0.50m',
                'materials' => [
                    [
                        'name' => 'Merino Wool',
                        'percentage' => 100,
                        'origin' => 'New Zealand',
                        'certification' => 'Responsible Wool Standard',
                        'hazardous_substances' => false
                    ]
                ],
                'sustainability' => [
                    'carbon_footprint' => '3.8 kg CO2e',
                    'water_usage' => '0 liters (rainwater fed)',
                    'waste' => '100% biodegradable',
                    'certifications' => ['RWS - Responsible Wool Standard', 'Mulesing Free']
                ],
                'durability' => [
                    'expected_lifespan' => '10+ years',
                    'care_instructions' => 'Wool-specific wash, gentle cycle, lay flat to dry',
                    'maintenance' => 'Minimal - naturally odor resistant'
                ],
                'end_of_life' => [
                    'recyclable' => true,
                    'biodegradable' => true,
                    'take_back_scheme' => 'Manufacturer take-back program',
                    'incineration_value' => 'High energy content'
                ]
            ]
        ]
    ];
}
?>
