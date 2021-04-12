<?php


abstract class Model
{

    protected $connection;
    protected $table;

    public function __construct($table)
    {
        $this->setConnection();
        $this->setTable($table);
    }

    protected function setTable($table)
    {
        $this->table = $table;
    }

    protected function setConnection()
    {
        $this->connection = new DatabaseConnection('127.0.0.1', null, 'vkharchenk', 'securepass', 'sword');
        // $this->connection = new DatabaseConnection('localhost', null, 'vkharchenk', 'securepass', 'sword');
    }

    abstract public function find($id);

    abstract public function delete();

    abstract public function save();

    abstract protected function insert();

    abstract protected function update();

}
