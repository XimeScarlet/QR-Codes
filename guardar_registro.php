<?php
// Realiza la conexión a la base de datos y otras configuraciones necesarias

// Verifica si se ha enviado un nombre para guardar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];

    // Aquí deberías realizar la inserción en tu base de datos utilizando la variable $nombre

    // Simulación de inserción exitosa
    $success = true;

    // Simulación de inserción en la base de datos
    if ($success) {
        echo json_encode(array("success" => true, "nombre" => $nombre));
    } else {
        echo json_encode(array("success" => false));
    }
} else {
    // Si no es una solicitud POST válida o falta el parámetro 'nombre'
    http_response_code(400);
}
?>
