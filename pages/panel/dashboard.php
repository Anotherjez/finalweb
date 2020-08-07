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

$sql ="SELECT COUNT(*) FROM pacientes";

$pacientes = Connection::query_arr($sql);

$sql ="SELECT COUNT(*) FROM events";

$citas = Connection::query_arr($sql);

$date = date("Y-m-d");
$sql = "SELECT SUM(costo) FROM consultas WHERE DATEDIFF(fecha, '{$date}') = 0 ";
        
$hoy = Connection::query_arr($sql);
$hoy = $hoy[0];

if($hoy['SUM(costo)'] == null){
  $hoy['SUM(costo)'] = 0.00;
}

$sql = "SELECT SUM(costo) FROM consultas";
$total = Connection::query_arr($sql);
$total = $total[0];

include('headerpanel.php');

?>

<div class="container">
  <h2>Dashboard</h2>
  <br>
  <div class="card-deck">
    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title"><i class="fas fa-heartbeat" style="color: red;"></i> Pacientes registrados</h5>
        <p class="card-text">Hay <?= $pacientes[0]['COUNT(*)'] ?> pacientes registrados.</p>
      </div>
    </div>

    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title"><i class="fas fa-calendar-alt" style="color: gray;"></i> Citas</h5>
        <p class="card-text">Hay <?= $citas[0]['COUNT(*)'] ?> citas registradas.</p>
      </div>
    </div>

    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title"><i class="fas fa-hand-holding-usd" style="color: green;"></i> Recaudado hoy</h5>
        <p class="card-text">Ingresos de hoy: RD$<?= $hoy['SUM(costo)'] ?></p>
      </div>
    </div>

    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title"><i class="fas fa-wallet" style="color: green;"></i> Ingresos totales</h5>
        <p class="card-text">Ingresos totales: RD$<?= $total['SUM(costo)'] ?></p>
      </div>
    </div>
  </div>
</div>

<?php include('footerpanel.php'); ?>