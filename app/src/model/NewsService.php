<?php

namespace Src\model;

use Src\db\DatabaseCon;

class NewsService
{
    private $dbConnection = null;

    public function __construct()
    {

        $this->dbConnection = (new DatabaseCon())->getConnection();
    }

    /**
     * to-do
     * - find a better name for this
     */
    public function getAllNews()
    {
        $statement = "
            SELECT * FROM news;
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function addNews($body = [])
    {
        $statement = "
            INSERT INTO news
                (title, content, author, views)
            VALUES
                (:title, :content, :author, :views);
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array(
                'title' => $body->title,
                'content' => $body->content,
                'author' => $body->author,
                'views' => $body->views,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getNewsDetail($id)
    {
        $statement = "
            SELECT * FROM news
            WHERE id = ?
            ;
        ";

        try {
            $statement = $this->dbConnection->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
