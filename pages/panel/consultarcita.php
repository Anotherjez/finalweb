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

if(!($user->getRole() == 2)){
  header("Location: dashboard.php");
}

include('headerpanel.php');

?>

<div class="container">
  <h2>Consultar cita proxima</h2>
  <br>
  <form action="showcita.php" method="get">
      <label>Ingrese una fecha</label>
      <input type="date" name="fecha" id="fecha" class="form-control" style="margin-bottom:20px;">
      
      <button type="submit" class="btn btn-primary">Consultar</button>
  </form>
</div>


<?php include('../footer.php'); ?>