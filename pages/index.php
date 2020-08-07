<?php

include('../libs/utils.php');

Connection::testconnection();

include_once('../libs/user.php');
include_once('../libs/user_session.php');

$userSession = new UserSession();
$user = new User();

if(isset($_SESSION['user'])){
  $user->setUser($userSession->getCurrentUser());
}
else if(isset($_POST['username']) && isset($_POST['password'])){
      
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
include('header.php');

?>

<section>

</section>
<div class="landing">
    <div class="landingText" data-aos="fade-down" data-aos-duration="1200">
        <h1>Stay In. <span style="color:#e0501b;font-size:4vw;">Stay Safe.</span></h1>
        <h3>Lets all work together to put an end to this pandemic. <br> Help to stop the spread.</h3>
    </div>
    <div class="landingImage" data-aos="fade-up" data-aos-duration="1200">
        <img src="../assets/images/home1.jpg">
    </div>
</div>
<section>
<div class="container landing">
    <div class="row row-cols-2">
    <div class="col landingImage" data-aos="fade-right" data-aos-duration="1200">
        <img src="../assets/images/home2.jpg" class="img-fluid">

    </div>
    <div class="col landingText" data-aos="fade-left" data-aos-duration="1200">
        <h2>Consulta con nosotros</h2>
        <h3>Ofrecemos el mejor servicio de acuerdo a tus necesidades.</h3>
    </div>
    </div>
</div>
</section>

<section>
<center class="landingText">
    <h1>Nuestro compromiso</h1>
</center>
<div class="card-deck" style="padding: 6vw 10vw 10vw 10vw;" data-aos="fade-up" data-aos-duration="1000">
  <div class="card">
    <img src="../assets/images/card1.jpg" class="img-fluid">
    <div class="card-body">
      <h5 class="card-title">Amor</h5>
      <p class="card-text">Realizamos nuestros servicios con esfuerzo y dedicacion.</p>
    </div>
  </div>
  <div class="card">
    <img src="../assets/images/card2.jpg" class="img-fluid">
    <div class="card-body" style="margin-top:10px;">
      <h5 class="card-title">Tiempo</h5>
      <p class="card-text">Hacemos valer el tiempo de nuestros clientes.</p>
    </div>
  </div>
  <div class="card">
    <img src="../assets/images/card3.jpg" class="img-fluid">
    <div class="card-body">
      <h5 class="card-title">Calidad</h5>
      <p class="card-text">Contamos con el mejor equipo para garantizar la calidad de nuestros servicios.</p>
    </div>
  </div>
</div>
</section>

<script src="../assets/js/aos.js"></script>
<script>
  AOS.init();
</script>
<?php include("footer.php"); ?>