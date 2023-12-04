<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "selecciontecnologico";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Revisar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    //INICIOS DE SESION
    session_start();
    if(!isset($_SESSION['idjefe'])){
        header("location:log.php");
    }
    $iduser= $_SESSION['idjefe'];

    $sql= "SELECT id_jefe, nombre FROM jefe WHERE id_jefe='$iduser'";
    $res=$conn->query($sql);
    $row=$res->fetch_assoc();
    //Aqui acaba el incio de sesio y recuperacion de datos
?>
<!DOCTYPE html>
<!--=== Coding by CodingLab | www.codinglabweb.com === -->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/diseñodash.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <title>TESJO</title> 
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="img/seleccion.png" alt="">
            </div>
            <!------------------------aqui va el nombre del usuario-------------------->
            <span class="logo_name">
                <?php echo utf8_decode($row['nombre']);?>
            </span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="dashAD.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <li><a href="tablaalumno.php">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Alumnos</span>
                </a></li>
                <li><a href="tablajefe.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Administradores</span>
                </a></li>
                <li><a href="tablaM.php">
                    <i class='bx bxs-user'></i>
                    <span class="link-name">Maestros</span>
                </a></li>
                <li><a href="cambiarcontraseña.php">
                <i class='bx bxs-lock-open-alt'></i>
                    <span class="link-name">Contraeña</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-share"></i>
                    <span class="link-name">Share</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="cerrar_sesion.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
            
            <img src="images/profile.jpg" alt="">
        </div>

        <div class="dash-content">

            <!----======== TABLA======== -->

            <div class="activity">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Cambio de contraseña</span>
                </div>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                    $idusr=$_SESSION['idjefe']; // ID del usuario cuya contraseña se va a modificar
                
                    $contrasena_actual = $_POST['contrasenaA'];
                    $nueva_contrasena = $_POST['contrasenaN'];
                
                    // Obtener la contraseña actual encriptada de la base de datos
                    $sql = "SELECT contrasena FROM jefe WHERE id_jefe= $idusr";
                    $resultado = $conn->query($sql);
                
                    if ($resultado->num_rows === 1) {
                        $fila = $resultado->fetch_assoc();
                        $contrasena_encriptada = $fila['contrasena'];
                
                        // Verificar si la contraseña actual ingresada coincide con la contraseña encriptada en la base de datos
                        if (hash('sha512', $contrasena_actual) === $contrasena_encriptada) {
                            // Encriptar la nueva contraseña
                            $nueva_contrasena_encriptada = hash('sha512', $nueva_contrasena);
                
                            // Actualizar la contraseña en la base de datos
                            $sql_update = "UPDATE jefe SET contrasena = '$nueva_contrasena_encriptada' WHERE id_jefe = $idusr";
                            $resultado_update = $conn->query($sql_update);
                
                            if ($resultado_update) {
                                echo "¡Contraseña actualizada correctamente!";
                            } else {
                                echo "Error al actualizar la contraseña: " . $conn->error;
                            }
                        } else {
                            echo "La contraseña actual no coincide";
                        }
                    } else {
                        echo "Usuario no encontrado";
                    }
                }else {

                }
                ?>
                <form action="" method="POST"  class="form-register">

                    <input class="controls" type="password" name="contrasenaA" id="apellidos" placeholder="Contraseña anterior" required>
                    <input class="controls" type="password" name="contrasenaN" id="apellidos" placeholder="Contraseña nueva" required>
                    <br>
                    <input class="botons" type="submit"name="enviar" value="ENVIAR">
                </form>
             
            </div>
        </div>
    </section>
    <script src="js/appDash.js"></script>
</body>
</html>
