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

if(!isset($_GET['paciente'])){

    header("Location: visitas.php");

}

include('headerpanel.php');

?>

<div class="container">
  <h2>Visitas del paciente</h2>
</div>
<br>

<div class="table-responsive">
    <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Paciente ID</th>
            <th scope="col">Fecha</th>
            <th scope="col">Comentario</th>
            <th scope="col">Receta</th>
            <th scope="col">Fecha de proxima visita</th>
        </tr>
    </thead>
    <tbody>
        <?php ShowVisitas($_GET['paciente']); ?>
    </tbody>
    </table>
<div>

<?php include('../footer.php'); ?>