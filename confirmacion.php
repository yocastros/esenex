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
            <a href="index.html" class="btn">Volver al Inicio</a>
        </div>
    </div>
</body>
</html>
