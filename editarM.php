
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/diseñodash.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <title>Admin Dashboard Panel</title> 
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
                    <span class="link-name">Contraseña</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-share"></i>
                    <span class="link-name">Share</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="#">
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
                    <span class="text">Editar Maestro</span>
                </div>
        <?php

            if(isset($_POST['enviar'])){

                $var1 = $_POST['id'];
                $var2 = $_POST['nom'];
                $var3 = $_POST['ap1'];
                $var4 = $_POST['ap2'];
                $var5 = $_POST['correo'];
                $var6 = $_POST['tel'];
                $var7 = $_POST['dom'];
                $var8 = $_POST['nac'];
                $var9 = $_POST['jef'];
                $var10 = $_POST['rol'];
                $var11 = $_POST['ta'];

                $sql = "UPDATE instructor
                    SET
                        nombrej= '$var2',
                        ap_paterno='$var3',
                        ap_materno='$var4',
                        correo = '$var5',
                        telefono ='$var6',
                        domicilio ='$var7',
                        fecha_nac = '$var8',
                        id_jefe = '$var9',
                        id_roll = '$var10',
                        id_taller ='$var11'

                    WHERE no_control = '$var1'";

                    $result = $conn->query($sql);

                        if ($result === TRUE) {
                            echo '
                                <script>
                                alert ("YUJU! USUARIO ACTUALIZADO")
                                window.location = "tablaM.php"
                                </script>
                            ';
                        } else {
                            echo '
                                <script>
                                
                                alert ("ALGO SALIO MAL!")
                                window.location = "tablaM.php"
                    
                                </script>
                            ';
                        }

                
            } else{
                $var1= $_GET['id'];
                            $sql = "SELECT * FROM instructor WHERE no_control = '$var1'";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $var1 = $row['no_control'];
                                $var2 = $row['nombrej'];
                                $var3 = $row['ap_paterno'];
                                $var4 = $row['ap_materno'];
                                $var5 = $row['correo'];
                                $var6 = $row['telefono'];
                                $var7 = $row['domicilio'];
                                $var8 = $row['fecha_nac'];
                                $var9 = $row['id_jefe'];
                                $var10= $row['id_roll'];
                                $var11= $row['id_taller'];
                            } else {
                                echo "ALUMNO no encontrado.";
                            }
            }
        

        ?>
            <form action="" method="post">
                <div class="form-group">
                    <label>N° de control:</label>
                    <input type="text" name ="id" value="<?php echo $var1; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Nombre</label>
                    <input type="text" name ="nom" value="<?php echo $var2; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Apellido Paterno</label>
                    <input type="text" name ="ap1" value="<?php echo $var3; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Apellido Materno</label>
                    <input type="text" name ="ap2" value="<?php echo $var4; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Correo</label>
                    <input type="text" name ="correo" value="<?php echo $var5; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Telefono</label>
                    <input type="text" name ="tel" value="<?php echo $var6; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Domicilio</label>
                    <input type="text" name ="dom" value="<?php echo $var7; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Nacimiento</label>
                    <input type="text" name ="nac" value="<?php echo $var8; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Jefe</label>
                    <select name="jef">
                            <?php

                                // Consulta para obtener las opciones de la tabla 'seleccion'
                                $sqlc = "SELECT id_jefe, nombre From jefe";
                                $resultc= $conn->query($sqlc);

                                // Verificar si hay resultados y generar las opciones del menú desplegable
                                if ($resultc->num_rows > 0) {
                                    while($row = $resultc->fetch_assoc()) {
                                        $idSeleccion = $row['id_jefe'];
                                        $nombreSeleccion = $row['nombre'];

                                        // Comprobar si el valor coincide con el valor seleccionado
                                        $selected = ($idSeleccion == $var10) ? "selected" : "";
                                        echo '<option value="' . $idSeleccion . '" ' . $selected . '>' . $nombreSeleccion . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No hay opciones disponibles</option>';
                                }

                            ?>
                        </select>
                </div>
                <div class="form-group">
                    <label for="">Roll</label>
                    <select name="rol">
                            <?php

                                // Consulta para obtener las opciones de la tabla 'seleccion'
                                $sqlc = "SELECT id_roll, tipo From roll";
                                $resultc= $conn->query($sqlc);

                                // Verificar si hay resultados y generar las opciones del menú desplegable
                                if ($resultc->num_rows > 0) {
                                    while($row = $resultc->fetch_assoc()) {
                                        $idSeleccion = $row['id_roll'];
                                        $nombreSeleccion = $row['tipo'];

                                        // Comprobar si el valor coincide con el valor seleccionado
                                        $selected = ($idSeleccion == $var10) ? "selected" : "";
                                        echo '<option value="' . $idSeleccion . '" ' . $selected . '>' . $nombreSeleccion . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No hay opciones disponibles</option>';
                                }

                            ?>
                        </select>
                </div>
                <div class="form-group">
                    <label for="">Taller</label>
                    <select name="ta">
                            <?php

                                // Consulta para obtener las opciones de la tabla 'seleccion'
                                $sqlc = "SELECT id_taller, nombre_taller From taller";
                                $resultc= $conn->query($sqlc);

                                // Verificar si hay resultados y generar las opciones del menú desplegable
                                if ($resultc->num_rows > 0) {
                                    while($row = $resultc->fetch_assoc()) {
                                        $idSeleccion = $row['id_taller'];
                                        $nombreSeleccion = $row['nombre_taller'];

                                        // Comprobar si el valor coincide con el valor seleccionado
                                        $selected = ($idSeleccion == $var10) ? "selected" : "";
                                        echo '<option value="' . $idSeleccion . '" ' . $selected . '>' . $nombreSeleccion . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No hay opciones disponibles</option>';
                                }
                                $conn->close();
                            ?>
                        </select>
                </div>
                    <br>

                    <input id="en"type="submit" name="enviar" value="Actualizar">
            </form>
                        
              
            </div>
        </div>
    </section>

    <script src="js/appDash.js"></script>
</body>
</html>