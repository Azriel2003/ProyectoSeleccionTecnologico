
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
                    <span class="text">Editar Alumno</span>
                </div>
                <?php
                        if(isset($_POST['enviar'])){
                            
                            $var1 = $_POST['mtr'];
                            $var2 = $_POST['nom'];
                            $var3 = $_POST['ap1'];
                            $var4 = $_POST['ap2'];
                            $var5 = $_POST['dom'];
                            $var6 = $_POST['gen'];
                            $var7 = $_POST['sem'];
                            $fechaNacimiento = $_POST['fe'];
                            $var9 = $_POST['tor'];
                            $var10= $_POST['car'];
                            $var11= $_POST['sel'];
                            $var12= $_POST['pun'];
                            $var13 = $_POST['rol'];
                            $var14 = $_POST['correo'];

                            $sql = "UPDATE estudiante SET
                                nombre_estudiante = '$var2',
                                ap_paterno = '$var3',
                                ap_materno= '$var4',
                                domicilio = '$var5',
                                genero = '$var6',
                                semestre= '$var7',
                                fecha_nac = STR_TO_DATE('$fechaNacimiento', '%Y-%m-%d'),
                                id_torneo = '$var9',
                                clavecarrera = '$var10',
                                id_seleccion = '$var11',
                                id_puntaje= '$var12',
                                id_roll = '$var13',
                                correo = '$var14'
                                WHERE matricula = '$var1'";

                            $result = $conn->query($sql);

                            if ($result === TRUE) {
                                echo '<script>alert("¡YUJU! USUARIO ACTUALIZADO"); window.location = "tablaalumno.php";</script>';
                            } else {
                                echo '<script>alert("UPS! ALGO SALIÓ MAL"); window.location = "tablaalumno.php";</script>';
                            }
                        } else {
                            $var1= $_GET['id'];
                            $sql = "SELECT * FROM estudiante WHERE matricula = '$var1'";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $var1 = $row['matricula'];
                                $var2 = $row['nombre_estudiante'];
                                $var3 = $row['ap_paterno'];
                                $var4 = $row['ap_materno'];
                                $var5 = $row['domicilio'];
                                $var6 = $row['genero'];
                                $var7 = $row['semestre'];
                                $fechaNacimiento = $row['fecha_nac'];
                                $var9 = $row['id_torneo'];
                                $var10= $row['clavecarrera'];
                                $var11= $row['id_seleccion'];
                                $var12= $row['id_puntaje'];
                                $var13 = $row['id_roll'];
                                $var14 = $row['correo'];
                                $var15 = $row['contrasena'];
                            } else {
                                echo "ALUMNO no encontrado.";
                            }
                        }
            ?>

            <form action="" method="post">
                <div class="form-group">
                    <label>Matricula:</label>
                    <input type="text" name ="mtr" value="<?php echo $var1; ?>"><br>
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
                    <label for="">Domicilio</label>
                    <input type="text" name ="dom" value="<?php echo $var5; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Genero</label>
                    <input type="text" name ="gen" value="<?php echo $var6; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Semestre</label>
                    <input type="text" name ="sem" value="<?php echo $var7; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Fecha Nacimiento</label>
                    <input type="text" name ="fe" value="<?php echo $fechaNacimiento; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Torneo</label>
                    <select name="tor">
                            <?php

                                // Consulta para obtener las opciones de la tabla 'seleccion'
                                $sqlc = "SELECT id_torneo, nombre From torneo";
                                $resultc= $conn->query($sqlc);

                                // Verificar si hay resultados y generar las opciones del menú desplegable
                                if ($resultc->num_rows > 0) {
                                    while($row = $resultc->fetch_assoc()) {
                                        $idSeleccion = $row['id_torneo'];
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
                    <label for="car">Carrera</label>
                    <select name="car">
                            <?php

                                // Consulta para obtener las opciones de la tabla 'seleccion'
                                $sqlc = "SELECT clavecarrera, nombrecarrera From carrera";
                                $resultc= $conn->query($sqlc);

                                // Verificar si hay resultados y generar las opciones del menú desplegable
                                if ($resultc->num_rows > 0) {
                                    while($row = $resultc->fetch_assoc()) {
                                        $idSeleccion = $row['clavecarrera'];
                                        $nombreSeleccion = $row['nombrecarrera'];

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
                        <label for="sel">Seleccion</label>
                        <select name="sel">
                            <?php

                                // Consulta para obtener las opciones de la tabla 'seleccion'
                                $sql = "SELECT s.id_seleccion, t.nombre_taller
                                        FROM seleccion s
                                        JOIN taller t ON s.id_taller=t.id_taller";
                                $result = $conn->query($sql);

                                // Verificar si hay resultados y generar las opciones del menú desplegable
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $idSeleccion = $row['id_seleccion'];
                                        $nombreSeleccion = $row['nombre_taller'];

                                        // Comprobar si el valor coincide con el valor seleccionado
                                        $selected = ($idSeleccion == $var11) ? "selected" : "";
                                        echo '<option value="' . $idSeleccion . '" ' . $selected . '>' . $nombreSeleccion . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No hay opciones disponibles</option>';
                                }

                                // Cerrar la conexión a la base de datos
                                $conn->close();
                            ?>
                        </select>
                </div>

                <div class="form-group">
                    <label for="">Puntaje</label>
                    <input type="text" name ="pun" value="<?php echo $var12; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Roll</label>
                    <input type="text" name ="rol" value="<?php echo $var13; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="">Correo</label>
                    <input type="text" name ="correo" value="<?php echo $var14; ?>"><br>
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