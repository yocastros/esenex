<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $plan = htmlspecialchars($_POST["plan"]);
    $razon_social = htmlspecialchars($_POST["razon-social"]);
    $giro = htmlspecialchars($_POST["giro"]);
    $direccion = htmlspecialchars($_POST["direccion"]);
    $comuna = htmlspecialchars($_POST["comuna"]);
    $ciudad = htmlspecialchars($_POST["ciudad"]);
    $telefono = htmlspecialchars($_POST["telefono"]);
    $rut = htmlspecialchars($_POST["rut"]);
    $precio = htmlspecialchars($_POST["precio"]);

    $fecha_inicio = date('d-m-Y');
    $fecha_fin = date('d-m-Y', strtotime('+30 days'));

    if ($email && $plan) {
        $to = $email;
        $subject = "Bienvenido a tu prueba gratuita de Hosting Esenex";
        
        // Configuramos las cabeceras para enviar en formato HTML
        $headers = "From: contacto@esenex.cl\r\n";
        $headers .= "Reply-To: contacto@esenex.cl\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Creamos el cuerpo del correo en formato HTML
        $body = "
        <html>
        <head>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    padding: 10px;
                    border: 1px solid #ddd;
                }
                th {
                    background-color: #f5f5f5;
                    text-align: left;
                }
                .header {
                    background-color: #66b2cc;
                    color: white;
                    padding: 20px;
                    margin-bottom: 20px;
                    text-align: center;
                }
                .logo {
                    max-width: 200px;
                    height: auto;
                    margin-bottom: 10px;
                }
                .footer {
                    margin-top: 20px;
                    padding: 10px;
                    background-color: #f5f5f5;
                }
            </style>
        </head>
        <body>
            <div class='header'>
                <img src='https://esenex.cl/images/logo_esenex.png' alt='Esenex Hosting' class='logo'>
                <h2>¡Bienvenido a Esenex Hosting!</h2>
            </div>

            <p>Estimado cliente,</p>
            <p>Gracias por confiar en nuestros servicios. A continuación, encontrará el detalle de su contratación:</p>

            <h3>Datos del Plan</h3>
            <table>
                <tr>
                    <th>Plan Contratado</th>
                    <td>$plan</td>
                </tr>
                <tr>
                    <th>Precio Mensual</th>
                    <td>$" . number_format($precio, 0, ',', '.') . " + IVA</td>
                </tr>
                <tr>
                    <th>Inicio Período de Prueba</th>
                    <td>$fecha_inicio</td>
                </tr>
                <tr>
                    <th>Fin Período de Prueba</th>
                    <td>$fecha_fin</td>
                </tr>
            </table>

            <h3>Datos del Cliente</h3>
            <table>
                <tr>
                    <th>Razón Social</th>
                    <td>$razon_social</td>
                </tr>
                <tr>
                    <th>RUT</th>
                    <td>$rut</td>
                </tr>
                <tr>
                    <th>Giro</th>
                    <td>$giro</td>
                </tr>
                <tr>
                    <th>Dirección</th>
                    <td>$direccion</td>
                </tr>
                <tr>
                    <th>Comuna</th>
                    <td>$comuna</td>
                </tr>
                <tr>
                    <th>Ciudad</th>
                    <td>$ciudad</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>$email</td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td>$telefono</td>
                </tr>
            </table>

            <p>Los datos de acceso a su Panel de Control (cPanel) serán enviados en un correo separado.</p>

            <div class='footer'>
                <p>Atentamente,<br>
                Equipo Esenex<br>
                WhatsApp: +56947923313<br>
                www.esenex.cl</p>
            </div>
        </body>
        </html>
        ";

        mail($to, $subject, $body, $headers);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Contratación</title>
    <link href="css/global/contratacion.css" rel="stylesheet">
</head>
<body>
    <div class="logo-container">
        <img src="images/logo_esenex.png" alt="Esenex Hosting Logo" class="logo">
    </div>
    
    <div class="form-container">
        <h1>Confirmación de Contratación</h1>
        <p>¡Gracias por contratar con nosotros! Aquí tienes el resumen de tu solicitud:</p>

        <div class="summary">
            <h2>Detalles de Contratación</h2>
            <p><strong>Plan Contratado:</strong> <?php echo htmlspecialchars($_POST['plan']); ?></p>
            <p><strong>RUT:</strong> <?php echo htmlspecialchars($_POST['rut']); ?></p>

            <h2>Datos del Contratante</h2>
            <p><strong>Razón Social:</strong> <?php echo htmlspecialchars($_POST['razon-social']); ?></p>
            <p><strong>Giro:</strong> <?php echo htmlspecialchars($_POST['giro']); ?></p>
            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($_POST['direccion']); ?></p>
            <p><strong>Comuna:</strong> <?php echo htmlspecialchars($_POST['comuna']); ?></p>
            <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($_POST['ciudad']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_POST['email']); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($_POST['telefono']); ?></p>
        </div>

        <div class="actions">
            <button onclick="window.print()">Imprimir</button>
            <a href="https://esenex.cl" class="btn">Volver al Inicio</a>
        </div>
    </div>
</body>
</html>