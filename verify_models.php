<?php

use App\Models\PostalCode;
use App\Models\Province;

// Test 1: Count records
echo "Testing Database Connection...\n";
$countStats = [
    'Provinces' => Province::count(),
    'PostalCodes' => PostalCode::count()
];
print_r($countStats);

// Test 2: Search specific postal code
$searchCode = '231'; // Banda Aceh area
echo "\nSearching for postal codes starting with '$searchCode'...\n";

$results = PostalCode::where('postal_code', 'LIKE', $searchCode . '%')
    ->with('province')
    ->limit(3)
    ->get();

if ($results->isEmpty()) {
    echo "No results found.\n";
} else {
    foreach ($results as $item) {
        $provName = $item->province ? $item->province->province_name : 'N/A';
        echo "- Code: {$item->postal_code} | City: {$item->city} | Prov: {$provName}\n";
    }
}

// Test 3: Check Relationship validity
echo "\nVerifying Relationship...\n";
$sample = PostalCode::first();
if ($sample) {
    echo "Sample Code: " . $sample->postal_code . "\n";
    echo "Province Code: " . $sample->province_code . "\n";
    if ($sample->province) {
        echo "Province Name (via relation): " . $sample->province->province_name . "\n";
    } else {
        echo "Province relation returned null (Check foreign keys/data integrity)\n";
    }
}
