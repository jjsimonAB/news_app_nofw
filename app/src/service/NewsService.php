<?php

namespace Src\service;

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
    public function getAllNews(int $authorId)
    {
        /**
         * TO-DO
         * - Add view counter
         */
        $statement = "
            SELECT news.id, news.title
            FROM news
            where author_id = :author_id AND is_deleted = 0;
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'author_id' => $authorId,
            ));
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function addNews(int $authorId, object $body)
    {
        $statement = "
            INSERT INTO news
                (title, content, author_id)
            VALUES
                (:title, :content, :author_id);
        ";
        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'title' => $body->title,
                'content' => $body->content,
                'author_id' => $authorId,
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

    public function getNewsDetail(int $id, int $authorId)
    {
        $statement = "
            SELECT * FROM news
            WHERE id = :id
            AND author_id = :authorId
            AND is_deleted = 0
        ";

        $statement2 = "
            SELECT categories.id, categories.category_name
            FROM news_categories
            LEFT JOIN categories on news_categories.categorie_id = categories.id
            where news_categories.news_id = :news_id;
        ";

        $categories = [];

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'id' => $id,
                'authorId' => $authorId,
            ));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            /**
             * TO-DO
             * - Refactor: move this to a private function
             */
            $statement = $this->dbConnection->prepare($statement2);
            $statement->execute(array(
                'news_id' => $result[0]['id'],
            ));
            $categories = $statement->fetchAll(\PDO::FETCH_ASSOC);
            // print_r($categories);
            $result[0]['categories'] = $categories;

            return $result;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateNews(int $id, object $body)
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

    public function deleteNews(int $id)
    {
        $statement = "
            UPDATE news
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

    public function getFiltredNews(int $userId, array $queryParams)
    {
        $filterKey = array_keys($queryParams)[0];

        $statement = "
            SELECT news.id, news.title
            FROM news
            where $filterKey = :value AND is_deleted = 0;
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'value' => $queryParams[$filterKey],
            ));
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }

        // switch ($filterKey) {
        //     case 'title':
        //         echo $queryParams[$filterKey];
        //         break;
        //     case 'author':
        //         echo $queryParams[$filterKey];
        //         break;
        //     case 'content':
        //         echo $queryParams[$filterKey];
        //         break;
        //     case 'between':
        //         echo $queryParams[$filterKey];
        //         break;
        //     default:
        //         return 'invalid filter';
        //         break;
        // }

    }
}
