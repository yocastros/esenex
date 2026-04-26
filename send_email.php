<?php
/**
 * send_email.php
 * Procesa el formulario de contacto de index.html
 * Envía el mensaje a ventas@esenex.es y una confirmación al remitente
 */

// --- Configuración ---
define('DESTINATARIO',  'ventas@esenex.es');
define('REMITENTE',     'noreply@esenex.es');
define('SITIO_URL',     'https://esenex.es');
define('SITIO_NOMBRE',  'Esenex Hosting');

// --- Helpers ---
function redirigir(string $status): void {
    header('Location: index.html?status=' . $status . '#contacto');
    exit;
}

function limpiar(string $valor): string {
    return htmlspecialchars(strip_tags(trim($valor)), ENT_QUOTES, 'UTF-8');
}

// --- Solo aceptar POST ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirigir('invalid');
}

// --- Recoger y validar campos ---
$nombre  = limpiar($_POST['name']    ?? '');
$email   = filter_var(trim($_POST['email']   ?? ''), FILTER_VALIDATE_EMAIL);
$mensaje = limpiar($_POST['message'] ?? '');

if (empty($nombre) || !$email || empty($mensaje)) {
    redirigir('invalid');
}

// Protección básica anti-spam: bloquear saltos de línea en campos de texto corto
if (preg_match('/[\r\n]/', $nombre)) {
    redirigir('invalid');
}

$fecha = date('d/m/Y H:i');


// =====================================================================
// 1. CORREO INTERNO — notificación al equipo de ventas
// =====================================================================
$asunto_interno = "Nuevo mensaje de contacto - {$nombre}";

$headers_internos  = "From: " . REMITENTE . "\r\n";
$headers_internos .= "Reply-To: {$email}\r\n";
$headers_internos .= "MIME-Version: 1.0\r\n";
$headers_internos .= "Content-Type: text/html; charset=UTF-8\r\n";

$cuerpo_interno = "
<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <style>
    body  { font-family: Arial, sans-serif; color: #333; background: #f4f7f9; margin: 0; padding: 20px; }
    .wrap { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .hdr  { background: linear-gradient(135deg, #66b2cc 0%, #4a90a4 100%);
            padding: 28px 30px; text-align: center; }
    .hdr img { max-width: 130px; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto; }
    .hdr h1 { color: #fff; margin: 0; font-size: 20px; }
    .body { padding: 30px; }
    .badge { display: inline-block; background: #e6f4ff; color: #2c5282;
             font-size: 12px; font-weight: 700; letter-spacing: .05em;
             padding: 4px 12px; border-radius: 20px; margin-bottom: 20px; }
    .field { margin-bottom: 18px; }
    .field label { display: block; font-size: 12px; font-weight: 700;
                   text-transform: uppercase; color: #718096; margin-bottom: 4px; }
    .field p { margin: 0; background: #f8fafc; border: 1px solid #e2e8f0;
               border-radius: 8px; padding: 12px 15px; font-size: 15px; line-height: 1.6; }
    .actions { background: #fff8e1; border: 1px solid #ffe082; border-radius: 8px;
               padding: 16px 20px; margin-top: 24px; }
    .actions p { margin: 0 0 8px; font-weight: 700; color: #7c5f00; font-size: 14px; }
    .actions ol { margin: 0; padding-left: 18px; color: #555; font-size: 14px; }
    .btn { display: inline-block; background: #25D366; color: #fff !important;
           padding: 11px 26px; text-decoration: none; border-radius: 6px;
           font-weight: 700; font-size: 14px; margin-top: 16px; }
    .ftr { text-align: center; padding: 20px; color: #a0aec0; font-size: 12px;
           border-top: 1px solid #e2e8f0; }
  </style>
</head>
<body>
  <div class='wrap'>
    <div class='hdr'>
      <img src='" . SITIO_URL . "/images/logo_esenex.png' alt='" . SITIO_NOMBRE . "'>
      <h1>Nuevo mensaje de contacto</h1>
    </div>
    <div class='body'>
      <span class='badge'>📬 FORMULARIO WEB · {$fecha}</span>

      <div class='field'>
        <label>Nombre</label>
        <p>{$nombre}</p>
      </div>
      <div class='field'>
        <label>Email</label>
        <p><a href='mailto:{$email}'>{$email}</a></p>
      </div>
      <div class='field'>
        <label>Mensaje</label>
        <p>" . nl2br($mensaje) . "</p>
      </div>

      <div class='actions'>
        <p>⚡ Acciones recomendadas:</p>
        <ol>
          <li>Responder al cliente en menos de 24 horas</li>
          <li>Usar Reply-To para responder directamente a {$email}</li>
        </ol>
      </div>
    </div>
    <div class='ftr'>
      " . SITIO_NOMBRE . " · <a href='mailto:" . DESTINATARIO . "'>" . DESTINATARIO . "</a> · +34 697 764 254
    </div>
  </div>
</body>
</html>
";

$enviado_interno = mail(DESTINATARIO, $asunto_interno, $cuerpo_interno, $headers_internos);


// =====================================================================
// 2. CORREO AL CLIENTE — acuse de recibo
// =====================================================================
$asunto_cliente = "Hemos recibido tu mensaje - " . SITIO_NOMBRE;

$headers_cliente  = "From: " . REMITENTE . "\r\n";
$headers_cliente .= "Reply-To: " . DESTINATARIO . "\r\n";
$headers_cliente .= "MIME-Version: 1.0\r\n";
$headers_cliente .= "Content-Type: text/html; charset=UTF-8\r\n";

$cuerpo_cliente = "
<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <style>
    body  { font-family: Arial, sans-serif; color: #333; background: #f4f7f9; margin: 0; padding: 20px; }
    .wrap { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .hdr  { background: linear-gradient(135deg, #66b2cc 0%, #4a90a4 100%);
            padding: 28px 30px; text-align: center; }
    .hdr img { max-width: 130px; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto; }
    .hdr h1 { color: #fff; margin: 0; font-size: 22px; }
    .hdr p  { color: rgba(255,255,255,0.85); margin: 8px 0 0; font-size: 14px; }
    .body { padding: 30px; }
    .ok-box { background: #e6fffa; border: 1px solid #81e6d9; border-radius: 10px;
              padding: 20px 24px; margin-bottom: 24px; text-align: center; }
    .ok-box h2 { color: #234e52; margin: 0 0 6px; font-size: 18px; }
    .ok-box p  { color: #2c7a7b; margin: 0; font-size: 14px; }
    .msg-box { background: #f8fafc; border-left: 4px solid #66b2cc; border-radius: 6px;
               padding: 16px 20px; margin-bottom: 24px; }
    .msg-box p { margin: 0; color: #555; font-size: 14px; line-height: 1.7; }
    .info { font-size: 14px; color: #555; line-height: 1.8; }
    .info strong { color: #2d3748; }
    .btn { display: inline-block; background: #66b2cc; color: #fff !important;
           padding: 12px 28px; text-decoration: none; border-radius: 6px;
           font-weight: 700; font-size: 14px; margin-top: 20px; }
    .ftr { text-align: center; padding: 20px; color: #a0aec0; font-size: 12px;
           border-top: 1px solid #e2e8f0; }
    .ftr a { color: #66b2cc; text-decoration: none; }
  </style>
</head>
<body>
  <div class='wrap'>
    <div class='hdr'>
      <img src='" . SITIO_URL . "/images/logo_esenex.png' alt='" . SITIO_NOMBRE . "'>
      <h1>¡Mensaje recibido!</h1>
      <p>Nos pondremos en contacto contigo pronto</p>
    </div>
    <div class='body'>
      <div class='ok-box'>
        <h2>✓ Tu mensaje ha llegado correctamente</h2>
        <p>Recibirás respuesta en menos de 24 horas en días laborables</p>
      </div>

      <p class='info'>Hola <strong>{$nombre}</strong>,</p>
      <p class='info'>
        Gracias por contactar con <strong>" . SITIO_NOMBRE . "</strong>. Hemos recibido tu mensaje
        y nuestro equipo lo revisará lo antes posible.
      </p>

      <p class='info' style='margin-top:16px;'><strong>Tu mensaje:</strong></p>
      <div class='msg-box'>
        <p>" . nl2br($mensaje) . "</p>
      </div>

      <p class='info'>
        Si necesitas atención urgente puedes contactarnos directamente:<br>
        <strong>Email:</strong> <a href='mailto:" . DESTINATARIO . "'>" . DESTINATARIO . "</a><br>
        <strong>WhatsApp:</strong> +34 697 764 254<br>
        <strong>Horario:</strong> Lunes a viernes, 9:00 – 18:00
      </p>

      <div style='text-align:center; margin-bottom:12px;'>
        <a class='btn' href='https://wa.me/34697764254?text=Hola,+he+enviado+un+mensaje+de+contacto+en+Esenex+Hosting'
           style='background:#25D366;'>WhatsApp</a>
      </div>

      <div style='text-align:center;'>
        <a class='btn' href='" . SITIO_URL . "#planes-hosting'>Ver nuestros planes</a>
      </div>
    </div>
    <div class='ftr'>
      <a href='" . SITIO_URL . "'>" . SITIO_NOMBRE . "</a> · 
      <a href='mailto:" . DESTINATARIO . "'>" . DESTINATARIO . "</a> · 
      +34 697 764 254
    </div>
  </div>
</body>
</html>
";

mail($email, $asunto_cliente, $cuerpo_cliente, $headers_cliente);


// --- Responder según resultado (fetch espera una respuesta 200) ---
http_response_code($enviado_interno ? 200 : 500);
exit;
