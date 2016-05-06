<?php

namespace Itb\Model;

class Database
{
    private $connection = null;
    
    public function __construct()
    {

       
        $db = new \PDO('sqlite:dogsDb_PDO.sqlite');

        //create the database
        $db->exec("DROP TABLE IF EXISTS dogs");
        $db->exec("CREATE TABLE dogs (id INTEGER PRIMARY KEY, breed TEXT, name TEXT, age INTEGER)");

        //insert some data...
        $db->exec("INSERT INTO dogs (breed, name, age) VALUES ('Labrador', 'Tank', 2);".
        "INSERT INTO dogs (breed, name, age) VALUES ('Husky', 'Glacier', 7); " .
        "INSERT INTO dogs (breed, name, age) VALUES ('Golden-Doodle', 'Ellie', 4);");
        
        $this->conection = $db;
        
    }
    
    public function __destruct()
    {
        $this->connection = null;
    }
    
    public function getConnection()
    {
    	return $this->connection;
    }
}