<?php

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
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
                $correo = $_POST ['cor'];
                $contrasenas = $_POST ['con'];
                $contrasena = hash('sha512', $contrasenas);

                session_start();
                if(isset($_SESSION['idjefe'])){
                    header("location: dashAD.php");
                }


                $sql="SELECT id_jefe,id_roll FROM jefe WHERE correo='$correo' and contrasena='$contrasena'
                    UNION 
                    SELECT no_control,id_roll FROM instructor WHERE correo='$correo' AND contrasena='$contrasena'";
                $resultado= $conn->query($sql);
                $rows=$resultado->num_rows;

                    if($rows > 0){
                        $row=$resultado->fetch_assoc();
                        $id_rol = $row['id_roll'];
                        $_SESSION['idjefe']=$row['id_jefe'];

                        if ($id_rol == 1) {
                            // Si el rol es 1 (admin)
                            header("location:dashAD.php");
                        } elseif ($id_rol == 2) {
                            // Si el rol es 2 (lector)
                            header("location:dashL.php");
                        } else {
                            // Otro rol no definido
                            echo '
                                <script>
                                    alert("Rol no definido para este usuario");
                                    window.location = "log.php";
                                </script>
                            ';
                            exit;
                        }
                        exit;

                    }else {
                        echo '
                            <script>
                                
                        
                            alert ("Usuario o contraseña incorrectos ");
                            window.location = "log.php";

                            
                            </script>
                        ';
                        exit;
                    }
                }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="img/TESJO.png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN & REGISTRO</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/diseño.css">
</head>
<body>
    <header class="header">
    </header>


    <div class="lds-ring loader" id="loader"><div></div><div></div><div></div><div></div></div>
    
<main>


<div class="contenedor__todo">
    <div class="caja__trasera">

       <div class="caja__trasera-login">
        <h3>¿Ya tienes una cuenta?</h3>
        <p>Inicia sesion para entrar a la pagina</p>
        <button id="btn__iniciar-sesion">Iniciar Sesion</button>
       </div>

       <div class="caja__trasera-register">
        <h3>¿Aun no tienes una cuenta?</h3>
        <p> Solicita al departamento que te otorge un permiso </p>
       </div>
    </div>


<!--Login register-->
    <div class="contenedor__login-register">

        <!--Login-->

        <form action="log.php" method="POST" class="formulario__login">
        <h2>INICIAR SESIÓN</h2>
        <input type="text" placeholder="Correo Electronico" name ="cor">
        <input type="password" placeholder="Contraseña" name = "con">
        <button >ENTRAR</button>
        </form>
    </div>
</div>

</main>

<script src="js/script.js"></script>

</body>
</html>