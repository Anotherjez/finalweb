<?php

include('../libs/utils.php');

if(isset($_POST['password1']) && isset($_POST['password2'])){
    if($_POST && $_POST['password1'] == $_POST['password2']){

        foreach($_POST as &$value){
            $value = addslashes($value);
        }        
        
        extract($_POST);
    
        $con = mysqli_connect($servername,$username,$password);
    
        $sql = "DROP DATABASE IF EXISTS {$dbname};";
        mysqli_query($con, $sql);
        $sql = "CREATE DATABASE {$dbname};";
        mysqli_query($con, $sql);
    
        mysqli_query($con, "use {$dbname}");
        
        // Costo Consultas
        $sql = "CREATE TABLE costoconsultas(
        id int(11) not null primary key auto_increment,
        costo double not null
        )";

        mysqli_query($con, $sql);

        // Consultas
        $sql = "CREATE TABLE consultas(
        id int(11) not null primary key auto_increment,
        title varchar(80) not null,
        costo double,
        monto_pagado double,
        fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        )";

        mysqli_query($con, $sql);
    
        // Pacientes
        $sql = "CREATE TABLE pacientes(
        id int(11) not null primary key auto_increment,
        cedula varchar(14) not null,
        nombre varchar(255) not null,
        apellido varchar(255) not null,
        nacimiento date not null,
        telefono varchar(60) not null,
        sangre nchar(2) not null);";
    
        mysqli_query($con, $sql);

        // Visita
        $sql = "CREATE TABLE visitas(
        id int(11) not null primary key auto_increment,
        paciente_id int not null,
        fecha date not null,
        comentario varchar(255) not null,
        receta varchar(255) not null,
        fecha_proxima date not null,
        FOREIGN KEY(paciente_id)
            REFERENCES pacientes(id));";
    
        mysqli_query($con, $sql);
    
        // Eventos/citas/calendario
        $sql= "CREATE TABLE events(
            id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            color varchar(7) DEFAULT NULL,
            start datetime NOT NULL,
            end datetime DEFAULT NULL
        );";
        mysqli_query($con, $sql);
    
        // Roles
        $sql = "CREATE TABLE user_role(
        id int PRIMARY KEY AUTO_INCREMENT not null,
        name varchar(10));";
        
        mysqli_query($con, $sql);
    
        // Usuarios
        $sql = "CREATE TABLE users(
        id int(11) not null primary key auto_increment,
        name varchar(250) not null,
        username varchar(250) not null,
        password varchar(250) not null,
        role int(11) not null,
        FOREIGN KEY (role)
            REFERENCES user_role(id));";
        
        mysqli_query($con, $sql);
    
        // Registros/Log
        $sql = "CREATE TABLE user_log(
        id int not null PRIMARY KEY AUTO_INCREMENT,
        user_id int not null,
        paciente_id int,
        remote_addr varchar(255) NOT NULL DEFAULT '',
        request_uri varchar(255) NOT NULL DEFAULT '',
        message text NOT NULL,
        log_date timestamp NOT NULL DEFAULT NOW(),
        FOREIGN KEY(user_id)
            REFERENCES users(id),
        FOREIGN KEY(paciente_id)
            REFERENCES pacientes(id));";
        
        mysqli_query($con, $sql);

        $sql = "insert into costoconsultas(costo) VALUES(500.00)";
        
        mysqli_query($con, $sql);
    
        $sql = "insert into user_role(name) VALUES('admin'),('doctor'),('asistente')";
        
        mysqli_query($con, $sql);
        
        $userpassword = md5($_POST['password1']);
        $sql = "insert into users(name, username, password, role) VALUES('{$_POST['name']}', '{$_POST['adminuser']}', '{$userpassword}', 1)";
        
        mysqli_query($con, $sql);
        mysqli_close($con);
    
        if($con == true){
            $config = "<?php
            define('DB_HOST', '{$servername}');
            define('DB_USER', '{$username}');
            define('DB_PASS', '{$password}');
            define('DB_NAME', '{$dbname}');
            ?>";
    
            if(!file_exists("../libs/configx.php")){
                file_put_contents('../libs/configx.php', $config, FILE_APPEND | LOCK_EX);
            }else{    
                file_put_contents("../libs/configx.php", $config);
            }
            header("Location:index.php");
        }
        
    }else if($_POST['password1'] != $_POST['password2'] && isset($_POST)){
        echo '<script language="javascript">';
        echo "alert('Las contraseñas no coinciden!');";
        echo '</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Instalar Consultorio</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/aos.css">
    <script src="../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
</head>
<body> 
    <img src="../assets/images/servidor.png" class="rounded mx-auto d-block" style="padding: 40px 0 40px 0;" data-aos="zoom-in" data-aos-duration="1200">

    <?php

        if(!file_exists("../libs/configx.php")){
            LoadInstall();
        }else{
            Installed();
        }
    ?>

<script src="../assets/js/aos.js"></script>
<script>
  AOS.init();

  $(document).ready(function(){
        $('#adminuser').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
    });
</script>
<script src="../assets/js/jquery.mask.min.js"></script>
<?php include("footer.php"); ?>