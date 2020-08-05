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
if(!($user->getRole() == 2)){
    header("Location: dashboard.php");
}

if($_POST && isset($_GET['paciente'])){

    foreach($_POST as &$value){
        $value = addslashes($value);
    }        
    
    extract($_POST);

    $sql = "select id from pacientes where cedula = '{$_GET['paciente']}'";
    $objs = Connection::query_arr($sql);
    $paciente = $objs[0];

    $sql = "insert into visitas(paciente_id, fecha, comentario, receta, fecha_proxima) 
    values('{$paciente['id']}','{$fecha}','{$comentario}','{$receta}','{$nextdate}')";
        
    $rsid = Connection::execute($sql, true);
    
    $userid = $user->getId();
    Write_Log("Registrar un evento de visita", $userid, $paciente['id']);
     

    header("Location:visitas.php");

}

include('headerpanel.php');

?>

<div class="container" style="padding-bottom: 40px;">
    
    <h2>Registrar evento de visita</h2>
    <br>    
    <form enctype="multipart/form-data" method="POST">

        <!-- Nombre -->
        <?= Input('fecha','Fecha','', ['type'=>'date']) ?>
        <?= Input('comentario','Comentario','', ['placeholder'=>'Ingrese un comentario sobre la visita']) ?>
        <?= Input('receta','Receta','', ['placeholder'=>'Ingrese las indicaciones de la receta']) ?>
        <?= Input('nextdate','Fecha de proxima visita','', ['type'=>'date']) ?>
        
        <br>
        <br>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="visitas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include('../footer.php'); ?>