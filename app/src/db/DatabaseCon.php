<?php

namespace Src\db;

use PDO;

class DatabaseCon
{
    private $dbConnection = null;
    private static $instance = null;

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $db = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');

        try {
            $this->dbConnection = new PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $password
            );
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DatabaseCon();
        }

        return self::$instance;
    }

    public function query(string $query, array $data = [])
    {
        try {
            $statement = $this->dbConnection->prepare($query);
            $statement->execute($data);
            return $statement;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getConnection()
    {

        return $this->dbConnection;
    }
}
