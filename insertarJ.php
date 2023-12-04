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
                <li><a href="cerrar_sesion">
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
                    <span class="text">Administradores</span>
                </div>
                <?php
                if(isset($_POST['enviar'])){
                
                    $var1 = $_POST["id"];
                    $var2 = $_POST["nom"];
                    $var3 = $_POST["ap1"];
                    $var4 = $_POST["ap2"];
                    $var5 = $_POST["rol"];
                    $var6 = $_POST["correo"];
                    $var7 = $_POST["contraseña"];
                
                    $contrasena = hash ('sha512', "$var7");
                
                    $stmt = $conn->prepare("INSERT INTO jefe (id_jefe, nombre, ap_paterno, ap_materno, id_roll, correo, contrasena)
                                            VALUES ('$var1', '$var2', '$var3', '$var4', '$var5', '$var6', '$contrasena')");
                    $correo_usuario = $var6;
                    $id = $var1;
                
                    $sql = "SELECT COUNT(*) AS total FROM jefe WHERE correo = ?";
                    $stmt2 = $conn->prepare($sql);
                    $stmt2->bind_param("s", $correo_usuario);
                    $stmt2->execute();
                    $result = $stmt2->get_result();
                    $row = $result->fetch_assoc();
                    $total_registros = $row['total'];
                
                    $sql = "SELECT COUNT(*) AS total FROM jefe WHERE id_jefe = ?";
                    $stmt3 = $conn->prepare($sql);
                    $stmt3->bind_param("i", $id);
                    $stmt3->execute();
                    $result = $stmt3->get_result();
                    $row = $result->fetch_assoc();
                    $t_mat = $row['total'];
                
                    if ($t_mat > 0) {
                        echo '<script>alert("Esta matricula ya existe!"); window.location = "insertarJ.php";</script>';
                    } else {
                        if ($total_registros > 0) {
                            echo '<script>alert("Este correo ya existe!"); window.location = "insertarJ.php";</script>';
                        } else {
                            $ej = $stmt->execute();
                
                            if ($ej) {
                                echo '<script>alert("¡YUJU! USUARIO REGISTRADO"); window.location = "tablajefe.php";</script>';
                            } else {
                                echo '<script>alert("¡ALGO SALIÓ MAL!"); window.location = "tablajefe.php";</script>';
                            }
                        }
                    }
                
                    $stmt->close();
                    $stmt2->close();
                    $stmt3->close();
                    $conn->close();
                
                
                }

                ?>
                <form action="" method="POST"  class="form-register">
                    <input class="controls" type="text" name="id" id="nombres" placeholder="ID" required>
                    <input class="controls" type="text" name="nom" id="nombres" placeholder="Nombre" required>
                    <input class="controls" type="text" name="ap1" id="nombres" placeholder="Apellido Paterno" >
                    <input class="controls" type="text" name="ap2" id="apellidos" placeholder="Apellido Materno">
                    <input class="controls" type="text" name="rol" id="apellidos" placeholder="rol" required>
                    <input class="controls" type="text" name="correo" id="apellidos" placeholder="correo">
                    <input class="controls" type="password" name="contraseña" id="apellidos" placeholder="contraseña">
                    <input class="botons" type="submit" name="enviar" value="ENVIAR">
                </form>
             
            </div>
        </div>
    </section>
    <script src="js/appDash.js"></script>
</body>
</html>
