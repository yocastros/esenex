<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="images/logo_esenex.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Facturación - Esenex Hosting</title>
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
            max-width: 650px;
            width: 100%;
        }
        .plan-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #66b2cc;
        }
        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #66b2cc;
            box-shadow: 0 0 0 3px rgba(102, 178, 204, 0.2);
        }
        .btn-primary {
            background: linear-gradient(135deg, #66b2cc 0%, #4a90a4 100%);
            border: none;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            margin-top: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 178, 204, 0.4);
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #66b2cc;
            text-decoration: none;
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
            width: 40px;
            height: 3px;
            background: #e2e8f0;
            margin-top: 16px;
        }
        .section-title {
            font-size: 14px;
            text-transform: uppercase;
            color: #66b2cc;
            font-weight: 700;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e8f0;
        }
    </style>
</head>
<?php
// Verificar si venimos de resumen.php con datos para editar
$datos_editar = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos_editar = [
        'nombre' => $_POST['nombre'] ?? '',
        'apellidos' => $_POST['apellidos'] ?? '',
        'email' => $_POST['email'] ?? '',
        'telefono' => $_POST['telefono'] ?? '',
        'razon_social' => $_POST['razon_social'] ?? '',
        'actividad' => $_POST['actividad'] ?? '',
        'direccion' => $_POST['direccion'] ?? '',
        'codigo_postal' => $_POST['codigo_postal'] ?? '',
        'ciudad' => $_POST['ciudad'] ?? '',
        'provincia' => $_POST['provincia'] ?? '',
        'plan' => $_POST['plan'] ?? '',
        'precio' => $_POST['precio'] ?? '',
        'documento' => $_POST['documento'] ?? '',
        'tipo_cliente' => $_POST['tipo_cliente'] ?? ''
    ];
}
?>
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
            <div class="step-line"></div>
            <div class="step">3</div>
            <div class="step-line"></div>
            <div class="step">4</div>
        </div>

        <h2 class="text-center mb-4">Datos de Facturación</h2>

        <div class="plan-info">
            <div class="row">
                <div class="col-6">
                    <small class="text-muted">Plan</small>
                    <p class="mb-0 fw-bold" id="selected-plan">-</p>
                </div>
                <div class="col-6 text-end">
                    <small class="text-muted">Precio/mes</small>
                    <p class="mb-0 fw-bold text-primary" id="selected-precio">-</p>
                </div>
            </div>
        </div>

        <form action="resumen.php" method="POST">
            <div class="section-title"><i class="fas fa-user"></i> Información de Contacto</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required
                           placeholder="Tu nombre"
                           value="<?php echo isset($datos_editar['nombre']) ? htmlspecialchars($datos_editar['nombre']) : ''; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="apellidos" class="form-label">Apellidos *</label>
                    <input type="text" id="apellidos" name="apellidos" class="form-control" required
                           placeholder="Tus apellidos"
                           value="<?php echo isset($datos_editar['apellidos']) ? htmlspecialchars($datos_editar['apellidos']) : ''; ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Correo Electrónico *</label>
                    <input type="email" id="email" name="email" class="form-control" required
                           placeholder="ejemplo@correo.com"
                           value="<?php echo isset($datos_editar['email']) ? htmlspecialchars($datos_editar['email']) : ''; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telefono" class="form-label">Teléfono *</label>
                    <input type="tel" id="telefono" name="telefono" class="form-control" required
                           placeholder="+34 612 345 678" pattern="^\+34\s?\d{3}\s?\d{3}\s?\d{3}$"
                           value="<?php echo isset($datos_editar['telefono']) ? htmlspecialchars($datos_editar['telefono']) : ''; ?>">
                    <div class="form-text">Formato: +34 612 345 678</div>
                </div>
            </div>

            <div class="section-title"><i class="fas fa-building"></i> Datos de la Empresa (si aplica)</div>

            <div class="mb-3">
                <label for="razon_social" class="form-label">Razón Social / Nombre Completo *</label>
                <input type="text" id="razon_social" name="razon_social" class="form-control" required
                       placeholder="Nombre para facturación"
                       value="<?php echo isset($datos_editar['razon_social']) ? htmlspecialchars($datos_editar['razon_social']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="actividad" class="form-label">Actividad / Sector</label>
                <input type="text" id="actividad" name="actividad" class="form-control"
                       placeholder="Ej: Comercio electrónico, Consultoría..."
                       value="<?php echo isset($datos_editar['actividad']) ? htmlspecialchars($datos_editar['actividad']) : ''; ?>">
            </div>

            <div class="section-title"><i class="fas fa-map-marker-alt"></i> Dirección de Facturación</div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección *</label>
                <input type="text" id="direccion" name="direccion" class="form-control" required
                       placeholder="Calle, número, piso, puerta"
                       value="<?php echo isset($datos_editar['direccion']) ? htmlspecialchars($datos_editar['direccion']) : ''; ?>">
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="codigo_postal" class="form-label">Código Postal *</label>
                    <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" required
                           placeholder="28001" pattern="^\d{5}$" maxlength="5"
                           value="<?php echo isset($datos_editar['codigo_postal']) ? htmlspecialchars($datos_editar['codigo_postal']) : ''; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ciudad" class="form-label">Ciudad *</label>
                    <input type="text" id="ciudad" name="ciudad" class="form-control" required
                           placeholder="Madrid"
                           value="<?php echo isset($datos_editar['ciudad']) ? htmlspecialchars($datos_editar['ciudad']) : ''; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="provincia" class="form-label">Provincia *</label>
                    <select id="provincia" name="provincia" class="form-select" required>
                        <?php
                        $provincias = [
                            'A Coruña', 'Álava', 'Albacete', 'Alicante', 'Almería', 'Asturias', 'Ávila',
                            'Badajoz', 'Baleares', 'Barcelona', 'Burgos', 'Cáceres', 'Cádiz', 'Cantabria',
                            'Castellón', 'Ciudad Real', 'Córdoba', 'Cuenca', 'Girona', 'Granada', 'Guadalajara',
                            'Gipuzkoa', 'Huelva', 'Huesca', 'Jaén', 'La Rioja', 'Las Palmas', 'León', 'Lleida',
                            'Lugo', 'Madrid', 'Málaga', 'Murcia', 'Navarra', 'Ourense', 'Palencia', 'Pontevedra',
                            'Salamanca', 'Santa Cruz de Tenerife', 'Segovia', 'Sevilla', 'Soria', 'Tarragona',
                            'Teruel', 'Toledo', 'Valencia', 'Valladolid', 'Vizcaya', 'Zamora', 'Zaragoza'
                        ];
                        $provincia_seleccionada = $datos_editar['provincia'] ?? '';
                        foreach ($provincias as $prov) {
                            $selected = ($provincia_seleccionada === $prov) ? 'selected' : '';
                            echo "<option value=\"$prov\" $selected>$prov</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Campo para mostrar el documento (solo lectura) -->
            <div class="mb-3">
                <label class="form-label">Documento de Identificación</label>
                <input type="text" class="form-control" id="display-documento" readonly style="background-color: #f8f9fa;">
                <input type="hidden" name="documento" id="hidden-documento">
            </div>

            <!-- Campos ocultos -->
            <input type="hidden" name="plan" id="hidden-plan">
            <input type="hidden" name="precio" id="hidden-precio">
            <input type="hidden" name="tipo_cliente" id="hidden-tipo-cliente">

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-arrow-right"></i> Continuar al Resumen
            </button>
        </form>

        <a href="contratar.html" class="back-link">← Volver al paso anterior</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        <?php if (!empty($datos_editar)): ?>
        // Si venimos de resumen.php (modificar datos), usar los datos POST
        const plan = "<?php echo $datos_editar['plan']; ?>";
        const precio = "<?php echo $datos_editar['precio']; ?>";
        const documento = "<?php echo $datos_editar['documento']; ?>";
        const tipoCliente = "<?php echo $datos_editar['tipo_cliente']; ?>";

        // Actualizar sessionStorage con los datos recibidos
        sessionStorage.setItem("plan", plan);
        sessionStorage.setItem("precio", precio);
        sessionStorage.setItem("documento", documento);
        sessionStorage.setItem("tipo_cliente", tipoCliente);

        <?php else: ?>
        // Si es entrada normal, obtener de sessionStorage
        const plan = sessionStorage.getItem("plan");
        const precio = sessionStorage.getItem("precio");
        const documento = sessionStorage.getItem("documento");
        const tipoCliente = sessionStorage.getItem("tipo_cliente");

        // Redirigir si no hay datos
        if (!plan || !documento) {
            alert("Por favor, completa el paso anterior");
            window.location.href = "contratar.html";
        }
        <?php endif; ?>

        // Formatear el precio en EUR
        const precioFormateado = new Intl.NumberFormat('es-ES', {
            style: 'currency',
            currency: 'EUR',
            minimumFractionDigits: 2
        }).format(precio);

        // Mostrar valores
        document.getElementById('selected-plan').textContent = plan;
        document.getElementById('selected-precio').textContent = precioFormateado;

        // Mostrar documento en campo de solo lectura
        const tipoDocText = {
            'autonomo': 'NIF (Autónomo)',
            'empresa': 'CIF (Empresa)',
            'particular': 'NIF (Particular)',
            'extranjero': 'NIE (Extranjero Residente)'
        };
        document.getElementById('display-documento').value = documento + ' - ' + (tipoDocText[tipoCliente] || tipoCliente);

        // Pasar datos como campos ocultos
        document.getElementById('hidden-plan').value = plan;
        document.getElementById('hidden-precio').value = precio;
        document.getElementById('hidden-documento').value = documento;
        document.getElementById('hidden-tipo-cliente').value = tipoCliente;

        // Formatear teléfono automáticamente (solo si el campo está vacío)
        const telefonoInput = document.getElementById('telefono');
        if (!telefonoInput.value) {
            telefonoInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('34')) {
                    value = value.substring(2);
                }
                if (value.length > 0) {
                    e.target.value = '+34 ' + value.match(/.{1,3}/g).join(' ').trim();
                }
            });
        }
    </script>
</body>
</html>
