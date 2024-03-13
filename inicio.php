<?php

require_once "db_conexion.php";

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generarContraseña() {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud = 10;
    $contraseña = '';
    for ($i = 0; $i < $longitud; $i++) {
        $indice = rand(0, strlen($caracteres) - 1);
        $contraseña .= $caracteres[$indice];
    }
    return $contraseña;
}

function enviarCorreo($destinatario, $asunto, $mensaje) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '22040114@alumno.utc.edu.mx';
        $mail->Password = 'xddepkjntuboeqou'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('22040114@alumno.utc.edu.mx', 'Ximena Scarlet Zapata Cabrera');
        $mail->addAddress($destinatario);

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;

        $mail->send();
        echo 'Correo electrónico enviado correctamente';
    } catch (Exception $e) {
        echo 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['correo'])) {
    $destinatario = $_POST['correo'];

    $nueva_contraseña = generarContraseña();

    $asunto = 'Recuperación de contraseña';
    $mensaje = 'Hola, aquí está tu nueva contraseña: <strong>' . $nueva_contraseña . '</strong>';

    enviarCorreo($destinatario, $asunto, $mensaje);

    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['matricula']) && isset($_POST['contrasena'])) {
    $matricula = $_POST['matricula'];
    $contrasena = $_POST['contrasena'];

    if ($matricula == 'admin') {
        header('Location: admin.php');
        exit;
    } else {
        $servername = "localhost"; // El servidor de la base de datos (en este caso, localhost)
        $username = "root"; // El nombre de usuario de la base de datos
        $password = ""; // La contraseña de la base de datos
        $db = "bd_tiempo"; // El nombre de la base de datos

        $conn = new mysqli($servername, $username, $password, $db);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $sql_maestros = "SELECT * FROM maestros WHERE matricula='$matricula' AND contrasena='$contrasena'";
        $result_maestros = $conn->query($sql_maestros);

        $sql_alumnos = "SELECT * FROM alumnos WHERE matricula='$matricula' AND contrasena='$contrasena'";
        $result_alumnos = $conn->query($sql_alumnos);

        if ($result_maestros->num_rows > 0 || $result_alumnos->num_rows > 0) {
            header('Location: index.php');
            exit;
        } else {
            echo "<script>swal('Error', 'Matrícula o contraseña incorrecta', 'error');</script>";
        }

        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>SCANNING</title>
  <link rel="stylesheet" href="css/inicio.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
    <body>
    <div class="container">
        <input type="checkbox" id="flip">
        <div class="cover">
        <div class="front">
            <img src="images/frontImg.jpg" alt="">
            <div class="text">
            <span class="text-1">Una experiencia agradable y confiable</span>
            <span class="text-2">Ingresa para empezar</span>
            </div>
        </div>
        </div>
        <div class="forms">
        <div class="form-content">
            <div class="login-form">
            <div class="title">Iniciar Sesión</div>
            <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="input-boxes">
                <div class="input-box">
                    <i class="fas fa-envelope"></i>
                    <input type="text" name="matricula" placeholder="Ingresa tu Matrícula" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="contrasena" placeholder="Ingresa tu Contraseña" required>
                </div>
                <div class="text"><a href="#" onclick="openModal()">¿Olvidaste tu contraseña?</a></div>
                <div class="button input-box">
                    <input type="submit" value="Ingresar">
                </div>
                <div class="text sign-up-text">Contacta con supervisor por problemas <label>Aquí</label></div>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    <form id="modalForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>Por favor, introduce tu correo electrónico:</p>
            <input type="email" id="correo" name="correo" placeholder="Correo electrónico" required>
            <button type="submit">Enviar</button>
        </div>
        </div>
    </form>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function openModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
        }

        function closeModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
        }

        window.onclick = function (event) {
        var modal = document.getElementById("myModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
        }
    </script>
    <?php if (isset($_GET['error'])) : ?>
        <script>swal('Error', 'Matrícula o contraseña incorrecta', 'error');</script>
    <?php endif; ?>
    </body>
</html>
