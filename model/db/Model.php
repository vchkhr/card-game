<?php

abstract class Model
{
    protected $connection;
    // protected $table;

    public function __construct()
    {
        $this->setConnection();
        // $this->setTable($table);
    }

    // protected function setTable($table)
    // {
    //     $this->table = $table;
    // }

    protected function setConnection()
    {
        $this->connection = new DatabaseConnection('127.0.0.1', null, 'yourlogin', 'yourpassword', 'card_game');
    }
}
