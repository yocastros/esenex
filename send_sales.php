<?php
if (isset($_GET["name"]) && isset($_GET["email"]) && isset($_GET["message"])) {
    $name = htmlspecialchars($_GET["name"]);
    $email = filter_var($_GET["email"], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_GET["message"]);

    // Configuración del correo a ventas
    $to_sales = "ventas@esenex.cl";
    $subject = "Nuevo Cliente - Esenex Hosting";
    $body = "Nombre: $name\nCorreo: $email\n\nMensaje:\n$message";
    $headers = "From: contacto@esenex.cl\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Intentar enviar el correo
    if (mail($to_sales, $subject, $body, $headers)) {
        echo "<h2>Correo enviado correctamente a ventas@esenex.cl</h2>";
    } else {
        echo "<h2>Error: No se pudo enviar el correo</h2>";
    }
    exit;
} else {
    echo "<h2>Error: No se recibieron datos</h2>";
    exit;
}
?>
