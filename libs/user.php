<?php 

include_once('connection.php');
include_once('configx.php');

 class User extends Connection{

    private $name;
    private $username;
    private $admin;

    public function userExists($user, $pass)
    {
        $md5pass = md5($pass);

        $sql = "Select * from users where username = '{$user}' AND password = '{$md5pass}'";

        $data = Connection::query_arr($sql);

        if(count($data) > 0){
            return true;
        }else{
            return false;
        }
    }

    public function setUser($user)
    {
        $sql = "Select * from users where username = '{$user}'";

        $data = Connection::query_arr($sql);

        foreach ($data as $currentUser) {
            $this->name = $currentUser['name'];
            $this->username = $currentUser['username'];
            if($currentUser['role'] == 1){
                $this->admin = true;
            }else{
                $this->admin = false;
            }
        }
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function getAdmin()
    {
        return $this->admin;
    }

    public function getId()
    {
        $sql = "select * from users where username = '{$this->username}'";

        $data = Connection::query_arr($sql);

        $user = $data[0];
        return $user['id'];
    }
 }

?>