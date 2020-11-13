<?php

namespace Src\router;

class Request
{
    public $params;
    public $reqMethod;
    public $contentType;
    private $user;

    public function __construct($params = [])
    {
        $this->params = $params;
        $this->reqMethod = trim($_SERVER['REQUEST_METHOD']);
        $this->contentType = !empty($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public static function getHeaders()
    {
        $headers = getallheaders();
        return $headers;
    }

    public static function getQueryParams()
    {
        $queries = array();
        parse_str($_SERVER['QUERY_STRING'], $queries);
        array_shift($queries);

        return $queries;
    }

    public function getBody()
    {
        if ($this->reqMethod !== 'POST') {
            return '';
        }

        $body = [];
        foreach ($_POST as $key => $value) {
            $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $body;
    }

    public function getJSON()
    {

        if (strcasecmp($this->contentType, 'application/json') !== 0) {
            return [];
        }

        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content);

        return $decoded;
    }
}
