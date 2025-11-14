<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<!DOCTYPE html>";
echo "<html><head><title>Run Seeders</title>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 1200px; margin: 20px auto; padding: 20px; }
    h1 { color: #333; }
    .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; margin: 10px 0; border-radius: 5px; }
    pre { background: #f5f5f5; padding: 10px; border-radius: 5px; overflow-x: auto; }
    .warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; margin: 10px 0; border-radius: 5px; }
</style>";
echo "</head><body>";

echo "<h1>🌱 Laravel Database Seeder</h1>";

// Check if Laravel app exists - assuming structure: public_html/ -> ../laravel_app/
$laravelAppPath = dirname(__DIR__) . '/laravel_app';
if (!is_dir($laravelAppPath)) {
    // Alternative: maybe it's just one level up
    $laravelAppPath = dirname(__DIR__);
}

echo "<div class='info'><strong>Laravel App Path:</strong> " . $laravelAppPath . "</div>";

// Manually include FileReading class (for case-sensitivity issues)
$fileReadingPath = $laravelAppPath . '/app/utils/filereading.php';
if (file_exists($fileReadingPath)) {
    require_once $fileReadingPath;
    echo "<div class='success'>✓ FileReading class loaded</div>";
} else {
    echo "<div class='warning'>⚠ FileReading not found at: " . $fileReadingPath . "</div>";
}

$autoloadPath = $laravelAppPath . '/vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    echo "<div class='error'><strong>ERROR:</strong> Composer autoload not found at: " . $autoloadPath . "</div>";
    echo "</body></html>";
    exit;
}

require $autoloadPath;

$bootstrapPath = $laravelAppPath . '/bootstrap/app.php';
if (!file_exists($bootstrapPath)) {
    echo "<div class='error'><strong>ERROR:</strong> Bootstrap file not found at: " . $bootstrapPath . "</div>";
    echo "</body></html>";
    exit;
}

try {
    $app = require_once $bootstrapPath;
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    echo "<div class='success'>✓ Laravel application loaded successfully</div>";
    
    // List of seeders to run
    $seeders = [
        'DatabaseSeeder',
        'AdminUserSeeder',
        'UserSeeder',
        'DriverSeeder',
        'GPSeeder',
        'RaceSeeder'
    ];
    
    echo "<h2>Running Seeders</h2>";
    
    foreach ($seeders as $seeder) {
        echo "<div class='info'>";
        echo "<h3>Running: " . $seeder . "</h3>";
        
        try {
            // Capture output
            ob_start();
            $exitCode = $kernel->call('db:seed', [
                '--class' => $seeder,
                '--force' => true
            ]);
            $output = ob_get_clean();
            
            if ($exitCode === 0) {
                echo "<div class='success'>✓ " . $seeder . " completed successfully</div>";
                if (!empty($output)) {
                    echo "<pre>" . htmlspecialchars($output) . "</pre>";
                }
            } else {
                echo "<div class='error'>✗ " . $seeder . " failed with exit code: " . $exitCode . "</div>";
                if (!empty($output)) {
                    echo "<pre>" . htmlspecialchars($output) . "</pre>";
                }
            }
        } catch (\Exception $e) {
            echo "<div class='error'>";
            echo "<strong>Error running " . $seeder . ":</strong><br>";
            echo htmlspecialchars($e->getMessage());
            echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
            echo "</div>";
        }
        
        echo "</div>";
    }
    
    echo "<h2>✅ Seeding Complete</h2>";
    echo "<div class='warning'><strong>⚠️ IMPORTANT:</strong> Delete this file (run-seeders.php) after use for security!</div>";
    
} catch (\Throwable $e) {
    echo "<div class='error'>";
    echo "<h2>Fatal Error</h2>";
    echo "<strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "<br>";
    echo "<strong>File:</strong> " . htmlspecialchars($e->getFile()) . "<br>";
    echo "<strong>Line:</strong> " . $e->getLine() . "<br><br>";
    echo "<strong>Stack Trace:</strong>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}

echo "</body></html>";
