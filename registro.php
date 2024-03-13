<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="stylesheet" href="css/registro.css"/>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-bar-chart-alt-2 icon'></i>
                            <span class="text nav-text">Listado</span>
                        </a>
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
        <div class="text">REGISTRO NUEVO</div>
        <section class="container">
            <header>Registration Form</header>
            <form action="#" class="form" method="POST">
                <div class="input-box">
                    <label>Nombre Completo</label>
                    <input type="text" name="nombre" placeholder="Ingresa el Nombre Completo" required />
                </div>

                <div class="input-box">
                    <label>Correo Electrónico</label>
                    <input type="email" name="correo" placeholder="Ingresa el correo institucional" required />
                </div>

                <div class="column">
                    <div class="input-box">
                        <label>Numero Telefónico (Max 10 dígitos)</label>
                        <input type="text" name="numtel" pattern="\d{10}" placeholder="Ingresa numero telefónico" required />
                    </div>
                    <div class="input-box">
                        <label>Día de Nacimiento (Debes ser mayor de 17 años)</label>
                        <input type="date" name="nacimiento" required />
                    </div>
                </div>
                <div class="gender-box">
                    <h3>Género</h3>
                    <div class="gender-option">
                        <div class="gender">
                            <input type="radio" id="check-male" name="genero" value="Hombre" checked />
                            <label for="check-male">Hombre</label>
                        </div>
                        <div class="gender">
                            <input type="radio" id="check-female" name="genero" value="Mujer" />
                            <label for="check-female">Mujer</label>
                        </div>
                        <div class="gender">
                            <input type="radio" id="check-other" name="genero" value="Prefiero no decirlo" />
                            <label for="check-other">Prefiero no decirlo</label>
                        </div>
                    </div>
                </div>
                <div class="input-box address">
                    <label>Matrícula</label>
                    <input type="text" name="matricula" placeholder="Ingresa la matrícula" required />
                </div>
                <div class="input-box address">
                    <label>Contraseña</label>
                    <input type="password" name="contrasena" placeholder="Ingresa la contraseña" required />
                </div>
                <div class="input-box address">
                    <label>Rol</label>
                    <div class="column">
                        <div class="select-box">
                            <select name="rol">
                                <option hidden>Selecciona un rol</option>
                                <option value="Maestro">Maestro</option>
                                <option value="Alumno">Alumno</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit">Ingresar</button>
            </form>
        </section>
    </section>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once "db_conexion.php";

        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $numtel = $_POST['numtel'];
        $nacimiento = $_POST['nacimiento'];
        $genero = $_POST['genero'];
        $rol = $_POST['rol'];
        $matricula = $_POST['matricula'];
        $contrasena = $_POST['contrasena'];

if (strlen($numtel) != 10) {
    echo "<script>swal('Error', 'El número de teléfono debe tener exactamente 10 dígitos', 'error');</script>";
    exit();
}

$hoy = new DateTime();
$fecha_nacimiento = new DateTime($nacimiento);
$edad = $hoy->diff($fecha_nacimiento)->y;
if ($edad < 17) {
    echo "<script>swal('Error', 'Debes ser mayor de 17 años para registrarte', 'error');</script>";
    exit();
}

if ($conexion->query($query) === TRUE) {
    echo "<script>swal('Éxito', 'Usuario agregado correctamente', 'success');</script>";
} else {
    echo "<script>swal('Error', 'Error al agregar usuario: " . $conexion->error . "', 'error');</script>";
}

        if ($rol === 'Maestro') {
            $query = "INSERT INTO maestros (nombre, correo, numtel, nacimiento, genero, matricula, contrasena) VALUES ('$nombre', '$correo', '$numtel', '$nacimiento', '$genero', '$matricula', '$contrasena')";
        } elseif ($rol === 'Alumno') {
            $query = "INSERT INTO alumnos (nombre, correo, numtel, nacimiento, genero, matricula, contrasena) VALUES ('$nombre', '$correo', '$numtel', '$nacimiento', '$genero', '$matricula', '$contrasena')";
        }

        $conexion->close();
    }
    ?>

    <script src="js/index.js"></script>
</body>
</html>