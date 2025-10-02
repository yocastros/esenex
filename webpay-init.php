<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar que autoload.php existe
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    die("Error: No se encontró el archivo autoload.php. Verifica la instalación de Composer.");
}

// Cargar Composer
require __DIR__ . '/vendor/autoload.php';

// Importar clases correctamente
use Transbank\Webpay\WebpayPlus;
use Transbank\Webpay\WebpayPlus\Transaction;

// Configurar WebPay
WebpayPlus::configureForProduction('597052921342', 'TU_API_KEY');

?>
