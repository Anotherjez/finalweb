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
        
        $sql = "update pacientes set cedula = '{$cedula}', nombre = '{$nombre}', apellido = '{$apellido}', nacimiento = '{$nacimiento}', telefono = '{$telefono}', sangre = '{$sangre}'";
        $userid = $user->getId();
        $pacienteid = $objs[0];
        $pacienteid = $pacienteid['id'];
        Write_Log("Editar Paciente", $userid, $pacienteid);
    }else{
        $sql = "insert into pacientes(cedula, nombre, apellido, nacimiento, telefono, sangre) 
        values('{$cedula}','{$nombre}','{$apellido}','{$nacimiento}','{$telefono}','{$sangre}')";
    }
    
    $rsid = Connection::execute($sql, true);
    
    if(!count($objs) > 0){
        $sql = "select * from pacientes where cedula = '{$cedula}'";
        $objs = Connection::query_arr($sql);
        $userid = $user->getId();
        $pacienteid = $objs[0];
        $pacienteid = $pacienteid['id'];
        Write_Log("Añadir Paciente", $userid, $pacienteid);
    }    

    header("Location:pacientes.php");

}
else if(isset($_GET['cedula'])){

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
    
    <?php if($isEditing) : echo "<h2>Editar Paciente</h2>"; else : echo "<h2>Añadir Paciente</h2>";endif; ?>
    <br>    
    <form enctype="multipart/form-data" method="POST">

        <?php 
            $condition = ['placeholder'=>'Cedula'];
            if($isEditing){
                $condition['readonly'] = 'readonly';
            }
            echo Input('cedula','Cedula',$_GET['cedula'], $condition);        
        ?>
        <!-- Nombre -->
        
        <?= Input('nombre','Nombre','', ['placeholder'=>'Ingrese su nombre']) ?>
        <?= Input('apellido','Apellido','', ['placeholder'=>'Ingrese su apellido']) ?>
        <?= Input('nacimiento','Fecha de Nacimiento','', ['type'=>'date']) ?>
        <?= Input('telefono','Telefono','', ['placeholder'=>'8091231234']) ?>
        <?= Input('sangre','Sangre','', ['placeholder'=>'Tipo de Sangre']) ?>

        
        <br>
        <br>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="pacientes.php" class="btn btn-secondary">Cancelar</a>
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