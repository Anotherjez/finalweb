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

if(!($user->getRole() == 2)){
  header("Location: dashboard.php");
}

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
    <div class="row">
        <div class="col">
            <h2>Recaudado hoy: RD$<?= $hoy['SUM(costo)'] ?></h2>
        </div>
        <div class="col">
            <h2>Ingresos totales: RD$<?= $total['SUM(costo)'] ?></h2>
        </div>
    </div>
  <br>
  <h4>Consultas</h4>
</div>
<br>

<div class="table-responsive" data-aos="fade-up" data-aos-duration="1000">
    <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Titulo</th>
            <th scope="col">Precio</th>
            <th scope="col">Monto pagado</th>
            <th scope="col">Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php GetPagos(); ?>
    </tbody>
    </table>
<div>

<script src="../../assets/js/aos.js"></script>
<script>
  AOS.init();
</script>
<?php include('../footer.php'); ?>