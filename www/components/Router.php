<?php

namespace Components;

class Router
{
    /**
     * @var array Path to file where routes live
     */
    protected $routes;

    public function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Normalize request uri
     * @return string
     */
    protected function getUri(): string
    {
        if (empty($_SERVER['REQUEST_URI'])) {
            return '';
        }

        $uri = trim($_SERVER['REQUEST_URI'], '/');
        return explode('?', $uri)[0];
    }

    /**
     * Get controller name, action name and parameters
     *
     * @param string $uriPattern Key in routes array
     * @param string $path Value in routes array
     * @param string $uri Normalized request uri
     * @return array
     */
    protected function getUriParts(string $uriPattern, string $path, string $uri): array
    {
        $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
        $segments = explode('/', $internalRoute);
        $controllerName = array_shift($segments) . 'Controller';
        $controllerName = ucfirst($controllerName);
        $actionName = 'action' . ucfirst(array_shift($segments));
        $parameters = $segments;

        return [$controllerName, $actionName, $parameters];
    }

    /**
     * Call appropriate action method of controller
     *
     * @param $controller
     * @param string $actionName
     * @param array $parameters
     * @return bool
     */
    protected function callAction(
        \Controllers\MainController $controller,
        string $actionName,
        array $parameters): bool
    {
        return call_user_func_array(
            array($controller, $actionName),
            $parameters
        );
    }

    /**
     * Search uri through routes array and call appropriate action method
     * in controller
     */
    public function handleRequest()
    {
        $uri = $this->getUri();

        foreach ($this->routes as $uriPattern => $path) {
            /**
             **  preg_match return true if $uriPattern === 'any string' &&
             **  $uri === '' (empty string)
             */
            if (!preg_match("~$uriPattern~", $uri)) continue;
            list($controllerName, $actionName, $parameters) = $this->getUriParts($uriPattern, $path, $uri);

            $className = "\Controllers\\$controllerName";
            $controller = new $className;

            if (!method_exists($controller, $actionName)) continue;
            $result = $this->callAction($controller, $actionName, $parameters);

            if (null != $result) return;
        }

        http_response_code(404);
        $template = str_replace('/', DIRECTORY_SEPARATOR, ROOT . '/views/404.php');
        $view = new View($template);
        echo $view->render();
    }
}