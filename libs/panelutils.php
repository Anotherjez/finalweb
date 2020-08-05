<?php

if(file_exists("../../libs/configx.php")){
    include('../../libs/configx.php');
}

include('../../libs/connection.php');

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
                <a href="editpaciente.php?cedula={$paciente['cedula']}" class="btn btn-outline-warning">Editar</a>
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

function Write_log($message, $id, $guestid)
{
  if( ($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
    $remote_addr = "REMOTE_ADDR_UNKNOWN";
  }
 
  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
    $request_uri = "https://";   
    else  
    $request_uri.= "http://";   
    
  if( ($request_uri.= $_SERVER['REQUEST_URI']) == '') {
    $request_uri.= "REQUEST_URI_UNKNOWN";
  }

  $sql = "INSERT INTO user_log(user_id, guest_id, remote_addr, request_uri, message) VALUES({$id}, {$guestid}, '{$remote_addr}', '{$request_uri}','{$message}')";
  Connection::execute($sql);
}

?>