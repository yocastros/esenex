<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST["message"]);

    if ($name && $email && $message) {
        echo "<h2>Datos recibidos en send_client.php</h2>";
        echo "<p><strong>Nombre:</strong> $name</p>";
        echo "<p><strong>Correo:</strong> $email</p>";
        echo "<p><strong>Mensaje:</strong> $message</p>";

        // Crear URL de redirección manual
        $redirect_url = "send_sales.php?name=" . urlencode($name) . "&email=" . urlencode($email) . "&message=" . urlencode($message);

        echo "<p><a href='$redirect_url'>Hacer clic aquí si no redirige automáticamente</a></p>";

        // Redirigir a send_sales.php
        header("Location: $redirect_url");
        exit;
    } else {
        echo "<h2>Error: Faltan datos</h2>";
        exit;
    }
}
?>
