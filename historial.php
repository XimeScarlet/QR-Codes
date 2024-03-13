<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basededatos = "bd_tiempo";

// Variable para almacenar los datos de la tabla
$tablaHTML = '';

// Variable para almacenar los datos para el CSV
$csvData = "Nombre,Tipo,Fecha\n";

// Verificar si se ha enviado una fecha y hora desde el formulario
if(isset($_POST['datetime']) && !isset($_GET['download'])) {
    $datetime = $_POST['datetime'];

    // Formatear la fecha y hora para que coincida con el formato esperado por MySQL
    $formattedDatetime = date("Y-m-d H:i:s", strtotime($datetime));

    try {
        $conexion = new mysqli($servidor, $usuario, $contrasena, $basededatos);

        if ($conexion->connect_error) {
            throw new Exception("Conexión fallida: " . $conexion->connect_error);
        }

        // Consulta para obtener registros de asistencia y faltas para la fecha y hora proporcionadas
        $sqlAlumnos = "SELECT nombre, 'alumnos' AS tipo, fecha_entrada FROM alumnos WHERE CONCAT(fecha_entrada, ' ', hora_entrada) = '$formattedDatetime'";
        $resultadoAlumnos = $conexion->query($sqlAlumnos);

        $sqlMaestros = "SELECT nombre, 'maestros' AS tipo, fecha_entrada FROM maestros WHERE CONCAT(fecha_entrada, ' ', hora_entrada) = '$formattedDatetime'";
        $resultadoMaestros = $conexion->query($sqlMaestros);

        // Mostrar los registros en una tabla
        if ($resultadoAlumnos->num_rows > 0 || $resultadoMaestros->num_rows > 0) {
            $tablaHTML .= "<h2>Registros para la fecha y hora: $datetime</h2>";
            $tablaHTML .= "<table border='1'>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Fecha y Hora</th>
                    </tr>";

            // Mostrar registros de alumnos y agregar al CSV
            while ($fila = $resultadoAlumnos->fetch_assoc()) {
                $tablaHTML .= "<tr>";
                $tablaHTML .= "<td>" . $fila['nombre'] . "</td>";
                $tablaHTML .= "<td>" . $fila['tipo'] . "</td>";
                $tablaHTML .= "<td>" . $fila['fecha_entrada'] . "</td>";
                $tablaHTML .= "</tr>";
                $csvData .= $fila['nombre'] . ',' . $fila['tipo'] . ',' . $fila['fecha_entrada'] . "\n";
            }

            // Mostrar registros de maestros y agregar al CSV
            while ($fila = $resultadoMaestros->fetch_assoc()) {
                $tablaHTML .= "<tr>";
                $tablaHTML .= "<td>" . $fila['nombre'] . "</td>";
                $tablaHTML .= "<td>" . $fila['tipo'] . "</td>";
                $tablaHTML .= "<td>" . $fila['fecha_entrada'] . "</td>";
                $tablaHTML .= "</tr>";
                $csvData .= $fila['nombre'] . ',' . $fila['tipo'] . ',' . $fila['fecha_entrada'] . "\n";
            }

            $tablaHTML .= "</table>";
        } else {
            $tablaHTML .= "No se encontraron registros para la fecha y hora: $datetime";
        }

        $conexion->close();
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

// Si se solicita la descarga del CSV
if (isset($_GET['download'])) {
    // Redirigir al archivo CSV para descargar
    header("Content-Type: application/csv");
    header("Content-Disposition: attachment; filename=fechas_buscadas.csv");
    echo $csvData;
    exit();
}

// Mostrar todos los registros
if(isset($_GET['showall'])) {
    try {
        $conexion = new mysqli($servidor, $usuario, $contrasena, $basededatos);

        if ($conexion->connect_error) {
            throw new Exception("Conexión fallida: " . $conexion->connect_error);
        }

        // Consulta para obtener todos los registros de asistencia y faltas
        $sqlAlumnos = "SELECT nombre, 'alumnos' AS tipo, fecha_entrada FROM alumnos";
        $resultadoAlumnos = $conexion->query($sqlAlumnos);

        $sqlMaestros = "SELECT nombre, 'maestros' AS tipo, fecha_entrada FROM maestros";
        $resultadoMaestros = $conexion->query($sqlMaestros);

        // Mostrar los registros en una tabla
        if ($resultadoAlumnos->num_rows > 0 || $resultadoMaestros->num_rows > 0) {
            $tablaHTML .= "<h2>Todos los Registros</h2>";
            $tablaHTML .= "<table border='1'>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Fecha y Hora</th>
                    </tr>";

            // Mostrar registros de alumnos y agregar al CSV
            while ($fila = $resultadoAlumnos->fetch_assoc()) {
                $tablaHTML .= "<tr>";
                $tablaHTML .= "<td>" . $fila['nombre'] . "</td>";
                $tablaHTML .= "<td>" . $fila['tipo'] . "</td>";
                $tablaHTML .= "<td>" . $fila['fecha_entrada'] . "</td>";
                $tablaHTML .= "</tr>";
                $csvData .= $fila['nombre'] . ',' . $fila['tipo'] . ',' . $fila['fecha_entrada'] . "\n";
            }

            // Mostrar registros de maestros y agregar al CSV
            while ($fila = $resultadoMaestros->fetch_assoc()) {
                $tablaHTML .= "<tr>";
                $tablaHTML .= "<td>" . $fila['nombre'] . "</td>";
                $tablaHTML .= "<td>" . $fila['tipo'] . "</td>";
                $tablaHTML .= "<td>" . $fila['fecha_entrada'] . "</td>";
                $tablaHTML .= "</tr>";
                $csvData .= $fila['nombre'] . ',' . $fila['tipo'] . ',' . $fila['fecha_entrada'] . "\n";
            }

            $tablaHTML .= "</table>";
        } else {
            $tablaHTML .= "No se encontraron registros.";
        }

        $conexion->close();
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesHL.css">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Historial de Faltas y Asistencias</title>
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <img src="img/logo.png" alt="logo">
                <div class="text header-text">
                    <span class="nombre">INICIO</span>
                    <span class="rol">ADMIN</span>
                </div>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Buscar...">
                </li>
                <ul class="menu-links">
                <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-pie-chart-alt icon'></i>
                            <span class="text nav-text">Perfil</span>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-bar-chart-alt-2 icon'></i>
                            <span class="text nav-text">Listado</span>
                    </li>
                    <li class="nav-link">
                        <a href="tiempor.php">
                            <i class='bx bx-pie-chart-alt icon'></i>
                            <span class="text nav-text">Tiempo Real</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="confi.php">
                            <i class='bx bx-pie-chart-alt icon'></i>
                            <span class="text nav-text">Configuración</span>
                    </li>
                    <li class="nav-link">
                        <a href="historial.php">
                            <i class='bx bx-heart icon'></i>
                            <span class="text nav-text">Historial</span>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="#">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Cerrar Sesión</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="moon-sun">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Modo Obscuro</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>
        
    </nav>
<div class="container">
    
    <div id="busqueda-section">
        <h2>Búsqueda por Fecha y Hora</h2>
        <form action="historial.php" method="post">
            <label for="datetime">Fecha y Hora:</label>
            <input type="datetime-local" id="datetime" name="datetime">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <!-- Agregar botón para descargar CSV -->
    <div>
        <button type="button" onclick="window.location.href='historial.php?download=true'">Descargar CSV</button>
    </div>

    <!-- Agregar botón para mostrar todos los registros -->
    <div>
        <button type="button" onclick="window.location.href='historial.php?showall=true'">Mostrar Todos los Registros</button>
    </div>

    <!-- Mostrar la tabla con los datos -->
    <?php echo $tablaHTML; ?>
</div>
</section>
    <script src="js/index.js"></script>
</body>
</html>
