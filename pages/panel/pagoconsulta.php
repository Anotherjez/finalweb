<?php

$isEditing = false;

include('../../libs/panelutils.php');

Connection::testconnection();

include_once('../../libs/user.php');
include_once('../../libs/user_session.php');

$userSession = new UserSession();
$user = new User();

if(isset($_SESSION['user'])){
    $user->setUser($userSession->getCurrentUser());
  }else if(isset($_POST['username']) && isset($_POST['password'])){
      
    $userForm = $_POST['username'];
    $passForm = $_POST['password'];
  
    if ($user->userExists($userForm, $passForm)) {
      $userSession->setCurrentUser($userForm);
      $user->setUser($userForm);
      header("Location: ../index.php");
    }else{
      echo '<script language="javascript">';
      echo "alert('Nombre de usuario y/o password incorrectos');";
      echo '</script>';
    }
  
  }else{
    header("Location: ../login.php");
}
if(!($user->getRole() == 3)){
    header("Location: dashboard.php");
}

if($_POST){

    foreach($_POST as &$value){
        $value = addslashes($value);
    }        
    
    extract($_POST);
    $monto ="select costo from costoconsultas where id = 1";
  
    $sql = "select * from consultas where title = '{$title}'";
 $objs = Connection::query_arr($sql);
 $objs1 = Connection::query_arr($monto);
    
      /*  $sql = "insert into consultas(title, costo, monto_pagado) 
        values('{$title}','{$nombre}','{$monto}')";*/
  
    
    $rsid = Connection::execute($sql, true);
    $rsid1 = Connection::execute($monto, true);
    var_dump($monto);
}

include('headerpanel.php');

?>

<div class="container" style="padding-bottom: 40px;">
    
    <h2>Añadir Paciente</h2>
    <br>    
    <form enctype="multipart/form-data" method="POST">
    <?= Input('title','Titulo de la Consulta','', ['placeholder'=>'Ex: Consulta con el Dr.Perez por las sgtes razones.....']) ?>
    <?= Input('monto','Monto a Pagar','', ['type'=>'number']) ?>
          
        <br>
        <br>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script>
    $(document).ready(function(){
        $('.pasaporte').mask('AA0000000');
        $('.room').mask('000');
        $('.telefono').mask('000000000000000');
    });
</script>
<script src="../../assets/js/jquery.mask.min.js"></script>
<script src="../../assets/js/guests.js"></script>

<?php include('../footer.php'); ?>