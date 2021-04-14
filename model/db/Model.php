<?php


abstract class Model
{

    protected $connection;
//    protected $table;

    public function __construct()
    {
        $this->setConnection();
//        $this->setTable($table);
    }

//    protected function setTable($table)
//    {
//        $this->table = $table;
//    }

    protected function setConnection()
    {
        $this->connection = new DatabaseConnection('127.0.0.1', null, 'mburenko', 'sEcurEvsd3bd90&4#m5:424pass', 'card_game');
//        $this->connection = new DatabaseConnection('127.0.0.1', null, 'vkharchenk', 'securepass', 'sword');
        // $this->connection = new DatabaseConnection('localhost', null, 'vkharchenk', 'securepass', 'sword');
    }

}
