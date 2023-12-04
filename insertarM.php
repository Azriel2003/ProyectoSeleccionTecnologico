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
                    <span class="text">NUEVO MAESTRO</span>
                </div>
                <?php
                    if(isset($_POST['enviar'])){
                            $var1 = $_POST["id"];
                            $var2 = $_POST["nom"];
                            $var3 = $_POST["ap1"];
                            $var4 = $_POST["ap2"];
                            $var5 = $_POST["correo"];
                            $var6 = $_POST["tel"];
                            $var7 = $_POST["dom"];
                            $fechaNacimiento = $_POST["fe"];
                            $var9 = $_POST["jef"];
                            $var10= $_POST["rol"];
                            $var11= $_POST["ta"];
                            $var12= $_POST["con"];

                            $contrasena = hash ('sha512', "$var12");
                            
                            $sql ="INSERT INTO instructor (no_control, nombrej, ap_paterno, ap_materno,correo,telefono,domicilio, fecha_nac, id_jefe, id_roll,id_taller,contrasena)
                                                                    VALUES('$var1','$var2','$var3','$var4','$var5','$var6','$var7','$fechaNacimiento','$var9','$var10','$var11','$contrasena')";

                            $sql_matricula = "SELECT COUNT(*) AS total FROM instructor WHERE no_control = '$var1'";
                            $result_matricula = $conn->query($sql_matricula);
                            $row_matricula = $result_matricula->fetch_assoc();
                            $total_matriculas = $row_matricula['total'];
        
                            if ($total_matriculas > 0) {
                                echo '
                                <script>
        
                                alert("Este numero de control ya existe.");
                                window.location = "insertarM.php";
        
                                </script>';
                            } else{
                                // Verificación del correo
                                $sql_correo = "SELECT COUNT(*) AS total FROM instructor WHERE correo = '$var5'";
                                $result_correo = $conn->query($sql_correo);
                                $row_correo = $result_correo->fetch_assoc();
                                $total_correos = $row_correo['total'];
        
                                if ($total_correos > 0) {
                                    echo '<script>alert("Este correo ya está registrado."); window.location = "insertarM.php";</script>';
                                }else {
                                    // Insertar usuario si la matrícula y el correo no están registrados
                                    $result = $conn->query($sql);
                                    if ($result){
                                        echo '
                                            <script>
                                            
                                              alert ("YUJU! USUARIO REGISTRADO")
                                              window.location = "tablaM.php"
                                 
                                            </script>
                                        ';
                                    }else{
                                        echo '
                                            <script>
                                            
                                              alert ("ALGO SALIO MAL!")
                                              window.location = "tablaM.php"
                                 
                                            </script>
                                        ';
                                    }
                                }
                            }
                    }       
                ?>

                <form action="" method="POST"  class="form-register">
                    <input class="controls" type="text" name="id" id="nombres" placeholder="Matricula" required>
                    <input class="controls" type="text" name="nom" id="nombres" placeholder="Nombre" required>
                    <input class="controls" type="text" name="ap1" id="nombres" placeholder="Apellido Paterno" >
                    <input class="controls" type="text" name="ap2" id="apellidos" placeholder="Apellido Materno">
                    <input class="controls" type="text" name="correo" id="apellidos" placeholder="correo" required>
                    <input class="controls" type="text" name="tel" id="apellidos" placeholder="Telefono">
                    <input class="controls" type="text" name="dom" id="apellidos" placeholder="Domicilio">
                    <input class="controls" type="text" name="fe" id="apellidos" placeholder="Fecha de Nacimiento DD/MM/YYYY">
                    <select name="jef" id="carrera">
                        <?php
                        // Consulta para obtener las carreras
                        $query = "SELECT id_jefe, nombre FROM jefe";
                        $result = $conn->query($query);

                        // Generar las opciones del menú desplegable
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                echo '<option value="' . $row['id_jefe'] . '">' . $row['nombre'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No hay carreras disponibles</option>';
                        }
                        // Cerrar la conexión a la base de datos
                        ?>
                    </select>
                    <select name="rol" id="carrera">
                        <?php
                        // Consulta para obtener las carreras
                        $query = "SELECT id_roll, tipo FROM roll";
                        $result = $conn->query($query);

                        // Generar las opciones del menú desplegable
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                echo '<option value="' . $row['id_roll'] . '">' . $row['tipo'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No hay carreras disponibles</option>';
                        }
                        // Cerrar la conexión a la base de datos
                        ?>
                    </select>
                    <select name="ta" id="carrera">
                        <?php
                            $query = "SELECT id_taller,nombre_taller from taller";
                            $result = $conn->query($query);

                            // Generar las opciones del menú desplegable
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {

                                    echo '<option value="' . $row['id_taller'] . '">' . $row['nombre_taller'] . '</option>';
                                }
                            } else {
                                echo '<option value="">No hay carreras disponibles</option>';
                            }
                            $conn->close();
                        ?>
                    </select>
                    <input class="controls" type="password" name="con" id="apellidos" placeholder="contraseña" required>

                    <input class="botons" type="submit" name="enviar" value="ENVIAR">
                </form>
             
            </div>
        </div>
    </section>
    <script src="js/appDash.js"></script>
</body>
</html>
