<?php

Namespace Itb;

require_once __DIR__ . '/../src/Products.php';

class Database
{
    const DB_Name = 'biffy';
    const DB_User = 'root';
    const DB_Pass = 'pass';
    const DB_Host = 'localhost:3306';

    //  Connection property
    private $connection;

    public function __construct()
    {
        $dsn = 'mysql:dbname=' . self::DB_Name . ';host=' . self::DB_Host;

        try
        {
            $this->connection = new \PDO($dsn, self::DB_User, self::DB_Pass);
        }

        catch (\Exception $e)
        {
            print '<pre>';
            var_dump($e);
        }
    }

    //  Getter to return connection when called
    public function getConnection()
    {
        return $this->connection;
    }
}
