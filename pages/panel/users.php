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

if(!$user->getAdmin()){
  header("Location: home.php");
}

if($_POST){

  foreach($_POST as &$value){
    $value = addslashes($value);
  }        

  extract($_POST);

  $sql = "delete from users where username = '{$username}'";
  Connection::execute($sql);
    
  header("Refresh:0");
}

include('headerpanel.php');

?>

<div class="container">
  <h2>Usuarios</h2>
  <br>
  <a href="useredit.php" class="btn btn-success"><i class="fas fa-user-plus"></i> Añadir usuario</a>
</div>
<br>

<div class="table-responsive">
    <table class="table table-striped table-hover" style="margin-bottom: 260px;">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Username</th>
            <th scope="col">Rol</th>
            <th scope="col">Accion</th>
        </tr>
    </thead>
    <tbody>
        <?php GetUsers(); ?>
    </tbody>
    </table>
<div>

<script>

  function DeleteUser(e){
    tr = e.parentNode.parentNode;
    if(confirm('¿Esta seguro que desea eliminar?')){
      value = tr.getAttribute('index');
      $.ajax({
        url: 'users.php',
        type: 'POST',
        dataType: 'html',
        data: {'username': value}
      });
    } 
  }
  
</script>

<?php include('../footer.php'); ?>