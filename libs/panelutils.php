<?php

if(file_exists("../../libs/configx.php")){
    include('../../libs/configx.php');
}

include('../../libs/connection.php');

function GetPacientesVisitas(){
    $sql = "Select * from pacientes";

    $data = Connection::query_arr($sql);
    $num = 0;

    if(count($data) > 0){
        foreach ($data as $paciente) {
            $num = $num + 1;
            echo<<<PACIENTE
                <tr index="{$paciente['cedula']}">
                <th scope="row">{$num}</th>
                <td>{$paciente['cedula']}</td>
                <td>{$paciente['nombre']}</td>
                <td>{$paciente['apellido']}</td>
                <td>{$paciente['nacimiento']}</td>
                <td>{$paciente['telefono']}</td>
                <td>{$paciente['sangre']}</td>
                <td>
                <a href="newvisitas.php?paciente={$paciente['cedula']}" class="btn btn-outline-success" style="margin:4px;">Registrar visita</a>
                <br>
                <a href="showvisitas.php?paciente={$paciente['id']}" class="btn btn-outline-info" style="margin:4px;">Visitas</a>
                </td>
            </tr>
            PACIENTE;
        }
    }else{
        echo<<<INFO
        <div class="alert alert-info" role="alert">
            Aun no hay pacientes registrados        
        </div>
        INFO;
    }
}

function ShowVisitas($id){
    $sql = "select * from visitas where paciente_id = {$id}";

    $data = Connection::query_arr($sql);
    $num = 0;

    if(count($data) > 0){
        foreach ($data as $visita) {
            $num = $num + 1;
            echo<<<VISITA
            <tr>
                <th scope="row">{$num}</th>
                <td>{$visita['paciente_id']}</td>
                <td>{$visita['fecha']}</td>
                <td>{$visita['comentario']}</td>
                <td>{$visita['receta']}</td>
                <td>{$visita['fecha_proxima']}</td>
            </tr>
            VISITA;
        }
    }else{
        echo<<<INFO
        <div class="alert alert-info" role="alert">
            Este paciente aun no tiene visitas registradas       
        </div>
        INFO;
    }
}

function GetPacientes()
{
    $sql = "Select * from pacientes";

    $data = Connection::query_arr($sql);
    $num = 0;

    if(count($data) > 0){
        foreach ($data as $paciente) {
            $num = $num + 1;
            echo<<<PACIENTE
                <tr index="{$paciente['cedula']}">
                <th scope="row">{$num}</th>
                <td>{$paciente['cedula']}</td>
                <td>{$paciente['nombre']}</td>
                <td>{$paciente['apellido']}</td>
                <td>{$paciente['nacimiento']}</td>
                <td>{$paciente['telefono']}</td>
                <td>{$paciente['sangre']}</td>
                <td>
                <a href="pacienteedit.php?paciente={$paciente['pasaporte']}" class="btn btn-outline-warning">Editar</a>
                <br>
                <button onclick="DeletePaciente(this)" class="btn btn-outline-danger">Eliminar</button>
                </td>
            </tr>
            PACIENTE;
        }
    }else{
        echo<<<INFO
        <div class="alert alert-info" role="alert">
            Aun no hay pacientes registrados        
        </div>
        INFO;
    }
}
function GetUsers()
{
    $sql = "Select * from users";

    $data = Connection::query_arr($sql);
    $num = 0;

    if(count($data) > 0){
        foreach ($data as $user) {
            $num = $num + 1;
            if ($user['role'] == 1) {
                $role = "Admin";
            }else if ($user['role'] == 2){
                $role = "Doctor";
            }else{
                $role = "Asistente";
            }
            echo<<<USER
            <tr index="{$user['username']}">
                <th scope="row">{$num}</th>
                    <td>{$user['name']}</td>
                    <td>{$user['username']}</td>
                    <td>{$role}</td>
                <td>
                <a href="useredit.php?user={$user['id']}" class="btn btn-outline-warning">Editar</a>
                <button onclick="DeleteUser(this)" class="btn btn-outline-danger">Eliminar</button>
                <a href="userlog.php?log={$user['id']}" class="btn btn-outline-info">Log</a>
                </td>
            </tr>
            USER;
        }
    }else{
        echo<<<INFO
        <div class="alert alert-info" role="alert">
            Aun no hay usuarios registrados        
        </div>
        INFO;
    }
}

function GetLogs($id)
{
    $sql = "select * from user_log where user_id = {$id}";

    $data = Connection::query_arr($sql);
    $num = 0;

    if(count($data) > 0){
        foreach ($data as $log) {
            $num = $num + 1;
            echo<<<LOG
            <tr>
                <th scope="row">{$num}</th>
                <td>{$log['user_id']}</td>
                <td>{$log['guest_id']}</td>
                <td>{$log['remote_addr']}</td>
                <td>{$log['message']}</td>
                <td>{$log['log_date']}</td>
            </tr>
            LOG;
        }
    }else{
        echo<<<INFO
        <div class="alert alert-info" role="alert">
            Aun no hay registros de este usuario       
        </div>
        INFO;
    }
}

function Input($id, $label, $value="", $opts=[]){

    $placeholder = "";
    $type = "text";
    $readonly = "";

    if(isset($_POST[$id])){
        $value = $_POST[$id];
    }

    extract($opts);

    if($id == "firstdate"){
        return <<<INPUT
        <div class="form-group">
            <label for="firstdatelabel">Fecha de llegada</label>
            <input required type="{$type}" value="{$value}" class="form-control" id="{$id}" name="{$id}" min="<?php echo(date('Y-m-d')); ?>" onchange="DateInput();">
        </div>
        INPUT;
    }
    else if($id == "role"){
        return <<<INPUT
        <div class="form-group">
            <label>{$label}</label>
            <select class="form-control" id="{$id}" name="{$id}" required>
                <option>Administrador</option>
                <option>Doctor</option>
                <option>Asistente</option>
            </select>
        </div>
        INPUT;
    }
    else if($id == 'comentario' || $id == 'receta'){
        return <<<INPUT
        <div class="form-group">
            <label>{$label}</label>
            <textarea required maxlength="255" class="form-control" id="{$id}" name="{$id}" rows="3" placeholder="{$placeholder}"></textarea>
        </div>
        INPUT;
    }
    else if($id == 'foto'){

        return <<<INPUT
        <label>{$label}</label>
        <div class="custom-file">
            <input type="{$type}" class="custom-file-input" name="{$id}" id="{$id}" accept=".jpg, .jpeg, .png">
            <label class="custom-file-label" for="customFile">Elige una foto</label>
        </div>
        INPUT;
    }
    else{

        return <<<INPUT
        <div class="form-group">
            <label>{$label}</label>
            <input required {$readonly} type="{$type}" value="{$value}" class="form-control {$id}" id="{$id}" name="{$id}" placeholder="{$placeholder}">
        </div>
        INPUT;
    }
    
}

function Write_log($message, $id = 0, $guestid)
{
  if( ($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
    $remote_addr = "REMOTE_ADDR_UNKNOWN";
  }
 
  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
    $request_uri = "https://";   
    else  
    $request_uri = "http://";   
    
  if( ($request_uri.= $_SERVER['REQUEST_URI']) == '') {
    $request_uri.= "REQUEST_URI_UNKNOWN";
  }

  $sql = "INSERT INTO user_log(user_id, paciente_id, remote_addr, request_uri, message) VALUES({$id}, {$guestid}, '{$remote_addr}', '{$request_uri}','{$message}')";
  Connection::execute($sql);
}

function LoadInstall(){
    echo<<<INSTALL
    <div class="container" style="margin-bottom: 60px;" data-aos="fade-up" data-aos-duration="1000">
        <form method="POST">
            <p>A continuación debes introducir los detalles de conexión de tu base de datos. Si no estás seguro de esta información contacta con tu proveedor de alojamiento web.</p>
            <div class="form-group">
              <label for="dbnamelabel">Nombre de la base de datos</label>
              <input required type="text" class="form-control" id="dbname" name="dbname" placeholder="consultorio">
              <small id="dbnameHelp" class="form-text text-muted">El nombre de la base de datos que quieres usar con tu pagina web.</small>
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
        <p>Su pagina web esta instalada y listo para su uso.</p>
        <hr>
        <p class="mb-0">Presiona el boton debajo para continuar a la pagina principal de tu Consultorio.</p>
        <br>
        <a href="index.php" class="btn btn-outline-success">Pagina princial</a>
    </div>
    </div>
    INSTALLED;
}

?>