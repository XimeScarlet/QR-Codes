<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>INDEX</title>
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
                <a href="Inicio.php">
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
    </section>
    <script src="js/index.js"></script>
</body>
</html>