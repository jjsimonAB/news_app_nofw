<?php

namespace Src\db;

class DatabaseCon
{
    private $dbConnection = null;

    public function __construct()
    {

    }

    public function getConnection()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $db = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');

        try {
            $this->dbConnection = new \PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
        } catch (\PDOException $e) {
            return $e->getMessage();
        }

        return $this->dbConnection;
    }
}
