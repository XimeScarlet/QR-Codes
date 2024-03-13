<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Configuración</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/stylesCn.css">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="js/whatsapp.js"></script>
</head>
<body>
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
                            <span class="text nav-text" onclick="showAlertas()">Alertas</span>
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
        <div class="text">CONFIGURACIÓN</div>
        <div class="container">
        <div class="btn-container">
        <button class="btn full-width" onclick="alertaHuellasAcceso()">Permitir Huellas de Acceso</button>
        <button class="btn full-width" onclick="window.location.href = 'registro.php'">Nuevo Registro</button>
        <button class="btn" onclick="enviarCorreo()">Enviar Correo de Aceptación</button>
        <button class="btn" onclick="bloquearAcceso()">Bloquear Acceso</button>

        </div>
        <div id="config-container">
            <button class="btn" onclick="configurarAlertasWhatsApp()">Configurar Alertas por WhatsApp</button>
        </div>
    </div>
    </section>
    <script src="js/index.js"></script>
    <script>
        function showAlertas() {
            Swal.fire({
                title: 'Selecciona el método de envío de alertas',
                html:
                    '<select id="alertMethod" class="swal2-input">' +
                    '<option value="whatsapp">WhatsApp</option>' +
                    '<option value="correo">Correo</option>' +
                    '</select>',
                showCancelButton: true,
                confirmButtonText: 'Enviar ahí Alerta',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const selectedMethod = document.getElementById('alertMethod').value;
                    console.log('Método seleccionado:', selectedMethod);
                    return true;
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        }

        function alertaHuellasAcceso() {
            const { value: nombre } = Swal.fire({
                title: 'Permitir Huellas de Acceso',
                input: 'text',
                inputLabel: 'Nombre de la persona:',
                inputPlaceholder: 'Ingrese el nombre',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Sí, permitir',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: (nombre) => {
                    return fetch(`/permitirHuellasAcceso?nombre=${nombre}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Request failed: ${error}`
                            )
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    showAlertas();
                    Swal.fire(
                        '¡Permitido!',
                        `Las huellas de acceso de ${nombre} están habilitadas para acceder a la institución.`,
                        'success'
                    );
                }
            });
        }

        function enviarCorreo() {
            const { value: nombre } = Swal.fire({
                title: 'Enviar Correo de Aceptación',
                input: 'text',
                inputLabel: 'Nombre del alumno:',
                inputPlaceholder: 'Ingrese el nombre',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Debe ingresar un nombre'
                    }
                }
            });

            if (nombre) {
                Swal.fire(
                    '¡Correo Enviado!',
                    `Se ha enviado un correo al alumno ${nombre} indicando que ha sido aceptado.`,
                    'success'
                );
            }
        }

        function bloquearAcceso() {
            const { value: nombre } = Swal.fire({
                title: 'Bloquear Acceso',
                input: 'text',
                inputLabel: 'Nombre de la persona:',
                inputPlaceholder: 'Ingrese el nombre',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sí, bloquear',
                cancelButtonText: 'Cancelar',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Debe ingresar un nombre'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        '¡Bloqueado!',
                        `El acceso de ${nombre} ha sido bloqueado.`,
                        'error'
                    );
                }
            });
        }

        // Función para configurar alertas por WhatsApp
        function configurarAlertasWhatsApp() {
            Swal.fire({
                title: 'Configuración de Alertas por WhatsApp',
                html:
                    '<label for="whatsapp-number">Número de WhatsApp:</label>' +
                    '<input type="text" id="whatsapp-number" placeholder="Ingrese el número de WhatsApp">' +
                    '<p>Ingrese el número de WhatsApp para configurar alertas por este medio.</p>',
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const whatsappNumber = document.getElementById('whatsapp-number').value;
                    console.log('Número de WhatsApp configurado:', whatsappNumber);
                    // Puedes realizar acciones con el número de WhatsApp, como almacenarlo o enviarlo al servidor.
                    return true;
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        }
    </script>
</body>
</html>
