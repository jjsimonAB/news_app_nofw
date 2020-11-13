<?php

namespace Src\model;

use Src\db\DatabaseCon;

class CategoriesService extends DatabaseCon
{
    private $dbConnection = null;

    public function __construct()
    {
        $this->dbConnection = $this->getConnection();
    }

    /**
     * to-do
     * - find a better name for this
     */
    public function getAllCategories()
    {
        /**
         * TO-DO
         * - Add view counter
         */
        $statement = "
            SELECT *
            FROM categories
            where is_deleted = 0;
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function addCategory(object $body)
    {
        $statement = "
            INSERT INTO categories
                (category_name)
            VALUES
                (:name);
        ";
        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'name' => $body->name,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateCategory(int $id, object $body)
    {
        $statement = "
            UPDATE categories
            SET
                category_name  = :name,
                updated_at = now()
            WHERE id = :id;
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'name' => $body->name,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteCategory(int $id)
    {
        $statement = "
            UPDATE categories
            SET
             is_deleted = 1
            WHERE id = :id;
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
