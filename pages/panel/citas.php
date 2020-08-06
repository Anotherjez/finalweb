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
    if(count($objs) > 0){
        
        $sql = "update events set title = '{$title}', start = '{$start}', end = '{$end}'";
        $userid = $user->getId();
        $guestid = $objs[0];
        $guestid = $guestid['id'];
        Write_Log("Editar Cita", $userid, $guestid);
    }else{
        $sql = "insert into events(title, start, end, nacimiento, telefono, sangre) 
        values('{$title}','{$start}','{$end}')";
    }
    
    $rsid = Connection::execute($sql, true);
    
    if(!count($objs) > 0){
        $sql = "select * from events where title = '{$title}'";
        $objs = Connection::query_arr($sql);
        $userid = $user->getId();
        $guestid = $objs[0];
        $guestid = $guestid['id'];
        Write_Log("Añadir Cita", $userid, $guestid);
    }    

    header("Location:dashboard.php");

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
    
    <?php if($isEditing) : echo "<h2>Crear Cita</h2>"; else : echo "<h2>Crear Cita</h2>";endif; ?>
    <br>    
    <form enctype="multipart/form-data" method="POST">

        <?php 
            $condition = ['placeholder'=>'Cedula'];
            if($isEditing){
                $condition['readonly'] = 'readonly';
            }
               
        ?>
        <!-- Nombre -->
        
        <?= Input('title','Titulo de la Cita','', ['placeholder'=>'Ex: Cita con el Dr.Hernandez para revisar.....']) ?>

        <?= Input('start','Hora de comienzo','', ['type'=>'time']) ?>
        <?= Input('end','Hora de salida','', ['type'=>'time']) ?>
     

        
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