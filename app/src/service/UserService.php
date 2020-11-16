<?php

namespace Src\service;

use Src\db\DatabaseCon;

class UserService extends DatabaseCon
{
    private $dbConnection = null;

    public function __construct()
    {

        $this->dbConnection = $this->getConnection();
    }

    public function getUserByEmail(String $email)
    {
        $statement = "
            SELECT
                id, user_name, email, password
            FROM
                users
            WHERE email = ?;
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array($email));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }

    }

    public function registerUser($body)
    {
        $statement = "
            INSERT INTO users
                (user_name, email, password)
            VALUES
                (:user_name, :email, :password);
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'user_name' => $body->user_name,
                'email' => $body->email,
                'password' => hash('sha1', $body->password),
            ));

            return $statement->rowCount();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
