<?php


class UserDB extends Model
{
    public $login;
    public $password;
    public $full_name;
    public $email_address;
    public $isAdmin;
    public $img;
    public $table = 'players';

    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        unset($this->connection);
    }

    public function find($login)
    {
        if ($this->connection->getConnectionStatus()) {
            if (!$this->isEmpty()) {
                $stmt = $this->connection->connection->prepare("SELECT * FROM $this->table  WHERE login = '$login';");
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
//                print_r($res);
                $this->login = $res['login'];
                $this->password = $res['password'];
                $this->full_name = $res['fullName'];
                $this->email_address = $res['emailUser'];
                $this->isAdmin = $res['isAdmin'];
                $this->img = $res['ing'];
            }
        }
    }

    public function save()
    {
        if ($this->connection->getConnectionStatus()) {
            $row = $this->isEmpty();
            if ($row) {
                $this->insert();
            } else {
                $this->update();
            }
        }
    }

    public function delete()
    {
        if ($this->connection->getConnectionStatus()) {
            if (!$this->isEmpty()) {
                $stmt = $this->connection->connection->prepare($this->connection->connection, "DELETE name FROM " . $this->table . " WHERE login = " . $this->login . ";");
                $stmt->execute();
                $this->login = null;
                $this->password = null;
                $this->full_name = null;
                $this->email_address = null;
            }
        }
    }

    public function isEmpty()
    {
        $request = "
                    SELECT 1 as isntEmpty
                    FROM players
                    WHERE login =  '$this->login';";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return !$res;
    }

    public function insert()
    {
        $request = "INSERT INTO players(login,password, fullName,emailUser)
        VALUE ('$this->login','$this->password','$this->full_name','$this->email_address');";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
    }

    public function update()
    {
        $request = "UPDATE players SET  login = '$this->login' , password = '$this->password' , full_name = '$this->full_name' , email_address = '$this->email_address'  WHERE login = '$this->login';";
        $stmt = $this->connection->connection->prepare($request);
        $stmt->execute();
    }

}