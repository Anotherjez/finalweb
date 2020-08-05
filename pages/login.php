<?php

include_once('../libs/user.php');
include_once('../libs/user_session.php');

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
    header("Location:index.php");
  }else{
    echo '<script language="javascript">';
    echo "alert('Nombre de usuario y/o password incorrectos');";
    echo '</script>';
  }

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Consultoria Medica</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <script src="../assets/js/bootstrap.min.js"></script>
  </head>
  <body> 
<div class="container login">
  <form action="" method="POST">
    <h2>Iniciar sesion</h2>
    <div class="form-group">
        <label for="usernameLabel">Nombre de usuario</label>
        <input type="text" class="form-control" id="username" name="username">
    </div>
    <div class="form-group">
        <label for="passwordLabel">Password</label>
        <input type="password" class="form-control" id="password" name="password">
        <small id="errorLabel" class="form-text text-muted"></small>
    </div>
    <button type="submit" class="btn btn-primary">Iniciar sesion</button>
    </form>
</div>

<?php include("footer.php"); ?>