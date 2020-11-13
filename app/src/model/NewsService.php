<?php

namespace Src\model;

use Src\db\DatabaseCon;

class NewsService extends DatabaseCon
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
    public function getAllNews($authorId)
    {
        $statement = "
            SELECT *
            FROM news
            where author_id = :author_id AND deleted_at IS NULL;
        ";

        $statement2 = "
            SELECT categories.id, categories.category_name
            FROM news_categories
            LEFT JOIN categories on news_categories.categorie_id = categories.id
            where news_id = :new_id;
        ";

        $categories = [];

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'author_id' => $authorId,
            ));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            /**
             * TO-DO
             * - Refactor: move this to a private function
             */
            foreach ($result as $key => $res) {
                $statement = $this->dbConnection->prepare($statement2);
                $statement->execute(array(
                    'new_id' => $res['id'],
                ));
                $categories = $statement->fetchAll(\PDO::FETCH_ASSOC);
                $result[$key]['categories'] = $categories;
            }

            return $result;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function addNews($authorId, $body = [])
    {
        $statement = "
            INSERT INTO news
                (title, content, author_id, views)
            VALUES
                (:title, :content, :author_id, :views);
        ";
        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'title' => $body->title,
                'content' => $body->content,
                'author_id' => $authorId,
                'views' => $body->views,
            ));
            $insertedID = $this->dbConnection->lastInsertId();
            if (isset($body->categories)) {
                $this->attachCategorieToNews($insertedID, $body->categories);
            }
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getNewsDetail($id, $authorId)
    {
        $statement = "
            SELECT * FROM news
            WHERE id = :id
            AND author_id = :authorId
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'id' => $id,
                'authorId' => $authorId,
            ));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateNew($id, $body)
    {
        $statement = "
            UPDATE news
            SET
                title    = :title,
                content  = :content,
                updated_at = now()
            WHERE id = :id;
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'title' => $body->title,
                'content' => $body->content,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteNew($id)
    {
        $statement = "
            UPDATE news
            SET
                deleted_at = :date,
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'deleted_at' => date("Y-m-d H:i:s"),
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function isOwner(int $authorId, int $newsId)
    {
        $statement = "
            SELECT * FROM news
            WHERE id = :id
            AND author_id = :authorId
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'id' => $newsId,
                'authorId' => $authorId,
            ));
            $result = $statement->rowCount();
            if ($result > 0) {
                return true;
            }

            return false;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    private function attachCategorieToNews(int $id, array $data): void
    {

        $statement = "
            INSERT INTO news_categories
                (news_id, categorie_id)
            VALUES
                (:news_id, :categorie_id);
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            foreach ($data as $key => $value) {
                $statement->execute(array(
                    'news_id' => $id,
                    'categorie_id' => $value,
                ));
            }
        } catch (\PDOException $e) {
            print_r($e->getMessage());
        }
    }
}
