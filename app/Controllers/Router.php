<?php

namespace App\Controllers;

final class Router
{

    public static $routes = array();
    private static $params = array();
    public static $requestedUrl = '';

    /**
     * Добавить маршрут
     */
    public static function addRoute($route, $destination = null)
    {
        if ($destination != null && !is_array($route)) {
            $route = array($route => $destination);
        }
        self::$routes = array_merge(self::$routes, $route);
    }

    /**
     * Разделить переданный URL на компоненты
     */
    public static function splitUrl($url)
    {
        return preg_split('/\//', $url, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Текущий обработанный URL
     */
    public static function getCurrentUrl()
    {
        return (self::$requestedUrl ?: '/');
    }

    /**
     * Обработка переданного URL
     */
    public static function dispatch($getCA = false, $requestedUrl = null)
    {
        // Если URL не передан, берем его из REQUEST_URI
        if (empty($requestedUrl)) {
            $uri = explode('?', $_SERVER["REQUEST_URI"]);
            $uri = reset($uri);
            $requestedUrl = ($uri != '/') ? urldecode(rtrim($uri, '/')) : $uri;
        }

        self::$requestedUrl = $requestedUrl;
        // если URL и маршрут полностью совпадают
        if (isset(self::$routes[$requestedUrl])) {
            self::$params = self::splitUrl(self::$routes[$requestedUrl]);

            return self::executeAction($getCA);
        }

        foreach (self::$routes as $route => $uri) {
            // Заменяем wildcards на рег. выражения
            if (strpos($route, ':') !== false) {
                $route = str_replace(':any', '(.+)', str_replace(':num', '([0-9]+)', $route));
            }

            if (preg_match('#^'.$route.'$#', $requestedUrl)) {
                if (strpos($uri, '$') !== false && strpos($route, '(') !== false) {
                    $uri = preg_replace('#^'.$route.'$#', $uri, $requestedUrl);
                }
                self::$params = self::splitUrl($uri);
                break; // URL обработан!
            }
        }

        return self::executeAction($getCA);
    }

    /**
     * Запуск соответствующего действия/экшена/метода контроллера
     */
    public static function executeAction($getCA = false)
    {
        $controller_name = (isset(self::$params[0]) ? self::$params[0] : 'PageController');
        $action = isset(self::$params[1]) ? self::$params[1] : 'er404Action';
        $params = array_slice(self::$params, 2);

        if ($getCA) {
            return array(
                'controller' => $controller_name,
                'action' => $action,
                'params' => $params,
            );
        } else {
            $controller_path = '\App\Controllers\\'.$controller_name;
            $controller = new $controller_path;

            return call_user_func_array(array($controller, $action), $params);
        }
    }

}