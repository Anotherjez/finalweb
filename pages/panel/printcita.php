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

if(!($user->getRole() == 3)){
  header("Location: dashboard.php");
}

include('headerpanel.php');

?>

<div class="container">
  <h2>Imprimir citas en una fecha especifica</h2>
    <br>

    <form method="post" action="../../libs/generate_pdf.php">
        <input type="hidden" id="type" name="type" value="citasdia">
        <div class="form-group">
            <input required type="date" name="fecha" id="fecha" class="form-control">
        </div>
        <button type="submit" id="pdf" name="pdf" class="btn btn-outline-success"><i class="far fa-file-pdf" aria-hidden="true"></i> Imprimir Receta</button>
    </form>
</div>

<?php include('../footer.php'); ?>