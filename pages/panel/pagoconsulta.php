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
  $sql ="select costo from costoconsultas where id = 1";

  $costo = Connection::query_arr($sql);
  $costo = $costo[0];
  $sql = "insert into consultas(title, costo, monto_pagado) 
  values('{$title}',{$costo['costo']},{$monto})";

  Connection::execute($sql);

  header("Location:dashboard.php");
}

include('headerpanel.php');

?>

<div class="container" style="padding-bottom: 40px;">
    
    <h2>Registrar pago de consulta</h2>
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

<?php include('../footer.php'); ?>