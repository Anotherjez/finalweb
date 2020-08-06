<?php

$data;

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
if(!isset($_GET['fecha'])){

    header("Location: consultarcita.php");

}
if(isset($_GET['fecha'])){

    $sql = "select * from events where DATEDIFF(start,'{$_GET['fecha']}') >=0 LIMIT 1";

    $objs = Connection::query_arr($sql);

}

include('headerpanel.php');

?>

<div class="container">
    <h2>Proxima cita</h2>
    <br>
    <? if($objs == null): ?>
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">No hay fechas proximas!</h4>
            <p>Al parecer no hay fechas proximas a las consultadas.</p>
        </div>
    <? else: ?>

        <h4>Titulo: <?= $objs[0]['title'] ?></h4>
        <h4>Fecha de inicio: <?= $objs[0]['start'] ?></h4>
        <h4>Fecha de fin: <?= $objs[0]['end'] ?></h4>        
        
    <? endif; ?>
</div>
<?php include('../footer.php'); ?>