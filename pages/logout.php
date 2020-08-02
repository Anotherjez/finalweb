<?php

include_once('../libs/user_session.php');

$userSession = new UserSession();
$userSession->closeSession();

header("Location:login.php");
?>