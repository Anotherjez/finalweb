<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Consultoria Medica</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/panel.css">
    <link rel="stylesheet" href="../../assets/css/aos.css">
    <link rel="stylesheet" href="../../assets/css/main.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="../../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
  </head>
<body>    

<nav class="navbar navbar-expand-lg navbar-light shadow-sm p-3 mb-5 bg-white sticky-top" id="homeNavBar">
  <a class="navbar-brand" href="../index.php">
    <img src="../../assets/images/icon.svg" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">  
    Consultoria Medica
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
    <div class="nav">
      <a class="nav-item nav-link" href="../index.php">Pagina principal</a>
      <? if ($user->isUser()): ?>
        <a class='nav-item nav-link' href='../logout.php'>Cerrar sesion</a>
      <? else: ?>
        <a class='nav-item nav-link' href='../login.php'>Iniciar sesion</a>
      <? endif; ?>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
          <!-- Dashboard -->
          <? if(strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false): ?>
            <a class="nav-link active" href="dashboard.php">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard <span class="sr-only">(current)</span>
            </a>
          <? else: ?>
            <a class="nav-link" href="dashboard.php">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
            </a>
          <? endif; ?>
          </li>
          <!-- Usuarios -->
          <? if($user->getRole() == 1): ?>
            <? if(strpos($_SERVER['REQUEST_URI'], 'users') !== false): ?>
              <li class="nav-item">
                <a class="nav-link active" href="users.php">
                <i class="fas fa-users"></i>
                  Usuarios <span class="sr-only">(current)</span>
                </a>
              </li>
            <? else: ?>
              <li class="nav-item">
                <a class="nav-link" href="users.php">
                <i class="fas fa-users"></i>
                  Usuarios
                </a>
              </li>
            <? endif; ?>
          <? endif; ?>
          <!-- Reportes -->
          <? if($user->getRole() == 1): ?>
            <? if(strpos($_SERVER['REQUEST_URI'], 'reportes') !== false): ?>
              <li class="nav-item">
                <a class="nav-link active" href="reportes.php">
                <i class="fas fa-file"></i>
                  Reportes del sistema <span class="sr-only">(current)</span>
                </a>
              </li>
            <? else: ?>
              <li class="nav-item">
                <a class="nav-link" href="reportes.php">
                <i class="fas fa-file"></i>
                  Reportes del sistema
                </a>
              </li>
            <? endif; ?>
          <? endif; ?>
          <!-- Calendario -->
          <? if(strpos($_SERVER['REQUEST_URI'], 'calendario') !== false): ?>
            <li class="nav-item">
              <a class="nav-link active" href="calendario.php">
              <i class="fas fa-calendar-alt"></i>
              Consultar citas <span class="sr-only">(current)</span>
              </a>
            </li>
          <? else: ?>
            <li class="nav-item">
              <a class="nav-link" href="calendario.php">
              <i class="fas fa-calendar-alt"></i>
              Consultar citas
              </a>
            </li>
          <? endif; ?>
          <!-- Asignar costo consultas -->
          <? if($user->getRole() == 1): ?>
            <? if(strpos($_SERVER['REQUEST_URI'], 'editconsultas') !== false): ?>
              <li class="nav-item">
                <a class="nav-link active" href="editconsultas.php">
                <i class="fas fa-hand-holding-usd"></i>
                  Asignar costo consultas<span class="sr-only">(current)</span>
                </a>
              </li>
            <? else: ?>
              <li class="nav-item">
                <a class="nav-link" href="editconsultas.php">
                <i class="fas fa-hand-holding-usd"></i>
                  Asignar costo consultas
                </a>
              </li>
            <? endif; ?>
          <? endif; ?>
          <!-- Asistente -->

          <!-- Pacientes -->
          <? if($user->getRole() == 3): ?>
            <? if(strpos($_SERVER['REQUEST_URI'], 'pacientes') !== false): ?>
              <li class="nav-item">
                <a class="nav-link active" href="pacientes.php">
                <i class="fas fa-heartbeat"></i>
                  Pacientes <span class="sr-only">(current)</span>
                </a>
              </li>
            <? else: ?>
              <li class="nav-item">
                <a class="nav-link" href="pacientes.php">
                <i class="fas fa-heartbeat"></i>
                  Pacientes
                </a>
              </li>
            <? endif; ?>
          <? endif; ?> 
          <!-- Citas -->
          <? if($user->getRole() == 3): ?>
            <? if(strpos($_SERVER['REQUEST_URI'], 'citas') !== false): ?>
              <li class="nav-item">
                <a class="nav-link active" href="citas.php">
                <i class="fas fa-calendar-minus"></i>
                  Asignar citas <span class="sr-only">(current)</span>
                </a>
              </li>
            <? else: ?>
              <li class="nav-item">
                <a class="nav-link" href="citas.php">
                <i class="fas fa-calendar-minus"></i>
                  Asignar citas
                </a>
              </li>
            <? endif; ?>
          <? endif; ?> 
            <!-- Imprimir citas -->
          <? if($user->getRole() == 3): ?>
            <? if(strpos($_SERVER['REQUEST_URI'], 'printcita') !== false): ?>
              <li class="nav-item">
                <a class="nav-link active" href="printcita.php">
                <i class="fas fa-print"></i>
                  Imprimir citas <span class="sr-only">(current)</span>
                </a>
              </li>
            <? else: ?>
              <li class="nav-item">
                <a class="nav-link" href="printcita.php">
                <i class="fas fa-print"></i>
                  Imprimir citas
                </a>
              </li>
            <? endif; ?>
          <? endif; ?> 
          <!-- Cumpleanos -->
          <? if($user->getRole() == 3): ?>
            <? if(strpos($_SERVER['REQUEST_URI'], 'cumple') !== false): ?>
              <li class="nav-item">
                <a class="nav-link active" href="cumple.php">
                <i class="fas fa-birthday-cake"></i>
                  Reporte de cumpleaños <span class="sr-only">(current)</span>
                </a>
              </li>
            <? else: ?>
              <li class="nav-item">
                <a class="nav-link" href="cumple.php">
                <i class="fas fa-birthday-cake"></i>
                  Reporte de cumpleaños
                </a>
              </li>
            <? endif; ?>
          <? endif; ?> 
          <!-- Pago consultas -->
          <? if($user->getRole() == 3): ?>
            <? if(strpos($_SERVER['REQUEST_URI'], 'pagoconsulta') !== false): ?>
              <li class="nav-item">
                <a class="nav-link active" href="pagoconsulta.php">
                <i class="fas fa-hand-holding-usd"></i>
                  Registrar pago consulta <span class="sr-only">(current)</span>
                </a>
              </li>
            <? else: ?>
              <li class="nav-item">
                <a class="nav-link" href="pagoconsulta.php">
                <i class="fas fa-hand-holding-usd"></i>
                  Registrar pago consulta
                </a>
              </li>
            <? endif; ?>
          <? endif; ?> 
          <!-- Doctor -->

          <!-- Visitas -->
          <? if($user->getRole() == 2): ?>
            <? if(strpos($_SERVER['REQUEST_URI'], 'visit') !== false): ?>
              <li class="nav-item">
                <a class="nav-link active" href="visitas.php">
                <i class="fas fa-location-arrow"></i>
                    Eventos de visitas <span class="sr-only">(current)</span>
                  </a>
              </li>
            <? else: ?>
              <li class="nav-item">
                <a class="nav-link" href="visitas.php">
                <i class="fas fa-location-arrow"></i>
                    Eventos de visitas
                  </a>
              </li>
            <? endif; ?>
          <? endif; ?>            
          <!-- Cita proxima -->
          <? if($user->getRole() == 2): ?>
            <? if(strpos($_SERVER['REQUEST_URI'], 'consultarcita') !== false): ?>
              <li class="nav-item">
                <a class="nav-link active" href="consultarcita.php">
                <i class="fas fa-calendar-alt"></i>
                  Consultar cita proxima <span class="sr-only">(current)</span>
                </a>
              </li>
            <? else: ?>
              <li class="nav-item">
                <a class="nav-link" href="consultarcita.php">
                <i class="fas fa-calendar-alt"></i>
                  Consultar cita proxima
                </a>
              </li>
            <? endif; ?>
          <? endif; ?> 
          <!-- Ingresos -->
          <? if($user->getRole() == 2): ?>
            <? if(strpos($_SERVER['REQUEST_URI'], 'ingresos') !== false): ?>
              <li class="nav-item">
                <a class="nav-link active" href="ingresos.php">
                <i class="fas fa-wallet"></i>
                  Ingresos <span class="sr-only">(current)</span>
                </a>
              </li>
            <? else: ?>
              <li class="nav-item">
                <a class="nav-link" href="ingresos.php">
                <i class="fas fa-wallet"></i>
                  Ingresos
                </a>
              </li>
            <? endif; ?>
          <? endif; ?> 
        </ul>
      </div>
    </nav>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
