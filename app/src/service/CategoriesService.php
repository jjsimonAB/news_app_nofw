<?php

namespace Src\service;

use PDO;
use Src\db\DatabaseCon;

class CategoriesService extends DatabaseCon
{
    private ?DatabaseCon $dbConnection = null;

    public function __construct()
    {
        $this->dbConnection = DatabaseCon::getInstance();;
    }

    /**
     * returns all the categories from the database
     *
     * @return Array categories
     */
    public function getAllCategories(): array
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

        return $this->dbConnection->query($statement)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Insert a category into the database
     *
     * @return Int
     */
    public function addCategory(object $body): int
    {
        $statement = "
            INSERT INTO categories
                (category_name)
            VALUES
                (:name);
        ";

        $data = array(
            'name' => $body->name,
        );

        return $this->dbConnection->query($statement, $data)->rowCount();
    }

    /**
     * Updates an existent category in the database;
     *
     * @return Int
     */
    public function updateCategory(int $id, object $body): int
    {
        $statement = "
            UPDATE categories
            SET
                category_name  = :name,
                updated_at = now()
            WHERE id = :id;
        ";

        $data = array(
            'id' => (int) $id,
            'name' => $body->name,
        );

        return $this->dbConnection->query($statement, $data)->rowCount();
    }

    /**
     * Removes a category
     *
     * @return Int
     */
    public function deleteCategory(int $id): int
    {
        $statement = "
            UPDATE categories
            SET
             is_deleted = 1
            WHERE id = :id;
        ";

        $data = array(
            'id' => (int) $id,
        );

        return $this->dbConnection->query($statement, $data)->rowCount();
    }
}
