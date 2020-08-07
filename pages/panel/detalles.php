<?php

$isEditing = true;

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

if(isset($_GET['cedula'])){

    $sql = "select * from pacientes where cedula = '{$_GET['cedula']}'";

    $objs = Connection::query_arr($sql);
    
    if(count($objs) > 0){
        $data = $objs[0];
        $_POST = $data;
        $isEditing = true;
    }
}

include('headerpanel.php');

?>

<div class="container" style="padding-bottom: 40px;">
    
    <h2>Este paciente ya existe</h2>
    <br>    
    <form enctype="multipart/form-data" method="POST">

        <?php 
            $condition = ['placeholder'=>'Cedula'];
            if($isEditing){
                $condition['readonly'] = 'readonly';
            }
            echo Input('cedula','Cedula',$_GET['cedula'], $condition);        
        ?>
        
        <?= Input('nombre','Nombre','', ['placeholder'=>'Ingrese su nombre', 'readonly'=>'readonly']) ?>
        <?= Input('apellido','Apellido','', ['placeholder'=>'Ingrese su apellido', 'readonly'=>'readonly']) ?>
        <?= Input('nacimiento','Fecha de Nacimiento','', ['type'=>'date', 'readonly'=>'readonly']) ?>
        <?= Input('telefono','Telefono','', ['placeholder'=>'8091231234', 'readonly'=>'readonly']) ?>
        <?= Input('sangre','Tipo de Sangre','', ['placeholder'=>'Tipo de Sangre', 'readonly'=>'readonly']) ?>

        
        <br>
        <br>

        
        <a href="pacientes.php" class="btn btn-secondary">Volver Atras</a>
    </form>
</div>

<?php include('../footer.php'); ?>