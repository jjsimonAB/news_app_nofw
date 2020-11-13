<?php

namespace Src\controller;

use Src\model\CategoriesService;
use Src\router\Request;
use Src\router\Response;

class CategoriesController
{

    /**
     * Gets all news from the database
     *
     * @param Request $req
     * @param Response $res
     * @return void
     */
    public static function getCategories(Request $req, Response $res): void
    {
        $user = $req->getUser();
        $category = new CategoriesService();
        $data = $category->getAllCategories();

        $res->toJSON([
            'data' => $data,
        ]);
    }

    /**
     * TO-DO
     * - reimplement responses with code and sutff
     */
    public static function addCategory(Request $req, Response $res)
    {
        $category = new CategoriesService();
        $data = $category->addCategory($req->getJson());

        $res->toJSON([
            'data' => $data,
        ]);
    }

    public static function editCategory(Request $req, Response $res)
    {
        $id = $req->params[0];
        $category = new CategoriesService();
        $data = $category->updateCategory($id, $req->getJson());
        $res->toJson([
            'data' => $data,
        ]);
    }

    public static function deleteCategory(Request $req, Response $res)
    {
        $id = $req->params[0];
        $category = new CategoriesService();
        $data = $category->deleteCategory($id);
        $res->toJson([
            'data' => $data,
        ]);
    }

}
