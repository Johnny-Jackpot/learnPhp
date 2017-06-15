<?php

namespace Components;

use Components\Http\ResponseInterface;
use Components\Http\HtmlResponse;
use Controllers\ControllerInterface;
use Controllers\MainController;

class Router
{
    /**
     * @return array
     */
    public function getRoutesConfig(): array
    {
        return App::getConfig()->getRoutes();
    }

    /**
     * Normalize request uri
     * @return string
     */
    protected function getUri(): string
    {
        if (!isset($_SERVER['REQUEST_URI']) || empty($_SERVER['REQUEST_URI'])) {
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
        $controllerName = array_shift($segments);
        $parameters = $segments;

        return [$controllerName, $parameters];
    }

    /**
     * Call appropriate action method of controller
     *
     * @param $controller
     * @param string $actionName
     * @param array $parameters
     * @return ResponseInterface
     */
    protected function callAction(
        ControllerInterface $controller,
        string $actionName,
        array $parameters
    ):ResponseInterface
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

        foreach ($this->getRoutesConfig() as $uriPattern => $path) {

            if (!preg_match("~$uriPattern~", $uri)) {
                continue;
            }

            if ('' === $uriPattern && $uri !== $uriPattern) {
                break;
            }

            list($controllerName, $parameters) = $this->getUriParts($uriPattern, $path, $uri);

            $className = "\Controllers\\$controllerName";
            $controller = new $className;
            $method = 'execute';

            if (!method_exists($controller, $method)) {
                continue;
            }

            if ($response = $this->callAction($controller, $method, $parameters)) {
                $response->send();
                return;
            }
            break;
        }

        $response = $this->sendNotFoundResponse();
        $response->send();
    }

    private function sendNotFoundResponse(): ResponseInterface
    {
        $template = str_replace('/', DIRECTORY_SEPARATOR, ROOT . '/templates/404.php');
        $view = str_replace('/', DIRECTORY_SEPARATOR, ROOT . '/views/404.php');
        $view = new View($template, $view);
        $response = new HtmlResponse();

        return $response->setHeader('HTTP/1.1 404 Not Found', true, 404)
                        ->setBody($view->render());
    }
}