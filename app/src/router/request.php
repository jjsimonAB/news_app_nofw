<?php

namespace Src\router;

class Request
{
    public array $params;
    public string $reqMethod;
    public string $contentType;
    public string $queryString;
    private $user;

    public function __construct(array $params = [], array $serverConf)
    {
        $this->params = $params;
        $this->reqMethod = trim($serverConf['request_method']);
        $this->queryString = $serverConf['request_query_string'];
        $this->contentType = !empty($serverConf['request_content_type']) ? trim($serverConf['request_content_type']) : '';
    }

    /**
     * returns the users on the request
     *
     * @return Object User
     */
    public function getUser(): object
    {
        return $this->user;
    }

    /**
     * Set an user into the request object
     *
     * @param  User
     * @return Object User
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * Set an user into the request object
     *
     * @return array Headers
     */
    public static function getHeaders()
    {
        return getallheaders();
    }

    /**
     * Returns the query params of the request
     *
     * @return array queryParams
     */
    public static function getQueryParams(): array
    {
        $queries = array();
        parse_str(self::$queryString, $queries);
        array_shift($queries);

        return $queries;
    }

    /**
     * Returns the body of the request
     *
     * @return array body
     */
    public function getBody(): array
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

    /**
     * Returns the body in object format
     *
     * @return object body
     */
    public function getJSON(): object
    {
        if (strcasecmp($this->contentType, 'application/json') !== 0) {
            return [];
        }

        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content);

        return $decoded;
    }
}
