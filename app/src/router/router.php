<?php

namespace Src\router;

class Router
{

    private static array $serverConf = [];

    /**
     * Inject server globals into the route logic
     *
     * @return void
     */
    public static function setConf(array $conf = []): void
    {
        self::$serverConf = $conf;
    }

    /**
     * Responds to a GET route
     *
     * @return void
     */
    public static function get($route, $callback): void
    {
        if (strcasecmp(self::$serverConf['request_method'], 'GET') !== 0) {
            return;
        }

        self::on($route, $callback);
    }

    /**
     * Responds to a POST route
     *
     * @return void
     */
    public static function post($route, $callback): void
    {

        if (strcasecmp(self::$serverConf['request_method'], 'POST') !== 0) {
            return;
        }

        self::on($route, $callback);
    }

    /**
     * Responds to a PUT route
     *
     * @return void
     */
    public static function put($route, $callback)
    {

        if (strcasecmp(self::$serverConf['request_method'], 'PUT') !== 0) {
            return;
        }

        self::on($route, $callback);
    }

    /**
     * Responds to a DELETE route
     *
     * @return void
     */
    public static function delete($route, $callback)
    {

        if (strcasecmp(self::$serverConf['request_method'], 'DELETE') !== 0) {
            return;
        }

        self::on($route, $callback);
    }

    /**
     * manages the route of the request
     *
     * @return void
     */
    public static function on($regex, $cb): void
    {
        $params = self::$serverConf['request_uri'];
        $params = (stripos($params, "/") !== 0) ? "/" . $params : $params;
        $regex = str_replace('/', '\/', $regex);
        $is_match = preg_match('/^' . ($regex) . '$/', $params, $matches, PREG_OFFSET_CAPTURE);

        if ($is_match) {
            array_shift($matches);
            $params = array_map(function ($param) {
                return $param[0];
            }, $matches);

            $cb(new Request($params, self::$serverConf), new Response());
        }
    }
}
