<?php
// Establecer la información de la base de datos
$servidor = "localhost";
$usuario = "root"; // Reemplaza 'tu_usuario' con el nombre de usuario de MySQL
$contrasena = ""; // Reemplaza 'tu_contraseña' con la contraseña de MySQL
$basededatos = "bd_tiempo";

try {
    // Conectar a la base de datos
    $conexion = new mysqli($servidor, $usuario, $contrasena, $basededatos);

    if ($conexion->connect_error) {
        throw new Exception("Conexión fallida: " . $conexion->connect_error);
    }

    // Recuperar lista de maestros con fecha y hora de entrada
    $sqlMaestros = "SELECT nombre, apellidos, fecha_entrada, hora_entrada FROM maestros";
    $resultadoMaestros = $conexion->query($sqlMaestros);

    $nombresMaestros = [];
    while ($filaMaestros = $resultadoMaestros->fetch_assoc()) {
        $nombresMaestros[] = $filaMaestros['nombre'] . " " . $filaMaestros['apellidos'] . " - Entrada: " . $filaMaestros['fecha_entrada'] . " " . $filaMaestros['hora_entrada'];
    }

    // Recuperar lista de alumnos con fecha y hora de entrada
    $sqlAlumnos = "SELECT nombre, apellidos, fecha_entrada, hora_entrada FROM alumnos";
    $resultadoAlumnos = $conexion->query($sqlAlumnos);

    $nombresAlumnos = [];
    while ($filaAlumnos = $resultadoAlumnos->fetch_assoc()) {
        $nombresAlumnos[] = $filaAlumnos['nombre'] . " " . $filaAlumnos['apellidos'] . " - Entrada: " . $filaAlumnos['fecha_entrada'] . " " . $filaAlumnos['hora_entrada'];
    }

    $conexion->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Entrada</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/stylesTm.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <section class="casa">
        <div class="text">Inicio</div>
    <section class="data-section">
        <h2>Lista de Maestros</h2>
        <ul>
            <?php
            foreach ($nombresMaestros as $nombreMaestro) {
                echo "<li>" . $nombreMaestro . "</li>";
            }
            ?>
        </ul>

        <h3>Gráfica de Faltas de Maestros</h3>
        <canvas id="faltas-maestros-chart" width="400" height="200"></canvas>
    </section>

    <section class="data-section">
        <h2>Lista de Alumnos</h2>
        <ul>
            <?php
            foreach ($nombresAlumnos as $nombreAlumno) {
                echo "<li>" . $nombreAlumno . "</li>";
            }
            ?>
        </ul>

        <h3>Gráfica de Faltas de Alumnos</h3>
        <canvas id="faltas-alumnos-chart" width="400" height="200"></canvas>
    </section>
</div>
</section>


<script src="js/index.js"></script>
<script>
    // Obtener el contexto del lienzo para la gráfica de faltas de maestros
    var faltasMaestrosCanvas = document.getElementById('faltas-maestros-chart').getContext('2d');
    var faltasMaestrosChart = new Chart(faltasMaestrosCanvas, {
        type: 'pie',
        data: {
            labels: ['Faltas', 'Asistencias'],
            datasets: [{
                label: 'Faltas vs Asistencias de Maestros',
                data: [2, 8], // Datos de ejemplo para faltas y asistencias de maestros
                backgroundColor: ['red', 'green']
            }]
        },
        options: {
            responsive: true
        }
    });

    // Obtener el contexto del lienzo para la gráfica de faltas de alumnos
    var faltasAlumnosCanvas = document.getElementById('faltas-alumnos-chart').getContext('2d');
    var faltasAlumnosChart = new Chart(faltasAlumnosCanvas, {
        type: 'pie',
        data: {
            labels: ['Faltas', 'Asistencias'],
            datasets: [{
                label: 'Faltas vs Asistencias de Alumnos',
                data: [1, 9], // Datos de ejemplo para faltas y asistencias de alumnos
                backgroundColor: ['red', 'green']
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
</body>
</html>

