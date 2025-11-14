<?php
/**
 * Laravel Deployment ZIP Creator
 *
 * Ez a script létrehozza a laravel-project.zip fájlt, ami tartalmazza:
 * - bootstrap/ mappa
 * - vendor/ mappa
 * - public/ mappa
 * - composer.json
 * - composer.lock
 * - artisan
 * - .env.example
 */

echo "==============================================\n";
echo "  Laravel Deployment ZIP Creator\n";
echo "==============================================\n\n";

// Ellenőrizzük, hogy a ZipArchive osztály elérhető-e
if (!class_exists('ZipArchive')) {
    die("HIBA: A ZipArchive PHP extension nincs telepítve!\n");
}

// Kimeneti ZIP fájl neve
$outputZip = __DIR__ . '/laravel-project.zip';

// Töroljük az előző ZIP-et ha létezik
if (file_exists($outputZip)) {
    echo "Régi laravel-project.zip törlése...\n";
    unlink($outputZip);
}

// Fájlok és mappák amiket be kell csomagolni
$itemsToPack = [
    'bootstrap',
    'vendor',
    'public',
    'composer.json',
    'composer.lock',
    'artisan',
    '.env.example'
];

echo "Ellenőrzés: Léteznek-e a szükséges fájlok?\n";
echo "--------------------------------------------\n";

$missingItems = [];
foreach ($itemsToPack as $item) {
    $path = __DIR__ . '/' . $item;
    if (file_exists($path)) {
        $size = is_dir($path) ? getDirSize($path) : filesize($path);
        echo "✓ " . str_pad($item, 20) . " (" . formatBytes($size) . ")\n";
    } else {
        echo "✗ $item - NEM TALÁLHATÓ!\n";
        $missingItems[] = $item;
    }
}

if (!empty($missingItems)) {
    echo "\nHIBA: A következő fájlok/mappák hiányoznak:\n";
    foreach ($missingItems as $item) {
        echo "  - $item\n";
    }
    die("\nA ZIP létrehozása megszakítva.\n");
}

echo "\n";
echo "ZIP fájl létrehozása...\n";
echo "--------------------------------------------\n";

$zip = new ZipArchive();
if ($zip->open($outputZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    die("HIBA: Nem sikerült létrehozni a ZIP fájlt!\n");
}

$fileCount = 0;

foreach ($itemsToPack as $item) {
    $path = __DIR__ . '/' . $item;

    if (is_dir($path)) {
        echo "Mappa hozzáadása: $item/\n";
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($files as $file) {
            $filePath = $file->getRealPath();
            $relativePath = $item . '/' . substr($filePath, strlen($path) + 1);

            if (is_dir($filePath)) {
                $zip->addEmptyDir($relativePath);
            } else {
                $zip->addFile($filePath, $relativePath);
                $fileCount++;
            }
        }
    } else {
        echo "Fájl hozzáadása: $item\n";
        $zip->addFile($path, $item);
        $fileCount++;
    }
}

echo "\n";
echo "ZIP fájl lezárása...\n";
$zip->close();

$zipSize = filesize($outputZip);

echo "\n";
echo "==============================================\n";
echo "  ✓ SIKERES!\n";
echo "==============================================\n";
echo "ZIP fájl: laravel-project.zip\n";
echo "Méret: " . formatBytes($zipSize) . "\n";
echo "Fájlok száma: $fileCount db\n";
echo "Hely: $outputZip\n";
echo "\n";
echo "Következő lépések:\n";
echo "1. Töltsd fel a laravel-project.zip fájlt a szerverre (WinSCP)\n";
echo "2. Töltsd fel az unzip.php fájlt is ugyanoda\n";
echo "3. Látogasd meg: yourdomain.com/unzip.php\n";
echo "==============================================\n";

// Segédfüggvények

function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}

function getDirSize($directory) {
    $size = 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)) as $file) {
        $size += $file->getSize();
    }
    return $size;
}

