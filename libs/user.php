<?php 

include_once('connection.php');
include_once('configx.php');

 class User extends Connection{

    private $name;
    private $username;
    private $role;
    private $isUser = false;
    
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
            $this->role = $currentUser['role'];
        }

        $this->isUser = true;
    }

    public function isUser(){
        return $this->isUser;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function getRole()
    {
        return $this->role;
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