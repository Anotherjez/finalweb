<?php

if(file_exists("../../libs/configx.php")){
    include('../../libs/configx.php');
}

include('../../libs/connection.php');

function GetGuests()
{
    $sql = "Select * from guests";

    $data = Connection::query_arr($sql);
    $num = 0;

    if(count($data) > 0){
        foreach ($data as $guest) {
            $num = $num + 1;
            echo<<<GUEST
                <tr index="{$guest['pasaporte']}">
                <th scope="row">{$num}</th>
                GUEST;
                if(file_exists("../../assets/profile/{$guest['id']}.jpg")){
                    echo "<td><img style='height: 60px;' src='../../assets/profile/{$guest['id']}.jpg'></td>";
                }else{
                    echo "<td><img style='height: 60px;' src='../../assets/profile/placeholder.jpg'></td>";
                }
                echo <<<GUEST
                <td>{$guest['nombre']}</td>
                <td>{$guest['apellido']}</td>
                <td>{$guest['pasaporte']}</td>
                <td>{$guest['correo']}</td>
                <td>{$guest['telefono']}</td>
                <td>{$guest['pais']}</td>
                <td>{$guest['firstdate']}</td>
                <td>{$guest['lastdate']}</td>
                <td>{$guest['room']}</td>
                <td>
                <a href="guestedit.php?guest={$guest['pasaporte']}" class="btn btn-outline-warning">Editar</a>
                <br>
                <button onclick="DeleteGuest(this)" class="btn btn-outline-danger">Eliminar</button>
                </td>
            </tr>
            GUEST;
        }
    }else{
        echo<<<INFO
        <div class="alert alert-info" role="alert">
            Aun no hay huespedes registrados        
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
            }else{
                $role = "Usuario";
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
                <option>Usuario</option>
                <option>Administrador</option>
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