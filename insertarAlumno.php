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
                    <span class="text">Insertar estudiantes de Seleccion</span>
                </div>

                <?php
                 if(isset($_POST['enviar'])){
                    $var1 = $_POST["mtr"];
                    $var2 = $_POST["nom"];
                    $var3 = $_POST["ap1"];
                    $var4 = $_POST["ap2"];
                    $var5 = $_POST["dom"];
                    $var6 = $_POST["gen"];
                    $var7 = $_POST["sem"];
                    $fechaNacimiento = $_POST["fe"];
                    $var9 = $_POST["tor"];
                    $var10= $_POST["car"];
                    $var11= $_POST["sel"];
                    $var12= $_POST["pun"];
                    $var13 = $_POST["rol"];
                    $var14 = $_POST["correo"];
                    $var15 = $_POST["contraseña"];

                    $contrasena = hash ('sha512', "$var15");

                    $sql = "INSERT INTO estudiante (matricula, nombre_estudiante, ap_paterno, ap_materno, domicilio, genero, semestre, fecha_nac, id_torneo, clavecarrera, id_seleccion, id_puntaje, id_roll, correo, contrasena)
                    VALUES ('$var1', '$var2', '$var3', '$var4', '$var5', '$var6', '$var7', '$fechaNacimiento', '$var9', '$var10', '$var11', '$var12', '$var13', '$var14', '$contrasena')";


                    $sql_matricula = "SELECT COUNT(*) AS total FROM estudiante WHERE matricula = '$var1'";
                    $result_matricula = $conn->query($sql_matricula);
                    $row_matricula = $result_matricula->fetch_assoc();
                    $total_matriculas = $row_matricula['total'];

                    if ($total_matriculas > 0) {
                        echo '
                        <script>

                        alert("Esta matrícula ya existe.");
                        window.location = "insertarAlumno.php";

                        </script>';
                    } else{
                        // Verificación del correo
                        $sql_correo = "SELECT COUNT(*) AS total FROM estudiante WHERE correo = '$var14'";
                        $result_correo = $conn->query($sql_correo);
                        $row_correo = $result_correo->fetch_assoc();
                        $total_correos = $row_correo['total'];

                        if ($total_correos > 0) {
                            echo '<script>alert("Este correo ya está registrado."); window.location = "insertarAlumno.php";</script>';
                        }else {
                            // Insertar usuario si la matrícula y el correo no están registrados
                            $result = $conn->query($sql);
                            if ($result){
                                echo '
                                    <script>
                                    
                                      alert ("YUJU! USUARIO REGISTRADO")
                                      window.location = "tablaalumno.php"
                         
                                    </script>
                                ';
                            }else{
                                echo '
                                    <script>
                                    
                                      alert ("ALGO SALIO MAL!")
                                      window.location = "tablaalumno.php"
                         
                                    </script>
                                ';
                            }
                        }
                    }
                 }
                ?>
                <form action="" method="POST"  class="form-register">
                    <input class="controls" type="text" name="mtr" id="nombres" placeholder="Matricula" required>
                    <input class="controls" type="text" name="nom" id="nombres" placeholder="Nombre" required>
                    <input class="controls" type="text" name="ap1" id="nombres" placeholder="Apellido Paterno" >
                    <input class="controls" type="text" name="ap2" id="apellidos" placeholder="Apellido Materno">
                    <input class="controls" type="text" name="dom" id="apellidos" placeholder="Domicilio">
                    <input class="controls" type="text" name="gen" id="apellidos" placeholder="Genero">
                    <input class="controls" type="text" name="sem" id="apellidos" placeholder="Semestre">
                    <input class="controls" type="text" name="fe" id="apellidos" placeholder="Fecha de Nacimiento YYYY/MM/DD">
                    <select name="tor" id="torneo">
                        <?php
                        // Consulta para obtener las carreras
                        $query = "SELECT id_torneo, nombre FROM torneo";
                        $result = $conn->query($query);

                        // Generar las opciones del menú desplegable
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                echo '<option value="' . $row['id_torneo'] . '">' . $row['nombre'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No hay carreras disponibles</option>';
                        }
                        // Cerrar la conexión a la base de datos
                        ?>
                    </select>
                    <select name="car" id="carrera">
                        <?php
                        // Consulta para obtener las carreras
                        $query = "SELECT clavecarrera, nombrecarrera FROM carrera";
                        $result = $conn->query($query);

                        // Generar las opciones del menú desplegable
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                echo '<option value="' . $row['clavecarrera'] . '">' . $row['nombrecarrera'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No hay carreras disponibles</option>';
                        }
                        // Cerrar la conexión a la base de datos
                        ?>
                    </select>
                    <select name="sel" id="seleccion">
                        <?php
                        // Consulta para obtener las carreras
                        $query = "SELECT s.id_seleccion, t.nombre_taller from seleccion s
                                INNER JOIN taller t on s.id_taller=t.id_taller";
                        $result = $conn->query($query);

                        // Generar las opciones del menú desplegable
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                echo '<option value="' . $row['id_seleccion'] . '">' . $row['nombre_taller'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No hay carreras disponibles</option>';
                        }
                        // Cerrar la conexión a la base de datos
                        ?>
                    </select>
                    <select name="pun" id="puntaje">
                        <?php
                        // Consulta para obtener las carreras
                        $query = "SELECT id_puntaje, tipo from puntaje";
                        $result = $conn->query($query);

                        // Generar las opciones del menú desplegable
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                echo '<option value="' . $row['id_puntaje'] . '">' . $row['tipo'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No hay carreras disponibles</option>';
                        }
                        // Cerrar la conexión a la base de datos
                        $conn->close();
                        ?>
                    </select>
                    <input class="controls" type="text" name="rol" id="apellidos" placeholder="rol" required>
                    <input class="controls" type="text" name="correo" id="apellidos" placeholder="correo">
                    <input class="controls" type="password" name="contraseña" id="apellidos" placeholder="contraseña">
                    <input class="botons" type="submit" name="enviar" value="enviar">
                </form>
             
            </div>
        </div>
    </section>
    <script src="js/appDash.js"></script>
</body>
</html>
