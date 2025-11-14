<?php
// Laravel Telepítési Fájlok Eltávolító Script
// Ez a script biztonságosan törli a telepítési segédfájlokat

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo '<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel - Telepítési Fájlok Törlése</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #e74c3c; margin-top: 0; }
        h2 { color: #2c3e50; }
        .success { color: #27ae60; font-weight: bold; }
        .error { color: #e74c3c; font-weight: bold; }
        .warning { color: #f39c12; font-weight: bold; }
        .file-list { background: #ecf0f1; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .file-item { padding: 5px 0; }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px 5px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            border: none;
            font-size: 16px;
        }
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        ul { line-height: 1.8; }
    </style>
</head>
<body>
<div class="container">';

echo '<h1>⚠️ Laravel Telepítési Fájlok Törlése</h1>';

// Fájlok és mappák listája amelyeket törölni fogunk
$filesToRemove = [
    'run-migrations.php',
    'public',
    'temp-extract',
    'laravel-project.zip',
    'vendor.zip',
    'node_modules',
    'temp_extract', // ideiglenes mappa ha maradt
    '../laravel_app',  // a teljes kicsomagolt Laravel mappa
    'build'
];

// Ellenőrizzük hogy van-e DELETE confirmation
if (!isset($_GET['confirm']) || $_GET['confirm'] !== 'yes') {
    // Megjelenítjük a megerősítő oldalt
    echo '<p class="warning">Ez a script a következő telepítési fájlokat fogja törölni:</p>';

    echo '<div class="file-list">';
    $foundFiles = [];
    $notFoundFiles = [];

    foreach ($filesToRemove as $file) {
        $path = __DIR__ . '/' . $file;

        if (is_file($path)) {
            $size = filesize($path);
            $sizeFormatted = formatBytes($size);
            echo '<div class="file-item">✓ <strong>' . htmlspecialchars($file) . '</strong> (' . $sizeFormatted . ')</div>';
            $foundFiles[] = $file;
        } elseif (is_dir($path)) {
            $size = getDirectorySize($path);
            $sizeFormatted = formatBytes($size);
            echo '<div class="file-item">✓ <strong>' . htmlspecialchars($file) . '/</strong> (mappa, ' . $sizeFormatted . ')</div>';
            $foundFiles[] = $file;
        } else {
            echo '<div class="file-item" style="color:#95a5a6;">⊘ ' . htmlspecialchars($file) . ' (nem található)</div>';
            $notFoundFiles[] = $file;
        }
    }
    echo '</div>';

    if (empty($foundFiles)) {
        echo '<h2 class="success">✓ Minden telepítési fájl már törölve lett!</h2>';
        echo '<p>A rendszer tiszta, nincs mit törölni.</p>';
        echo '<p><a href="/" class="btn btn-secondary">← Vissza a főoldalra</a></p>';
    } else {
        echo '<h2 class="warning">Figyelmeztetés!</h2>';
        echo '<ul>';
        echo '<li>Ezek a fájlok <strong>véglegesen törlődnek</strong></li>';
        echo '<li>Győződj meg róla, hogy a Laravel alkalmazásod már működik</li>';
        echo '<li>Biztonsági okokból <strong>ajánlott törölni</strong> ezeket a fájlokat</li>';
        echo '<li>Ez a művelet <strong>NEM vonható vissza</strong></li>';
        echo '</ul>';

        echo '<form method="GET" action="" style="margin-top: 30px;">';
        echo '<input type="hidden" name="confirm" value="yes">';
        echo '<button type="submit" class="btn btn-danger">🗑️ IGEN, TÖRÖLD A FÁJLOKAT</button>';
        echo '<a href="/" class="btn btn-secondary">Mégse</a>';
        echo '</form>';
    }

} else {
    // Törlés megerősítve, végrehajtjuk
    echo '<h2>Törlés folyamatban...</h2>';

    $deletedFiles = [];
    $failedFiles = [];

    foreach ($filesToRemove as $file) {
        $path = __DIR__ . '/' . $file;

        if (is_file($path)) {
            if (unlink($path)) {
                echo '<p class="success">✓ Törölve: ' . htmlspecialchars($file) . '</p>';
                $deletedFiles[] = $file;
            } else {
                echo '<p class="error">✗ Nem sikerült törölni: ' . htmlspecialchars($file) . '</p>';
                $failedFiles[] = $file;
            }
        } elseif (is_dir($path)) {
            if (deleteDirectory($path)) {
                echo '<p class="success">✓ Mappa törölve: ' . htmlspecialchars($file) . '/</p>';
                $deletedFiles[] = $file;
            } else {
                echo '<p class="error">✗ Nem sikerült törölni a mappát: ' . htmlspecialchars($file) . '/</p>';
                $failedFiles[] = $file;
            }
        }
    }

    echo '<hr style="margin: 30px 0;">';

    if (empty($failedFiles)) {
        echo '<h2 class="success">✓ Sikeres takarítás!</h2>';
        echo '<p>Minden telepítési fájl sikeresen törölve lett.</p>';
        echo '<p><strong>Összesen törölve:</strong> ' . count($deletedFiles) . ' elem</p>';
        echo '<div class="file-list">';
        foreach ($deletedFiles as $file) {
            echo '<div class="file-item">✓ ' . htmlspecialchars($file) . '</div>';
        }
        echo '</div>';
        echo '<p style="margin-top: 30px;"><a href="/" class="btn btn-secondary">← Tovább a főoldalra</a></p>';
        echo '<p style="color: #95a5a6; font-size: 14px;">Ez az oldal 5 másodperc múlva automatikusan átirányít...</p>';
        echo '<script>setTimeout(function(){ window.location.href = "/"; }, 5000);</script>';
    } else {
        echo '<h2 class="warning">⚠️ Részleges törlés</h2>';
        echo '<p><strong>Sikeresen törölve:</strong> ' . count($deletedFiles) . ' elem</p>';
        echo '<p><strong>Nem sikerült törölni:</strong> ' . count($failedFiles) . ' elem</p>';

        echo '<div class="file-list">';
        echo '<h3>Nem sikerült törölni:</h3>';
        foreach ($failedFiles as $file) {
            echo '<div class="file-item">✗ ' . htmlspecialchars($file) . '</div>';
        }
        echo '</div>';

        echo '<p>Próbáld meg manuálisan FTP-n keresztül törölni ezeket a fájlokat.</p>';
        echo '<p><a href="/" class="btn btn-secondary">← Vissza a főoldalra</a></p>';
    }
}

echo '</div></body></html>';

// Segédfüggvények

function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}

function getDirectorySize($path) {
    $size = 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)) as $file) {
        $size += $file->getSize();
    }
    return $size;
}

function deleteDirectory($dir) {
    if (!is_dir($dir)) return false;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            unlink($path);
        }
    }
    return rmdir($dir);
}
?>

