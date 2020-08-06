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
if(!($user->getRole() == 1)){
    header("Location: dashboard.php");
}

if($_POST){

    foreach($_POST as &$value){
        $value = addslashes($value);
    }        
    
    extract($_POST);

    $sql = "update costoconsultas set costo = {$costo} where id = 1";
        
    Connection::execute($sql);
    
    $userid = $user->getId();
    Write_Log("Asignar costo consulta", $userid);
     

    header("Location:editconsultas.php");

}
$sql = "select costo from costoconsultas where id = 1";
        
$costo = Connection::query_arr($sql);
$costo = $costo[0];

include('headerpanel.php');

?>

<div class="container" style="padding-bottom: 40px;">
    
    <div class="row">
        <div class="col">
            <h2>Asignar costo de consultas</h2>
        </div>
        <div class="col">
            <h2>Costo actual: RD$<?= $costo['costo'] ?></h2>
        </div>
    </div>
    <br>    
    <form enctype="multipart/form-data" method="POST">

        <!-- Nombre -->
        <?= Input('costo','Monto (RD$)','', ['type'=>'number']) ?>
        
        <br>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>

<?php include('../footer.php'); ?>