<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$zipFile = './laravel-project.zip';
$extractTo = '../laravel_app/';       //célmappa

if (!file_exists($zipFile)) {
    die('Hiba: A vendor.zip nem található a /laravel_app/ mappában');
}

$zip = new ZipArchive;
$res = $zip->open($zipFile);

if ($res === TRUE) {
  // Kicsomagolás a célmappába
  $zip->extractTo($extractTo);
  $zip->close();
  echo '<h1>Sikeres kicsomagolás!</h1>';
  echo 'A <strong>vendor</strong> mappa a <strong>/laravel_app/</strong> mappába lett kicsomagolva.<br>';
  echo '<strong>FONTOS:</strong> Most azonnal töröld ezt a <strong>unzip.php</strong> fájlt a szerverről!';
} else {
  echo 'Hiba: A ZIP fájlt nem sikerült megnyitni.';
}

// copy the ../laravel_app/public contents to ../public_html
function copyDirectory($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                copyDirectory($src . '/' . $file, $dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}
copyDirectory($extractTo . 'public', '../public_html');
