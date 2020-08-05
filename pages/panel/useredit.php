<?php

$isEditing = false;

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

if($_POST){

    foreach($_POST as &$value){
        $value = addslashes($value);
    }        
    
    extract($_POST);
    if($password1 == $password2){

        $userpassword = md5($_POST['password1']);
        $sql = "select * from users where username = '{$username}'";

        $objs = Connection::query_arr($sql);
        
        if($role == "Asistente"){
            $userrole = 3;
        }else if($role == "Doctor"){
            $userrole = 2;
        }else if($role == "Administrador"){
            $userrole = 1;
        }
        
        if(count($objs) > 0){
            
            $sql = "update users set name = '{$name}', password = '{$userpassword}', role = {$userrole} where username = '{$username}'";
            
        }else{
            $sql = "insert into users(name, username, password, role) VALUES('{$name}', '{$username}', '{$userpassword}', $userrole)";
        }
        
        Connection::execute($sql);
        
        header("Location:users.php");
    }else{
        echo '<script language="javascript">';
        echo "alert('Las contraseñas no coinciden!');";
        echo '</script>';
    }

}
else if(isset($_GET['user'])){

    $sql = "select * from users where id = {$_GET['user']}";

    $objs = Connection::query_arr($sql);
    
    if(count($objs) > 0){
        $data = $objs[0];
        $_POST = $data;
        $isEditing = true;
    }
}

include('headerpanel.php');

?>

<div class="container" style="padding-bottom: 40px;">
    
    <?php if($isEditing) : echo "<h2>Editar Usuario</h2>"; else : echo "<h2>Añadir Usuario</h2>";endif; ?>
    <br>    
    <form enctype="multipart/form-data" method="POST">

        <?php 
            $condition = ['placeholder'=>'Username'];
            if($isEditing){
                $condition['readonly'] = 'readonly';
            }
            echo Input('username','Username','', $condition);        
        ?>
        <!-- Nombre -->
        <?= Input('name','Nombre','', ['placeholder'=>'Ingrese su nombre']) ?>
        <?= Input('password1','Contraseña','', ['type'=>'password']) ?>
        <?= Input('password2','Repetir Contraseña','', ['type'=>'password']) ?>
        <?= Input('role','Rol','', ['placeholder'=>'']) ?>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="users.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include('../footer.php'); ?>