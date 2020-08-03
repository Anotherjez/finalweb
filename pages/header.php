<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Consultoria Medica</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/aos.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
  </head>
  <body>    

  <nav class="navbar navbar-expand-lg navbar-light shadow p-3 mb-5 bg-white sticky-top" id="homeNavBar">
  <a class="navbar-brand" href="index.php">
    <img src="../assets/images/icon.svg" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">  
    Consultoria Medica
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
    <div class="nav">
      <? if ($user->isUser()): ?>
        <a class="btn btn-primary" href="panel/home.php"><span class="font-weight-bold">Panel</span></a>
        <a class='nav-item nav-link' href='logout.php'>Cerrar sesion</a>
      <? else: ?>
        <a class='nav-item nav-link' href='login.php'>Iniciar sesion</a>
      <? endif; ?>
    </div>
  </div>
</nav>