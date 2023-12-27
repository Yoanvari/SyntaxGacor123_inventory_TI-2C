<?php
require_once 'CRUD.php';
abstract class Controller implements CRUD
{
    protected $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }
}
?>