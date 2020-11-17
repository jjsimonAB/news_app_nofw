<?php

namespace Src\controller;

use Src\router\Request;
use Src\router\Response;
use Src\service\NewsService;

class NewsController
{

    /**
     * Gets all news from the database
     *
     * @param Request $req
     * @param Response $res
     * @return void
     */
    public static function getNews(Request $req, Response $res): void
    {
        $user = $req->getUser();
        $news = new NewsService();
        $data = $news->getAllNews($user->id);

        $res->toJSON([
            'data' => $data,
        ]);
    }

    /**
     * Create a news registry in the database
     *
     * @param Request $req
     * @param Response $res
     * @return void
     */
    public static function addNews(Request $req, Response $res): void
    {
        $user = $req->getUser();
        $news = new NewsService();
        $data = $news->addNews($user->id, $req->getJson());

        $res->toJSON([
            'data' => $data,
        ]);
    }

    /**
     * Returns the detail of a given news id
     *
     * @param Request $req
     * @param Response $res
     * @return void
     */
    public static function getNewsDetail(Request $req, Response $res): void
    {
        $user = $req->getUser();
        $id = $req->params[0];
        $news = new NewsService();
        $data = $news->getNewsDetail($id, $user->id);

        $res->toJSON([
            'data' => $data,
        ]);
    }

    /**
     * Edit an existent news in the database
     *
     * @param Request $req
     * @param Response $res
     * @return void
     */
    public static function editNew(Request $req, Response $res): void
    {
        $user = $req->getUser();
        $id = $req->params[0];
        $news = new NewsService();
        if ($news->isOwner($user, $id)) {
            $data = $news->updateNews($id, $req->getJson());
            $res->toJson([
                'data' => $data,
            ]);
        } else {
            $res->status(500);
            $res->toJson([
                'data' => "you don't own this",
            ]);
        }
    }

    /**
     * Removes a news from the database
     *
     * @param Request $req
     * @param Response $res
     * @return void
     */
    public static function deleteNews(Request $req, Response $res): void
    {
        $user = $req->getUser();
        $id = $req->params[0];
        $news = new NewsService();
        if ($news->isOwner($user, $id)) {
            $data = $news->deleteNews($id);
            $res->toJson([
                'data' => $data,
            ]);
        } else {
            $res->status(500);
            $res->toJson([
                'data' => "you don't own this",
            ]);
        }
    }

    /**
     * Get news filtered
     *
     * @param Request $req
     * @param Response $res
     * @return void
     */
    public static function getNewsFiltred(Request $req, Response $res): void
    {
        $user = $req->getUser();
        $news = new NewsService();
        $data = $news->getFiltredNews($user->id, $req->getQueryParams());

        $res->toJSON([
            'data' => $data,
        ]);
    }

}
