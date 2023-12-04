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
$query = "SELECT e.matricula, e.nombre_estudiante, e.ap_paterno, e.ap_materno, e.domicilio, e.genero,
            e.semestre, e.fecha_nac, f.nombre, c.nombrecarrera, t.nombre_taller, e.id_puntaje, r.tipo, e.correo, e.contrasena
            FROM estudiante e
            INNER JOIN seleccion s ON e.id_seleccion = s.id_seleccion
            JOIN taller t ON s.id_taller = t.id_taller
            JOIN torneo f ON e.id_torneo = f.id_torneo
            INNER JOIN roll r ON e.id_roll = r.id_roll
            join carrera c on e.clavecarrera=c.clavecarrera";
$result = $conn->query($query);

if ($result === false) {
    echo "Error en la consulta: " . $conn->error;
} 
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
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    
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
                <li><a href="dashL.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <li><a href="tablaAL.php">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Alumnos</span>
                </a></li>
                <li><a href="tablaML.php">
                    <i class='bx bxs-user'></i>
                    <span class="link-name">Maestros</span>
                </a></li>
                <li><a href="cambioCL.php">
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
        </div>

        <div class="dash-content">

            <!----======== TABLA======== -->
            <div class="activity">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Tabla estudiantes de Seleccion</span>
                </div>
                <div class ="h">
                </div>
                <table id="myTable">
                    <thead>
                        <tr>
                            <th class="e">#</th>
                            <th class="e">Nombre</th>
                            <th class="e">Apellido</th>
                            <th class="e">Apellido</th>
                            <th class="e">Genero</th>
                            <th class="e">Semestre</th>
                            <th class="e">Carrera</th>
                            <th class="e">Seleccion</th>
                            <th class="e">Putaje</th>
                            <th class="e">Rol</th>
                            <th class="e">Correo</th>
                            <th class="e">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                
                            ?>

                            <tr>
                            <td class="a"><?php echo $row['matricula']?></td>
                            <td class="a"><?php echo $row['nombre_estudiante']?></td>
                            <td class="a"><?php echo $row['ap_paterno']?></td>
                            <td class="a"><?php echo $row['ap_materno']?></td>
                            <td class="a"><?php echo $row['genero']?></td>
                            <td class="a"><?php echo $row['semestre']?></td>
                            <td class="a"><?php echo $row['nombrecarrera']?></td>
                            <td class="a"><?php echo $row['nombre_taller']?></td>
                            <td class="a"><?php echo $row['id_puntaje']?></td>
                            <td class="a"><?php echo $row['tipo']?></td>
                            <td class="a"><?php echo $row['correo']?></td>
                            <td class="a">
                                    <a href="agregarAL.php?id=<?php echo $row['matricula']?>" class="d"><i class='bx bx-file'></i></a>
                            </td>
                            </tr>
                           <?php     
                            }
                            }
                            $conn->close();
                            ?>
                    </tbody>
                
                </table>    
            </div>
        </div>
    </section>
    <script src="js/appDash.js"></script>
    <script>
        function confirmarEliminacion(event) {
            event.preventDefault();

            var confirmar = confirm('¿Estás seguro de que deseas eliminar este elemento?');

            if(confirmar) {
                var url = event.target.getAttribute('href');
                window.location =url;
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
</body>
</html>