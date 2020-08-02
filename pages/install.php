<?php

include('../libs/utils.php');

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
    
    $sql = "CREATE TABLE guests(
    id int(11) not null primary key auto_increment,
    nombre varchar(250) not null,
    apellido varchar(250) not null,
    pasaporte varchar(250) not null,
    correo varchar(250) not null,
    telefono varchar(250) not null,
    pais varchar(250) not null,
    firstdate date,
    lastdate date,
    room int(11));";

    mysqli_query($con, $sql);

    $sql = "create table user_role(
    id int PRIMARY KEY AUTO_INCREMENT not null,
    name varchar(10));";
    
    mysqli_query($con, $sql);

    $sql = "CREATE TABLE users(
    id int(11) not null primary key auto_increment,
    name varchar(250) not null,
    username varchar(250) not null,
    password varchar(250) not null,
    role int(11) not null,
    FOREIGN KEY (role)
        REFERENCES user_role(id));";
    
    mysqli_query($con, $sql);

    $sql = "CREATE TABLE user_log(
	id int not null PRIMARY KEY AUTO_INCREMENT,
    user_id int not null,
    guest_id int not null,
    remote_addr varchar(255) NOT NULL DEFAULT '',
    request_uri varchar(255) NOT NULL DEFAULT '',
    message text NOT NULL,
    log_date timestamp NOT NULL DEFAULT NOW(),
    FOREIGN KEY(user_id)
    	REFERENCES users(id),
    FOREIGN KEY(guest_id)
    	REFERENCES guests(id));";
    
    mysqli_query($con, $sql);

    $sql = "insert into user_role(name) VALUES('admin'),('user')";
    
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Instalar Hotel Magno</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.scss">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
<body> 
    <img src="../assets/images/hotelicon.png" class="rounded mx-auto d-block" style="padding-top: 40px;">

    <?php

        if(!file_exists("../libs/configx.php")){
            LoadInstall();
        }else{
            Installed();
        }
    ?>
    
</body>
</html>