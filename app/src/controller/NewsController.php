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
    public static function getNews(Request $req, Response $res)
    {
        $user = $req->getUser();
        $news = new NewsService();
        $data = $news->getAllNews($user->id);

        $res->toJSON([
            'data' => $data,
        ]);
    }

    /**
     * TO-DO
     * - reimplement responses with code and sutff
     */
    public static function addNews(Request $req, Response $res)
    {
        $user = $req->getUser();
        $news = new NewsService();
        $data = $news->addNews($user->id, $req->getJson());

        $res->toJSON([
            'data' => $data,
        ]);
    }

    public static function getNewsDetail(Request $req, Response $res)
    {
        $user = $req->getUser();
        $id = $req->params[0];
        $news = new NewsService();
        $data = $news->getNewsDetail($id, $user->id);

        $res->toJSON([
            'data' => $data,
        ]);
    }

    public static function editNew(Request $req, Response $res)
    {
        $user = $req->getUser();
        $id = $req->params[0];
        $news = new NewsService();
        if ($news->isOwner($user->id, $id)) {
            $data = $news->updateNews($id, $req->getJson());
            $res->toJson([
                'data' => $data,
            ]);
        } else {
            $res->status(500);
            $res->toJson([
                'error' => "you don't own this",
            ]);
        }
    }

    public static function deleteNews(Request $req, Response $res)
    {
        $user = $req->getUser();
        $id = $req->params[0];
        $news = new NewsService();
        if ($news->isOwner($user->id, $id)) {
            $data = $news->deleteNews($id);
            $res->toJson([
                'data' => $data,
            ]);
        } else {
            $res->status(500);
            $res->toJson([
                'error' => "you don't own this",
            ]);
        }
    }

    public static function getNewsFiltred(Request $req, Response $res)
    {
        $user = $req->getUser();
        $news = new NewsService();
        $data = $news->getFiltredNews($user->id, $req->getQueryParams());

        $res->toJSON([
            'data' => $data,
        ]);
    }

}
