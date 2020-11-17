<?php

namespace Src\service;

use Src\db\DatabaseCon;

class NewsService extends DatabaseCon
{
    private $dbConnection = null;

    public function __construct()
    {
        $this->dbConnection = DatabaseCon::getInstance();;
    }

    /**
     * returns all the news from the database
     *
     * @return array news
     */
    public function getAllNews(int $authorId): array
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

        $data = array(
            'author_id' => $authorId,
        );

        return $this->dbConnection->query($statement, $data)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Insert a news into the database
     *
     * @return Int
     */
    public function addNews(int $authorId, object $body): int
    {
        $statement = "
            INSERT INTO news
                (title, content, author_id)
            VALUES
                (:title, :content, :author_id);
        ";

        $data = array(
            'title' => $body->title,
            'content' => $body->content,
            'author_id' => $authorId,
        );

        $insertedNews = $this->dbConnection->query($statement, $data);
        $insertedID = $this->dbConnection->getConnection()->lastInsertId();

        if (isset($body->categories)) {
            $this->attachCategorieToNews($insertedID, $body->categories);
        }

        return $insertedNews->rowCount();
    }

    /**
     * Returns all the categories related to a news
     *
     * @return array
     */
    private function getCategories(int $newsId): array
    {
        $statement = "
            SELECT categories.id, categories.category_name
            FROM news_categories
            LEFT JOIN categories on news_categories.categorie_id = categories.id
            where news_categories.news_id = :news_id;
        ";

        $data = array(
            'news_id' => $newsId,
        );

        return $this->dbConnection->query($statement, $data)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Returns the detail of a news
     *
     * @return array
     */
    public function getNewsDetail(int $id, int $authorId): array
    {
        $statement = "
            SELECT * FROM news
            WHERE id = :id
            AND author_id = :authorId
            AND is_deleted = 0
        ";

        $data = array(
            'id' => $id,
            'authorId' => $authorId,
        );

        $result = $this->dbConnection->query($statement, $data)->fetchAll(\PDO::FETCH_ASSOC);

        if (!empty($result)) {
            $categories = $this->getCategories($result[0]['id']);
            $result[0]['categories'] = $categories;
        }

        return $result;
    }


    /**
     * Edit an existent news
     *
     * @return int
     */
    public function updateNews(int $id, object $body): int
    {
        $statement = "
            UPDATE news
            SET
                title    = :title,
                content  = :content,
                updated_at = now()
            WHERE id = :id;
        ";

        $data = array(
            'id' => (int) $id,
            'title' => $body->title,
            'content' => $body->content,
        );

        return $this->dbConnection->query($statement, $data)->rowCount();
    }

    /**
     * Removes a news from the database
     *
     * @return int
     */
    public function deleteNews(int $id): int
    {
        $statement = "
            UPDATE news
            SET
             is_deleted = 1
            WHERE id = :id;
        ";

        $data = array(
            'id' => (int) $id,
        );

        return $this->dbConnection->query($statement, $data)->rowCount();
    }

    /**
     * Verify if a given user is owner of a given news
     *
     * @return bool
     */
    public function isOwner($author, int $newsId): bool
    {
        $statement = "
            SELECT * FROM news
            WHERE id = :id
            AND author_id = :authorId
        ";

        $data = array(
            'id' => $newsId,
            'authorId' => $author->id,
        );

        $result = $this->dbConnection->query($statement, $data)->rowCount();

        if ($result > 0) {
            return true;
        }

        return false;
    }

    /**
     * creates the relationship between a news and a category
     *
     * @return void
     */
    private function attachCategorieToNews(int $id, array $data): void
    {

        $statement = "
            INSERT INTO news_categories
                (news_id, categorie_id)
            VALUES
                (:news_id, :categorie_id);
        ";

        foreach ($data as $key => $value) {
            $this->dbConnection->query($statement, array(
                'news_id' => $id,
                'categorie_id' => $value,
            ))->rowCount();
        }
    }

    /**
     * Returns filtred news from the database 
     *
     * @return bool
     */
    public function getFiltredNews(int $userId, array $queryParams): array
    {
        $filterKey = array_keys($queryParams)[0];

        $statement = "
            SELECT news.id, news.title
            FROM news
            where $filterKey = :value AND is_deleted = 0;
        ";

        $data = array(
            'value' => $queryParams[$filterKey],
        );

        return $this->dbConnection->query($statement, $data)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
