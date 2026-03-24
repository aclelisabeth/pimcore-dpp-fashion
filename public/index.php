<?php
/**
 * Pimcore DPP Fashion - REST API
 * Digital Product Passport for Fashion/Textiles
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Product storage file
$PRODUCTS_FILE = __DIR__ . '/../data/products.json';
$DATA_DIR = __DIR__ . '/../data';

// Ensure data directory exists
if (!is_dir($DATA_DIR)) {
    if (!mkdir($DATA_DIR, 0755, true)) {
         error_log('Failed to create data directory: ' . $DATA_DIR);
         http_response_code(500);
         die(json_encode(['error' => 'Failed to initialize data directory']));
    }
}

// Verify directory is writable
if (!is_writable($DATA_DIR)) {
     error_log('Data directory is not writable: ' . $DATA_DIR);
     http_response_code(500);
     die(json_encode(['error' => 'Data directory is not writable']));
}

// Initialize products file if it doesn't exist
if (!file_exists($PRODUCTS_FILE)) {
    initializeProductsFile();
}

// Load demo products class
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
    $product_id = (int)$matches[1];
    
    if ($request_method === 'GET') {
        handleSingleExport($product_id);
    }
} elseif (preg_match('/^\/api\/dpp\/(\d+)$/', $request_uri, $matches)) {
    $product_id = (int)$matches[1];
    
    if ($request_method === 'PUT') {
        // PUT /api/dpp/{id} - Update product
        handleUpdateProduct($product_id);
    }
} elseif ($request_uri === '/api/dpp/products' && $request_method === 'POST') {
    // POST /api/dpp/products - Create new product
    handleCreateProduct();
} elseif ($request_uri === '/api/dpp/products' && $request_method === 'GET') {
    // GET /api/dpp/products - list all products
    handleProductsList();
} elseif ($request_uri === '/api/dpp/batch/export' && $request_method === 'POST') {
    // POST /api/dpp/batch/export - batch export
    handleBatchExport();
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
            'GET /' => 'API info',
            'GET /api/dpp/products' => 'List all products',
            'POST /api/dpp/products' => 'Create new product',
            'GET /api/dpp/{productId}/export' => 'Export single product DPP data',
            'POST /api/dpp/batch/export' => 'Batch export multiple products',
        ],
        'demo_products' => [1, 2, 3]
    ]);
}

function handleProductsList() {
    global $PRODUCTS_FILE;
    
    $products = loadProducts();
    
    $list = array_map(function($p) {
        return [
            'id' => $p['id'],
            'name' => $p['name'],
            'category' => $p['category'],
            'sku' => $p['sku'] ?? null
        ];
    }, $products);
    
    echo json_encode([
        'status' => 'success',
        'count' => count($list),
        'products' => $list
    ]);
}

function handleCreateProduct() {
     global $PRODUCTS_FILE;
     
     $json_string = file_get_contents('php://input');
     $input = json_decode($json_string, true);
     
     // Validate JSON decode succeeded
     if ($input === null && !empty($json_string)) {
         http_response_code(400);
         echo json_encode(['error' => 'Invalid JSON: ' . json_last_error_msg()]);
         return;
     }
     
     // Validate required fields
     $required = ['name', 'category', 'sku', 'dpp_data'];
     foreach ($required as $field) {
         if (!isset($input[$field])) {
             http_response_code(400);
             echo json_encode(['error' => "Missing required field: $field"]);
             return;
         }
     }
    
    $products = loadProducts();
    
    // Generate new ID (max ID + 1)
    $max_id = 0;
    foreach ($products as $p) {
        if ($p['id'] > $max_id) {
            $max_id = $p['id'];
        }
    }
    
    $new_product = [
        'id' => $max_id + 1,
        'name' => $input['name'],
        'category' => $input['category'],
        'sku' => $input['sku'],
        'description' => $input['description'] ?? '',
        'manufacturer' => $input['manufacturer'] ?? '',
        'origin_country' => $input['origin_country'] ?? '',
        'production_date' => $input['production_date'] ?? date('Y-m-d'),
        'dpp_data' => $input['dpp_data'],
        'created_at' => date('c'),
        'updated_at' => date('c')
    ];
    
    // Add optional fields
    foreach (['size', 'color', 'price', 'currency'] as $field) {
        if (isset($input[$field])) {
            $new_product[$field] = $input[$field];
        }
    }
    
    // Add to products array
    $products[] = $new_product;
    
    // Save products
    if (file_put_contents($PRODUCTS_FILE, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))) {
        http_response_code(201);
        echo json_encode([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $new_product
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save product']);
    }
}

function handleUpdateProduct($product_id) {
     global $PRODUCTS_FILE;
     
     $json_string = file_get_contents('php://input');
     $input = json_decode($json_string, true);
     
     // Validate JSON decode succeeded
     if ($input === null && !empty($json_string)) {
         http_response_code(400);
         echo json_encode(['error' => 'Invalid JSON: ' . json_last_error_msg()]);
         return;
     }
     
     if (!$input) {
         http_response_code(400);
         echo json_encode(['error' => 'Invalid or empty request body']);
         return;
     }
    
    $products = loadProducts();
    $product_found = false;
    $updated_product = null;
    
    // Find and update product
    foreach ($products as &$p) {
        if ($p['id'] === $product_id) {
            $product_found = true;
            
            // Handle dpp_data specially (merge instead of replace)
            if (isset($input['dpp_data']) && is_array($input['dpp_data'])) {
                // Merge dpp_data instead of replacing it
                if (!isset($p['dpp_data'])) {
                    $p['dpp_data'] = [];
                }
                foreach ($input['dpp_data'] as $key => $value) {
                    $p['dpp_data'][$key] = $value;
                }
            }
            
            // Update other fields
            foreach ($input as $key => $value) {
                if ($key !== 'id' && $key !== 'created_at' && $key !== 'dpp_data') {
                    $p[$key] = $value;
                }
            }
            
            // Update the updated_at timestamp
            $p['updated_at'] = date('c');
            $updated_product = $p;
            
            break;
        }
    }
    
    if (!$product_found) {
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
        return;
    }
    
    // Save updated products
    if (file_put_contents($PRODUCTS_FILE, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))) {
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $updated_product
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update product']);
    }
}

function handleSingleExport($product_id) {
    $products = loadProducts();
    
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
     $json_string = file_get_contents('php://input');
     $input = json_decode($json_string, true);
     
     // Validate JSON decode succeeded
     if ($input === null && !empty($json_string)) {
         http_response_code(400);
         echo json_encode(['error' => 'Invalid JSON: ' . json_last_error_msg()]);
         return;
     }
     
     if (!$input || !isset($input['productIds']) || !is_array($input['productIds'])) {
         http_response_code(400);
         echo json_encode(['error' => 'Invalid request body. Expected: {"productIds": [1, 2, 3]}']);
         return;
     }
     
     // Validate product IDs are integers
     foreach ($input['productIds'] as $id) {
         if (!is_int($id) || $id <= 0) {
             http_response_code(400);
             echo json_encode(['error' => 'Product IDs must be positive integers']);
             return;
         }
     }
     
     $products = loadProducts();
     
     // Create indexed lookup for O(n) performance instead of O(n²)
     $product_index = [];
     foreach ($products as $p) {
         $product_index[$p['id']] = $p;
     }
     
     $exported = [];
     foreach ($input['productIds'] as $id) {
         if (isset($product_index[$id])) {
             $exported[] = $product_index[$id];
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

function loadProducts() {
     global $PRODUCTS_FILE;
     
     if (!file_exists($PRODUCTS_FILE)) {
         return getDefaultProducts();
     }
     
     $content = file_get_contents($PRODUCTS_FILE);
     
     if ($content === false) {
         error_log('Failed to read products file: ' . $PRODUCTS_FILE);
         return getDefaultProducts();
     }
     
     $products = json_decode($content, true);
     
     // Validate JSON decode succeeded
     if ($products === null && !empty($content)) {
         error_log('Invalid JSON in products file: ' . json_last_error_msg());
         return getDefaultProducts();
     }
     
     if (!is_array($products)) {
         return getDefaultProducts();
     }
     
     return $products;
}

function initializeProductsFile() {
     global $PRODUCTS_FILE;
     
     $default_products = getDefaultProducts();
     $json_content = json_encode($default_products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
     
     if ($json_content === false) {
         error_log('Failed to encode default products to JSON: ' . json_last_error_msg());
         http_response_code(500);
         die(json_encode(['error' => 'Failed to initialize products file']));
     }
     
     $bytes_written = file_put_contents($PRODUCTS_FILE, $json_content);
     
     if ($bytes_written === false) {
         error_log('Failed to write products file: ' . $PRODUCTS_FILE);
         http_response_code(500);
         die(json_encode(['error' => 'Failed to write products file']));
     }
}

function getDefaultProducts() {
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
