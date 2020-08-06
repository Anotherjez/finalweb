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

if($_POST){

  foreach($_POST as &$value){
    $value = addslashes($value);
  }        

  extract($_POST);

  $sql = "delete from pacientes where cedula = '{$cedula}'";
  Connection::execute($sql);
    
  header("Refresh:0");
}

include('headerpanel.php');

?>

<div class="container">
  <h2>Pacientes</h2>
</div>
<br>

<div class="table-responsive">
    <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Cedula</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Fecha de nacimiento</th>
            <th scope="col">Telefono</th>
            <th scope="col">Tipo de Sangre</th>
            <th scope="col">Accion</th>
        </tr>
    </thead>
    <tbody>
        <?php GetPacientesVisitas(); ?>
    </tbody>
    </table>
<div>

<?php include('../footer.php'); ?>