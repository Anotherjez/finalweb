<?php

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

if(!isset($_GET['log'])){

    header("Location: user.php");

}

include('headerpanel.php');

?>

<div class="container">
  <h2>Logs de Usuarios</h2>
</div>
<br>

<div class="table-responsive">
    <table class="table table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Usuario ID</th>
            <th scope="col">Huesped ID</th>
            <th scope="col">Direccion IP</th>
            <th scope="col">Accion</th>
            <th scope="col">Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php GetLogs($_GET['log']); ?>
    </tbody>
    </table>
<div>

<?php include('../footer.php'); ?>