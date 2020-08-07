<?php

include_once('libs/user.php');
include_once('libs/user_session.php');

$userSession = new UserSession();
$user = new User();

if(isset($_SESSION['user'])){
    $user->setUser($userSession->getCurrentUser());
    header("Location:pages/index.php");
}else if(isset($_POST['username']) && isset($_POST['password'])){
    
    $userForm = $_POST['username'];
    $passForm = $_POST['password'];

    if ($user->userExists($userForm, $passForm)) {
        $userSession->setCurrentUser($userForm);
        $user->setUser($userForm);
        header("Location:pages/index.php");
    }else{
        echo '<script language="javascript">';
        echo "alert('Nombre de usuario y/o password incorrectos');";
        echo '</script>';
    }

}else{
    header("Location:pages/index.php");
}

?>