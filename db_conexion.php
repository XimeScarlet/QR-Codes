<?php
// Datos de conexión a la base de datos en XAMPP
$servidor = "localhost"; // El servidor de la base de datos (en este caso, localhost)
$usuario = "root"; // El nombre de usuario de la base de datos en XAMPP (por defecto, root)
$contrasena = ""; // La contraseña de la base de datos en XAMPP (por defecto, sin contraseña)
$basededatos = "bd_tiempo"; // El nombre de la base de datos que has creado en XAMPP

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $contrasena, $basededatos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if(isset($_POST['start_date']) && isset($_POST['end_date'])){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Consulta para buscar historial en la base de datos
    $query = "SELECT * FROM historial WHERE fecha BETWEEN '$start_date' AND '$end_date'";
    $resultado = $conexion->query($query);

    // Crear arreglo para almacenar los resultados
    $historial = array();

    // Obtener resultados y agregarlos al arreglo
    while ($fila = $resultado->fetch_assoc()) {
        $historial[] = $fila;
    }
 
    // Devolver resultados como JSON
    echo json_encode($historial);
} else {
    // Si no se reciben las fechas, devolver un mensaje de error
    echo json_encode(array("error" => "Fechas no recibidas"));
}

// No cerrar la conexión aquí

?>
