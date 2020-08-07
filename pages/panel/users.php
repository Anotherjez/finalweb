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

if(!($user->getRole() == 1)){
  header("Location: dashboard.php");
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
    <table class="table table-striped table-hover" data-aos="fade-up" data-aos-duration="1000">
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

<script src="../../assets/js/aos.js"></script>
<script>
  AOS.init();
</script>
<?php include('../footer.php'); ?>