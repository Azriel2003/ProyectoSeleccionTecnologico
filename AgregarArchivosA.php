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

?>
<!DOCTYPE html>
<!--=== Coding by CodingLab | www.codinglabweb.com === -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- CSS personalizado --> 
    <link rel="stylesheet" href="css/diseñodash.css">
    
      
      
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">       
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
                Hola! <?php echo utf8_decode($row['nombre']);?>
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
            
            <!--<img src="images/profile.jpg" alt="">-->
        </div>
        <div class="dash-content">
            <div class="activity">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <?php
                            $var1= $_GET['id'];
                            $sql = "SELECT * FROM estudiante WHERE matricula = '$var1'";
                            $result = $conn->query($sql);
                                            
                            if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $nombre=$row['nombre_estudiante'];
                                    $apellido=$row['ap_paterno'];
                            } else {
                                                echo "ALUMNO no encontrado.";
                            }
                    ?>
                    <span class="text">Archivos de <?php echo"$nombre $apellido" ?></span>
                </div>
                <!--aqui va el conenido-->

                        <div class="row">
                            <div class="col-lg-12">            
                            <button type="button" class="btn btn-success" style="margin-bottom: 10px;" data-toggle="modal" data-target="#agregar"><i class='bx bx-upload'></i></button>  
                            </div>    
                        </div>   
                        <table >
                                        <thead >
                                            <tr>     
                                                <th class="e">Matricula</th>                           
                                                <th class="e">C.Domicilio</th>
                                                <th class="e"></th>
                                                <th class="e">Receta</th> 
                                                <th class="e"></th> 
                                                <th class="e">CURP</th> 
                                                <th class="e"></th> 
                                                <th class="e">A.Nacimiento</th>    
                                                <th class="e"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $var1= $_GET['id'];
                                            $sql = "SELECT * FROM estudiante WHERE matricula = '$var1'";
                                            $result = $conn->query($sql);
                                            
                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                            } else {
                                                echo "ALUMNO no encontrado.";
                                            }
                                        ?>
                                            <?php
                                                    $consulta= mysqli_query($conn,"SELECT *FROM estudiante Where matricula='$var1'");  
                                            ?> 

                                            <tr>
                                                <td class="a"><?php echo $row['matricula']?></td>
                                                <td class="a"><?php  echo $row['comprobante_domiciliario']?></td>
                                                <td>
                                                    <a href="download.php?id=<?php echo $var1?>" class="btn btn-primary">
                                                    <i class='bx bx-download'></i>
                                                    </a>
                                                
                                                </td>
                                                <td class="a"><?php  echo $row['receta_medica']?></td>
                                                <td>
                                                    <a href="download.php?id2=<?php echo $var1?>" class="btn btn-primary">
                                                    <i class='bx bx-download'></i>
                                                    </a>
                                                
                                                </td>
                                                <td class="a"><?php  echo $row['curp']?></td>
                                                <td>
                                                    <a href="download.php?id3=<?php echo $var1?>" class="btn btn-primary">
                                                    <i class='bx bx-download'></i>
                                                    </a>
                                                
                                                </td>
                                                <td class="a"><?php  echo $row['actanacimiento']?></td>
                                                <td>
                                                    <a href="download.php?id4=<?php echo $var1?>" class="btn btn-primary">
                                                    <i class='bx bx-download'></i>
                                                    </a>
                                                
                                                </td>
                                            </tr>
                                                                           
                                        </tbody>        
                                    </table>                  
                                    </div>
                                </div>
                        </div>  
                    </div>    
                <!------------modal----------------->
                <div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h3 class="modal-title" id="exampleModalLabel">Agregar Archivos</h3>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                                <div class="modal-body">
                                <?php
                                if (isset($_FILES['dom']) && isset($_FILES['re'])&& isset($_FILES['cu'])&& isset($_FILES['ac'])) {
                                    extract($_POST);

                                    // Definir la carpeta de destino
                                    $carpeta_destino = "files/";

                                    // Obtener el nombre y la extensión del primer archivo
                                    $nombre_archivo1 = basename($_FILES["dom"]["name"]);
                                    $extension1 = strtolower(pathinfo($nombre_archivo1, PATHINFO_EXTENSION));

                                    // Obtener el nombre y la extensión del segundo archivo
                                    $nombre_archivo2 = basename($_FILES["re"]["name"]);
                                    $extension2 = strtolower(pathinfo($nombre_archivo2, PATHINFO_EXTENSION));

                                    // Obtener el nombre y la extensión del tercer archivo
                                    $nombre_archivo3 = basename($_FILES["cu"]["name"]);
                                    $extension3 = strtolower(pathinfo($nombre_archivo3, PATHINFO_EXTENSION));

                                    // Obtener el nombre y la extensión del cuarto archivo
                                    $nombre_archivo4 = basename($_FILES["ac"]["name"]);
                                    $extension4 = strtolower(pathinfo($nombre_archivo4, PATHINFO_EXTENSION));


                                    // Validar las extensiones de los archivos
                                    $extensiones_permitidas = array("pdf", "doc", "docx");

                                    if (in_array($extension1, $extensiones_permitidas) && in_array($extension2, $extensiones_permitidas)
                                    && in_array($extension3, $extensiones_permitidas)&& in_array($extension4, $extensiones_permitidas)) {
                                        // Mover el primer archivo a la carpeta de destino
                                        if (move_uploaded_file($_FILES["dom"]["tmp_name"], $carpeta_destino . $nombre_archivo1) &&
                                            move_uploaded_file($_FILES["re"]["tmp_name"], $carpeta_destino . $nombre_archivo2)&&
                                            move_uploaded_file($_FILES["cu"]["tmp_name"], $carpeta_destino . $nombre_archivo3)&&
                                            move_uploaded_file($_FILES["ac"]["tmp_name"], $carpeta_destino . $nombre_archivo4)) {

                                            // Actualizar la información de los archivos en la base de datos
                                            $sql = "UPDATE estudiante SET
                                                    comprobante_domiciliario='$nombre_archivo1',
                                                    receta_medica='$nombre_archivo2',
                                                    curp='$nombre_archivo3',
                                                    actanacimiento='$nombre_archivo4'
                                                    WHERE matricula = '$var1'";

                                            $resultado = mysqli_query($conn, $sql);
                                            if ($resultado) {
                                                echo "<script language='JavaScript'>
                                                alert('Archivos Subidos');
                                                location.assign('tablaalumno.php');
                                                </script>";
                                            } else {
                                                echo "<script language='JavaScript'>
                                                alert('Error al subir los archivos');
                                                location.assign('AgregarArchivosA.php');
                                                </script>";
                                            }
                                        } else {
                                            echo "<script language='JavaScript'>
                                            alert('Error al subir los archivos');
                                            location.assign('AgregarArchivosA.php');
                                            </script>";
                                        }
                                    } else {
                                        echo "<script language='JavaScript'>
                                        alert('Solo se permiten archivos PDF, DOC y DOCX.');
                                        </script>";
                                    }
                                }
                                ?>
                                    <form action="" method="POST" enctype="multipart/form-data">

                                        <div class="row">
                                            <div class="col-sm-6">
                                                
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Comprobante de Domicilio (WORD & PDF)</label>
                                            <input type="file" name="dom" id="archivo" class="form-control" required>

                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Receta Medica (WORD & PDF)</label>
                                            <input type="file" name="re" id="archivo" class="form-control" required>
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">CURP (WORD & PDF)</label>
                                            <input type="file" name="cu" id="archivo" class="form-control" required>
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Acta de Nacimiento(WORD & PDF)</label>
                                            <input type="file" name="ac" id="archivo" class="form-control" required>
                                        </div>
                                        <br>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" id="register" name="registrar">Guardar</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                        </div>

                                </div>

                                </form>
                            </div>
                        </div>
                </div>
                <!-------------------modal----------->
            </div>
        </div>
    </section>
    <script src="js/appDash.js"></script>
       <!-- jQuery, Popper.js, Bootstrap JS -->
       <script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
      
    <!-- datatables JS -->
    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>  
</body>
</html>
