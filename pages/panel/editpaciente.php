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

    $sql = "select * from guests where pasaporte = '{$pasaporte}'";

    $objs = Connection::query_arr($sql);
    if(count($objs) > 0){
        
        $sql = "update guests set nombre = '{$nombre}', apellido = '{$apellido}', correo = '{$correo}', telefono = '{$telefono}', pais = '{$pais}', firstdate = '{$firstdate}', lastdate = '{$lastdate}', room = {$room} where pasaporte = '{$pasaporte}'";
        $userid = $user->getId();
        $guestid = $objs[0];
        $guestid = $guestid['id'];
        Write_Log("Editar huesped", $userid, $guestid);
    }else{
        $sql = "insert into guests(nombre, apellido, pasaporte, correo, telefono, pais, firstdate, lastdate, room) 
        values('{$nombre}','{$apellido}','{$pasaporte}','{$correo}','{$telefono}','{$pais}','{$firstdate}','{$lastdate}',{$room})";
    }
    
    $rsid = Connection::execute($sql, true);
    
    if(!count($objs) > 0){
        $sql = "select * from guests where pasaporte = '{$pasaporte}'";
        $objs = Connection::query_arr($sql);
        $userid = $user->getId();
        $guestid = $objs[0];
        $guestid = $guestid['id'];
        Write_Log("Añadir huesped", $userid, $guestid);
    }
    
    $dir = "../../assets/profile";
        
    if(!is_dir($dir)){
        mkdir($dir);
    }

    $file = $_FILES['foto'];
    if($file['error'] == 0){
        move_uploaded_file($file['tmp_name'], "{$dir}/{$rsid}.jpg");
    }

    header("Location:dashboard.php");

}
else if(isset($_GET['guest'])){

    $sql = "select * from guests where pasaporte = '{$_GET['guest']}'";

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
    
    <?php if($isEditing) : echo "<h2>Editar Huesped</h2>"; else : echo "<h2>Añadir Huesped</h2>";endif; ?>
    <br>    
    <form enctype="multipart/form-data" method="POST">

        <?php 
            $condition = ['placeholder'=>'RD0101010'];
            if($isEditing){
                $condition['readonly'] = 'readonly';
            }
            echo Input('pasaporte','Pasaporte','', $condition);        
        ?>
        <!-- Nombre -->
        <?= Input('nombre','Nombre','', ['placeholder'=>'Ingrese su nombre']) ?>
        <?= Input('apellido','Apellido','', ['placeholder'=>'Ingrese su apellido']) ?>
        <?= Input('correo','Correo','', ['placeholder'=>'name@example.com', 'type'=>'email']) ?>
        <?= Input('telefono','Telefono','', ['placeholder'=>'8091231234']) ?>
        <?= Input('pais','Pais de origen','', ['placeholder'=>'Republica Dominicana']) ?>
        <?= Input('firstdate','Fecha de llegada','', ['type'=>'date']) ?>
        <?= Input('lastdate','Fecha de salida','', ['type'=>'date']) ?>
        <?= Input('room','Numero de habitacion','', ['placeholder'=>'301','type'=>'number']) ?>
        <?= Input('foto','Foto','',['type'=>'file']) ?>
        
        <br>
        <br>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="home.php" class="btn btn-secondary">Cancelar</a>
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