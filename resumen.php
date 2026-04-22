<?php
session_start();

// Procesar datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar y sanitizar datos
    $plan = htmlspecialchars($_POST["plan"] ?? '');
    $precio = floatval($_POST["precio"] ?? 0);
    $documento = htmlspecialchars($_POST["documento"] ?? '');
    $tipo_cliente = htmlspecialchars($_POST["tipo_cliente"] ?? '');
    $nombre = htmlspecialchars($_POST["nombre"] ?? '');
    $apellidos = htmlspecialchars($_POST["apellidos"] ?? '');
    $email = filter_var($_POST["email"] ?? '', FILTER_VALIDATE_EMAIL);
    $telefono = htmlspecialchars($_POST["telefono"] ?? '');
    $razon_social = htmlspecialchars($_POST["razon_social"] ?? '');
    $actividad = htmlspecialchars($_POST["actividad"] ?? '');
    $direccion = htmlspecialchars($_POST["direccion"] ?? '');
    $codigo_postal = htmlspecialchars($_POST["codigo_postal"] ?? '');
    $ciudad = htmlspecialchars($_POST["ciudad"] ?? '');
    $provincia = htmlspecialchars($_POST["provincia"] ?? '');

    // Validar campos obligatorios
    if (!$email || empty($plan) || empty($documento) || empty($nombre)) {
        header("Location: contratar_unificado.html");
        exit;
    }

    // Calcular totales
    $iva = $precio * 0.21;
    $total = $precio + $iva;

    // Guardar en sesión para el proceso de pago
    $_SESSION['contratacion'] = [
        'plan' => $plan,
        'precio' => $precio,
        'iva' => $iva,
        'total' => $total,
        'documento' => $documento,
        'tipo_cliente' => $tipo_cliente,
        'nombre' => $nombre,
        'apellidos' => $apellidos,
        'email' => $email,
        'telefono' => $telefono,
        'razon_social' => $razon_social,
        'actividad' => $actividad,
        'direccion' => $direccion,
        'codigo_postal' => $codigo_postal,
        'ciudad' => $ciudad,
        'provincia' => $provincia,
        'fecha' => date('d/m/Y'),
        'referencia' => 'ESX-' . strtoupper(uniqid())
    ];

    // Enviar correo al cliente con instrucciones de pago
    $to_cliente = $email;
    $subject_cliente = "Instrucciones de Pago - Esenex Hosting";

    $headers_cliente = "From: noreply@esenex.es\r\n";
    $headers_cliente .= "Reply-To: ventas@esenex.es\r\n";
    $headers_cliente .= "MIME-Version: 1.0\r\n";
    $headers_cliente .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body_cliente = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #66b2cc 0%, #4a90a4 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .header img { max-width: 150px; margin-bottom: 15px; }
            .header h1 { color: white; margin: 0; font-size: 24px; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .info-box { background: white; padding: 20px; margin: 15px 0; border-radius: 8px; border-left: 4px solid #66b2cc; }
            .info-box h3 { margin-top: 0; color: #2c5282; font-size: 16px; }
            table { width: 100%; border-collapse: collapse; margin: 15px 0; }
            th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
            th { background: #f1f5f9; font-weight: 600; }
            .total-row { background: #e6fffa; font-weight: bold; }
            .footer { text-align: center; margin-top: 30px; padding: 20px; color: #718096; font-size: 14px; }
            .highlight { background: #fffbeb; border: 1px solid #f6e05e; padding: 15px; border-radius: 8px; margin: 15px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <img src='https://esenex.es/images/logo_esenex.png' alt='Esenex Hosting'>
                <h1>Instrucciones de Pago</h1>
            </div>
            <div class='content'>
                <p>Hola <strong>{$nombre}</strong>,</p>
                <p>Gracias por tu solicitud de contratación. Para completar tu pedido, por favor realiza el pago siguiendo las instrucciones a continuación:</p>

                <div class='info-box'>
                    <h3>📋 Referencia: {$_SESSION['contratacion']['referencia']}</h3>
                    <p><strong>Plan:</strong> {$plan}</p>
                    <p><strong>Fecha:</strong> " . date('d/m/Y') . "</p>
                </div>

                <div class='info-box'>
                    <h3>💰 Desglose del Pago</h3>
                    <table>
                        <tr><th>Concepto</th><th style='text-align:right'>Importe</th></tr>
                        <tr><td>Plan {$plan} (mensual)</td><td style='text-align:right'>" . number_format($precio, 2, ',', '.') . " €</td></tr>
                        <tr><td>IVA (21%)</td><td style='text-align:right'>" . number_format($iva, 2, ',', '.') . " €</td></tr>
                        <tr class='total-row'><td><strong>TOTAL A PAGAR</strong></td><td style='text-align:right'><strong>" . number_format($total, 2, ',', '.') . " €</strong></td></tr>
                    </table>
                </div>

                <div class='highlight'>
                    <h3>🏦 Métodos de Pago</h3>
                    <p><strong>Transferencia Bancaria:</strong></p>
                    <p>Titular: Esenex Hosting SL<br>
                    IBAN: ES00 0000 0000 0000 0000 0000<br>
                    Concepto: {$_SESSION['contratacion']['referencia']} - {$nombre} {$apellidos}</p>
                    <p><strong>Tarjeta de crédito/débito:</strong> Contacta con nosotros</p>
                </div>

                <div class='info-box'>
                    <h3>📍 Datos de Facturación</h3>
                    <p><strong>{$razon_social}</strong><br>
                    Documento: {$documento}<br>
                    {$direccion}<br>
                    {$codigo_postal} {$ciudad} ({$provincia})<br>
                    Tel: {$telefono}</p>
                </div>

                <p style='font-size:13px;color:#718096;margin-top:20px;'>
                    Una vez recibido el pago, activaremos tu servicio y recibirás los datos de acceso.
                </p>
            </div>
            <div class='footer'>
                <p>Esenex Hosting - España<br>
                ventas@esenex.es | +34 697 764 254</p>
            </div>
        </div>
    </body>
    </html>
    ";

    mail($to_cliente, $subject_cliente, $body_cliente, $headers_cliente);

    // Enviar correo al departamento de ventas
    $to_ventas = "ventas@esenex.es";
    $subject_ventas = "Nueva Solicitud de Contratación - {$plan}";

    $headers_ventas = "From: noreply@esenex.es\r\n";
    $headers_ventas .= "Reply-To: {$email}\r\n";
    $headers_ventas .= "MIME-Version: 1.0\r\n";
    $headers_ventas .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body_ventas = "
    <h2>Nueva Solicitud de Contratación</h2>
    <p><strong>Referencia:</strong> {$_SESSION['contratacion']['referencia']}</p>
    <p><strong>Fecha:</strong> " . date('d/m/Y H:i') . "</p>
    <hr>
    <h3>Datos del Plan</h3>
    <p><strong>Plan:</strong> {$plan}<br>
    <strong>Precio:</strong> " . number_format($precio, 2, ',', '.') . " €/mes<br>
    <strong>Total con IVA:</strong> " . number_format($total, 2, ',', '.') . " €</p>

    <h3>Datos del Cliente</h3>
    <p><strong>Tipo:</strong> {$tipo_cliente}<br>
    <strong>Nombre:</strong> {$nombre} {$apellidos}<br>
    <strong>Razón Social:</strong> {$razon_social}<br>
    <strong>Documento:</strong> {$documento}<br>
    <strong>Actividad:</strong> {$actividad}</p>

    <h3>Contacto</h3>
    <p><strong>Email:</strong> {$email}<br>
    <strong>Teléfono:</strong> {$telefono}</p>

    <h3>Dirección</h3>
    <p>{$direccion}<br>
    {$codigo_postal} {$ciudad}<br>
    {$provincia}, España</p>

    <hr>
    <p><strong>ACCIONES PENDIENTES:</strong></p>
    <p>1. Contactar al cliente en las próximas 24 horas<br>
    2. Confirmar método de pago<br>
    3. Procesar pago y activar servicio</p>

    <p><em>Fecha de solicitud: " . date('d/m/Y H:i') . "</em></p>
    ";

    mail($to_ventas, $subject_ventas, $body_ventas, $headers_ventas);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="images/logo_esenex.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Contratación - Esenex Hosting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #66b2cc 0%, #4a90a4 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }
        .logo-container {
            margin-bottom: 30px;
        }
        .logo {
            max-width: 180px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 700px;
            width: 100%;
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .step {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #718096;
            margin: 0 10px;
        }
        .step.active {
            background: #66b2cc;
            color: white;
        }
        .step.completed {
            background: #48bb78;
            color: white;
        }
        .step-line {
            width: 60px;
            height: 3px;
            background: #e2e8f0;
            margin-top: 16px;
        }
        .trust-badges {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 25px 0;
            flex-wrap: wrap;
        }
        .trust-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #4a5568;
            background: #f7fafc;
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
        }
        .trust-badge i {
            color: #48bb78;
            font-size: 16px;
        }
        .summary-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }
        .summary-section {
            margin-bottom: 25px;
        }
        .summary-section h4 {
            color: #66b2cc;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e8f0;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .summary-row:last-child {
            border-bottom: none;
        }
        .summary-row .label {
            color: #718096;
        }
        .summary-row .value {
            font-weight: 600;
            color: #2d3748;
        }
        .price-table {
            width: 100%;
            margin-top: 15px;
        }
        .price-table td {
            padding: 10px;
        }
        .price-table .total {
            background: #c6f6d5;
            font-weight: bold;
            font-size: 18px;
            color: #22543d;
        }
        .btn-primary {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border: none;
            padding: 18px 30px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(72, 187, 120, 0.4);
        }
        .btn-outline {
            background: transparent;
            border: 2px solid #66b2cc;
            color: #66b2cc;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            transition: all 0.3s;
        }
        .btn-outline:hover {
            background: #66b2cc;
            color: white;
        }
        .alert-success {
            background: #c6f6d5;
            border: 1px solid #9ae6b4;
            color: #22543d;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .payment-info {
            background: #fffbeb;
            border: 2px solid #f6e05e;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .payment-info h4 {
            color: #744210;
            margin-bottom: 15px;
        }
        .payment-info p {
            margin-bottom: 8px;
            color: #744210;
        }
        /* Optimización móvil */
        @media (max-width: 768px) {
            body {
                padding: 20px 10px;
            }
            .form-container {
                padding: 25px;
            }
            .summary-row {
                font-size: 14px;
            }
            .trust-badges {
                gap: 8px;
            }
            .trust-badge {
                font-size: 11px;
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <a href="index.html">
            <img src="images/logo_esenex.png" alt="Esenex Hosting Logo" class="logo">
        </a>
    </div>

    <div class="form-container">
        <!-- Indicador de pasos -->
        <div class="step-indicator">
            <div class="step completed"><i class="fas fa-check"></i></div>
            <div class="step-line" style="background: #48bb78;"></div>
            <div class="step active">2</div>
        </div>

        <h2 class="text-center mb-3">Confirma tu Contratación</h2>

        <!-- Badges de confianza -->
        <div class="trust-badges">
            <div class="trust-badge">
                <i class="fas fa-shield-alt"></i>
                <span>Conexión SSL Segura</span>
            </div>
            <div class="trust-badge">
                <i class="fas fa-undo"></i>
                <span>30 días garantía</span>
            </div>
            <div class="trust-badge">
                <i class="fas fa-headset"></i>
                <span>Soporte 24/7</span>
            </div>
        </div>

        <div class="alert-success">
            <i class="fas fa-envelope"></i> Se enviará confirmación a <strong><?php echo $email; ?></strong>
        </div>

        <div class="summary-box">
            <div class="summary-section">
                <h4><i class="fas fa-shopping-cart"></i> Tu Plan</h4>
                <div class="summary-row">
                    <span class="label">Referencia</span>
                    <span class="value"><?php echo $_SESSION['contratacion']['referencia']; ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Plan seleccionado</span>
                    <span class="value">Plan <?php echo $plan; ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Periodicidad</span>
                    <span class="value">Mensual</span>
                </div>
            </div>

            <div class="summary-section">
                <h4><i class="fas fa-euro-sign"></i> Desglose de Precios</h4>
                <table class="price-table">
                    <tr>
                        <td>Plan <?php echo $plan; ?> (mensual)</td>
                        <td style="text-align:right"><?php echo number_format($precio, 2, ',', '.'); ?> €</td>
                    </tr>
                    <tr>
                        <td>IVA (21%)</td>
                        <td style="text-align:right"><?php echo number_format($iva, 2, ',', '.'); ?> €</td>
                    </tr>
                    <tr class="total">
                        <td><strong>TOTAL</strong></td>
                        <td style="text-align:right"><strong><?php echo number_format($total, 2, ',', '.'); ?> €/mes</strong></td>
                    </tr>
                </table>
            </div>

            <div class="summary-section">
                <h4><i class="fas fa-user"></i> Datos del Cliente</h4>
                <div class="summary-row">
                    <span class="label">Nombre</span>
                    <span class="value"><?php echo $nombre . ' ' . $apellidos; ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Razón Social</span>
                    <span class="value"><?php echo $razon_social; ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Documento</span>
                    <span class="value"><?php echo $documento; ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Email</span>
                    <span class="value"><?php echo $email; ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Teléfono</span>
                    <span class="value"><?php echo $telefono; ?></span>
                </div>
            </div>

            <div class="summary-section">
                <h4><i class="fas fa-map-marker-alt"></i> Dirección de Facturación</h4>
                <div class="summary-row">
                    <span class="label">Dirección completa</span>
                    <span class="value"><?php echo $direccion . ', ' . $codigo_postal . ' ' . $ciudad . ', ' . $provincia; ?></span>
                </div>
            </div>
        </div>

        <div class="payment-info">
            <h4><i class="fas fa-info-circle"></i> Próximos Pasos</h4>
            <p>✓ Al confirmar, recibirás un email con las instrucciones de pago</p>
            <p>✓ Podrás pagar por transferencia o tarjeta</p>
            <p>✓ Una vez confirmado el pago, activaremos tu servicio en menos de 24 horas</p>
        </div>

        <form action="confirmacion.php" method="POST">
            <input type="hidden" name="ref" value="<?php echo $_SESSION['contratacion']['referencia']; ?>">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-circle"></i> Confirmar Contratación
            </button>
        </form>

        <!-- Formulario para volver atrás manteniendo los datos -->
        <form action="contratar_unificado.html" method="GET" class="text-center">
            <button type="button" onclick="history.back()" class="btn-outline" style="background: transparent; border: 2px solid #66b2cc; color: #66b2cc; padding: 12px 30px; border-radius: 8px; cursor: pointer;">
                ← Modificar datos
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>