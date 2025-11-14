<?php
// Laravel Migráció és Seeder Futtató Script
// FIGYELEM: Töröld ezt a fájlt a futtatás után!

ini_set('display_errors', 1);
ini_set('max_execution_time', 300);
error_reporting(E_ALL);

echo '<h2>Laravel Migráció és Seeder</h2>';
echo '<p>Inicializálás...</p>';

// Laravel autoload és bootstrap betöltése
require __DIR__ . '/../laravel_app/vendor/autoload.php';
$app = require_once __DIR__ . '/../laravel_app/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

try {
    echo '<h3>1. Migráció futtatása...</h3>';
    $kernel->call('migrate', ['--force' => true]);
    echo '<p style="color:green;">✓ Migrációk sikeresen lefutottak!</p>';

    echo '<h3>2. Seederek futtatása...</h3>';
    $kernel->call('db:seed', ['--force' => true]);
    echo '<p style="color:green;">✓ Seederek sikeresen lefutottak!</p>';

    echo '<h3>3. Konfiguráció cache-elése...</h3>';
    $kernel->call('config:clear');
    $kernel->call('config:cache');
    echo '<p style="color:green;">✓ Konfiguráció cache-elve!</p>';

    echo '<h3>4. Route cache-elése...</h3>';
    $kernel->call('route:cache');
    echo '<p style="color:green;">✓ Route-ok cache-elve!</p>';

    echo '<hr>';
    echo '<h2 style="color:green;">✓ SIKERES TELEPÍTÉS!</h2>';
    echo '<h3 style="color:red;">⚠️ AZONNAL TÖRÖLD EZT A FÁJLT A SZERVERRŐL!</h3>';
    echo '<p>A Laravel alkalmazásod most már elérhető: <a href="/">Főoldal megnyitása</a></p>';

} catch (Exception $e) {
    echo '<h2 style="color:red;">❌ Hiba történt!</h2>';
    echo '<h3>Hibaüzenet:</h3>';
    echo '<pre style="background:#f5f5f5;padding:15px;border:1px solid #ddd;">' . htmlspecialchars($e->getMessage()) . '</pre>';
    echo '<h3>Stack trace:</h3>';
    echo '<pre style="background:#f5f5f5;padding:15px;border:1px solid #ddd;font-size:12px;">' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    echo '<hr>';
    echo '<h3>Lehetséges okok:</h3>';
    echo '<ul>';
    echo '<li>Hibás adatbázis beállítások a .env fájlban</li>';
    echo '<li>Az adatbázis nem létezik vagy nem elérhető</li>';
    echo '<li>Nincs írási jogosultság a storage/ mappában</li>';
    echo '<li>A vendor mappa nem lett feltöltve</li>';
    echo '</ul>';
}
?>
