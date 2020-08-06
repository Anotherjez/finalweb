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

if(!($user->getRole() == 3)){
  header("Location: dashboard.php");
}

if($_POST){

  foreach($_POST as &$value){
    $value = addslashes($value);
  }        

  extract($_POST);

$time  = strtotime($end);

$month = date('m',$time);

  $sql = "Select * from pacientes WHERE EXTRACT(MONTH FROM nacimiento) = '{$month}'";

  $data = Connection::query_arr($sql);
  $num = 0;

}
include('headerpanel.php');
?>

<div class="container">
  <h2>Cumpleaños de Pacientes</h2>
  <br>
    
</div>
<br>
<form enctype="multipart/form-data" method="POST">
        
<?= Input('end','Hora de salida','', ['type'=>'month']) ?>
          
        <br>
        <br>
        
        <button type="submit" class="btn btn-primary">Buscar Paciente</button>
        
    </form>
<div class="table-responsive">
    <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Fecha de nacimiento</th>
            <th scope="col">Telefono</th>
            
        </tr>
    </thead>
    <tbody>
        <?php if(count($data) > 0){
        foreach ($data as $paciente) {
            $num = $num + 1;
            echo<<<PACIENTE
                <tr index="{$paciente['cedula']}">
                <th scope="row">{$num}</th>
               
                <td>{$paciente['nombre']}</td>
                <td>{$paciente['apellido']}</td>
                <td>{$paciente['nacimiento']}</td>
                <td>{$paciente['telefono']}</td>
              
            
            </tr>
            PACIENTE;
        }
    }else{
        echo<<<INFO
        <div class="alert alert-info" role="alert">
            Aun no hay pacientes registrados        
        </div>
        INFO;
    } ?>
    </tbody>
    </table>
<div>



<?php include('../footer.php'); ?>