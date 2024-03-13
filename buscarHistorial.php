<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basededatos = "bd_tiempo";

$singleDate = $_POST['single_date'];

try {
    $conexion = new mysqli($servidor, $usuario, $contrasena, $basededatos);

    if ($conexion->connect_error) {
        throw new Exception("Conexión fallida: " . $conexion->connect_error);
    }

    $sql = "SELECT * FROM tabla WHERE fecha = '$singleDate'";
    $resultado = $conexion->query($sql);

    $htmlResult = "<ul>";
    while ($fila = $resultado->fetch_assoc()) {
        $htmlResult .= "<li>" . $fila['columna1'] . " - " . $fila['columna2'] . "</li>";
    }
    $htmlResult .= "</ul>";

    $conexion->close();

    echo $htmlResult;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
