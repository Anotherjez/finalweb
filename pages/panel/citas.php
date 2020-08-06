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

    $sql = "select * from events where title = '{$title}'";

    $objs = Connection::query_arr($sql);

    $start = $fecha + ' ' + $start;
    $end = $fecha + ' ' + $end;
    $color = "#008000";

    $sql = "insert into events(title, color, start, end) 
    values('{$title}','{$color}',{$start}','{$end}')";
    
    
    $rsid = Connection::execute($sql, true);
    

    $sql = "select * from events where title = '{$title}'";
    $objs = Connection::query_arr($sql);
    $userid = $user->getId();
    $guestid = $objs[0];
    $guestid = $guestid['id'];
    Write_Log("Añadir Cita", $userid, $guestid);
     

    header("Location:dashboard.php");

}

include('headerpanel.php');

?>

<div class="container" style="padding-bottom: 40px;">
    
    <h2>Crear Cita</h2>
    <br>    
    <form enctype="multipart/form-data" method="POST">

        
        <?= Input('title','Titulo de la Cita','', ['placeholder'=>'Ex: Cita con el Dr.Hernandez para revisar.....']) ?>
        <?= Input('fecha','Hora de comienzo','', ['type'=>'date']) ?>
        <?= Input('start','Hora de comienzo','', ['type'=>'time']) ?>
        <?= Input('end','Hora de salida','', ['type'=>'time']) ?>
     

        
        <br>
        <br>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="pacientes.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include('../footer.php'); ?>