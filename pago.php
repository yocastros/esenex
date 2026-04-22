<?php
/**
 * Archivo deprecado - La plataforma de pago no está activa
 * Redirige al flujo de solicitud manual
 */

session_start();

if (isset($_SESSION['contratacion'])) {
    header("Location: confirmacion.php?ref=" . $_SESSION['contratacion']['referencia']);
} else {
    header("Location: index.html");
}
exit;
?>
