<?php


class User
{
    public $login;
    public $password;
    public $full_name;
    public $email_address;
    public $isAdmin;

    public function __construct($login, $password, $full_name, $email_address, $isAdmin)
    {
        $this->login = $login;
        $this->password = $password;
        $this->full_name = $full_name;
        $this->email_address = $email_address;
        $this->isAdmin = $isAdmin;
    }
}
