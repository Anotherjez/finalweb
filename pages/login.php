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
    <title>Hotel Magno</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.scss">
    <link rel="stylesheet" href="../assets/css/login.scss">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
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


  <section id="footer">
  <div class="container">
    <div class="row">
      <div class="mx-auto">
        <ul class="list-unstyled list-inline social text-center">
          <li class="list-inline-item"><a href="https://www.youtube.com/channel/UC0RfXvPGEcMlJouPg6TL-Hg" target="_blank"><i class="ali ali-yt"></i></a></li>
          <li class="list-inline-item"><a href="https://www.instagram.com/anotherjez/" target="_blank"><i class="ali ali-ig"></i></a></li>
          <li class="list-inline-item"><a href="https://github.com/Anotherjez" target="_blank"><i class="ali ali-git"></i></a></li>
        </ul>
      </div>
    </div>	
    <div class="row">
      <div class="col mx-auto text-center text-white">
        <p><u><a href="#homeNavBar">Hotel Magno</a></u> es un proyecto con fines educativos</p>
        <p class="h6">© Todos los derechos reservados.<a class="text-green ml-2" href="https://www.instagram.com/anotherjez/" target="_blank">Jesus Mercado</a></p>
      </div>	
		</div>
	</section>
</body>
</html>