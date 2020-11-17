<?php

namespace Src\service;

use Src\db\DatabaseCon;

class UserService extends DatabaseCon
{
    private $dbConnection = null;

    public function __construct()
    {
        $this->dbConnection = DatabaseCon::getInstance();;
    }

    /**
     * Given an email returns a user
     *
     * @return array
     */
    public function getUserByEmail(String $email): array
    {
        $statement = "
            SELECT
                id, user_name, email, password
            FROM
                users
            WHERE email = ?;
        ";

        $data = array($email);

        return $this->dbConnection->query($statement, $data)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Creates a new user
     *
     * @return int
     */
    public function registerUser($body): int
    {
        $statement = "
            INSERT INTO users
                (user_name, email, password)
            VALUES
                (:user_name, :email, :password);
        ";

        $data = array(
            'user_name' => $body->user_name,
            'email' => $body->email,
            'password' => password_hash($body->password, PASSWORD_DEFAULT),
        );

        return $this->dbConnection->query($statement, $data)->rowCount();
    }
}
