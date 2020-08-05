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

    $sql = "select * from pacientes where cedula = '{$cedula}'";

    $objs = Connection::query_arr($sql);
    if(count($objs) > 0){
        
        header("Location: detalles.php?cedula={$paciente['cedula']}");
    }else{
        header("Location: editpaciente.php");
    }

}

include('headerpanel.php');

?>

<div class="container" style="padding-bottom: 40px;">
    
    <h2>Añadir Paciente</h2>
    <br>    
    <form enctype="multipart/form-data" method="GET" action="editpaciente.php">
        
        <?= Input('cedula','Cedula','', ['placeholder'=>'Cedula']) ?>
          
        <br>
        <br>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="editpaciente.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script>
    $(document).ready(function(){
        $('.pasaporte').mask('AA0000000');
        $('.room').mask('000');
        $('.telefono').mask('000000000000000');
    });
</script>
<script src="../../assets/js/jquery.mask.min.js"></script>
<script src="../../assets/js/guests.js"></script>

<?php include('../footer.php'); ?>