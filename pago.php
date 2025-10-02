<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use Transbank\Webpay\WebpayPlus\Transaction;

require 'webpay-init.php'; // Asegúrate de que este archivo exista y esté correctamente configurado

try {
    $buyOrder = uniqid(); // Identificador único de la orden
    $sessionId = session_id();
    $amount = 10000; // Monto de prueba, reemplázalo con el valor dinámico
    $returnUrl = "esenex.cl/confirmacion.php"; // URL de retorno después del pago

    $response = (new Transaction)->create($buyOrder, $sessionId, $amount, $returnUrl);

    // Redirigir al usuario a WebPay
    header("Location: " . $response->getUrl() . "?token_ws=" . $response->getToken());
    exit;
} catch (Exception $e) {
    echo "Error al iniciar la transacción: " . $e->getMessage();
}
?>
