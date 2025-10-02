<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>🔍 Verificación de WebPay</h2>";

// 1️⃣ Verificar si autoload.php está presente
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    die("<p style='color: red;'>❌ Error: No se encontró <code>vendor/autoload.php</code>. Verifica que la carpeta <code>vendor/</code> esté en el servidor.</p>");
}

require __DIR__ . '/vendor/autoload.php';
echo "<p style='color: green;'>✅ Autoload cargado correctamente.</p>";

// 2️⃣ Verificar si Transbank está instalado verificando `installed.json`
$installedJsonPath = __DIR__ . "/vendor/composer/installed.json";

if (!file_exists($installedJsonPath)) {
    die("<p style='color: red;'>❌ Error: No se encontró <code>installed.json</code>. Verifica que hayas subido la carpeta <code>vendor/composer/</code> correctamente.</p>");
}

$composerPackages = json_decode(file_get_contents($installedJsonPath), true);
$transbankInstalled = false;

foreach ($composerPackages as $package) {
    if (isset($package['name']) && strpos($package['name'], 'transbank/transbank-sdk') !== false) {
        $transbankInstalled = true;
        break;
    }
}

if (!$transbankInstalled) {
    die("<p style='color: red;'>❌ Error: El paquete <code>transbank/transbank-sdk</code> no está instalado. Intenta reinstalarlo con <code>composer require transbank/transbank-sdk</code> en tu PC y vuelve a subirlo.</p>");
}

echo "<p style='color: green;'>✅ Transbank SDK detectado en Composer.</p>";

// 3️⃣ Cargar manualmente la clase WebpayPlus si no la encuentra automáticamente
if (!class_exists('Transbank\Webpay\WebpayPlus\WebpayPlus')) {
    require_once __DIR__ . '/vendor/transbank/src/Webpay/WebpayPlus.php';
}

use Transbank\Webpay\WebpayPlus\WebpayPlus;


if (!class_exists('Transbank\Webpay\WebpayPlus\WebpayPlus')) {
    die("<p style='color: red;'>❌ Error: No se encontró la clase <code>WebpayPlus</code>. Verifica la estructura de <code>vendor/transbank/src/</code>.</p>");
}

echo "<p style='color: green;'>✅ Transbank SDK cargado correctamente.</p>";

// 4️⃣ Intentar configurar WebPay
try {
    WebpayPlus::configureForProduction('597052921342', 'AQUI_VA_TU_API_KEY_REAL');
    echo "<p style='color: green;'>✅ WebPay configurado correctamente.</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error al configurar WebPay: " . $e->getMessage() . "</p>";
}
?>


