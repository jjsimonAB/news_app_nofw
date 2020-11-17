<?php

namespace Src\db;

use PDO;
use PDOException;
use PDOStatement;

class DatabaseCon
{
    private ?PDO $dbConnection = null;
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
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Returns the current instance if it doesn't exists creates a new one
     * 
     * @return DatabaseCon
     */
    public static function getInstance(): DatabaseCon
    {
        if (!self::$instance) {
            self::$instance = new DatabaseCon();
        }

        return self::$instance;
    }

    /**
     * Execute a query and return the response
     * 
     * @param string $query
     * @param array $data
     * @return PDOStatement
     */
    public function query(string $query, array $data = []): PDOStatement
    {
        try {
            $statement = $this->dbConnection->prepare($query);
            $statement->execute($data);
            return $statement;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Returns the currect database conection
     * 
     * @return PDO
     */
    public function getConnection(): ?PDO
    {
        return $this->dbConnection;
    }
}
