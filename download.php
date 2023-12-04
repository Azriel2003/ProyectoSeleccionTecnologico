<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "selecciontecnologico";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Revisar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
    session_start();
    if(!isset($_SESSION['idjefe'])){
        header("location:log.php");
    }
$iduser= $_SESSION['idjefe'];

$sql= "SELECT id_jefe, nombre FROM jefe WHERE id_jefe='$iduser'";
$res=$conn->query($sql);
$row=$res->fetch_assoc();


// Obtener el nombre del archivo desde la URL
$id = $_GET['id'];
$id2 = $_GET['id2'];
$id3 = $_GET['id3'];
$id4 = $_GET['id4'];
// Buscar el archivo en la base de datos
$sql = "SELECT * FROM estudiante WHERE matricula = '$id'";
$resultado = mysqli_query($conn, $sql);
$sql2 = "SELECT * FROM estudiante WHERE matricula = '$id2'";
$resultado2 = mysqli_query($conn, $sql);
$sql3 = "SELECT * FROM estudiante WHERE matricula = '$id3'";
$resultado3 = mysqli_query($conn, $sql);
$sql4 = "SELECT * FROM estudiante WHERE matricula = '$id4'";
$resultado4 = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) == 1) {
    $fila = mysqli_fetch_assoc($resultado);
    $archivo = $fila['comprobante_domiciliario'];
    $ruta_archivo = "files/" . $archivo;

    // Verificar que el archivo exista en el servidor
    if (file_exists($ruta_archivo)) {
        // Enviar el archivo al navegador
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $archivo . '"');
        readfile($ruta_archivo);
    } else {
        echo "El archivo no existe en el servidor.";
    }
} else {
    echo "El archivo no se encontró en la base de datos.";
}
if (mysqli_num_rows($resultado2) == 1) {
    $fila = mysqli_fetch_assoc($resultado);
    $archivo = $fila['receta_medica'];
    $ruta_archivo = "files/" . $archivo;

    // Verificar que el archivo exista en el servidor
    if (file_exists($ruta_archivo)) {
        // Enviar el archivo al navegador
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $archivo . '"');
        readfile($ruta_archivo);
    } else {
        echo "El archivo no existe en el servidor.";
    }
} else {
    echo "El archivo no se encontró en la base de datos.";
}
if (mysqli_num_rows($resultado3) == 1) {
    $fila = mysqli_fetch_assoc($resultado);
    $archivo = $fila['curp'];
    $ruta_archivo = "files/" . $archivo;

    // Verificar que el archivo exista en el servidor
    if (file_exists($ruta_archivo)) {
        // Enviar el archivo al navegador
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $archivo . '"');
        readfile($ruta_archivo);
    } else {
        echo "El archivo no existe en el servidor.";
    }
} else {
    echo "El archivo no se encontró en la base de datos.";
}
if (mysqli_num_rows($resultado4) == 1) {
    $fila = mysqli_fetch_assoc($resultado);
    $archivo = $fila['actanacimiento'];
    $ruta_archivo = "files/" . $archivo;

    // Verificar que el archivo exista en el servidor
    if (file_exists($ruta_archivo)) {
        // Enviar el archivo al navegador
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $archivo . '"');
        readfile($ruta_archivo);
    } else {
        echo "El archivo no existe en el servidor.";
    }
} else {
    echo "El archivo no se encontró en la base de datos.";
}
