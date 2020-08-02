<?php

if(file_exists("../libs/configx.php")){
  include('../libs/configx.php');
}
include('../libs/connection.php');


function LoadInstall(){
    echo<<<INSTALL
    <div class="container container2" style="margin-bottom: 60px;">
        <form method="POST">
            <p>A continuación debes introducir los detalles de conexión de tu base de datos. Si no estás seguro de esta información contacta con tu proveedor de alojamiento web.</p>
            <div class="form-group">
              <label for="dbnamelabel">Nombre de la base de datos</label>
              <input required type="text" class="form-control" id="dbname" name="dbname" placeholder="hotel">
              <small id="dbnameHelp" class="form-text text-muted">El nombre de la base de datos que quieres usar con Hotel Magno.</small>
            </div>
            <div class="form-group">
              <label for="usernamelabel">Nombre de usuario</label>
              <input required type="text" class="form-control" id="username" name="username" placeholder="root">
              <small id="usernameHelp" class="form-text text-muted">El nombre de usuario de tu base de datos.</small>
            </div>
            <div class="form-group">
              <label for="passwordlabel">Contraseña</label>
              <input type="text" class="form-control" id="password" name="password" placeholder="mysql">
              <small id="passwordHelp" class="form-text text-muted">La contraseña de tu base de datos.</small>
            </div>
            <div class="form-group">
              <label for="servernamelabel">Servidor de la base de datos</label>
              <input required type="text" class="form-control" id="servername" name="servername" placeholder="localhost">
              <small id="servernameHelp" class="form-text text-muted">Deberías recibir esta información de tu proveedor de alojamiento web, si localhost no funciona.</small>
            </div>
            <div class="form-group">
              <label for="namelabel">Nombre completo</label>
              <input required type="text" class="form-control" id="name" name="name" placeholder="Ingres tu nombre">
            </div>
            <div class="form-group">
              <label for="adminuserlabel">Nombre de usuario</label>
              <input required type="text" class="form-control" id="adminuser" name="adminuser" placeholder="admin">
            </div>
            <div class="form-group">
              <label for="passwordlabel1">Contraseña</label>
              <input required type="password" class="form-control" id="password1" name="password1">
            </div>
            <div class="form-group">
              <label for="passwordlabel2">Repetir contraseña</label>
              <input required type="password" class="form-control" id="password2" name="password2">
            </div>
            <button type="submit" class="btn btn-outline-primary">Enviar</button>
          </form>
    </div>
    INSTALL;
}

function Installed(){
    echo<<<INSTALLED
    <div class="container" style="padding-top: 40px;">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Instalado!</h4>
        <p>Hotel Magno esta instalado y listo para su uso.</p>
        <hr>
        <p class="mb-0">Presiona el boton debajo para continuar a la pagina principal de tu Hotel Magno.</p>
        <br>
        <a href="index.php" class="btn btn-outline-success">Pagina princial</a>
    </div>
    </div>
    INSTALLED;
}

?>