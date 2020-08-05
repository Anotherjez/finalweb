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

if($_POST){

  foreach($_POST as &$value){
    $value = addslashes($value);
  }        

  extract($_POST);
  $userid = $user->getId();
  $sql = "select * from guests where pasaporte = '{$pasaporte}'";
  $objs = Connection::query_arr($sql);
  $objs = $objs[0];
  $guestid = $objs['id'];

  Write_Log("Eliminar huesped", $userid, $guestid);
  $sql = "delete from guests where pasaporte = '{$pasaporte}'";
  Connection::execute($sql);
    
  header("Refresh:0");
}

include('headerpanel.php');

?>

<div class="container">
  <h2>Huespedes</h2>
  <br>
  <a href="guestedit.php" class="btn btn-success"><i class="fas fa-user-plus"></i> Añadir huesped</a>
  
</div>
<br>

<div class="table-responsive">
    <table class="table table-striped table-hover" style="margin-bottom: 260px;">
    <thead class="thead-dark">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Foto</th>
        <th scope="col">Nombre</th>
        <th scope="col">Apellido</th>
        <th scope="col">Pasaporte</th>
        <th scope="col">Correo</th>
        <th scope="col">Telefono</th>
        <th scope="col">Pais</th>
        <th scope="col">Fecha de llegada</th>
        <th scope="col">Fecha de salida</th>
        <th scope="col">Habitacion</th>
        <th scope="col">Accion</th>
        </tr>
    </thead>
    <tbody>
        <?php GetGuests(); ?>
    </tbody>
    </table>
<div>

<script>

  function DeleteGuest(e){
    tr = e.parentNode.parentNode;
    if(confirm('¿Esta seguro que desea eliminar?')){
      value = tr.getAttribute('index');
      $.ajax({
        url: 'home.php',
        type: 'POST',
        dataType: 'html',
        data: {'pasaporte': value}
      });
    } 
  }
</script>

<?php include('footerpanel.php'); ?>