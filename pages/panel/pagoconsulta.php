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

$sql ="select costo from costoconsultas where id = 1";

$costo = Connection::query_arr($sql);
$costo = $costo[0];

if($_POST){

  foreach($_POST as &$value){
      $value = addslashes($value);
  }        
  
  extract($_POST);

  $sql = "insert into consultas(title, costo, monto_pagado) 
  values('{$title}',{$costo['costo']},{$monto})";
  echo "<script>alert('Consulta creada exitosamente');window.location='dashboard.php'</script>";
  Connection::execute($sql);
 
  header("Location:printconsulta.php");
}

include('headerpanel.php');

?>

<div class="container">

  <h2>Registrar pago de consulta</h2>
  <h4>Precio por consulta: RD$<?= $costo['costo'] ?></h4>
  <br>    
  <form enctype="multipart/form-data" method="POST">
    <?= Input('title','Titulo de la Consulta','', ['placeholder'=>'Ex: Consulta con el Dr.Perez por las sgtes razones.....']) ?>
    <div class="form-group">
      <label>Monto a pagar</label>
      <input required type="number" value="0" class="form-control" id="monto" name="monto" max=<?= $costo['costo'] ?>>
    </div>

    <button type="submit" class="btn btn-primary">Registrar</button>
    <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php include('../footer.php'); ?>