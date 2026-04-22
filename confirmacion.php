<?php
session_start();

// Verificar si viene del resumen (POST) o por URL
$referencia = $_POST['ref'] ?? $_GET['ref'] ?? '';

// Recuperar datos de la sesión
$contratacion = $_SESSION['contratacion'] ?? null;

// Si hay datos en sesión, usarlos
if ($contratacion) {
    $plan = $contratacion['plan'];
    $email = $contratacion['email'];
    $nombre = $contratacion['nombre'];
    $apellidos = $contratacion['apellidos'];
    $total = $contratacion['total'];
    $referencia = $contratacion['referencia'];
    $telefono = $contratacion['telefono'];

    // Enviar correo de confirmación de solicitud recibida
    $to = $email;
    $subject = "✓ Solicitud Recibida - Esenex Hosting";

    $headers = "From: noreply@esenex.es\r\n";
    $headers .= "Reply-To: ventas@esenex.es\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .header img { max-width: 150px; margin-bottom: 15px; }
            .header h1 { color: white; margin: 0; font-size: 24px; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .success-box { background: #c6f6d5; border: 1px solid #9ae6b4; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
            .success-box h2 { color: #22543d; margin: 0 0 10px 0; }
            .info-box { background: white; padding: 20px; margin: 15px 0; border-radius: 8px; border-left: 4px solid #66b2cc; }
            .info-box h3 { margin-top: 0; color: #2c5282; font-size: 16px; }
            .btn { display: inline-block; background: #66b2cc; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 10px 5px; }
            .footer { text-align: center; margin-top: 30px; padding: 20px; color: #718096; font-size: 14px; }
            .steps { background: #ebf8ff; padding: 20px; border-radius: 8px; margin: 15px 0; }
            .steps ol { margin: 0; padding-left: 20px; }
            .steps li { margin-bottom: 10px; color: #2c5282; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <img src='https://esenex.es/images/logo_esenex.png' alt='Esenex Hosting'>
                <h1>¡Solicitud Recibida!</h1>
            </div>
            <div class='content'>
                <div class='success-box'>
                    <h2>✓ Gracias por tu confianza</h2>
                    <p>Tu solicitud ha sido registrada correctamente</p>
                </div>

                <p>Hola <strong>{$nombre}</strong>,</p>
                <p>Hemos recibido tu solicitud para contratar el plan <strong>{$plan}</strong>.</p>

                <div class='info-box'>
                    <h3>📋 Detalles de tu solicitud</h3>
                    <p><strong>Referencia:</strong> {$referencia}</p>
                    <p><strong>Plan:</strong> {$plan}</p>
                    <p><strong>Importe mensual:</strong> " . number_format($total, 2, ',', '.') . " € (IVA incluido)</p>
                    <p><strong>Fecha:</strong> " . date('d/m/Y H:i') . "</p>
                </div>

                <div class='steps'>
                    <h3>🚀 ¿Qué sigue ahora?</h3>
                    <ol>
                        <li><strong>En las próximas horas</strong> recibirás un email con las instrucciones de pago</li>
                        <li><strong>Puedes pagar</strong> por transferencia bancaria o tarjeta de crédito</li>
                        <li><strong>Una vez confirmado el pago</strong>, activaremos tu servicio en menos de 24 horas</li>
                        <li><strong>Recibirás los datos de acceso</strong> a tu panel de control cPanel</li>
                    </ol>
                </div>

                <div class='info-box'>
                    <h3>📞 ¿Necesitas ayuda?</h3>
                    <p>Nuestro equipo está disponible para ayudarte:</p>
                    <p><strong>Email:</strong> ventas@esenex.es<br>
                    <strong>WhatsApp:</strong> +34 697 764 254<br>
                    <strong>Horario:</strong> Lunes a Viernes, 9:00 - 18:00</p>
                </div>

                <p style='text-align:center; margin-top: 30px;'>
                    <a href='https://wa.me/34697764254?text=Hola, mi referencia es {$referencia}' class='btn'>Contactar por WhatsApp</a>
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

    mail($to, $subject, $body, $headers);

    // Enviar notificación al equipo de ventas
    $to_ventas = "ventas@esenex.es";
    $subject_ventas = "✓ NUEVA SOLICITUD CONFIRMADA - {$referencia}";

    $headers_ventas = "From: noreply@esenex.es\r\n";
    $headers_ventas .= "Reply-To: {$email}\r\n";
    $headers_ventas .= "MIME-Version: 1.0\r\n";
    $headers_ventas .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body_ventas = "
    <div style='background: #c6f6d5; padding: 20px; border-radius: 8px; margin-bottom: 20px;'>
        <h2 style='color: #22543d; margin: 0;'>✓ NUEVA SOLICITUD CONFIRMADA</h2>
    </div>
    
    <p><strong>Referencia:</strong> {$referencia}</p>
    <p><strong>Fecha:</strong> " . date('d/m/Y H:i') . "</p>
    <hr>
    
    <h3>Datos del Plan</h3>
    <p><strong>Plan:</strong> {$plan}<br>
    <strong>Precio mensual:</strong> " . number_format($contratacion['precio'], 2, ',', '.') . " €<br>
    <strong>IVA (21%):</strong> " . number_format($contratacion['iva'], 2, ',', '.') . " €<br>
    <strong>Total:</strong> " . number_format($total, 2, ',', '.') . " €/mes</p>

    <h3>Datos del Cliente</h3>
    <p><strong>Tipo:</strong> {$contratacion['tipo_cliente']}<br>
    <strong>Nombre:</strong> {$nombre} {$apellidos}<br>
    <strong>Razón Social:</strong> {$contratacion['razon_social']}<br>
    <strong>Documento:</strong> {$contratacion['documento']}<br>
    <strong>Actividad:</strong> {$contratacion['actividad']}</p>

    <h3>Contacto</h3>
    <p><strong>Email:</strong> {$email}<br>
    <strong>Teléfono:</strong> {$telefono}</p>

    <h3>Dirección</h3>
    <p>{$contratacion['direccion']}<br>
    {$contratacion['codigo_postal']} {$contratacion['ciudad']}<br>
    {$contratacion['provincia']}, España</p>

    <hr>
    <div style='background: #fff5f5; padding: 15px; border-left: 4px solid #f56565; margin: 20px 0;'>
        <p style='margin: 0; font-weight: bold;'>⚡ ACCIONES INMEDIATAS:</p>
        <ol style='margin: 10px 0 0 0; padding-left: 20px;'>
            <li>Contactar al cliente en las próximas 2-4 horas</li>
            <li>Enviar instrucciones de pago personalizadas</li>
            <li>Preparar cuenta de hosting para activación rápida</li>
        </ol>
    </div>
    
    <p><a href='https://wa.me/34{$telefono}?text=Hola {$nombre}, gracias por tu solicitud {$referencia}' style='display: inline-block; background: #25D366; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin-top: 10px;'>Contactar por WhatsApp</a></p>
    ";

    mail($to_ventas, $subject_ventas, $body_ventas, $headers_ventas);

    // Limpiar sesión después de confirmación exitosa
    unset($_SESSION['contratacion']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="images/logo_esenex.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Solicitud Confirmada! - Esenex Hosting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
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
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 650px;
            width: 100%;
            text-align: center;
        }
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: scaleIn 0.5s ease-out;
        }
        .success-icon i {
            font-size: 50px;
            color: white;
        }
        @keyframes scaleIn {
            0% { transform: scale(0); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        h1 {
            color: #22543d;
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        .subtitle {
            color: #718096;
            font-size: 18px;
            margin-bottom: 30px;
        }
        .reference-box {
            background: #f0fdf4;
            border: 2px solid #86efac;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
        }
        .reference-box .ref-label {
            font-size: 14px;
            color: #15803d;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .reference-box .ref-value {
            font-size: 24px;
            color: #166534;
            font-weight: 700;
            font-family: monospace;
        }
        .next-steps {
            background: #eff6ff;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
        }
        .next-steps h3 {
            color: #1e40af;
            font-size: 18px;
            margin-bottom: 15px;
            text-align: center;
        }
        .next-steps ol {
            margin: 0;
            padding-left: 25px;
            color: #1e3a8a;
        }
        .next-steps li {
            margin-bottom: 12px;
            font-size: 15px;
        }
        .next-steps li strong {
            color: #1e40af;
        }
        .action-buttons {
            margin: 30px 0;
        }
        .btn-whatsapp {
            background: #25D366;
            color: white;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-whatsapp:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
            color: white;
        }
        .btn-email {
            background: #3b82f6;
            color: white;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-email:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
            color: white;
        }
        .btn-home {
            background: transparent;
            border: 2px solid #48bb78;
            color: #48bb78;
            padding: 14px 30px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            transition: all 0.3s;
        }
        .btn-home:hover {
            background: #48bb78;
            color: white;
        }
        .contact-info {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
            color: #718096;
        }
        /* Optimización móvil */
        @media (max-width: 768px) {
            body {
                padding: 20px 10px;
            }
            .form-container {
                padding: 35px 25px;
            }
            h1 {
                font-size: 26px;
            }
            .subtitle {
                font-size: 16px;
            }
            .reference-box .ref-value {
                font-size: 20px;
            }
            .next-steps li {
                font-size: 14px;
            }
            .action-buttons {
                display: flex;
                flex-direction: column;
            }
            .btn-whatsapp, .btn-email, .btn-home {
                width: 100%;
                margin: 8px 0;
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
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1>¡Solicitud Confirmada!</h1>
        <p class="subtitle">Gracias por confiar en Esenex Hosting</p>

        <?php if (isset($referencia)): ?>
        <div class="reference-box">
            <div class="ref-label">Tu número de referencia:</div>
            <div class="ref-value"><?php echo $referencia; ?></div>
        </div>

        <div class="next-steps">
            <h3><i class="fas fa-rocket"></i> ¿Qué sigue ahora?</h3>
            <ol>
                <li><strong>Hemos enviado</strong> un email a <strong><?php echo $email; ?></strong> con todos los detalles</li>
                <li><strong>En las próximas horas</strong> nuestro equipo te contactará con las instrucciones de pago</li>
                <li><strong>Podrás pagar</strong> por transferencia bancaria o tarjeta de crédito</li>
                <li><strong>Una vez confirmado</strong> el pago, activaremos tu hosting en menos de 24 horas</li>
            </ol>
        </div>

        <div class="action-buttons">
            <a href="https://wa.me/34697764254?text=Hola%2C%20mi%20referencia%20es%20<?php echo $referencia; ?>" class="btn-whatsapp" target="_blank">
                <i class="fab fa-whatsapp"></i> Contactar por WhatsApp
            </a>
            <a href="mailto:ventas@esenex.es?subject=Referencia: <?php echo $referencia; ?>" class="btn-email">
                <i class="fas fa-envelope"></i> Enviar Email
            </a>
        </div>

        <a href="index.html" class="btn-home">
            <i class="fas fa-home"></i> Volver al Inicio
        </a>

        <div class="contact-info">
            <p><i class="fas fa-headset"></i> <strong>¿Necesitas ayuda inmediata?</strong></p>
            <p>Email: ventas@esenex.es<br>
            WhatsApp: +34 697 764 254<br>
            Horario: Lunes a Viernes, 9:00 - 18:00h</p>
        </div>

        <?php else: ?>
        <div class="alert alert-warning mt-4">
            <p><i class="fas fa-info-circle"></i> No se encontraron detalles de la solicitud.</p>
            <p>Si tienes alguna duda, por favor contacta con nuestro equipo.</p>
        </div>
        <a href="index.html" class="btn-home">Volver al Inicio</a>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2025 Esenex Hosting. Todos los derechos reservados.</p>
            <p class="mb-0">
                <a href="index.html" class="text-white me-3" style="text-decoration: none;">Inicio</a>
                <a href="sobre-nosotros.html" class="text-white me-3" style="text-decoration: none;">Sobre Nosotros</a>
                <a href="politica-privacidad.html" class="text-white me-3" style="text-decoration: none;">Política de Privacidad</a>
                <a href="index.html#contacto" class="text-white" style="text-decoration: none;">Contacto</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>